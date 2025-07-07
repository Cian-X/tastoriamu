<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tastoria - Rasa yang Membawa Kemenangan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/css/mu-theme.css?v=fixoverflow2">
    <style>
        body { background: #e5e5e5; }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="mu-navbar">
        <div class="mu-container">
            <a href="/" class="mu-logo"><i class="fas fa-fire"></i> Tastoria</a>
            <ul class="mu-nav">
                <li><a href="/" @if(request()->is('/')) class="active" @endif>Beranda</a></li>
                <li><a href="/foods" @if(request()->is('foods')) class="active" @endif>Menu</a></li>
                <li><a href="/orders" @if(request()->is('orders')) class="active" @endif>Pesanan</a></li>
                @guest
                    <li><a href="/login" @if(request()->is('login')) class="active" @endif>Login</a></li>
                @else
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin" @if(request()->is('admin')) class="active" @endif>Dashboard</a></li>
                    @elseif(auth()->user()->role === 'kurir')
                        <li><a href="/kurir/dashboard" @if(request()->is('kurir/dashboard*')) class="active" @endif>Dashboard</a></li>
                    @elseif(auth()->user()->role === 'user')
                        <li><a href="/user/dashboard" @if(request()->is('user/dashboard*')) class="active" @endif>Dashboard</a></li>
                    @endif
                    <li class="mu-nav-item">
                        <span style="color:#fff;font-weight:500;min-width:60px;text-align:center;">{{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none;border:none;color:#fff;font-weight:500;cursor:pointer;padding:0 0.7em;font-size:1em;transition:color 0.2s;" onmouseover="this.style.color='#B3A369'" onmouseout="this.style.color='#fff'">Logout</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    <main class="mu-main">
        @yield('content')
    </main>
    <footer class="mu-footer">
        <div class="mu-container mu-footer-content">
            <div class="mu-footer-brand">
                <span class="mu-footer-logo"><i class="fas fa-fire"></i> Tastoria</span>
                <p>Platform pemesanan makanan online terpercaya dengan berbagai pilihan menu favorit Anda.</p>
            </div>
            <div class="mu-footer-links">
                <h5>Layanan</h5>
                <ul>
                    <li>Pesan Makanan</li>
                    <li>Pengiriman Kilat</li>
                    <li>Rasa Juara</li>
                    <li>Layanan 24 Jam</li>
                </ul>
            </div>
            <div class="mu-footer-contact">
                <h5>Kontak</h5>
                <ul>
                    <li><i class="fas fa-phone"></i> +62 823-6726-4912</li>
                    <li><i class="fas fa-envelope"></i> info@tastoria.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> Tangerang, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="mu-container" style="text-align:center;margin-top:1.5rem;color:#B3A369;">
            <span>&copy; {{ date('Y') }} Tastoria - Red Passion Food</span>
        </div>
    </footer>
</body>
</html> 