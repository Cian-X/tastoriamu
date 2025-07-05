@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:900px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-user"></i> Dashboard Pengguna</h4>
            <div class="mu-badge" style="margin-bottom:1.2em;">Selamat datang, {{ auth()->user()->name }}!</div>
            <div style="margin-bottom:2em;">
                <a href="{{ route('orders.index') }}" class="mu-btn mu-btn-primary"><i class="fas fa-list"></i> Lihat Riwayat Pesanan</a>
            </div>
            <div class="mu-card" style="margin-bottom:1.5rem;">
                <div class="mu-card-body">
                    <h6 class="mu-card-title"><i class="fas fa-utensils"></i> Pesanan Terakhir</h6>
                    @if($lastOrder)
                        <div style="display:flex;flex-wrap:wrap;gap:1.5rem;align-items:center;">
                            <div style="flex:2;min-width:180px;">
                                <h6 class="mu-card-title">Order #{{ $lastOrder->id }}</h6>
                                <small class="mu-badge"><i class="fas fa-calendar"></i> {{ $lastOrder->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <div style="flex:2;min-width:180px;">
                                <h6 class="mu-card-title">{{ $lastOrder->nama_pemesan }}</h6>
                                <small class="mu-badge"><i class="fas fa-map-marker-alt"></i> {{ $lastOrder->alamat }}</small>
                            </div>
                            <div style="flex:1;text-align:center;">
                                <span class="mu-price">Rp{{ number_format($lastOrder->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="flex:1;text-align:center;">
                                @if($lastOrder->status == 'menunggu pembayaran')
                                    <span class="mu-badge" style="background:#ffc107;color:#000;">Menunggu Pembayaran</span>
                                @elseif($lastOrder->status == 'siap antar')
                                    <span class="mu-badge" style="background:#17a2b8;color:#fff;">Siap Antar</span>
                                @elseif($lastOrder->status == 'dalam pengiriman')
                                    <span class="mu-badge" style="background:#007bff;color:#fff;">Dalam Pengiriman</span>
                                @elseif($lastOrder->status == 'selesai')
                                    <span class="mu-badge" style="background:#28a745;color:#fff;">Selesai</span>
                                @else
                                    <span class="mu-badge">{{ ucfirst($lastOrder->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top:1em;">
                            <a href="{{ route('orders.index') }}" class="mu-btn mu-btn-outline"><i class="fas fa-eye"></i> Detail Pesanan</a>
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
            <div class="mu-card">
                <div class="mu-card-body">
                    <h6 class="mu-card-title"><i class="fas fa-chart-bar"></i> Statistik Pesanan</h6>
                    <div style="display:flex;gap:2rem;flex-wrap:wrap;margin-top:1rem;">
                        <div style="flex:1;min-width:150px;text-align:center;">
                            <div class="mu-badge mu-badge-type">Total Pesanan</div>
                            <div class="mu-title" style="font-size:1.5rem;margin-top:0.5rem;">{{ $totalOrders }}</div>
                        </div>
                        <div style="flex:1;min-width:150px;text-align:center;">
                            <div class="mu-badge mu-badge-type">Total Pengeluaran</div>
                            <div class="mu-title" style="font-size:1.5rem;margin-top:0.5rem;">Rp{{ number_format($totalSpent, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 