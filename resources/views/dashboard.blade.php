@extends('layouts.app')

@section('title', 'Dashboard - POS Application')
@section('page-title', 'Dashboard')

@push('styles')
<style>
/* Chart Filter Dropdown Styling */
.chart-filter-dropdown select {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    -ms-appearance: none !important;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 16px;
    padding-right: 40px;
    background-color: white;
}

/* Dark mode support for chart filter dropdown */
[data-bs-theme="dark"] .chart-filter-dropdown select {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23ffffff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
    background-color: #343a40;
}

/* Browser-specific fixes */
.chart-filter-dropdown select::-ms-expand {
    display: none;
}

.chart-filter-dropdown select::-webkit-outer-spin-button,
.chart-filter-dropdown select::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
@endpush

@section('content')
<div class="row">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Total Produk</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['total_products']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Stok Rendah</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['low_stock_products']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Penjualan Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold">Rp {{ number_format($stats['today_sales'], 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-uppercase mb-1">Transaksi Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold">{{ number_format($stats['today_transactions']) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Sales Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-area me-2"></i>
                    <span id="chartTitle">Grafik Penjualan 7 Hari Terakhir</span>
                </h6>
                <div class="d-flex gap-2">
                    <div class="chart-filter-dropdown">
                        <select id="periodFilter" class="form-select form-select-sm" style="width: auto;">
                            <option value="week" {{ $period == 'week' ? 'selected' : '' }}>7 Hari Terakhir</option>
                            <option value="month" {{ $period == 'month' ? 'selected' : '' }}>12 Bulan Terakhir</option>
                            <option value="year" {{ $period == 'year' ? 'selected' : '' }}>5 Tahun Terakhir</option>
                        </select>
                    </div>
                    <div class="chart-filter-dropdown">
                        <select id="yearFilter" class="form-select form-select-sm" style="width: auto; display: none;">
                            @for($i = date('Y'); $i >= date('Y') - 10; $i--)
                                <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <canvas id="salesChart" width="100%" height="40"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-xl-4 col-lg-5">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>
                    Statistik Cepat
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Total Pelanggan:</span>
                        <strong>{{ number_format($stats['total_customers']) }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Total Supplier:</span>
                        <strong>{{ number_format($stats['total_suppliers']) }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Penjualan Bulan Ini:</span>
                        <strong>Rp {{ number_format($stats['month_sales'], 0, ',', '.') }}</strong>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Transaksi Bulan Ini:</span>
                        <strong>{{ number_format($stats['month_transactions']) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Sales -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list me-2"></i>
                    Penjualan Terbaru
                </h6>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-primary btn-sm" id="syncButton" onclick="syncDashboard()">
                        <i class="fas fa-sync-alt me-1"></i>
                        <span id="syncText">Sinkronisasi</span>
                    </button>
                    <a href="{{ route('sales.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Tambah Penjualan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Customer</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $sale->customer_id ? ($sale->customer ? $sale->customer->name : 'Customer Tidak Ditemukan') : 'Pelanggan Umum' }}</td>
                                <td><strong>{{ $sale->formatted_total }}</strong></td>
                                <td>
                                    <span class="badge {{ $sale->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($sale->status == 'pending')
                                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" 
                                                    onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data penjualan</p>
                                    <a href="{{ route('sales.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Tambah Penjualan Pertama
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Products -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Stok Rendah
                </h6>
            </div>
            <div class="card-body">
                @forelse($lowStockProducts as $product)
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded" width="40" height="40">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="fas fa-box text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0">{{ $product->name }}</h6>
                        <small class="text-muted">Stok: {{ $product->stock }} {{ $product->unit->symbol }}</small>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center">Tidak ada produk dengan stok rendah</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Top Products -->
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-trophy me-2"></i>
                    Produk Terlaris Bulan Ini
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Terjual</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ number_format($product->total_sold) }}</td>
                                <td>{{ $product->unit->symbol }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data produk terlaris</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Sales Chart
const ctx = document.getElementById('salesChart').getContext('2d');
let salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($salesChartData, 'date')) !!},
        datasets: [{
            label: 'Penjualan (Rp)',
            data: {!! json_encode(array_column($salesChartData, 'sales')) !!},
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Chart filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const periodFilter = document.getElementById('periodFilter');
    const yearFilter = document.getElementById('yearFilter');
    const chartTitle = document.getElementById('chartTitle');
    
    // Show/hide year filter based on period
    function toggleYearFilter() {
        if (periodFilter.value === 'year') {
            yearFilter.style.display = 'block';
        } else {
            yearFilter.style.display = 'none';
        }
    }
    
    // Update chart title
    function updateChartTitle() {
        const titles = {
            'week': 'Grafik Penjualan 7 Hari Terakhir',
            'month': 'Grafik Penjualan 12 Bulan Terakhir',
            'year': 'Grafik Penjualan 5 Tahun Terakhir'
        };
        chartTitle.textContent = titles[periodFilter.value];
    }
    
    // Load chart data
    function loadChartData() {
        const period = periodFilter.value;
        const year = yearFilter.value;
        
        fetch(`{{ route('dashboard.chart-data') }}?period=${period}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update chart data
                    salesChart.data.labels = data.data.map(item => item.date);
                    salesChart.data.datasets[0].data = data.data.map(item => item.sales);
                    salesChart.update();
                }
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
            });
    }
    
    // Event listeners
    periodFilter.addEventListener('change', function() {
        toggleYearFilter();
        updateChartTitle();
        loadChartData();
    });
    
    yearFilter.addEventListener('change', function() {
        if (periodFilter.value === 'year') {
            loadChartData();
        }
    });
    
    // Initialize
    toggleYearFilter();
    updateChartTitle();
});

// Dashboard Sync Function
function syncDashboard() {
    const syncButton = document.getElementById('syncButton');
    const syncText = document.getElementById('syncText');
    const syncIcon = syncButton.querySelector('i');
    
    // Disable button and show loading
    syncButton.disabled = true;
    syncText.textContent = 'Menyinkronkan...';
    syncIcon.className = 'fas fa-spinner fa-spin me-1';
    
    // Make AJAX request
    fetch('{{ route("dashboard.sync") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('success', data.message);
            
            // Update sync time
            syncText.textContent = 'Terakhir: ' + data.data.sync_time;
            
            // Reload page after 1 second to show updated data
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showNotification('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('error', 'Terjadi kesalahan saat sinkronisasi');
    })
    .finally(() => {
        // Re-enable button
        syncButton.disabled = false;
        syncIcon.className = 'fas fa-sync-alt me-1';
        
        // Reset text after 3 seconds
        setTimeout(() => {
            syncText.textContent = 'Sinkronisasi';
        }, 3000);
    });
}

// Notification function
function showNotification(type, message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; min-width: 300px; max-width: 500px; text-align: center;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to body
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endpush






