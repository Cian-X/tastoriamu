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
                            <div style="flex:2;min-width:220px;display:flex;flex-direction:column;gap:0.5em;align-items:flex-start;max-width:100%;">
                                <div class="order-badge order-badge-user"><i class="fas fa-user"></i> {{ $order->nama_pemesan }}</div>
                                @if($order->tracking_number)
                                    <div class="order-badge order-badge-tracking"><i class="fas fa-truck"></i> {{ $order->tracking_number }}</div>
                                @endif
                                <div class="order-badge order-badge-alamat"><i class="fas fa-map-marker-alt"></i> {{ $order->alamat }}</div>
                            </div>
                        </div>
                        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:1.5rem 2.5rem;margin-top:1.2em;justify-content:space-between;">
                            <div style="flex:1;text-align:left;min-width:120px;">
                                <span class="mu-price" style="font-size:1.3em;">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                            </div>
                            <div style="flex:1;text-align:left;min-width:160px;">
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
                            <div style="flex:1;text-align:left;min-width:120px;">
                                @if($order->payment_status == 'unpaid')
                                    <span class="mu-badge mu-badge-danger">Belum Bayar</span>
                                @else
                                    <span class="mu-badge mu-badge-success">Sudah Bayar</span>
                                @endif
                            </div>
                            <div style="flex:1;text-align:right;min-width:120px;">
                                <button class="mu-btn mu-btn-outline mu-btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#order{{ $order->id }}"><i class="fas fa-eye"></i> Detail</button>
                                @if($order->status == 'menunggu pembayaran' || $order->payment_status == 'unpaid')
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mu-btn mu-btn-danger mu-btn-sm" onclick="return confirm('Yakin ingin menghapus pesanan ini?')" style="margin-left:0.5em;"><i class="fas fa-trash"></i> Hapus</button>
                                    </form>
                                @endif
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
                                    <strong class="mu-price">Rp{{ number_format(isset($items[0]) ? $items[0]['harga'] * $items[0]['qty'] : $order->total_harga, 0, ',', '.') }}</strong>
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
.mu-btn-danger {
  background: #dc3545;
  color: #fff;
  border: none;
  transition: background 0.2s;
}
.mu-btn-danger:hover {
  background: #b52a37;
  color: #fff;
}
.mu-btn-warning {
  background: #ffc107;
  color: #111;
  border: none;
  transition: background 0.2s;
}
.mu-btn-warning:hover {
  background: #e0a800;
  color: #111;
}
@media (max-width: 700px) {
    .mu-card-body { padding:1.2rem 0.7rem !important; }
}
.order-badge {
  display: flex;
  align-items: center;
  gap: 0.5em;
  background: #f4f7fa;
  color: #3a3a3a;
  font-weight: 600;
  padding: 0.45em 1.15em;
  border-radius: 1.2em;
  font-size: 0.98em;
  border: 1px solid #e3e8ee;
  box-shadow: 0 1px 4px rgba(0,0,0,0.03);
  margin-bottom: 0.5em;
  transition: box-shadow 0.2s, border 0.2s;
  width: fit-content;
  max-width: 100%;
  word-break: break-word;
}
.order-badge:last-child { margin-bottom: 0; }
@media (max-width: 700px) {
  .order-badge { font-size: 0.95em; padding: 0.4em 0.8em; }
}
.order-badge i {
  color: #1877f2;
  font-size: 1.08em;
}
.order-badge-user {
  background: #eaf4ff;
  color: #1877f2;
  border: 1px solid #cbe2fa;
}
.order-badge-alamat {
  background: #fffbe6;
  color: #b38b00;
  border: 1px solid #f7e6b0;
}
.order-badge-tracking {
  background: #eafaf1;
  color: #1e8e3e;
  border: 1px solid #b6e7d6;
}
.order-badge:hover {
  box-shadow: 0 2px 8px rgba(24,119,242,0.08);
  border: 1.5px solid #1877f2;
  cursor: pointer;
}
</style>
@endsection 