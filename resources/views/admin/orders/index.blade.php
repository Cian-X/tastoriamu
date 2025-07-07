@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1200px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-list"></i> Semua Pesanan</h4>
            @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="mu-card" style="margin-bottom:1.5rem;">
                    <div class="mu-card-body">
                        <div style="display:flex;flex-wrap:wrap;gap:1.5rem;align-items:center;">
                            <div style="flex:1;min-width:150px;">
                                <h6 class="mu-card-title">Order #{{ $order->id }}</h6>
                                <small class="mu-badge" style="margin-bottom:0.3em;"><i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <div style="flex:1;min-width:150px;">
                                <h6 class="mu-card-title">{{ $order->user->name ?? $order->nama_pemesan }}</h6>
                                <small class="mu-badge"><i class="fas fa-map-marker-alt"></i> {{ $order->alamat }}</small>
                                @if($order->tracking_number)
                                <br><small class="mu-badge"><i class="fas fa-truck"></i> {{ $order->tracking_number }}</small>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                <span class="mu-price">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="flex:1;text-align:center;">
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
                            </div>
                            <div style="flex:1;text-align:center;">
                                @if($order->payment_status == 'unpaid')
                                    <span class="mu-badge" style="background:#dc3545;color:#fff;">Belum Bayar</span>
                                    @if($order->payment_method == 'cash' && $order->status == 'menunggu pembayaran')
                                    <form action="{{ route('admin.orders.confirmPayment', $order->id) }}" method="POST" style="margin-top:0.5em;">
                                        @csrf
                                        <button type="submit" class="mu-btn mu-btn-sm">Konfirmasi Pembayaran</button>
                                    </form>
                                    @endif
                                @else
                                    <span class="mu-badge" style="background:#28a745;color:#fff;">Sudah Bayar</span>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                <button class="mu-btn-outline mu-btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#order{{ $order->id }}"><i class="fas fa-eye"></i> Detail</button>
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
                                @if($order->payment_method)
                                <div style="margin-top:0.5em;">
                                    <small><strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment_method) }}</small>
                                </div>
                                @endif
                                @if($order->estimated_delivery)
                                <div style="margin-top:0.5em;">
                                    <small><strong>Estimasi Pengiriman:</strong> {{ $order->estimated_delivery->format('d M Y H:i') }}</small>
                                </div>
                                @endif
                                @if($order->confirmed_at)
                                <div style="margin-top:0.5em;">
                                    <small><strong>Dikonfirmasi:</strong> {{ $order->confirmed_at ? \Carbon\Carbon::parse($order->confirmed_at)->format('d M Y H:i') : '-' }}</small>
                                </div>
                                @endif
                                @if($order->delivered_at)
                                <div style="margin-top:0.5em;">
                                    <small><strong>Dikirim:</strong> {{ $order->delivered_at->format('d M Y H:i') }}</small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div style="text-align:center;padding:2.5rem 0;">
                    <i class="fas fa-receipt" style="font-size:3rem;color:#ccc;"></i>
                    <h5 style="color:#888;">Belum Ada Pesanan</h5>
                    <p style="color:#888;">Belum ada pesanan yang masuk</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 