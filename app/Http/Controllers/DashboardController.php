<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Show dashboard
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get today's date
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        
        // Get filter parameters
        $period = $request->get('period', 'week'); // week, month, year
        $year = $request->get('year', Carbon::now()->year);
        
        // Try to get cached data first, fallback to fresh data
        $cachedStats = Cache::get('dashboard_stats');
        $cachedRecentSales = Cache::get('recent_sales');
        $cachedLowStockProducts = Cache::get('low_stock_products');
        $cachedTopProducts = Cache::get('top_products');
        
        // Dashboard statistics
        $stats = $cachedStats ?: [
            'total_products' => Product::count(),
            'low_stock_products' => Product::lowStock()->count(),
            'total_customers' => Customer::count(),
            'total_suppliers' => Supplier::count(),
            'today_sales' => Sale::whereDate('created_at', $today)->sum('total_amount'),
            'month_sales' => Sale::where('created_at', '>=', $thisMonth)->sum('total_amount'),
            'today_transactions' => Sale::whereDate('created_at', $today)->count(),
            'month_transactions' => Sale::where('created_at', '>=', $thisMonth)->count(),
        ];

        // Recent sales
        $recentSales = $cachedRecentSales ?: Sale::with(['user', 'customer'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Low stock products
        $lowStockProducts = $cachedLowStockProducts ?: Product::with(['category', 'unit'])
            ->lowStock()
            ->limit(10)
            ->get();

        // Top selling products (this month)
        $topProducts = $cachedTopProducts ?: Product::select('products.id', 'products.name', 'products.code', 'products.price', 'products.category_id', 'products.unit_id', DB::raw('SUM(sale_items.quantity) as total_sold'))
            ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.created_at', '>=', $thisMonth)
            ->groupBy('products.id', 'products.name', 'products.code', 'products.price', 'products.category_id', 'products.unit_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Sales chart data based on period
        $salesChartData = $this->getSalesChartData($period, $year);

        return view('dashboard', compact('stats', 'recentSales', 'lowStockProducts', 'topProducts', 'salesChartData', 'period', 'year'));
    }

    /**
     * Get sales chart data based on period
     */
    private function getSalesChartData($period, $year)
    {
        $salesChartData = [];
        
        switch ($period) {
            case 'week':
                // Last 7 days
                for ($i = 6; $i >= 0; $i--) {
                    $date = Carbon::today()->subDays($i);
                    $salesChartData[] = [
                        'date' => $date->format('d/m'),
                        'sales' => Sale::whereDate('created_at', $date)->sum('total_amount')
                    ];
                }
                break;
                
            case 'month':
                // Last 12 months
                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $startOfMonth = $date->copy()->startOfMonth();
                    $endOfMonth = $date->copy()->endOfMonth();
                    
                    $salesChartData[] = [
                        'date' => $date->format('M Y'),
                        'sales' => Sale::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('total_amount')
                    ];
                }
                break;
                
            case 'year':
                // Last 5 years
                for ($i = 4; $i >= 0; $i--) {
                    $date = Carbon::create($year - $i, 1, 1);
                    $startOfYear = $date->copy()->startOfYear();
                    $endOfYear = $date->copy()->endOfYear();
                    
                    $salesChartData[] = [
                        'date' => $date->format('Y'),
                        'sales' => Sale::whereBetween('created_at', [$startOfYear, $endOfYear])->sum('total_amount')
                    ];
                }
                break;
        }
        
        return $salesChartData;
    }

    /**
     * Get chart data via AJAX
     */
    public function getChartData(Request $request)
    {
        $period = $request->get('period', 'week');
        $year = $request->get('year', Carbon::now()->year);
        
        $salesChartData = $this->getSalesChartData($period, $year);
        
        return response()->json([
            'success' => true,
            'data' => $salesChartData
        ]);
    }

    /**
     * Manual sync dashboard data
     */
    public function sync()
    {
        try {
            // Clear existing cache
            Cache::forget('dashboard_stats');
            Cache::forget('recent_sales');
            Cache::forget('low_stock_products');
            Cache::forget('top_products');
            
            // Get today's date
            $today = Carbon::today();
            $thisMonth = Carbon::now()->startOfMonth();
            
            // Calculate fresh statistics
            $stats = [
                'total_products' => Product::count(),
                'low_stock_products' => Product::lowStock()->count(),
                'total_customers' => Customer::count(),
                'total_suppliers' => Supplier::count(),
                'today_sales' => Sale::whereDate('created_at', $today)->sum('total_amount'),
                'month_sales' => Sale::where('created_at', '>=', $thisMonth)->sum('total_amount'),
                'today_transactions' => Sale::whereDate('created_at', $today)->count(),
                'month_transactions' => Sale::where('created_at', '>=', $thisMonth)->count(),
            ];

            // Get fresh data
            $recentSales = Sale::with(['user', 'customer'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            $lowStockProducts = Product::with(['category', 'unit'])
                ->lowStock()
                ->limit(10)
                ->get();

            $topProducts = Product::select('products.id', 'products.name', 'products.code', 'products.price', 'products.category_id', 'products.unit_id', DB::raw('SUM(sale_items.quantity) as total_sold'))
                ->join('sale_items', 'products.id', '=', 'sale_items.product_id')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->where('sales.created_at', '>=', $thisMonth)
                ->groupBy('products.id', 'products.name', 'products.code', 'products.price', 'products.category_id', 'products.unit_id')
                ->orderBy('total_sold', 'desc')
                ->limit(10)
                ->get();

            // Cache fresh data
            Cache::put('dashboard_stats', $stats, 3600);
            Cache::put('recent_sales', $recentSales, 3600);
            Cache::put('low_stock_products', $lowStockProducts, 3600);
            Cache::put('top_products', $topProducts, 3600);

            return response()->json([
                'success' => true,
                'message' => 'Data dashboard berhasil disinkronkan!',
                'data' => [
                    'total_sales' => $stats['today_transactions'],
                    'total_products' => $stats['total_products'],
                    'total_customers' => $stats['total_customers'],
                    'total_revenue' => $stats['today_sales'],
                    'sync_time' => now()->format('d/m/Y H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error saat sinkronisasi: ' . $e->getMessage()
            ], 500);
        }
    }
}






