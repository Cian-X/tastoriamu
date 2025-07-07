@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card" style="background:none;box-shadow:none;padding:0;">
        <div class="mu-card-body" style="padding:0;">
            <h4 class="mu-title" style="margin-bottom:2.2rem;"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h4>
            <div class="admin-stat-row">
                <div class="admin-stat-card">
                    <span class="admin-stat-icon"><i class="fas fa-users"></i></span>
                    <span class="admin-stat-badge">Total User</span>
                    <div class="admin-stat-value">{{ $totalUsers }}</div>
                </div>
                <div class="admin-stat-card">
                    <span class="admin-stat-icon"><i class="fas fa-utensils"></i></span>
                    <span class="admin-stat-badge">Total Menu</span>
                    <div class="admin-stat-value">{{ $totalFoods }}</div>
                </div>
                <div class="admin-stat-card">
                    <span class="admin-stat-icon"><i class="fas fa-receipt"></i></span>
                    <span class="admin-stat-badge">Total Pesanan</span>
                    <div class="admin-stat-value">{{ $totalOrders }}</div>
                </div>
                <div class="admin-stat-card">
                    <span class="admin-stat-icon"><i class="fas fa-money-bill-wave"></i></span>
                    <span class="admin-stat-badge">Total Pendapatan</span>
                    <div class="admin-stat-value">Rp{{ number_format($totalRevenue,0,',','.') }}</div>
                </div>
            </div>
            <div class="admin-nav-row">
                <a href="{{ route('admin.users') }}" class="admin-nav-btn"><i class="fas fa-users"></i> Kelola User</a>
                <a href="{{ route('admin.orders') }}" class="admin-nav-btn"><i class="fas fa-list"></i> Semua Pesanan</a>
                <a href="{{ route('foods.index') }}" class="admin-nav-btn"><i class="fas fa-utensils"></i> Kelola Menu</a>
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

<div class="admin-section">
    <div class="admin-section-title"><span class="section-icon"><i class="fas fa-money-bill-wave"></i></span> Konfirmasi Pembayaran Transfer
        @if($pendingTransferOrders->count() > 0)
            <span class="mu-badge" style="background:#DA291C;color:#fff;margin-left:0.7em;">{{ $pendingTransferOrders->count() }}</span>
        @endif
    </div>
    @if($pendingTransferOrders->count() > 0)
    <table class="mu-table">
        <thead><tr><th>Pemesan</th><th>Total</th><th>Status</th><th>Metode</th><th>Bukti Transfer</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($pendingTransferOrders as $order)
            <tr>
                <td>{{ $order->nama_pemesan }}</td>
                <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                <td><span class="mu-badge" style="background:#ffc107;color:#000;">{{ ucfirst($order->status) }}</span></td>
                <td><span class="mu-badge" style="background:#1877f2;color:#fff;">Transfer</span></td>
                <td>
                    @if($order->bukti_transfer)
                        <a href="{{ asset('storage/'.$order->bukti_transfer) }}" target="_blank">Lihat Bukti</a>
                    @else
                        <span style="color:#dc3545;">Belum Upload</span>
                    @endif
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.orders.confirmPayment', $order->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="mu-btn mu-btn-primary" onclick="return confirm('Konfirmasi pembayaran transfer untuk pesanan ini?')">
                            <i class="fas fa-check"></i> Konfirmasi Pembayaran
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="admin-section-empty">
        <i class="fas fa-check-circle empty-icon"></i>
        <p>Tidak ada pesanan transfer yang menunggu konfirmasi pembayaran</p>
    </div>
    @endif
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
.admin-stat-row {
    display: flex;
    gap: 2.2em;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 2.2em;
}
.admin-stat-card {
    background: #fff;
    border-radius: 1.3em;
    box-shadow: 0 4px 24px #da291c18;
    padding: 2.2em 2.5em 1.7em 2.5em;
    min-width: 210px;
    text-align: center;
    flex: 1 1 210px;
    margin-bottom: 1.2em;
    position: relative;
    transition: box-shadow 0.2s, transform 0.2s;
}
.admin-stat-card:hover {
    box-shadow: 0 8px 32px #da291c33;
    transform: translateY(-6px) scale(1.03);
}
.admin-stat-icon {
    font-size: 2.3em;
    margin-bottom: 0.3em;
    color: #DA291C;
    display: block;
}
.admin-stat-badge {
    background: #DA291C;
    color: #fff;
    font-size: 1.05em;
    font-weight: 800;
    border-radius: 0.7em;
    padding: 0.3em 1.2em;
    display: inline-block;
    margin-bottom: 0.7em;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px #da291c22;
}
.admin-stat-value {
    font-size: 2.3em;
    font-weight: 900;
    color: #222;
    margin-top: 0.2em;
    letter-spacing: 1px;
}
.admin-nav-row {
    margin-top: 2rem;
    display: flex;
    gap: 1.2em;
    flex-wrap: wrap;
    justify-content: center;
}
.admin-nav-btn {
    background: #fff;
    color: #DA291C;
    border: 2px solid #DA291C;
    border-radius: 0.7em;
    font-weight: 700;
    padding: 0.7em 1.7em;
    font-size: 1.08em;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px #da291c11;
    display: flex;
    align-items: center;
    gap: 0.7em;
    cursor: pointer;
    text-decoration: none;
}
.admin-nav-btn:hover {
    background: #DA291C;
    color: #fff;
    box-shadow: 0 4px 16px #da291c22;
}
.admin-section {
    margin-top: 2.5em;
    background: #fff;
    border-radius: 1.3em;
    box-shadow: 0 4px 24px #da291c18;
    padding: 2.2em 2.5em;
}
.admin-section-title {
    text-align: center;
    font-weight: 800;
    font-size: 1.5em;
    margin-bottom: 1.2em;
    color: #222;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6em;
}
.admin-section-title .section-icon {
    font-size: 1.2em;
    color: #DA291C;
}
.admin-section-empty {
    text-align: center;
    color: #888;
    padding: 2.5em 0 1.5em 0;
}
.admin-section-empty .empty-icon {
    font-size: 2.5em;
    color: #28a745;
    margin-bottom: 1rem;
}
@media (max-width: 900px) {
    .admin-stat-row { flex-direction: column; gap: 1em; }
    .admin-nav-row { flex-direction: column; gap: 0.7em; }
}
</style>
@endsection 