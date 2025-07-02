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
            <thead><tr><th>Nama</th><th>Role</th></tr></thead>
            <tbody>
                @foreach($users as $user)
                <tr><td>{{ $user->name }}</td><td>{{ ucfirst($user->role) }}</td></tr>
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
            <thead><tr><th>Nama</th><th>Harga</th></tr></thead>
            <tbody>
                @foreach($foods as $food)
                <tr><td>{{ $food->nama }}</td><td>Rp{{ number_format($food->harga,0,',','.') }}</td></tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal Order -->
<div id="orderModal" class="mu-modal" style="display:none;">
    <div class="mu-modal-content">
        <span class="mu-modal-close" onclick="closeModal('orderModal')">&times;</span>
        <h4 class="mu-title">Daftar Pesanan</h4>
        <table class="mu-table">
            <thead><tr><th>Pemesan</th><th>Item</th><th>Qty</th><th>Harga Satuan</th><th>Total</th></tr></thead>
            <tbody>
                @foreach($orders as $order)
                    @if(is_array($order->items))
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $order->nama_pemesan }}</td>
                            <td>{{ $item['nama'] ?? '-' }}</td>
                            <td>{{ $item['qty'] ?? 1 }}</td>
                            <td>Rp{{ number_format($item['harga'] ?? 0,0,',','.') }}</td>
                            <td>Rp{{ number_format(($item['harga'] ?? 0) * ($item['qty'] ?? 1),0,',','.') }}</td>
                        </tr>
                        @endforeach
                    @endif
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
        <table class="mu-table">
            <thead><tr><th>Pemesan</th><th>Total</th><th>Status</th><th>Metode</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($orders as $order)
                    @if($order->payment_method === 'cash' && $order->status === 'menunggu pembayaran')
                    <tr>
                        <td>{{ $order->nama_pemesan }}</td>
                        <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                        <td><span class="mu-badge" style="background:#B3A369;color:#111;">{{ ucfirst($order->status) }}</span></td>
                        <td><span class="mu-badge" style="background:#DA291C;color:#fff;">Cash</span></td>
                        <td>
                            <form method="POST" action="{{ route('admin.orders.confirmCash', $order->id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="mu-btn mu-btn-primary" onclick="return confirm('Konfirmasi pembayaran cash untuk pesanan ini?')">
                                    <i class="fas fa-check"></i> Konfirmasi Pembayaran
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
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