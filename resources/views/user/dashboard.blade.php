@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:900px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-user"></i> Dashboard Pengguna</h4>
            <div class="mu-badge" style="margin-bottom:1.2em;">Selamat datang, {{ auth()->user()->name }}!</div>
            <div style="margin-bottom:2em;">
                <a href="/orders" class="mu-btn mu-btn-primary"><i class="fas fa-list"></i> Lihat Riwayat Pesanan</a>
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
                                @if($lastOrder->status == 'pending')
                                    <span class="mu-badge" style="background:#B3A369;color:#fff;">Menunggu</span>
                                @elseif($lastOrder->status == 'processing')
                                    <span class="mu-badge" style="background:#DA291C;color:#fff;">Diproses</span>
                                @elseif($lastOrder->status == 'delivered')
                                    <span class="mu-badge" style="background:#111;color:#B3A369;">Selesai</span>
                                @else
                                    <span class="mu-badge">{{ ucfirst($lastOrder->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="margin-top:1em;">
                            <a href="/orders" class="mu-btn mu-btn-outline"><i class="fas fa-eye"></i> Detail Pesanan</a>
                        </div>
                    @else
                        <div style="text-align:center;padding:2.5rem 0;">
                            <i class="fas fa-receipt" style="font-size:2rem;color:#ccc;"></i>
                            <h5 style="color:#888;">Belum Ada Pesanan</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 