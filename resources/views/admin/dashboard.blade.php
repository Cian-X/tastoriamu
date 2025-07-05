@extends('layouts.app')

@section('content')
@php
    $pendingCashOrders = $orders->where('payment_method', 'cash')->where('status', 'menunggu pembayaran');
@endphp
@if($pendingCashOrders->count() > 0)
    <div class="mu-alert-login" style="margin:1.5em auto 0 auto;max-width:700px;">
        <i class="fas fa-bell"></i> Ada <b>{{ $pendingCashOrders->count() }}</b> pesanan cash menunggu konfirmasi pembayaran!
    </div>
@endif
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h4>
            <div style="display:flex;gap:2rem;flex-wrap:wrap;">
                <div class="mu-card mu-dashboard-box" onclick="showModal('userModal')" style="flex:1 1 200px;text-align:center;cursor:pointer;">
                    <div class="mu-card-body">
                        <div class="mu-badge mu-badge-type" style="margin-bottom:0.7em;">Total User</div>
                        <div class="mu-title" style="font-size:2rem;">{{ $totalUsers }}</div>
                    </div>
                </div>
                <div class="mu-card mu-dashboard-box" onclick="showModal('foodModal')" style="flex:1 1 200px;text-align:center;cursor:pointer;">
                    <div class="mu-card-body">
                        <div class="mu-badge mu-badge-type" style="margin-bottom:0.7em;">Total Menu</div>
                        <div class="mu-title" style="font-size:2rem;">{{ $totalFoods }}</div>
                    </div>
                </div>
                <div class="mu-card mu-dashboard-box" onclick="showModal('orderModal')" style="flex:1 1 200px;text-align:center;cursor:pointer;">
                    <div class="mu-card-body">
                        <div class="mu-badge mu-badge-type" style="margin-bottom:0.7em;">Total Pesanan</div>
                        <div class="mu-title" style="font-size:2rem;">{{ $totalOrders }}</div>
                    </div>
                </div>
                <div class="mu-card mu-dashboard-box" style="flex:1 1 200px;text-align:center;">
                    <div class="mu-card-body">
                        <div class="mu-badge mu-badge-type" style="margin-bottom:0.7em;">Total Pendapatan</div>
                        <div class="mu-title" style="font-size:2rem;">Rp{{ number_format($totalRevenue,0,',','.') }}</div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top:2rem;display:flex;gap:1rem;flex-wrap:wrap;">
                <a href="{{ route('admin.users') }}" class="mu-btn mu-btn-outline">
                    <i class="fas fa-users"></i> Kelola User
                </a>
                <a href="{{ route('admin.orders') }}" class="mu-btn mu-btn-outline">
                    <i class="fas fa-list"></i> Semua Pesanan
                </a>
                <a href="{{ route('foods.index') }}" class="mu-btn mu-btn-outline">
                    <i class="fas fa-utensils"></i> Kelola Menu
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal User -->
<div id="userModal" class="mu-modal" style="display:none;">
    <div class="mu-modal-content">
        <span class="mu-modal-close" onclick="closeModal('userModal')">&times;</span>
        <h4 class="mu-title">Daftar Pengguna</h4>
        <table class="mu-table">
            <thead><tr><th>Nama</th><th>Email</th><th>Role</th></tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ ucfirst($user->role) }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Food -->
<div id="foodModal" class="mu-modal" style="display:none;">
    <div class="mu-modal-content">
        <span class="mu-modal-close" onclick="closeModal('foodModal')">&times;</span>
        <h4 class="mu-title">Daftar Makanan/Minuman</h4>
        <table class="mu-table">
            <thead><tr><th>Nama</th><th>Harga</th><th>Kategori</th></tr></thead>
            <tbody>
                @foreach($foods as $food)
                <tr><td>{{ $food->nama }}</td><td>Rp{{ number_format($food->harga,0,',','.') }}</td><td>{{ $food->category->nama ?? '-' }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Order -->
<div id="orderModal" class="mu-modal" style="display:none;">
    <div class="mu-modal-content">
        <span class="mu-modal-close" onclick="closeModal('orderModal')">&times;</span>
        <h4 class="mu-title">Daftar Pesanan Terbaru</h4>
        <table class="mu-table">
            <thead><tr><th>Pemesan</th><th>Total</th><th>Status</th><th>Pembayaran</th></tr></thead>
            <tbody>
                @foreach($recentOrders as $order)
                <tr>
                    <td>{{ $order->nama_pemesan }}</td>
                    <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                    <td>
                        @if($order->status == 'menunggu pembayaran')
                            <span class="mu-badge" style="background:#ffc107;color:#000;">Menunggu Pembayaran</span>
                        @elseif($order->status == 'siap antar')
                            <span class="mu-badge" style="background:#17a2b8;color:#fff;">Siap Antar</span>
                        @elseif($order->status == 'dalam pengiriman')
                            <span class="mu-badge" style="background:#007bff;color:#fff;">Dalam Pengiriman</span>
                        @elseif($order->status == 'selesai')
                            <span class="mu-badge" style="background:#28a745;color:#fff;">Selesai</span>
                        @else
                            <span class="mu-badge">{{ ucfirst($order->status) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($order->payment_status == 'unpaid')
                            <span class="mu-badge" style="background:#dc3545;color:#fff;">Belum Bayar</span>
                        @else
                            <span class="mu-badge" style="background:#28a745;color:#fff;">Sudah Bayar</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mu-card">
    <div class="mu-card-body">
        <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-money-bill-wave"></i> Konfirmasi Pembayaran Cash
            @if($pendingCashOrders->count() > 0)
                <span class="mu-badge" style="background:#DA291C;color:#fff;margin-left:0.7em;">{{ $pendingCashOrders->count() }}</span>
            @endif
        </h4>
        @if($pendingCashOrders->count() > 0)
        <table class="mu-table">
            <thead><tr><th>Pemesan</th><th>Total</th><th>Status</th><th>Metode</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($pendingCashOrders as $order)
                <tr>
                    <td>{{ $order->nama_pemesan }}</td>
                    <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                    <td><span class="mu-badge" style="background:#ffc107;color:#000;">{{ ucfirst($order->status) }}</span></td>
                    <td><span class="mu-badge" style="background:#DA291C;color:#fff;">Cash</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.orders.confirmPayment', $order->id) }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="mu-btn mu-btn-primary" onclick="return confirm('Konfirmasi pembayaran cash untuk pesanan ini?')">
                                <i class="fas fa-check"></i> Konfirmasi Pembayaran
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align:center;padding:2rem;color:#888;">
            <i class="fas fa-check-circle" style="font-size:2rem;color:#28a745;margin-bottom:1rem;"></i>
            <p>Tidak ada pesanan cash yang menunggu konfirmasi pembayaran</p>
        </div>
        @endif
    </div>
</div>

<script>
function showModal(id) {
    document.getElementById(id).style.display = 'block';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}
window.onclick = function(event) {
    ['userModal','foodModal','orderModal'].forEach(function(id){
        var modal = document.getElementById(id);
        if(event.target == modal) modal.style.display = 'none';
    });
}
</script>

<style>
.mu-modal { position:fixed;z-index:999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);display:flex;align-items:center;justify-content:center; }
.mu-modal-content { background:#fff;border-radius:1em;padding:2em 1.5em;max-width:900px;width:95vw;max-height:80vh;overflow:auto;box-shadow:0 8px 32px rgba(0,0,0,0.2);position:relative; margin:0 auto; display:block; }
.mu-modal-close { position:absolute;top:1em;right:1em;font-size:2em;cursor:pointer;color:#DA291C; }
.mu-table { width:100%;border-collapse:separate;border-spacing:0;margin-top:1em; table-layout:auto; background:#fff; border-radius:0.7em; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.03); }
.mu-table th, .mu-table td { border:1px solid #eee;padding:0.7em 1.2em;text-align:center;font-size:1em; }
.mu-table th { background:#DA291C;color:#fff;text-align:center;font-weight:600;letter-spacing:0.5px; }
.mu-table tr:nth-child(even) { background:#faf9f7; }
.mu-table tr:hover { background:#ffe5e5; transition: background 0.2s; }
.mu-title { text-align:center;font-weight:700;font-size:1.5em;margin-bottom:1.2em;color:#222; }
@media (max-width: 700px) {
  .mu-modal-content { padding: 1em 0.3em; max-width:98vw; }
  .mu-title { font-size: 1.1em; }
  .mu-table th, .mu-table td { padding: 0.5em 0.3em; font-size: 0.95em; }
}
</style>
@endsection 