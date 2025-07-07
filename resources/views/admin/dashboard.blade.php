@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card" style="background:none;box-shadow:none;padding:0;">
        <div class="mu-card-body" style="padding:0;">
            <h4 class="mu-title" style="margin-bottom:2.2rem;"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h4>
            <div class="admin-stat-row">
                <div class="admin-stat-card">
                    <span class="admin-stat-icon-wrap"><i class="fas fa-users admin-stat-icon"></i></span>
                    <span class="admin-stat-badge">Total User</span>
                    <div class="admin-stat-value">{{ $totalUsers }}</div>
                </div>
                <div class="admin-stat-card">
                    <span class="admin-stat-icon-wrap"><i class="fas fa-utensils admin-stat-icon"></i></span>
                    <span class="admin-stat-badge">Total Menu</span>
                    <div class="admin-stat-value">{{ $totalFoods }}</div>
                </div>
                <div class="admin-stat-card">
                    <span class="admin-stat-icon-wrap"><i class="fas fa-receipt admin-stat-icon"></i></span>
                    <span class="admin-stat-badge">Total Pesanan</span>
                    <div class="admin-stat-value">{{ $totalOrders }}</div>
                </div>
                <div class="admin-stat-card">
                    <span class="admin-stat-icon-wrap"><i class="fas fa-money-bill-wave admin-stat-icon"></i></span>
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
        <svg class="empty-svg" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="32" cy="32" r="32" fill="#f7ecd2"/>
          <path d="M20 36h24M20 28h24M24 20h16" stroke="#DA291C" stroke-width="3" stroke-linecap="round"/>
          <circle cx="32" cy="48" r="4" fill="#28a745"/>
        </svg>
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

@push('styles')
<style>
:root {
    --tastoria-red: #DA291C;
    --tastoria-gold: #B3A369;
    --tastoria-pastel-gold: #f7ecd2;
    --tastoria-glass: rgba(255,255,255,0.82);
}
.admin-stat-row {
    display: flex;
    gap: 2.7em;
    flex-wrap: wrap;
    justify-content: center;
    margin-bottom: 2.7em;
}
.admin-stat-card {
    background: var(--tastoria-glass);
    border-radius: 1.7em;
    box-shadow: 0 8px 36px #da291c18;
    padding: 2.7em 2.9em 2.2em 2.9em;
    min-width: 230px;
    text-align: center;
    flex: 1 1 230px;
    margin-bottom: 1.7em;
    position: relative;
    transition: box-shadow 0.2s, transform 0.2s, border 0.2s;
    border: 2.5px solid var(--tastoria-gold);
    backdrop-filter: blur(7px);
}
.admin-stat-card:hover {
    box-shadow: 0 16px 48px #da291c33;
    transform: translateY(-10px) scale(1.05);
    border: 3px solid var(--tastoria-gold);
}
.admin-stat-icon-wrap {
    width: 3.5em;
    height: 3.5em;
    background: var(--tastoria-pastel-gold);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 0.7em auto;
    box-shadow: 0 4px 18px #b3a36955;
    border: 2.5px solid var(--tastoria-gold);
}
.admin-stat-icon {
    font-size: 2.1em;
    color: var(--tastoria-gold);
    display: block;
}
.admin-stat-badge {
    background: var(--tastoria-red);
    color: #fff;
    font-size: 1.13em;
    font-weight: 900;
    border-radius: 0.8em;
    padding: 0.35em 1.3em;
    display: inline-block;
    margin-bottom: 0.8em;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 8px #da291c22;
}
.admin-stat-value {
    font-size: 2.7em;
    font-weight: 900;
    color: #222;
    margin-top: 0.2em;
    letter-spacing: 1px;
    animation: stat-pop 0.7s cubic-bezier(.68,-0.55,.27,1.55);
}
@keyframes stat-pop {
    0% { transform: scale(0.7); opacity: 0; }
    80% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); }
}
.admin-nav-row {
    margin-top: 2.7rem;
    display: flex;
    gap: 1.5em;
    flex-wrap: wrap;
    justify-content: center;
}
.admin-nav-btn {
    background: #fff;
    color: var(--tastoria-red);
    border: 2.5px solid var(--tastoria-red);
    border-radius: 1.3em;
    font-weight: 900;
    padding: 1em 2.3em;
    font-size: 1.15em;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 12px #da291c11;
    display: flex;
    align-items: center;
    gap: 1em;
    cursor: pointer;
    text-decoration: none;
    position: relative;
    overflow: hidden;
}
.admin-nav-btn i { font-size: 1.3em; }
.admin-nav-btn:active::after {
    content: '';
    position: absolute;
    left: 50%; top: 50%;
    width: 200%; height: 200%;
    background: rgba(218,41,28,0.13);
    border-radius: 50%;
    transform: translate(-50%,-50%) scale(0.7);
    animation: ripple 0.4s linear;
    pointer-events: none;
    z-index: 1;
}
@keyframes ripple {
    0% { opacity: 0.7; transform: translate(-50%,-50%) scale(0.7); }
    80% { opacity: 0.3; transform: translate(-50%,-50%) scale(1.2); }
    100% { opacity: 0; transform: translate(-50%,-50%) scale(1.5); }
}
.admin-nav-btn:hover {
    background: var(--tastoria-red);
    color: #fff;
    box-shadow: 0 8px 24px #da291c22;
}
.admin-section {
    margin-top: 3em;
    background: var(--tastoria-glass);
    border-radius: 1.5em;
    box-shadow: 0 8px 36px #da291c18;
    padding: 3em 2.7em;
    border: 2.5px solid var(--tastoria-gold);
    backdrop-filter: blur(7px);
}
.admin-section-title {
    text-align: center;
    font-weight: 900;
    font-size: 1.8em;
    margin-bottom: 1.7em;
    color: #222;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8em;
}
.admin-section-title .section-icon {
    font-size: 1.4em;
    color: var(--tastoria-red);
}
.admin-section-empty {
    text-align: center;
    color: #888;
    padding: 3.5em 0 2.2em 0;
}
.admin-section-empty .empty-svg {
    width: 110px;
    height: 110px;
    margin-bottom: 1.5rem;
    display: block;
    margin-left: auto;
    margin-right: auto;
}
@media (max-width: 900px) {
    .admin-stat-row { flex-direction: column; gap: 1.3em; }
    .admin-nav-row { flex-direction: column; gap: 0.9em; }
}
</style>
@endpush
@endsection 