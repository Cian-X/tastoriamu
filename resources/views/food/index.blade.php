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
                    <form action="{{ route('foods.orderNow', $food->id) }}" method="POST">
                        @csrf
                        <button type="button" class="mu-btn mu-btn-primary" onclick="openOrderModal({{ $food->id }}, '{{ addslashes($food->nama) }}', {{ $food->harga }})"><i class="fas fa-cart-plus"></i> Pesan</button>
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

<!-- Modal Order -->
<div id="orderModal" class="mu-modal" style="display:none;">
    <div class="mu-modal-content" style="max-width:400px;">
        <span class="mu-modal-close" onclick="closeOrderModal()">&times;</span>
        <h4 class="mu-title">Pesan <span id="modalFoodName"></span></h4>
        <form id="orderNowForm" method="POST">
            @csrf
            <input type="hidden" name="food_id" id="modalFoodId">
            <div class="mu-form-group">
                <label for="modalQty">Jumlah</label>
                <input type="number" name="qty" id="modalQty" class="mu-input" value="1" min="1" required>
            </div>
            <div class="mu-form-group">
                <label for="modalAlamat">Alamat Pengiriman</label>
                <textarea name="alamat" id="modalAlamat" class="mu-input" required>{{ auth()->user()->alamat ?? '' }}</textarea>
            </div>
            <div style="text-align:right;margin-top:1.5rem;">
                <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-check"></i> Pesan Sekarang</button>
            </div>
        </form>
    </div>
</div>
<script>
function openOrderModal(foodId, foodName, foodHarga) {
    document.getElementById('orderModal').style.display = 'flex';
    document.getElementById('modalFoodName').innerText = foodName;
    document.getElementById('modalFoodId').value = foodId;
    document.getElementById('orderNowForm').action = '/foods/' + foodId + '/order-now';
    document.getElementById('modalQty').value = 1;
    document.getElementById('modalAlamat').value = '{{ auth()->user()->alamat ?? '' }}';
}
function closeOrderModal() {
    document.getElementById('orderModal').style.display = 'none';
}
window.onclick = function(event) {
    var modal = document.getElementById('orderModal');
    if(event.target == modal) modal.style.display = 'none';
}
</script>
<style>
.mu-modal { position:fixed;z-index:999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center; }
.mu-modal-content { background:#fff;border-radius:1em;padding:2em 1.5em;max-width:400px;width:95vw;box-shadow:0 8px 32px rgba(0,0,0,0.2);position:relative; margin:0 auto; display:block; }
.mu-modal-close { position:absolute;top:1em;right:1em;font-size:2em;cursor:pointer;color:#DA291C; }
</style>
@endsection 