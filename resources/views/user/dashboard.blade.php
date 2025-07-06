@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:700px;margin:2.5rem auto;">
  <div class="mu-card" style="padding:2.2rem 1.5rem 1.5rem 1.5rem;">
    <h2 class="mu-title" style="font-size:2rem;margin-bottom:0.5rem;"><i class="fas fa-user-circle"></i> Halo, {{ auth()->user()->name }}!</h2>
    <div style="color:#666;font-size:1.08rem;margin-bottom:1.5rem;">Selamat datang di Tastoria, nikmati kemudahan memesan makanan favoritmu.</div>
    <a href="{{ route('orders.index') }}" class="mu-btn mu-btn-primary" style="font-size:1.1em;margin-bottom:2rem;"><i class="fas fa-history"></i> Lihat Riwayat Pesanan</a>
    <div class="mu-card" style="background:#fff;box-shadow:0 2px 12px #eee;border-radius:16px;padding:1.5rem 1rem;margin-bottom:2rem;">
      <h3 class="mu-card-title" style="font-size:1.2rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:8px;"><i class="fas fa-utensils"></i> Pesanan Terakhir</h3>
      @if($lastOrder)
        <div style="display:flex;flex-direction:column;gap:0.7rem;">
          <div class="order-title" style="font-size:1.1rem;font-weight:700;color:#d32f2f;display:flex;align-items:center;gap:0.5em;"><i class="fas fa-receipt"></i> Order #{{ $lastOrder->id }}</div>
          <div style="display:flex;flex-wrap:wrap;gap:0.7em 1em;align-items:center;margin-bottom:0.5em;">
            <span class="mu-badge mu-badge-date2"><i class="fas fa-calendar-alt"></i> {{ $lastOrder->created_at->format('d M Y H:i') }}</span>
            <span class="mu-badge mu-badge-user2"><i class="fas fa-user"></i> {{ $lastOrder->nama_pemesan }}</span>
            <span class="mu-badge mu-badge-alamat2"><i class="fas fa-map-marker-alt"></i> {{ $lastOrder->alamat }}</span>
          </div>
          <div style="margin-bottom:0.5em;">
            <span class="mu-price">Rp{{ number_format($lastOrder->total_harga, 0, ',', '.') }}</span>
          </div>
          <div style="display:flex;flex-wrap:wrap;gap:0.7em 1em;align-items:center;">
            @if($lastOrder->status == 'menunggu pembayaran')
              <span class="mu-badge mu-badge-status mu-badge-warning"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>
            @elseif($lastOrder->status == 'siap antar')
              <span class="mu-badge mu-badge-status mu-badge-info"><i class="fas fa-biking"></i> Siap Antar</span>
            @elseif($lastOrder->status == 'dalam pengiriman')
              <span class="mu-badge mu-badge-status mu-badge-primary"><i class="fas fa-shipping-fast"></i> Dalam Pengiriman</span>
            @elseif($lastOrder->status == 'selesai')
              <span class="mu-badge mu-badge-status mu-badge-success2"><i class="fas fa-check-circle"></i> Selesai</span>
            @else
              <span class="mu-badge mu-badge-status mu-badge-danger">{{ ucfirst($lastOrder->status) }}</span>
            @endif
          </div>
          <div style="margin-top:0.9rem;">
            <a href="{{ route('orders.index') }}" class="mu-btn mu-btn-outline" style="font-size:1em;"><i class="fas fa-info-circle"></i> Detail Pesanan</a>
          </div>
        </div>
      @else
        <div style="text-align:center;padding:2rem 0;">
          <i class="fas fa-receipt" style="font-size:2rem;color:#ccc;"></i>
          <h5 style="color:#888;">Belum Ada Pesanan</h5>
          <p style="color:#888;">Mulai pesan makanan favoritmu sekarang!</p>
          <a href="{{ route('foods.index') }}" class="mu-btn" style="margin-top:1rem;"><i class="fas fa-utensils"></i> Lihat Menu</a>
        </div>
      @endif
    </div>
    @if($totalOrders > 0)
    <div class="mu-card" style="background:#fff;box-shadow:0 2px 12px #eee;border-radius:16px;padding:1.5rem 1rem;">
      <h3 class="mu-card-title" style="font-size:1.2rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:8px;"><i class="fas fa-chart-bar"></i> Statistik Pesanan</h3>
      <div class="mu-stats-row">
        <div class="mu-stats-col">
          <span class="mu-badge mu-badge-stats mu-badge-stats-red"><i class="fas fa-list-ol"></i> Total Pesanan</span>
          <div class="mu-stats-value">{{ $totalOrders }}</div>
        </div>
        <div class="mu-stats-col">
          <span class="mu-badge mu-badge-stats mu-badge-stats-blue"><i class="fas fa-wallet"></i> Total Pengeluaran</span>
          <div class="mu-stats-value">Rp{{ number_format($totalSpent, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection 

{{-- Tambahkan ke file CSS global Anda (misal: public/css/mu-theme.css) --}}
<style>
.mu-card {
  box-shadow: 0 2px 12px rgba(218,41,28,0.07);
  border-radius: 1.2em;
  overflow: hidden;
}
.mu-badge {
  display: inline-flex;
  align-items: center;
  border-radius: 1.2em;
  font-size: 1em;
  font-weight: 600;
  padding: 0.38em 1.1em;
  margin-bottom: 0.18em;
  margin-right: 0.3em;
  gap: 0.45em;
  border: 1.5px solid #e3e8ee;
  background: #f8f9fa;
  box-shadow: 0 1px 4px #eee;
}
.mu-badge-date {
  background: #e0e0e0;
  color: #444;
  border-color: #bdbdbd;
}
.mu-badge-user {
  background: #2196f3;
  color: #fff;
  border-color: #1976d2;
}
.mu-badge-alamat {
  background: #ffe082;
  color: #795548;
  border-color: #ffd54f;
}
.mu-badge-status { font-weight:700;padding:0.5em 1.2em;border-radius:1em;font-size:1em; border-width:2px; }
.mu-badge-warning { background:#ffc107;color:#111; border-color:#ffecb3; }
.mu-badge-info { background:#29b6f6;color:#fff; border-color:#0288d1; }
.mu-badge-primary { background:#1976d2;color:#fff; border-color:#1565c0; }
.mu-badge-success { background:#43a047;color:#fff; border-color:#388e3c; }
.mu-badge-danger { background:#e53935;color:#fff; border-color:#b71c1c; }
.mu-price {
  color: #d32f2f;
  font-size: 1.6em;
  font-weight: 800;
  letter-spacing: 0.5px;
  margin-bottom: 0.2em;
  display: inline-block;
}
.mu-btn-outline { border:2px solid #d32f2f;color:#d32f2f;background:#fff;transition:all 0.2s; }
.mu-btn-outline:hover { background:#d32f2f;color:#fff; }
.mu-badge-date2 {
  background: #e0e0e0 !important;
  color: #444 !important;
  border-color: #bdbdbd !important;
}
.mu-badge-user2 {
  background: #2196f3 !important;
  color: #fff !important;
  border-color: #1976d2 !important;
}
.mu-badge-alamat2 {
  background: #ffe082 !important;
  color: #795548 !important;
  border-color: #ffd54f !important;
}
.mu-badge-success2 {
  background: #43a047 !important;
  color: #fff !important;
  border-color: #b7eb8f !important;
}
.mu-badge-stats {
  font-size: 1em;
  font-weight: 700;
  padding: 0.45em 1.2em;
  border-radius: 1.2em;
  margin-bottom: 0.5em;
  display: inline-flex;
  align-items: center;
  gap: 0.5em;
}
.mu-badge-stats-red {
  background: #d32f2f !important;
  color: #fff !important;
}
.mu-badge-stats-blue {
  background: #1976d2 !important;
  color: #fff !important;
}
.mu-stats-row {
  display: flex;
  gap: 2.5rem;
  flex-wrap: wrap;
  justify-content: center;
  align-items: flex-end;
}
.mu-stats-col {
  flex: 1;
  min-width: 140px;
  text-align: center;
}
.mu-stats-value {
  font-size: 2.1rem;
  font-weight: 900;
  color: #222;
  margin-top: 0.5em;
  letter-spacing: 1px;
}
</style> 