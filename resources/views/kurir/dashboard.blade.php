@extends('layouts.app')

@push('styles')
<style>
:root {
    --tastoria-red: #DA291C;
    --tastoria-gold: #B3A369;
    --tastoria-bg: #f8f8f8;
    --tastoria-dark: #222;
    --tastoria-shadow: 0 4px 24px rgba(218,41,28,0.08);
    --tastoria-shadow-card: 0 2px 12px rgba(218,41,28,0.07);
    --tastoria-glass: rgba(255,255,255,0.7);
}
.kurir-hero {
    background: linear-gradient(90deg, var(--tastoria-red) 60%, var(--tastoria-gold) 100%);
    color: #fff;
    border-radius: 1.2em 1.2em 0 0;
    padding: 2.5em 2em 1.5em 2em;
    display: flex;
    align-items: center;
    gap: 2em;
    box-shadow: var(--tastoria-shadow);
    position: relative;
    overflow: hidden;
}
.kurir-hero::after {
    content: '';
    position: absolute;
    right: 0; top: 0; bottom: 0;
    width: 180px;
    background: var(--tastoria-glass);
    filter: blur(8px);
    opacity: 0.3;
    pointer-events: none;
}
.kurir-hero-icon {
    font-size: 4em;
    background: var(--tastoria-glass);
    color: var(--tastoria-red);
    border-radius: 50%;
    padding: 0.4em 0.6em;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}
.kurir-hero-icon:hover {
    transform: rotate(-10deg) scale(1.08);
}
.kurir-hero-title {
    font-size: 2.2em;
    font-weight: 900;
    margin-bottom: 0.2em;
    letter-spacing: 1px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.08);
}
.kurir-hero-badge {
    background: var(--tastoria-gold);
    color: #fff;
    font-size: 1.1em;
    font-weight: 700;
    border-radius: 0.5em;
    padding: 0.3em 1.1em;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    display: inline-block;
}
.kurir-stat {
    display: flex;
    gap: 2em;
    margin: 2em 0 1.5em 0;
    flex-wrap: wrap;
}
.kurir-stat-card {
    background: var(--tastoria-glass);
    border-radius: 1em;
    box-shadow: var(--tastoria-shadow-card);
    padding: 1.2em 2em;
    min-width: 180px;
    text-align: center;
    flex: 1 1 180px;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s;
}
.kurir-stat-card:hover {
    box-shadow: 0 6px 24px rgba(218,41,28,0.13);
    transform: translateY(-4px) scale(1.03);
}
.kurir-stat-icon {
    font-size: 2em;
    margin-bottom: 0.2em;
    color: var(--tastoria-gold);
    display: block;
}
.kurir-stat-label {
    color: var(--tastoria-gold);
    font-weight: 600;
    font-size: 1em;
    margin-bottom: 0.3em;
}
.kurir-stat-value {
    font-size: 2.2em;
    font-weight: 900;
    color: var(--tastoria-red);
    letter-spacing: 1px;
    /* For animation, add class 'count-up' if needed */
}
.mu-table {
    background: #fff;
    border-radius: 1em;
    overflow: hidden;
    box-shadow: var(--tastoria-shadow-card);
    margin-bottom: 2em;
}
.mu-table th {
    background: var(--tastoria-red) !important;
    color: #fff !important;
    position: sticky;
    top: 0;
    z-index: 2;
}
.mu-table tr {
    transition: box-shadow 0.15s, background 0.15s;
}
.mu-table tbody tr:hover {
    background: #fff6f5;
    box-shadow: 0 2px 8px rgba(218,41,28,0.07);
}
.mu-table td.status-siap {
    color: #fff;
    background: var(--tastoria-gold);
    font-weight: 700;
    border-radius: 0.5em;
    text-align: center;
    min-width: 90px;
}
.mu-table td.status-perjalanan {
    color: #fff;
    background: var(--tastoria-red);
    font-weight: 700;
    border-radius: 0.5em;
    text-align: center;
    min-width: 90px;
}
.mu-table td.status-selesai {
    color: #fff;
    background: var(--tastoria-dark);
    font-weight: 700;
    border-radius: 0.5em;
    text-align: center;
    min-width: 90px;
}
.mu-btn.mu-btn-primary {
    background: var(--tastoria-red);
    color: #fff;
    border-radius: 0.5em;
    font-weight: 700;
    transition: background 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px rgba(218,41,28,0.07);
    padding: 0.5em 1.2em;
    font-size: 1em;
}
.mu-btn.mu-btn-primary:hover {
    background: var(--tastoria-gold);
    color: #fff;
    box-shadow: 0 4px 16px rgba(218,41,28,0.13);
}
@media (max-width: 900px) {
    .kurir-stat { flex-direction: column; gap: 1em; }
    .kurir-hero { flex-direction: column; gap: 1em; text-align: center; }
}
@media (max-width: 600px) {
    .mu-container { padding: 0 0.5em; }
    .kurir-hero { padding: 1.2em 0.5em 1em 0.5em; }
    .kurir-stat-card { padding: 1em 0.5em; }
    .mu-table th, .mu-table td { font-size: 0.95em; }
    .mu-table { font-size: 0.95em; }
}
</style>
@endpush

@section('content')
@if($activeOrders->count() > 0)
    <div class="mu-alert-login" style="margin:1.5em auto 0 auto;max-width:700px;">
        <i class="fas fa-bell"></i> Ada <b>{{ $activeOrders->count() }}</b> pesanan siap diantar!
    </div>
@endif
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card" style="padding:0;overflow:hidden;background:var(--tastoria-bg);">
        <div class="kurir-hero">
            <span class="kurir-hero-icon"><i class="fas fa-motorcycle"></i></span>
            <div>
                <div class="kurir-hero-title">Dashboard Kurir</div>
                <span class="kurir-hero-badge">Selamat datang, {{ auth()->user()->name }}!</span>
            </div>
        </div>
        <div class="mu-card-body" style="padding-top:2em;">
            <div class="kurir-stat">
                <div class="kurir-stat-card">
                    <span class="kurir-stat-icon"><i class="fas fa-box"></i></span>
                    <div class="kurir-stat-label">Pesanan Siap Antar</div>
                    <div class="kurir-stat-value">{{ $activeOrders->count() }}</div>
                </div>
                <div class="kurir-stat-card">
                    <span class="kurir-stat-icon"><i class="fas fa-truck"></i></span>
                    <div class="kurir-stat-label">Dalam Pengiriman</div>
                    <div class="kurir-stat-value">{{ $deliveringOrders->count() }}</div>
                </div>
                <div class="kurir-stat-card">
                    <span class="kurir-stat-icon"><i class="fas fa-check-circle"></i></span>
                    <div class="kurir-stat-label">Pengantaran Selesai</div>
                    <div class="kurir-stat-value">{{ $finishedOrders->count() }}</div>
                </div>
            </div>
            @if($activeOrders->count() > 0)
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin-bottom:0.7em;color:var(--tastoria-red);">Pesanan Siap Antar</h5>
            <div style="overflow-x:auto;">
            <table class="mu-table">
                <thead>
                    <tr>
                        <th>Nama Pemesan</th>
                        <th>Alamat</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeOrders as $order)
                    <tr>
                        <td>{{ $order->nama_pemesan }}</td>
                        <td>{{ $order->alamat }}</td>
                        <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                        <td class="status-siap"><i class="fas fa-box"></i> {{ ucfirst($order->status) }}</td>
                        <td>
                            <form action="{{ route('kurir.order.update', $order->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" name="status" value="ambil" class="mu-btn mu-btn-primary"><i class="fas fa-motorcycle"></i> Ambil</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @endif
            @if($deliveringOrders->count() > 0)
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin:2em 0 0.7em 0;color:var(--tastoria-red);">Pesanan Dalam Pengiriman</h5>
            <div style="overflow-x:auto;">
            <table class="mu-table">
                <thead>
                    <tr>
                        <th>Nama Pemesan</th>
                        <th>Alamat</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deliveringOrders as $order)
                    <tr>
                        <td>{{ $order->nama_pemesan }}</td>
                        <td>{{ $order->alamat }}</td>
                        <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                        <td class="status-perjalanan"><i class="fas fa-truck"></i> {{ ucfirst($order->status) }}</td>
                        <td>
                                <form action="{{ route('kurir.order.update', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" name="status" value="selesai" class="mu-btn mu-btn-primary"><i class="fas fa-check"></i> Selesai</button>
                                </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @endif
            @if($finishedOrders->count() > 0)
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin:2em 0 0.7em 0;color:var(--tastoria-red);">Riwayat Pengantaran</h5>
            <div style="overflow-x:auto;">
            <table class="mu-table">
                <thead>
                    <tr>
                        <th>Nama Pemesan</th>
                        <th>Alamat</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finishedOrders as $order)
                    <tr>
                        <td>{{ $order->nama_pemesan }}</td>
                        <td>{{ $order->alamat }}</td>
                        <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                        <td class="status-selesai"><i class="fas fa-check-circle"></i> {{ ucfirst($order->status) }}</td>
                        <td>
                            @if($order->delivered_at)
                                {{ \Carbon\Carbon::parse($order->delivered_at)->format('d M Y H:i') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @endif
            @if($activeOrders->count() == 0 && $deliveringOrders->count() == 0 && $finishedOrders->count() == 0)
            <div style="text-align:center;padding:2.5rem 0;">
                <i class="fas fa-motorcycle" style="font-size:4.5rem;color:var(--tastoria-gold);"></i>
                <h5 style="color:#888;font-size:1.3em;font-weight:700;">Belum Ada Pesanan</h5>
                <p style="color:#888;">Belum ada pesanan yang perlu diantar. Silakan tunggu pesanan baru masuk.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 