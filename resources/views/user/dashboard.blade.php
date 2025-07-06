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
          <div class="order-title" style="font-size:1.1rem;font-weight:700;color:#222;display:flex;align-items:center;gap:0.5em;"><i class="fas fa-receipt"></i> Order #{{ $lastOrder->id }}</div>
          <div class="order-badge order-badge-date"><i class="fas fa-calendar-alt"></i> {{ $lastOrder->created_at->format('d M Y H:i') }}</div>
          <div class="order-badge order-badge-user"><i class="fas fa-user"></i> {{ $lastOrder->nama_pemesan }}</div>
          <div class="order-badge order-badge-alamat"><i class="fas fa-map-marker-alt"></i> {{ $lastOrder->alamat }}</div>
          <span class="mu-badge mu-badge-danger" style="font-size:1.08em;"><i class="fas fa-money-bill-wave"></i> Rp{{ number_format($lastOrder->total_harga, 0, ',', '.') }}</span>
          <div>
            @if($lastOrder->status == 'menunggu pembayaran')
              <span class="mu-badge mu-badge-status mu-badge-warning"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>
            @elseif($lastOrder->status == 'siap antar')
              <span class="mu-badge mu-badge-status mu-badge-info"><i class="fas fa-biking"></i> Siap Antar</span>
            @elseif($lastOrder->status == 'dalam pengiriman')
              <span class="mu-badge mu-badge-status mu-badge-primary"><i class="fas fa-shipping-fast"></i> Dalam Pengiriman</span>
            @elseif($lastOrder->status == 'selesai')
              <span class="mu-badge mu-badge-status mu-badge-success"><i class="fas fa-check-circle"></i> Selesai</span>
            @else
              <span class="mu-badge mu-badge-status">{{ ucfirst($lastOrder->status) }}</span>
            @endif
          </div>
          <div style="margin-top:0.7rem;">
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
      <div style="display:flex;gap:2rem;flex-wrap:wrap;">
        <div style="flex:1;min-width:120px;text-align:center;">
          <div class="mu-badge mu-badge-type"><i class="fas fa-list-ol"></i> Total Pesanan</div>
          <div class="mu-title" style="font-size:1.5rem;margin-top:0.5rem;font-weight:900;">{{ $totalOrders }}</div>
        </div>
        <div style="flex:1;min-width:120px;text-align:center;">
          <div class="mu-badge mu-badge-type"><i class="fas fa-wallet"></i> Total Pengeluaran</div>
          <div class="mu-title" style="font-size:1.5rem;margin-top:0.5rem;font-weight:900;">Rp{{ number_format($totalSpent, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection 