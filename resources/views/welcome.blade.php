@extends('layouts.app')

@section('content')
<div class="mu-hero-full">
    <div class="mu-hero-overlay"></div>
    <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&w=1200&q=80" alt="" class="mu-hero-bgimg">
    <div class="mu-hero-content mu-hero-center">
        <div class="mu-hero-title-row">
            <i class="fas fa-fire mu-hero-icon"></i>
            <span class="mu-title">Tastoria</span>
        </div>
        <p class="mu-hero-slogan">Makan Enak, Semangat Juara!</p>
        <div class="mu-hero-btn-group">
            <a href="{{ route('foods.index') }}" class="mu-btn mu-btn-lg mu-cta-main mu-cta-anim"><i class="fas fa-utensils"></i> Lihat Menu</a>
            <a href="{{ route('register') }}" class="mu-btn mu-btn-outline mu-btn-lg mu-cta-anim" style="margin-left:1rem;">Gabung Member</a>
        </div>
    </div>
</div>

<div class="mu-section mu-promo-banner-hero">
    <div class="mu-promo-badge-big">Promo GGMU</div>
    <h2 class="mu-promo-hero-title">Diskon 7% Setiap Hari Senin!</h2>
    <p class="mu-promo-hero-desc">Menu favorit United, harga spesial untuk kamu. Jangan lewatkan!</p>
</div>

<div class="mu-section mu-howto-zigzag">
    <h3 class="mu-section-title">Cara Pesan di Tastoria</h3>
    <div class="mu-howto-stepper">
        <div class="mu-howto-step mu-step-1"><span class="mu-step-icon">🍽️</span><span>Pilih Menu</span></div>
        <div class="mu-step-arrow"><i class="fas fa-chevron-right"></i></div>
        <div class="mu-howto-step mu-step-2"><span class="mu-step-icon">💳</span><span>Pesan & Bayar</span></div>
        <div class="mu-step-arrow"><i class="fas fa-chevron-right"></i></div>
        <div class="mu-howto-step mu-step-3"><span class="mu-step-icon">🏠</span><span>Nikmati di Rumah</span></div>
    </div>
</div>

<div class="mu-section mu-advantage-modern">
    <div class="mu-advantage-list-modern">
        <div class="mu-advantage-card mu-advantage-tilt"><i class="fas fa-bolt"></i><h4>Pesan Kilat</h4><p>Pesan makanan favoritmu, langsung sampai tanpa ribet!</p></div>
        <div class="mu-advantage-card mu-advantage-tilt"><i class="fas fa-trophy"></i><h4>Rasa Juara</h4><p>Menu pilihan dengan cita rasa juara, layaknya MU!</p></div>
        <div class="mu-advantage-card mu-advantage-tilt"><i class="fas fa-clock"></i><h4>Layanan 24 Jam</h4><p>Pesan makanan kapan saja, siap melayani 24 jam!</p></div>
    </div>
    <div class="mu-testimoni-modern">
        <h3 class="mu-section-title">Apa Kata Mereka?</h3>
        <div class="mu-testimoni-slider-modern">
            <div class="mu-testimoni-card"><img src="https://images.unsplash.com/photo-1519125323398-675f0ddb6308" alt="Andi"><div><span class="mu-testimoni-name">Andi</span><span class="mu-testimoni-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span><span class="mu-testimoni-text">"Makanannya enak, pengiriman cepat! #GGMU"</span></div></div>
            <div class="mu-testimoni-card"><img src="https://images.unsplash.com/photo-1510915228340-29c85a43dcfe?auto=format&fit=facearea&w=256&h=256&facepad=2&q=80" alt="Sari"><div><span class="mu-testimoni-name">Sari</span><span class="mu-testimoni-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span><span class="mu-testimoni-text">"Tastoria selalu jadi andalan nonton bola bareng!"</span></div></div>
        </div>
    </div>
</div>
@endsection
