@extends('layouts.app')

@section('content')
@php
    $siapAntarOrders = $activeOrders->where('status', 'dikonfirmasi');
@endphp
@if($siapAntarOrders->count() > 0)
    <div class="mu-alert-login" style="margin:1.5em auto 0 auto;max-width:700px;">
        <i class="fas fa-bell"></i> Ada <b>{{ $siapAntarOrders->count() }}</b> pesanan siap diantar!
    </div>
@endif
<style>
    .kurir-hero {
        background: linear-gradient(90deg, #DA291C 60%, #B3A369 100%);
        color: #fff;
        border-radius: 1.2em 1.2em 0 0;
        padding: 2.5em 2em 1.5em 2em;
        display: flex;
        align-items: center;
        gap: 2em;
        box-shadow: 0 4px 24px rgba(218,41,28,0.08);
    }
    .kurir-hero-icon {
        font-size: 3.5em;
        background: #fff;
        color: #DA291C;
        border-radius: 50%;
        padding: 0.3em 0.5em;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    .kurir-hero-title {
        font-size: 2.1em;
        font-weight: 800;
        margin-bottom: 0.2em;
        letter-spacing: 1px;
    }
    .kurir-stat {
        display: flex;
        gap: 2em;
        margin: 2em 0 1.5em 0;
        flex-wrap: wrap;
    }
    .kurir-stat-card {
        background: #fff;
        border-radius: 1em;
        box-shadow: 0 2px 12px rgba(218,41,28,0.07);
        padding: 1.2em 2em;
        min-width: 180px;
        text-align: center;
        flex: 1 1 180px;
    }
    .kurir-stat-label {
        color: #B3A369;
        font-weight: 600;
        font-size: 1em;
        margin-bottom: 0.3em;
    }
    .kurir-stat-value {
        font-size: 2em;
        font-weight: 800;
        color: #DA291C;
    }
    .mu-table th {
        background: #DA291C !important;
        color: #fff !important;
    }
    .mu-table td.status-siap {
        color: #fff;
        background: #B3A369;
        font-weight: 600;
        border-radius: 0.5em;
    }
    .mu-table td.status-perjalanan {
        color: #fff;
        background: #DA291C;
        font-weight: 600;
        border-radius: 0.5em;
    }
    .mu-table td.status-selesai {
        color: #fff;
        background: #222;
        font-weight: 600;
        border-radius: 0.5em;
    }
    .mu-btn.mu-btn-primary {
        background: #DA291C;
        color: #fff;
        border-radius: 0.5em;
        font-weight: 600;
        transition: background 0.2s;
    }
    .mu-btn.mu-btn-primary:hover {
        background: #B3A369;
        color: #fff;
    }
</style>
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card" style="padding:0;overflow:hidden;">
        <div class="kurir-hero">
            <span class="kurir-hero-icon"><i class="fas fa-motorcycle"></i></span>
            <div>
                <div class="kurir-hero-title">Dashboard Kurir</div>
                <span class="mu-badge mu-badge-type" style="background:#B3A369;color:#fff;font-size:1em;">Selamat datang, {{ auth()->user()->name }}!</span>
            </div>
        </div>
        <div class="mu-card-body" style="padding-top:2em;">
            <div class="kurir-stat">
                <div class="kurir-stat-card">
                    <div class="kurir-stat-label">Pesanan Aktif</div>
                    <div class="kurir-stat-value">{{ $activeOrders->count() }}</div>
                </div>
                <div class="kurir-stat-card">
                    <div class="kurir-stat-label">Pengantaran Selesai</div>
                    <div class="kurir-stat-value">{{ $finishedOrders->count() }}</div>
                </div>
                <div class="kurir-stat-card">
                    <div class="kurir-stat-label">Pesanan Siap Antar</div>
                    <div class="kurir-stat-value">{{ $siapAntarOrders->count() }}</div>
                </div>
            </div>
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin-bottom:0.7em;color:#DA291C;">Pesanan Aktif</h5>
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
                    @forelse($activeOrders as $order)
                    <tr>
                        <td>{{ $order->nama_pemesan }}</td>
                        <td>{{ $order->alamat }}</td>
                        <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                        <td class="status-{{ $order->status == 'siap antar' ? 'siap' : ($order->status == 'dalam perjalanan' ? 'perjalanan' : 'selesai') }}">
                            {{ ucfirst($order->status) }}
                        </td>
                        <td>
                            @if($order->status == 'siap antar')
                                <form action="{{ route('kurir.order.update', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" name="status" value="dalam perjalanan" class="mu-btn mu-btn-primary"><i class="fas fa-motorcycle"></i> Ambil</button>
                                </form>
                            @elseif($order->status == 'dalam perjalanan')
                                <form action="{{ route('kurir.order.update', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" name="status" value="selesai" class="mu-btn mu-btn-primary"><i class="fas fa-check"></i> Selesai</button>
                                </form>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" style="text-align:center;color:#aaa;">Tidak ada pesanan aktif</td></tr>
                    @endforelse
                </tbody>
            </table>
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin:2em 0 0.7em 0;color:#DA291C;">Riwayat Pengantaran</h5>
            <table class="mu-table">
                <thead>
                    <tr>
                        <th>Nama Pemesan</th>
                        <th>Alamat</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($finishedOrders as $order)
                    <tr>
                        <td>{{ $order->nama_pemesan }}</td>
                        <td>{{ $order->alamat }}</td>
                        <td>Rp{{ number_format($order->total_harga,0,',','.') }}</td>
                        <td class="status-selesai">{{ ucfirst($order->status) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;color:#aaa;">Belum ada riwayat pengantaran</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 