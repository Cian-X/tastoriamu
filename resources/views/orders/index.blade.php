@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-list"></i> Riwayat Pesanan</h4>
            @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="mu-card" style="margin-bottom:1.5rem;">
                    <div class="mu-card-body">
                        <div style="display:flex;flex-wrap:wrap;gap:1.5rem;align-items:center;">
                            <div style="flex:2;min-width:180px;">
                                <h6 class="mu-card-title">Order #{{ $order->id }}</h6>
                                <small class="mu-badge" style="margin-bottom:0.3em;"><i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <div style="flex:2;min-width:180px;">
                                <h6 class="mu-card-title">{{ $order->nama_pemesan }}</h6>
                                <small class="mu-badge"><i class="fas fa-map-marker-alt"></i> {{ $order->alamat }}</small>
                                @if($order->tracking_number)
                                <br><small class="mu-badge"><i class="fas fa-truck"></i> {{ $order->tracking_number }}</small>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                <span class="mu-price">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="flex:1;text-align:center;">
                                @if($order->status == 'pending')
                                    <span class="mu-badge" style="background:#B3A369;color:#fff;">Menunggu</span>
                                @elseif($order->status == 'processing')
                                    <span class="mu-badge" style="background:#DA291C;color:#fff;">Diproses</span>
                                @elseif($order->status == 'delivered')
                                    <span class="mu-badge" style="background:#111;color:#B3A369;">Selesai</span>
                                @else
                                    <span class="mu-badge">{{ ucfirst($order->status) }}</span>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                @if($order->payment_status == 'unpaid')
                                    <span class="mu-badge" style="background:#DA291C;color:#fff;">Belum Bayar</span>
                                    <form action="{{ route('orders.confirmPayment', $order->id) }}" method="POST" style="margin-top:0.5em;">
                                        @csrf
                                        <button type="submit" class="mu-btn">Konfirmasi Pembayaran</button>
                                    </form>
                                @else
                                    <span class="mu-badge" style="background:#B3A369;color:#111;">Sudah Bayar</span>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                <button class="mu-btn-outline" type="button" data-bs-toggle="collapse" data-bs-target="#order{{ $order->id }}"><i class="fas fa-eye"></i> Detail</button>
                            </div>
                        </div>
                        <div class="collapse" id="order{{ $order->id }}" style="margin-top:1.2em;">
                            <div class="mu-card mu-card-body" style="background:#f9f9f9;">
                                <h6>Detail Pesanan:</h6>
                                @php $items = json_decode($order->items, true); @endphp
                                @foreach($items as $item)
                                <div style="display:flex;justify-content:space-between;margin-bottom:0.3em;">
                                    <span>{{ $item['nama'] }} x{{ $item['qty'] }}</span>
                                    <span>Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                                <hr>
                                <div style="display:flex;justify-content:space-between;">
                                    <strong>Total</strong>
                                    <strong class="mu-price">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align:center;padding:2.5rem 0;">
                    <i class="fas fa-receipt" style="font-size:3rem;color:#ccc;"></i>
                    <h5 style="color:#888;">Belum Ada Pesanan</h5>
                    <p style="color:#888;">Anda belum memiliki riwayat pesanan</p>
                    <a href="{{ route('foods.index') }}" class="mu-btn" style="margin-top:1rem;"><i class="fas fa-utensils"></i> Pesan Sekarang</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 