@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:900px;margin:2rem auto;">
    <div class="mu-card" style="box-shadow:0 8px 32px rgba(218,41,28,0.10);border:0;">
        <div class="mu-card-body">
            <h2 class="mu-title" style="margin-bottom:1.5rem;display:flex;align-items:center;gap:10px;font-size:2.1rem;"><i class="fas fa-user-circle"></i> Dashboard Pengguna</h2>
            <div class="mu-badge mu-badge-welcome" style="margin-bottom:1.2em;"><i class="fas fa-hand-peace"></i> Selamat datang, {{ auth()->user()->name }}!</div>
            <div style="margin-bottom:2em;">
                <a href="{{ route('orders.index') }}" class="mu-btn mu-btn-primary" style="font-size:1.1em;"><i class="fas fa-history"></i> Lihat Riwayat Pesanan</a>
            </div>
            <div class="mu-card" style="margin-bottom:1.5rem;background:rgba(255,255,255,0.98);box-shadow:0 4px 16px rgba(218,41,28,0.07);border:0;">
                <div class="mu-card-body">
                    <h5 class="mu-card-title" style="font-size:1.2rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:8px;"><i class="fas fa-utensils"></i> Pesanan Terakhir</h5>
                    @if($lastOrder)
                        <div style="display:flex;flex-wrap:wrap;gap:1.5rem;align-items:flex-start;">
                            <div style="flex:2;min-width:180px;">
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <span class="mu-order-header"><i class="fas fa-receipt"></i> <b>Order #{{ $lastOrder->id }}</b></span>
                                    <span class="mu-badge mu-badge-date"><i class="fas fa-calendar-alt"></i> {{ $lastOrder->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                            <div style="flex:2;min-width:180px;display:flex;flex-direction:column;gap:8px;">
                                <span class="mu-badge mu-badge-user"><i class="fas fa-user"></i> {{ $lastOrder->nama_pemesan }}</span>
                                <span class="mu-badge mu-badge-address"><i class="fas fa-map-marker-alt"></i> {{ $lastOrder->alamat }}</span>
                            </div>
                            <div style="flex:1;text-align:center;align-self:center;">
                                <span class="mu-price" style="font-size:1.4rem;font-weight:900;color:#DA291C;"><i class="fas fa-money-bill-wave"></i> Rp{{ number_format($lastOrder->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="flex:1;text-align:center;align-self:center;">
                                @if($lastOrder->status == 'menunggu pembayaran')
                                    <span class="mu-badge mu-badge-status mu-badge-wait"><i class="fas fa-clock"></i> Menunggu Pembayaran</span>
                                @elseif($lastOrder->status == 'siap antar')
                                    <span class="mu-badge mu-badge-status mu-badge-ready"><i class="fas fa-biking"></i> Siap Antar</span>
                                @elseif($lastOrder->status == 'dalam pengiriman')
                                    <span class="mu-badge mu-badge-status mu-badge-ongoing"><i class="fas fa-shipping-fast"></i> Dalam Pengiriman</span>
                                @elseif($lastOrder->status == 'selesai')
                                    <span class="mu-badge mu-badge-status mu-badge-done"><i class="fas fa-check-circle"></i> Selesai</span>
                                @else
                                    <span class="mu-badge mu-badge-status">{{ ucfirst($lastOrder->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top:1.2em;">
                            <a href="{{ route('orders.index') }}" class="mu-btn mu-btn-outline" style="font-size:1.05em;"><i class="fas fa-info-circle"></i> Detail Pesanan</a>
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
            </div>
            @if($totalOrders > 0)
            <div class="mu-card" style="background:rgba(255,255,255,0.98);box-shadow:0 4px 16px rgba(218,41,28,0.07);border:0;">
                <div class="mu-card-body">
                    <h5 class="mu-card-title" style="font-size:1.2rem;margin-bottom:1.2rem;display:flex;align-items:center;gap:8px;"><i class="fas fa-chart-bar"></i> Statistik Pesanan</h5>
                    <div style="display:flex;gap:2rem;flex-wrap:wrap;margin-top:1rem;">
                        <div style="flex:1;min-width:150px;text-align:center;">
                            <div class="mu-badge mu-badge-type"><i class="fas fa-list-ol"></i> Total Pesanan</div>
                            <div class="mu-title" style="font-size:1.7rem;margin-top:0.5rem;font-weight:900;">{{ $totalOrders }}</div>
                        </div>
                        <div style="flex:1;min-width:150px;text-align:center;">
                            <div class="mu-badge mu-badge-type"><i class="fas fa-wallet"></i> Total Pengeluaran</div>
                            <div class="mu-title" style="font-size:1.7rem;margin-top:0.5rem;font-weight:900;">Rp{{ number_format($totalSpent, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 