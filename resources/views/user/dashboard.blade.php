@extends('layouts.app')

@section('content')
<div class="dashboard-bg">
  <div class="dashboard-main-card">
    <div class="dashboard-header">
      <div class="avatar-xl">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <h1 class="dashboard-title">Halo, {{ auth()->user()->name }}!</h1>
      <p class="dashboard-subtext">Selamat datang di Tastoria, nikmati kemudahan memesan makanan favoritmu.</p>
    </div>
    <a href="{{ route('orders.index') }}" class="btn-main"><i class="fas fa-history"></i> Lihat Riwayat Pesanan</a>
    <div class="dashboard-section">
      <h2><i class="fas fa-utensils"></i> Pesanan Terakhir</h2>
      @if($lastOrder)
        <div class="order-flex">
          <div class="order-info">
            <div class="order-id"><i class="fas fa-receipt"></i> <b>Order #{{ $lastOrder->id }}</b></div>
            <div class="order-date"><i class="fas fa-calendar-alt"></i> {{ $lastOrder->created_at->format('d M Y H:i') }}</div>
            <div class="order-user"><i class="fas fa-user"></i> {{ $lastOrder->nama_pemesan }}</div>
            <div class="order-address"><i class="fas fa-map-marker-alt"></i> {{ $lastOrder->alamat }}</div>
          </div>
          <div class="order-divider"></div>
          <div class="order-right">
            <div class="order-price">Rp{{ number_format($lastOrder->total_harga, 0, ',', '.') }}</div>
            <div class="order-status order-status-{{ str_replace(' ', '-', $lastOrder->status) }}">
              <i class="fas fa-clock"></i> {{ ucfirst($lastOrder->status) }}
            </div>
            <a href="{{ route('orders.index') }}" class="btn-detail">Detail Pesanan</a>
          </div>
        </div>
      @else
        <div style="text-align:center;padding:2.5rem 0;">
          <i class="fas fa-receipt" style="font-size:2rem;color:#ccc;"></i>
          <h5 style="color:#888;">Belum Ada Pesanan</h5>
          <p style="color:#888;">Mulai pesan makanan favoritmu sekarang!</p>
          <a href="{{ route('foods.index') }}" class="mu-btn" style="margin-top:1rem;"><i class="fas fa-utensils"></i> Lihat Menu</a>
        </div>
      @endif
    </div>
    @if($totalOrders > 0)
    <div class="dashboard-section">
      <h2><i class="fas fa-chart-bar"></i> Statistik Pesanan</h2>
      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-list-ol"></i></div>
          <div class="stat-label">Total Pesanan</div>
          <div class="stat-value">{{ $totalOrders }}</div>
        </div>
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-wallet"></i></div>
          <div class="stat-label">Total Pengeluaran</div>
          <div class="stat-value">Rp{{ number_format($totalSpent, 0, ',', '.') }}</div>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection 