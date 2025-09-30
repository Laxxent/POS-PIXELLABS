<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\Customer;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'customer']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $sales = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::active()->with(['category', 'unit'])->get();
        $customers = Customer::active()->get();

        return view('sales.create', compact('products', 'customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'type' => 'required|in:retail,wholesale',
            'payment_method' => 'required|in:cash,transfer,e_wallet,credit',
            'paid_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount_amount' => 'nullable|numeric|min:0',
            'items.*.serial_number' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // Generate invoice number
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . str_pad(Sale::whereDate('created_at', Carbon::today())->count() + 1, 4, '0', STR_PAD_LEFT);

            // Calculate totals
            $subtotal = 0;
            $totalDiscount = 0;

            foreach ($request->items as $item) {
                $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount_amount'] ?? 0);
                $subtotal += $itemTotal;
                $totalDiscount += $item['discount_amount'] ?? 0;
            }

            $taxAmount = 0; // You can implement tax calculation here
            $totalAmount = $subtotal + $taxAmount;
            $changeAmount = max(0, $request->paid_amount - $totalAmount);

            // Create sale
            $sale = Sale::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'type' => $request->type,
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $changeAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Create sale items and update stock
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Check stock availability
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok produk {$product->name} tidak mencukupi. Stok tersedia: {$product->stock}");
                }

                $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount_amount'] ?? 0);

                // Create sale item
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'total_price' => $itemTotal,
                    'serial_number' => $item['serial_number'] ?? null,
                ]);

                // Update stock
                $oldStock = $product->stock;
                $newStock = $oldStock - $item['quantity'];
                $product->update(['stock' => $newStock]);

                // Create stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'stock_before' => $oldStock,
                    'stock_after' => $newStock,
                    'reference_type' => 'sale',
                    'reference_id' => $sale->id,
                    'notes' => "Penjualan - {$sale->invoice_number}",
                    'user_id' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('sales.show', $sale)
                ->with('success', 'Transaksi penjualan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load(['user', 'customer', 'saleItems.product']);
        
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        if ($sale->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya transaksi pending yang dapat diedit.');
        }

        $sale->load(['saleItems.product']);
        $products = Product::active()->with(['category', 'unit'])->get();
        $customers = Customer::active()->get();

        return view('sales.edit', compact('sale', 'products', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        if ($sale->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya transaksi pending yang dapat diedit.');
        }

        // Similar validation and update logic as store method
        // Implementation would be similar to store method
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        if ($sale->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya transaksi pending yang dapat dihapus.');
        }

        DB::beginTransaction();

        try {
            // Restore stock
            foreach ($sale->saleItems as $item) {
                $product = $item->product;
                $oldStock = $product->stock;
                $newStock = $oldStock + $item->quantity;
                
                $product->update(['stock' => $newStock]);

                // Create stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $item->quantity,
                    'stock_before' => $oldStock,
                    'stock_after' => $newStock,
                    'reference_type' => 'sale_cancellation',
                    'reference_id' => $sale->id,
                    'notes' => "Pembatalan penjualan - {$sale->invoice_number}",
                    'user_id' => auth()->id(),
                ]);
            }

            $sale->delete();

            DB::commit();

            return redirect()->route('sales.index')
                ->with('success', 'Transaksi penjualan berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Print receipt
     */
    public function printReceipt(Sale $sale)
    {
        $sale->load(['user', 'customer', 'saleItems.product']);
        
        return view('sales.receipt', compact('sale'));
    }
}






