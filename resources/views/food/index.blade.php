@extends('layouts.app')

@section('content')
<div class="mu-hero mu-hero-food mu-hero-food-img">
    <div class="mu-hero-food-overlay"></div>
    <img src="https://images.unsplash.com/photo-1464306076886-debca5e8a6b0?auto=format&fit=crop&w=1200&q=80" class="mu-hero-food-bgimg">
    <div class="mu-hero-food-content">
        <h2 class="mu-title">Menu Favorit United</h2>
        <p class="mu-slogan">Rasakan Sensasi Makan dengan Semangat Juara!<br>#GGMU Red Passion Fast Delivery</p>
        <form class="mu-filter" method="GET" action="">
            <input type="text" name="q" placeholder="Cari makanan..." value="{{ request('q') }}">
            <input type="number" name="min" placeholder="Min" value="{{ request('min') }}">
            <input type="number" name="max" placeholder="Max" value="{{ request('max') }}">
            <select name="sort">
                <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama</option>
                <option value="harga" {{ request('sort') == 'harga' ? 'selected' : '' }}>Harga</option>
            </select>
            <button type="submit" class="mu-btn">Filter</button>
        </form>
    </div>
</div>
<div class="mu-container mu-food-container">
    <div class="mu-food-list">
        @forelse($foods as $food)
        <div class="mu-card mu-food-card">
            <div class="mu-food-img-wrap">
                <img src="{{ $food->gambar }}" alt="{{ $food->nama }}" class="mu-food-img">
            </div>
            <div class="mu-card-body">
                <div class="mu-badge mu-badge-type">{{ $food->kategori }}</div>
                <h5 class="mu-card-title">{{ $food->nama }}</h5>
                <p class="mu-card-desc">{{ $food->deskripsi }}</p>
                <div class="mu-food-meta">
                    <span class="mu-price">Rp{{ number_format($food->harga, 0, ',', '.') }}</span>
                    <form action="{{ route('foods.addToCart', $food->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-cart-plus"></i> Pesan</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="mu-food-empty">
            <h5>Tidak ada makanan ditemukan</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection 