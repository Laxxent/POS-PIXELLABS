<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\Cache;

class SyncDashboardData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dashboard:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi data dashboard setiap satu jam';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi data dashboard...');
        
        try {
            // Clear cache untuk memastikan data terbaru
            Cache::forget('dashboard_stats');
            Cache::forget('recent_sales');
            Cache::forget('low_stock_products');
            Cache::forget('top_products');
            
            // Hitung statistik dashboard
            $totalSales = Sale::count();
            $totalProducts = Product::count();
            $totalCustomers = Customer::count();
            $totalRevenue = Sale::sum('total_amount');
            
            // Ambil data penjualan terbaru
            $recentSales = Sale::with(['user', 'customer'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            // Ambil produk dengan stok rendah
            $lowStockProducts = Product::with(['category', 'unit'])
                ->where('stock', '<=', 10)
                ->where('is_active', true)
                ->limit(10)
                ->get();
            
            // Ambil produk terlaris
            $topProducts = Product::with(['category', 'unit'])
                ->where('is_active', true)
                ->orderBy('stock', 'desc')
                ->limit(5)
                ->get();
            
            // Cache data untuk performa
            Cache::put('dashboard_stats', [
                'total_sales' => $totalSales,
                'total_products' => $totalProducts,
                'total_customers' => $totalCustomers,
                'total_revenue' => $totalRevenue,
            ], 3600); // Cache selama 1 jam
            
            Cache::put('recent_sales', $recentSales, 3600);
            Cache::put('low_stock_products', $lowStockProducts, 3600);
            Cache::put('top_products', $topProducts, 3600);
            
            $this->info('✅ Sinkronisasi berhasil!');
            $this->info("📊 Total Penjualan: {$totalSales}");
            $this->info("📦 Total Produk: {$totalProducts}");
            $this->info("👥 Total Pelanggan: {$totalCustomers}");
            $this->info("💰 Total Pendapatan: Rp " . number_format($totalRevenue, 0, ',', '.'));
            $this->info("🕐 Data di-cache selama 1 jam");
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Error saat sinkronisasi: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
