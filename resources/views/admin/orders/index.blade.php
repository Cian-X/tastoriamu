@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1200px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-list"></i> Semua Pesanan</h4>
            @if(count($orders) > 0)
                @foreach($orders as $order)
                <div class="admin-order-card">
                    <div class="admin-order-info">
                        <div class="admin-order-title">Order #{{ $order->id }}</div>
                        <div class="admin-order-meta">
                            <span class="admin-order-badge"><i class="fas fa-calendar"></i> {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') : '-' }}</span>
                            <span class="admin-order-name">{{ $order->user->name ?? $order->nama_pemesan }}</span>
                            <span class="admin-order-badge"><i class="fas fa-map-marker-alt"></i> {{ $order->alamat }}</span>
                            @if($order->tracking_number)
                            <span class="admin-order-badge"><i class="fas fa-truck"></i> {{ $order->tracking_number }}</span>
                            @endif
                        </div>
                        <div class="admin-order-price">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</div>
                        <div class="admin-order-status">
                            @if($order->status == 'menunggu pembayaran')
                                <span class="badge-status badge-status-yellow">Menunggu Pembayaran</span>
                            @elseif($order->status == 'siap antar')
                                <span class="badge-status badge-status-blue">Siap Antar</span>
                            @elseif($order->status == 'dalam pengiriman')
                                <span class="badge-status badge-status-blue">Dalam Pengiriman</span>
                            @elseif($order->status == 'selesai')
                                <span class="badge-status badge-status-green">Selesai</span>
                            @else
                                <span class="badge-status badge-status-red">{{ ucfirst($order->status) }}</span>
                            @endif
                            @if($order->payment_status == 'unpaid')
                                <span class="badge-status badge-status-red">Belum Bayar</span>
                            @else
                                <span class="badge-status badge-status-green">Sudah Bayar</span>
                            @endif
                        </div>
                    </div>
                    <div class="admin-order-action">
                        <a href="#order{{ $order->id }}" class="admin-order-detail-btn"><i class="fas fa-eye"></i> Detail</a>
                    </div>
                </div>
                <div class="collapse" id="order{{ $order->id }}" style="margin-top:1.5em;">
                    <div class="mu-card mu-card-body" style="background:#f9f9f9;border-radius:1em;">
                        <h6 style="font-weight:700;margin-bottom:1em;">Detail Pesanan:</h6>
                        @php $items = is_array($order->items) ? $order->items : json_decode($order->items, true); @endphp
                        @foreach($items as $item)
                        <div style="display:flex;align-items:center;gap:1em;margin-bottom:0.7em;">
                            @if(isset($item['gambar']))
                                <img src="{{ asset($item['gambar']) }}" alt="{{ $item['nama'] }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #eee;">
                            @else
                                @php
                                  $food = \App\Models\Food::where('nama', $item['nama'])->first();
                                @endphp
                                @if($food && $food->gambar)
                                  <img src="{{ asset($food->gambar) }}" alt="{{ $item['nama'] }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;border:1px solid #eee;">
                                @endif
                            @endif
                            <div>
                                <b>{{ $item['nama'] }}</b> x{{ $item['qty'] }}<br>
                                <span>Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                        @if(!empty($order->catatan))
                        <div style="margin-top:1em;">
                            <span style="color:#DA291C;font-weight:600;">Catatan:</span><br>
                            <span>{{ $order->catatan }}</span>
                        </div>
                        @endif
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

@push('styles')
<style>
.admin-order-card {
    background: #fff;
    border-radius: 1.3em;
    box-shadow: 0 4px 24px #da291c18;
    padding: 2em 2.2em 1.5em 2.2em;
    margin-bottom: 2em;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    gap: 2em;
    justify-content: space-between;
}
.admin-order-info {
    flex: 2 1 320px;
    min-width: 220px;
}
.admin-order-meta {
    display: flex;
    flex-direction: column;
    gap: 0.7em;
    margin-bottom: 0.7em;
}
.admin-order-badge {
    background: #faf9f7;
    color: #222;
    border: 1.5px solid #DA291C;
    border-radius: 0.8em;
    padding: 0.5em 1.2em;
    font-size: 1em;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5em;
    margin-bottom: 0.2em;
}
.admin-order-title {
    font-size: 1.25em;
    font-weight: 900;
    margin-bottom: 0.3em;
    color: #222;
}
.admin-order-name {
    font-size: 1.1em;
    font-weight: 800;
    margin-bottom: 0.2em;
    color: #DA291C;
}
.admin-order-price {
    font-size: 1.3em;
    font-weight: 900;
    color: #DA291C;
    margin-bottom: 0.2em;
}
.admin-order-status {
    display: flex;
    gap: 0.7em;
    align-items: center;
    margin-bottom: 0.7em;
}
.badge-status {
    border-radius: 1em;
    font-weight: 800;
    font-size: 1em;
    padding: 0.5em 1.3em;
    display: inline-block;
}
.badge-status-yellow { background: #ffc107; color: #222; }
.badge-status-red { background: #DA291C; color: #fff; }
.badge-status-green { background: #28a745; color: #fff; }
.badge-status-blue { background: #1877f2; color: #fff; }
.admin-order-action {
    display: flex;
    flex-direction: column;
    gap: 0.7em;
    align-items: flex-end;
    min-width: 120px;
}
.admin-order-detail-btn {
    background: #fff;
    color: #DA291C;
    border: 2px solid #DA291C;
    border-radius: 1em;
    font-weight: 800;
    padding: 0.6em 1.5em;
    font-size: 1.08em;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px #da291c11;
    display: flex;
    align-items: center;
    gap: 0.7em;
    cursor: pointer;
    text-decoration: none;
}
.admin-order-detail-btn:hover {
    background: #DA291C;
    color: #fff;
    box-shadow: 0 4px 16px #da291c22;
}
@media (max-width: 900px) {
    .admin-order-card { flex-direction: column; gap: 1em; padding: 1.2em 0.7em; }
    .admin-order-action { align-items: flex-start; }
}
</style>
@endpush 