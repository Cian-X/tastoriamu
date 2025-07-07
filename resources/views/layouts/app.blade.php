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
    <style>
    @media (max-width: 700px) {
      .mu-nav {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100vw !important;
        min-width: 0 !important;
        max-width: 100vw !important;
        background: #DA291C !important;
        z-index: 2000 !important;
        box-shadow: 0 8px 32px rgba(218,41,28,0.13) !important;
        border-radius: 0 0 18px 18px !important;
        padding: 1.5em 0 1em 0 !important;
        margin: 0 !important;
        overflow-x: hidden !important;
      }
      body, html {
        overflow-x: hidden !important;
      }
      .mu-nav[style*='display: block'] {
        display: flex !important;
      }
      .mu-nav li {
        width: 100% !important;
        text-align: left !important;
        margin: 0 !important;
        padding: 0 !important;
        border-bottom: 1px solid #fff2 !important;
      }
      .mu-nav li:last-child {
        border-bottom: none !important;
      }
      .mu-nav a, .mu-nav a.active {
        width: 100% !important;
        display: block !important;
        padding: 1em 1.5em !important;
        font-size: 1.1em !important;
        border-radius: 0 !important;
        color: #fff !important;
        background: none !important;
        border: none !important;
        box-shadow: none !important;
      }
      .mu-nav a:hover, .mu-nav a.active {
        background: #b71c1c !important;
        color: #fff !important;
      }
    }
    </style>
</head>
<body>
    <nav class="mu-navbar">
        <div class="mu-container">
            <a href="/" class="mu-logo"><i class="fas fa-fire"></i> Tastoria</a>
            <button class="mu-hamburger" id="muHamburgerBtn" aria-label="Menu" style="display:none;">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="mu-nav" id="muNavMenu">
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
    <script>
    // Hamburger menu mobile only
    (function() {
      var btn = document.getElementById('muHamburgerBtn');
      var menu = document.getElementById('muNavMenu');
      function checkMobile() {
        if(window.innerWidth <= 700) {
          btn.style.display = 'block';
          menu.classList.add('mu-nav-mobile');
          menu.style.display = 'none';
        } else {
          btn.style.display = 'none';
          menu.classList.remove('mu-nav-mobile');
          menu.style.display = '';
        }
      }
      btn && btn.addEventListener('click', function() {
        if(menu.style.display === 'block') {
          menu.style.display = 'none';
          document.body.style.overflowX = '';
          document.documentElement.style.overflowX = '';
        } else {
          menu.style.display = 'block';
          document.body.style.overflowX = 'hidden';
          document.documentElement.style.overflowX = 'hidden';
        }
      });
      // Auto close menu on link click (mobile only)
      if(menu) {
        menu.querySelectorAll('a').forEach(function(link) {
          link.addEventListener('click', function() {
            if(window.innerWidth <= 700) {
              menu.style.display = 'none';
              document.body.style.overflowX = '';
              document.documentElement.style.overflowX = '';
            }
          });
        });
      }
      window.addEventListener('resize', checkMobile);
      window.addEventListener('DOMContentLoaded', checkMobile);
    })();
    </script>
</body>
</html> 