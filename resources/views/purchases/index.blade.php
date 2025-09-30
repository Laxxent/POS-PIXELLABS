@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Purchases') }}</span>
                    <a href="{{ route('purchases.create') }}" class="btn btn-primary btn-sm" style="border-radius: 6px;">Tambah Data Pembelian</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>{{ __('ID') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Supplier') }}</th>
                                    <th>{{ __('Total') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases ?? [] as $purchase)
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $purchase->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                                    <td>Rp {{ number_format($purchase->total_amount, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge {{ $purchase->status == 'completed' ? 'bg-success' : ($purchase->status == 'pending' ? 'bg-warning' : ($purchase->status == 'cancelled' ? 'bg-secondary' : 'bg-danger')) }}">
                                            {{ ucfirst($purchase->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('purchases.show', $purchase->id) }}" class="btn btn-info btn-sm" title="View" style="border-radius: 6px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="btn btn-primary btn-sm" title="Edit" style="border-radius: 6px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" style="border-radius: 6px;" onclick="return confirm('Yakin ingin menghapus transaksi ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Status Change Buttons -->
                                            @if($purchase->status == 'completed')
                                            <form action="{{ route('purchases.update-status', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="btn btn-warning btn-sm" title="Set to Pending" style="border-radius: 6px;" onclick="return confirm('Ubah status menjadi Pending? Stok akan dikurangi.')">
                                                    <i class="fas fa-clock"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('purchases.update-status', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-secondary btn-sm" title="Set to Cancelled" style="border-radius: 6px;" onclick="return confirm('Ubah status menjadi Cancelled? Stok akan dikurangi.')">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                            @elseif($purchase->status == 'pending')
                                            <form action="{{ route('purchases.update-status', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success btn-sm" title="Set to Completed" style="border-radius: 6px;" onclick="return confirm('Ubah status menjadi Completed? Stok akan ditambahkan.')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('purchases.update-status', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="cancelled">
                                                <button type="submit" class="btn btn-secondary btn-sm" title="Set to Cancelled" style="border-radius: 6px;" onclick="return confirm('Ubah status menjadi Cancelled?')">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </form>
                                            @elseif($purchase->status == 'cancelled')
                                            <form action="{{ route('purchases.update-status', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn btn-success btn-sm" title="Set to Completed" style="border-radius: 6px;" onclick="return confirm('Ubah status menjadi Completed? Stok akan ditambahkan.')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('purchases.update-status', $purchase->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                <input type="hidden" name="status" value="pending">
                                                <button type="submit" class="btn btn-warning btn-sm" title="Set to Pending" style="border-radius: 6px;" onclick="return confirm('Ubah status menjadi Pending?')">
                                                    <i class="fas fa-clock"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{ __('No purchases found.') }}</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if(isset($purchases) && $purchases->hasPages())
                        <div class="mt-4">
                            {{ $purchases->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection