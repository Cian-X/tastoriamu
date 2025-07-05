@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h2 class="mu-title" style="margin-bottom:2rem;"><i class="fas fa-list"></i> Riwayat Pesanan</h2>
            @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="mu-card mu-order-card" style="margin-bottom:2rem;box-shadow:0 2px 12px rgba(218,41,28,0.07);border-radius:1.2em;overflow:hidden;">
                    <div class="mu-card-body" style="padding:2rem 2.5rem;">
                        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:1.5rem 2.5rem;">
                            <div style="flex:1;min-width:180px;">
                                <h5 class="mu-card-title" style="margin-bottom:0.5em;">Order #{{ $order->id }}</h5>
                                <span class="mu-badge mu-badge-date"><i class="fas fa-calendar"></i> {{ $order->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div style="flex:2;min-width:220px;">
                                <div class="mu-badge mu-badge-user"><i class="fas fa-user"></i> {{ $order->nama_pemesan }}</div>
                                <div class="mu-badge mu-badge-alamat"><i class="fas fa-map-marker-alt"></i> {{ $order->alamat }}</div>
                                @if($order->tracking_number)
                                <div class="mu-badge mu-badge-tracking"><i class="fas fa-truck"></i> {{ $order->tracking_number }}</div>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                <span class="mu-price" style="font-size:1.3em;">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="flex:1;text-align:center;">
                                @if($order->status == 'menunggu pembayaran')
                                    <span class="mu-badge mu-badge-status mu-badge-warning">Menunggu Pembayaran</span>
                                @elseif($order->status == 'siap antar')
                                    <span class="mu-badge mu-badge-status mu-badge-info">Siap Antar</span>
                                @elseif($order->status == 'dalam pengiriman')
                                    <span class="mu-badge mu-badge-status mu-badge-primary">Dalam Pengiriman</span>
                                @elseif($order->status == 'selesai')
                                    <span class="mu-badge mu-badge-status mu-badge-success">Selesai</span>
                                @else
                                    <span class="mu-badge mu-badge-status">{{ ucfirst($order->status) }}</span>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                @if($order->payment_status == 'unpaid')
                                    <span class="mu-badge mu-badge-danger">Belum Bayar</span>
                                @else
                                    <span class="mu-badge mu-badge-success">Sudah Bayar</span>
                                @endif
                            </div>
                            <div style="flex:1;text-align:center;">
                                <button class="mu-btn mu-btn-outline mu-btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#order{{ $order->id }}"><i class="fas fa-eye"></i> Detail</button>
                            </div>
                        </div>
                        <div class="collapse" id="order{{ $order->id }}" style="margin-top:1.5em;">
                            <div class="mu-card mu-card-body" style="background:#f9f9f9;border-radius:1em;">
                                <h6 style="font-weight:700;margin-bottom:1em;">Detail Pesanan:</h6>
                                @php $items = is_array($order->items) ? $order->items : json_decode($order->items, true); @endphp
                                @foreach($items as $item)
                                <div style="display:flex;justify-content:space-between;margin-bottom:0.5em;">
                                    <span><b>{{ $item['nama'] }}</b> x{{ $item['qty'] }}</span>
                                    <span>Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</span>
                                </div>
                                @endforeach
                                <hr>
                                <div style="display:flex;justify-content:space-between;font-size:1.1em;">
                                    <strong>Total</strong>
                                    <strong class="mu-price">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</strong>
                                </div>
                                <div style="margin-top:1em;display:flex;gap:2em;flex-wrap:wrap;">
                                    <div><b>Metode Pembayaran:</b> {{ ucfirst($order->payment_method) }}</div>
                                    <div><b>Estimasi Pengiriman:</b> {{ $order->estimated_delivery ? $order->estimated_delivery->format('d M Y H:i') : '-' }}</div>
                                    @if($order->confirmed_at)
                                    <div><b>Dikonfirmasi:</b> {{ $order->confirmed_at->format('d M Y H:i') }}</div>
                                    @endif
                                    @if($order->delivered_at)
                                    <div><b>Dikirim:</b> {{ $order->delivered_at->format('d M Y H:i') }}</div>
                                    @endif
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
<style>
.mu-order-card { transition:box-shadow 0.2s; }
.mu-badge-date, .mu-badge-user, .mu-badge-alamat, .mu-badge-tracking {
    background:#f5f5f5;color:#B3A369;font-weight:600;margin-right:0.5em;margin-bottom:0.3em;display:inline-block;padding:0.4em 1em;border-radius:1em;font-size:0.98em;
}
.mu-badge-status { font-weight:700;padding:0.5em 1.2em;border-radius:1em;font-size:1em; }
.mu-badge-warning { background:#ffc107;color:#111; }
.mu-badge-info { background:#17a2b8;color:#fff; }
.mu-badge-primary { background:#007bff;color:#fff; }
.mu-badge-success { background:#28a745;color:#fff; }
.mu-badge-danger { background:#dc3545;color:#fff; }
.mu-btn-outline.mu-btn-sm { font-size:0.95em;padding:0.4em 1.2em; }
@media (max-width: 700px) {
    .mu-card-body { padding:1.2rem 0.7rem !important; }
}
</style>
@endsection 