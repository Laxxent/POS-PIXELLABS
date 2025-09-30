<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Purchase::with(['user', 'supplier']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function($supplierQuery) use ($search) {
                      $supplierQuery->where('name', 'like', "%{$search}%");
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

        $purchases = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::active()->with(['category', 'unit'])->get();
        $suppliers = Supplier::active()->get();

        return view('purchases.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'payment_method' => 'required|in:cash,transfer,credit',
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
            $invoiceNumber = 'PUR-' . date('Ymd') . '-' . str_pad(Purchase::whereDate('created_at', Carbon::today())->count() + 1, 4, '0', STR_PAD_LEFT);

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
            $remainingAmount = max(0, $totalAmount - $request->paid_amount);

            // Create purchase
            $purchase = Purchase::create([
                'invoice_number' => $invoiceNumber,
                'user_id' => auth()->id(),
                'supplier_id' => $request->supplier_id,
                'subtotal' => $subtotal,
                'discount_amount' => $totalDiscount,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
                'paid_amount' => $request->paid_amount,
                'remaining_amount' => $remainingAmount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
                'notes' => $request->notes,
            ]);

            // Create purchase items and update stock
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $itemTotal = ($item['quantity'] * $item['unit_price']) - ($item['discount_amount'] ?? 0);

                // Create purchase item
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'total_price' => $itemTotal,
                    'serial_number' => $item['serial_number'] ?? null,
                ]);

                // Update stock
                $oldStock = $product->stock;
                $newStock = $oldStock + $item['quantity'];
                $product->update(['stock' => $newStock]);

                // Create stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'in',
                    'quantity' => $item['quantity'],
                    'stock_before' => $oldStock,
                    'stock_after' => $newStock,
                    'reference_type' => 'purchase',
                    'reference_id' => $purchase->id,
                    'notes' => "Pembelian - {$purchase->invoice_number}",
                    'user_id' => auth()->id(),
                ]);
            }

            DB::commit();

            return redirect()->route('purchases.show', $purchase)
                ->with('success', 'Transaksi pembelian berhasil disimpan.');

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
    public function show(Purchase $purchase)
    {
        $purchase->load(['user', 'supplier', 'purchaseItems.product']);
        
        return view('purchases.show', compact('purchase'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        if ($purchase->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya transaksi pending yang dapat diedit.');
        }

        $purchase->load(['purchaseItems.product']);
        $products = Product::active()->with(['category', 'unit'])->get();
        $suppliers = Supplier::active()->get();

        return view('purchases.edit', compact('purchase', 'products', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        if ($purchase->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya transaksi pending yang dapat diedit.');
        }

        // Similar validation and update logic as store method
        // Implementation would be similar to store method
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        if ($purchase->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Hanya transaksi pending yang dapat dihapus.');
        }

        DB::beginTransaction();

        try {
            // Restore stock
            foreach ($purchase->purchaseItems as $item) {
                $product = $item->product;
                $oldStock = $product->stock;
                $newStock = $oldStock - $item->quantity;
                
                $product->update(['stock' => $newStock]);

                // Create stock movement
                StockMovement::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'stock_before' => $oldStock,
                    'stock_after' => $newStock,
                    'reference_type' => 'purchase_cancellation',
                    'reference_id' => $purchase->id,
                    'notes' => "Pembatalan pembelian - {$purchase->invoice_number}",
                    'user_id' => auth()->id(),
                ]);
            }

            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')
                ->with('success', 'Transaksi pembelian berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Update purchase status
     */
    public function updateStatus(Request $request, Purchase $purchase)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $oldStatus = $purchase->status;
        $newStatus = $request->status;

        // If changing from completed to pending/cancelled, restore stock
        if ($oldStatus === 'completed' && in_array($newStatus, ['pending', 'cancelled'])) {
            DB::beginTransaction();
            
            try {
                foreach ($purchase->purchaseItems as $item) {
                    $product = $item->product;
                    $oldStock = $product->stock;
                    $newStock = $oldStock - $item->quantity;
                    
                    $product->update(['stock' => $newStock]);

                    // Create stock movement
                    StockMovement::create([
                        'product_id' => $product->id,
                        'type' => 'out',
                        'quantity' => $item->quantity,
                        'stock_before' => $oldStock,
                        'stock_after' => $newStock,
                        'reference_type' => 'purchase',
                        'reference_id' => $purchase->id,
                        'notes' => "Status changed from {$oldStatus} to {$newStatus}",
                        'user_id' => auth()->id()
                    ]);
                }
                
                $purchase->update(['status' => $newStatus]);
                DB::commit();
                
                return redirect()->back()
                    ->with('success', "Purchase status berhasil diubah dari {$oldStatus} menjadi {$newStatus}.");
                    
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Error saat mengubah status: ' . $e->getMessage());
            }
        }
        
        // If changing from pending/cancelled to completed, add stock
        elseif (in_array($oldStatus, ['pending', 'cancelled']) && $newStatus === 'completed') {
            DB::beginTransaction();
            
            try {
                foreach ($purchase->purchaseItems as $item) {
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
                        'reference_type' => 'purchase',
                        'reference_id' => $purchase->id,
                        'notes' => "Status changed from {$oldStatus} to {$newStatus}",
                        'user_id' => auth()->id()
                    ]);
                }
                
                $purchase->update(['status' => $newStatus]);
                DB::commit();
                
                return redirect()->back()
                    ->with('success', "Purchase status berhasil diubah dari {$oldStatus} menjadi {$newStatus}.");
                    
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Error saat mengubah status: ' . $e->getMessage());
            }
        }
        
        // If changing between pending and cancelled (no stock change)
        else {
            $purchase->update(['status' => $newStatus]);
            
            return redirect()->back()
                ->with('success', "Purchase status berhasil diubah dari {$oldStatus} menjadi {$newStatus}.");
        }
    }

}






