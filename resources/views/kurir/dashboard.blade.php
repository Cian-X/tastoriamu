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
    --tastoria-pastel-gold: #e7d7b1;
    --tastoria-pastel-red: #f8bdb7;
    --tastoria-pastel-gray: #f3f3f3;
}
.kurir-hero {
    background: var(--tastoria-red);
    color: #fff;
    border-radius: 2em 2em 0 0;
    padding: 3.2em 2.5em 2.7em 2.5em;
    display: flex;
    align-items: center;
    gap: 2em;
    box-shadow: var(--tastoria-shadow);
    position: relative;
    overflow: hidden;
    min-height: 180px;
    margin-bottom: 1.5em;
}
.kurir-hero-svg-wrap {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
.kurir-hero-svg-glow {
    position: absolute;
    width: 170px;
    height: 170px;
    border-radius: 50%;
    background: radial-gradient(circle, #fff7 0%, #B3A36922 80%, transparent 100%);
    filter: blur(12px);
    z-index: 0;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);
    pointer-events: none;
}
.kurir-hero-svg {
    width: 140px;
    height: 140px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 6px 32px 0 #b3a36933;
    margin-right: 0.5em;
    animation: motor-bounce 2.5s infinite cubic-bezier(.68,-0.55,.27,1.55);
    border: 3px solid var(--tastoria-gold);
    z-index: 1;
}
.kurir-hero-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    min-width: 0;
}
.kurir-hero-title {
    font-size: 2.9em;
    font-weight: 900;
    margin-bottom: 0.25em;
    letter-spacing: 1px;
    text-shadow: 0 4px 18px rgba(0,0,0,0.18);
    line-height: 1.08;
}
.kurir-hero-badge {
    background: rgba(255,255,255,0.92);
    color: var(--tastoria-gold);
    font-size: 1.18em;
    font-weight: 900;
    border-radius: 0.9em;
    padding: 0.5em 1.7em;
    box-shadow: 0 4px 16px #b3a36933;
    display: inline-block;
    margin: 0.2em 0 0.7em 0;
    backdrop-filter: blur(6px);
    border: 2px solid #e7d7b1;
    max-width: 100vw;
    white-space: nowrap;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
    gap: 0.6em;
}
.kurir-hero-badge .badge-emoji {
    font-size: 1.2em;
    margin-right: 0.1em;
}
.kurir-hero-subtitle {
    font-size: 1.08em;
    color: #fff;
    opacity: 0.90;
    margin-top: 0.1em;
    font-weight: 600;
    letter-spacing: 0.2px;
    text-shadow: 0 2px 8px rgba(0,0,0,0.13);
    line-height: 1.3;
    display: flex;
    align-items: center;
    gap: 0.5em;
}
.kurir-hero-subtitle .subtitle-emoji {
    font-size: 1.1em;
}
.kurir-stat {
    display: flex;
    gap: 2em;
    margin: 2em 0 1.5em 0;
    flex-wrap: wrap;
    justify-content: center;
}
.kurir-stat-card {
    background: #fff;
    border-radius: 1.2em;
    box-shadow: 0 4px 24px rgba(218,41,28,0.10);
    padding: 1.7em 2.3em;
    min-width: 220px;
    text-align: center;
    flex: 1 1 220px;
    position: relative;
    overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s, border 0.2s;
    cursor: pointer;
    margin-bottom: 1em;
    border: 2px solid var(--tastoria-pastel-gold);
    will-change: transform;
}
.kurir-stat-card:hover {
    box-shadow: 0 12px 32px rgba(218,41,28,0.18);
    transform: translateY(-8px) scale(1.045);
    border: 2.5px solid var(--tastoria-gold);
}
.kurir-stat-icon {
    font-size: 2.3em;
    margin-bottom: 0.2em;
    color: var(--tastoria-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5em;
    height: 2.5em;
    background: var(--tastoria-pastel-gold);
    border-radius: 50%;
    margin: 0 auto 0.3em auto;
    box-shadow: 0 2px 8px #e7d7b1cc;
}
.kurir-stat-label {
    color: var(--tastoria-gold);
    font-weight: 700;
    font-size: 1.1em;
    margin-bottom: 0.3em;
    letter-spacing: 0.5px;
}
.kurir-stat-value {
    font-size: 2.6em;
    font-weight: 900;
    color: var(--tastoria-red);
    letter-spacing: 1px;
    transition: color 0.3s;
    font-family: 'Montserrat', Arial, sans-serif;
    animation: stat-pop 0.7s cubic-bezier(.68,-0.55,.27,1.55);
}
@keyframes stat-pop {
    0% { transform: scale(0.7); opacity: 0; }
    80% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); }
}
.mu-table {
    background: #fff;
    border-radius: 1.2em;
    overflow: hidden;
    box-shadow: var(--tastoria-shadow-card);
    margin-bottom: 2em;
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.mu-table th {
    background: var(--tastoria-red) !important;
    color: #fff !important;
    position: sticky;
    top: 0;
    z-index: 2;
    font-size: 1.08em;
    font-weight: 800;
    letter-spacing: 0.5px;
    border: none;
}
.mu-table tr {
    transition: box-shadow 0.15s, background 0.15s;
}
.mu-table tbody tr:hover {
    background: #fff6f5;
    box-shadow: 0 2px 12px #f8bdb7cc;
}
.mu-table td, .mu-table th {
    padding: 1.1em 1.3em;
    border: none;
}
.mu-table td.status-siap {
    color: var(--tastoria-dark);
    background: var(--tastoria-pastel-gold);
    font-weight: 900;
    border-radius: 0.7em;
    text-align: center;
    min-width: 110px;
    font-size: 1.08em;
    letter-spacing: 0.5px;
    padding: 0.6em 1.4em;
    box-shadow: 0 2px 8px #e7d7b1cc;
    margin: 0.1em 0;
    vertical-align: middle;
    border: none;
    transition: box-shadow 0.2s, background 0.2s, transform 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5em;
    cursor: pointer;
}
.mu-table td.status-siap:hover {
    background: #f5e7c6;
    box-shadow: 0 4px 16px #e7d7b1cc;
    transform: scale(1.04) rotate(-2deg);
    animation: badge-shake 0.4s;
}
.mu-table td.status-selesai {
    color: #fff;
    background: #444;
    font-weight: 900;
    border-radius: 0.7em;
    text-align: center;
    min-width: 110px;
    font-size: 1.08em;
    letter-spacing: 0.5px;
    padding: 0.6em 1.4em;
    box-shadow: 0 2px 8px #bbb;
    margin: 0.1em 0;
    vertical-align: middle;
    border: none;
    transition: box-shadow 0.2s, background 0.2s, transform 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5em;
    cursor: pointer;
}
.mu-table td.status-selesai:hover {
    background: #666;
    box-shadow: 0 4px 16px #bbb;
    transform: scale(1.04) rotate(2deg);
    animation: badge-shake 0.4s;
}
@keyframes badge-shake {
    0% { transform: scale(1) rotate(0deg); }
    20% { transform: scale(1.04) rotate(-6deg); }
    40% { transform: scale(1.04) rotate(6deg); }
    60% { transform: scale(1.04) rotate(-3deg); }
    80% { transform: scale(1.04) rotate(2deg); }
    100% { transform: scale(1.04) rotate(0deg); }
}
.mu-btn.mu-btn-primary {
    background: var(--tastoria-red);
    color: #fff;
    border-radius: 0.7em;
    font-weight: 800;
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    box-shadow: 0 2px 8px rgba(218,41,28,0.07);
    padding: 0.6em 1.4em;
    font-size: 1.08em;
    letter-spacing: 0.5px;
    border: none;
    position: relative;
    overflow: hidden;
}
.mu-btn.mu-btn-primary:active::after {
    content: '';
    position: absolute;
    left: 50%; top: 50%;
    width: 200%; height: 200%;
    background: rgba(255,255,255,0.25);
    border-radius: 50%;
    transform: translate(-50%,-50%) scale(0.7);
    animation: ripple 0.4s linear;
    pointer-events: none;
    z-index: 1;
}
@keyframes ripple {
    0% { opacity: 0.7; transform: translate(-50%,-50%) scale(0.7); }
    80% { opacity: 0.3; transform: translate(-50%,-50%) scale(1.2); }
    100% { opacity: 0; transform: translate(-50%,-50%) scale(1.5); }
}
.mu-btn.mu-btn-primary:hover {
    background: var(--tastoria-gold);
    color: #fff;
    box-shadow: 0 4px 16px rgba(218,41,28,0.13);
    transform: scale(1.07);
}
@media (max-width: 900px) {
    .kurir-stat { flex-direction: column; gap: 1.2em; }
    .kurir-hero { flex-direction: column; gap: 1.2em; text-align: center; padding: 2em 0.7em 1.5em 0.7em; }
    .kurir-hero-svg-wrap { margin: 0 auto 1em auto; }
    .kurir-hero-content { align-items: center; }
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
            <div class="kurir-hero-svg-wrap">
                <div class="kurir-hero-svg-glow"></div>
                <div class="kurir-hero-svg">
                    <!-- SVG motor delivery animasi -->
                    <svg width="100" height="100" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="40" cy="40" r="40" fill="#fff3"/>
                      <g>
                        <rect x="30" y="38" width="20" height="8" rx="2" fill="#DA291C"/>
                        <rect x="50" y="38" width="8" height="8" rx="2" fill="#B3A369"/>
                        <rect x="22" y="38" width="8" height="8" rx="2" fill="#B3A369"/>
                        <rect x="36" y="30" width="8" height="8" rx="2" fill="#DA291C"/>
                        <circle cx="26" cy="50" r="6" fill="#fff" stroke="#B3A369" stroke-width="3">
                          <animateTransform attributeName="transform" type="rotate" from="0 26 50" to="360 26 50" dur="2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="54" cy="50" r="6" fill="#fff" stroke="#DA291C" stroke-width="3">
                          <animateTransform attributeName="transform" type="rotate" from="0 54 50" to="360 54 50" dur="2s" repeatCount="indefinite"/>
                        </circle>
                      </g>
                    </svg>
                </div>
            </div>
            <div class="kurir-hero-content">
                <div class="kurir-hero-title">Dashboard Kurir</div>
                <span class="kurir-hero-badge">Selamat datang, {{ auth()->user()->name }}!</span>
                <div class="kurir-hero-subtitle">Siap mengantarkan pesanan dengan semangat juara!</div>
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
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin-bottom:0.7em;color:var(--tastoria-red);font-weight:900;">Pesanan Siap Antar</h5>
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
                        <td><span class="status-siap"><i class="fas fa-box"></i> Siap antar</span></td>
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
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin:2em 0 0.7em 0;color:var(--tastoria-red);font-weight:900;">Pesanan Dalam Pengiriman</h5>
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
                        <td class="status-perjalanan"><i class="fas fa-truck"></i> Dalam pengiriman</td>
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
            <h5 class="mu-title" style="font-size:1.2em;text-align:left;margin:2em 0 0.7em 0;color:var(--tastoria-red);font-weight:900;">Riwayat Pengantaran</h5>
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
                        <td class="status-selesai"><i class="fas fa-check-circle"></i> Selesai</td>
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
            <div style="text-align:center;padding:3.5rem 0;">
                <div style="display:flex;justify-content:center;align-items:center;">
                  <svg width="160" height="160" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation:motor-bounce 2.5s infinite cubic-bezier(.68,-0.55,.27,1.55);">
                    <circle cx="40" cy="40" r="40" fill="#f8bdb7"/>
                    <g>
                      <rect x="30" y="38" width="20" height="8" rx="2" fill="#DA291C"/>
                      <rect x="50" y="38" width="8" height="8" rx="2" fill="#B3A369"/>
                      <rect x="22" y="38" width="8" height="8" rx="2" fill="#B3A369"/>
                      <rect x="36" y="30" width="8" height="8" rx="2" fill="#DA291C"/>
                      <circle cx="26" cy="50" r="6" fill="#fff" stroke="#B3A369" stroke-width="3">
                        <animateTransform attributeName="transform" type="rotate" from="0 26 50" to="360 26 50" dur="2s" repeatCount="indefinite"/>
                      </circle>
                      <circle cx="54" cy="50" r="6" fill="#fff" stroke="#DA291C" stroke-width="3">
                        <animateTransform attributeName="transform" type="rotate" from="0 54 50" to="360 54 50" dur="2s" repeatCount="indefinite"/>
                      </circle>
                    </g>
                  </svg>
                </div>
                <h5 style="color:#888;font-size:1.3em;font-weight:900;margin-top:1.2em;">Belum Ada Pesanan</h5>
                <p style="color:#888;">Belum ada pesanan yang perlu diantar. Tetap semangat, pesanan baru akan segera datang!</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 