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
                <div id="alamatWarning" style="color:#d9534f;font-size:0.97em;margin-top:0.2em;display:none;">
                    Alamat terlalu singkat, mohon isi dengan lengkap!
                </div>
            </div>
            <div class="mu-form-group">
                <label for="modalPayment">Metode Pembayaran</label>
                <div style="display:flex;gap:1.2em;align-items:center;">
                    <label style="display:flex;align-items:center;gap:0.5em;">
                        <input type="radio" name="payment_method" value="cod" checked onchange="toggleDanaInfo()"> COD (Bayar di Tempat)
                    </label>
                    <label style="display:flex;align-items:center;gap:0.5em;">
                        <input type="radio" name="payment_method" value="transfer" onchange="toggleDanaInfo()"> Transfer
                    </label>
                </div>
                <div id="danaInfo" style="display:none;margin-top:1em;">
                    <div class="dana-transfer-box">
                        <img src="{{ asset('images/dana.jpg') }}" alt="DANA" class="dana-logo">
                        <div class="dana-text">
                            <div class="dana-number">0823 6726 4912</div>
                            <div class="dana-instruction">
                                Setelah transfer, upload bukti pembayaran di halaman selanjutnya.
                            </div>
                        </div>
                    </div>
                </div>
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
    document.querySelector('input[name=payment_method][value=cod]').checked = true;
    toggleDanaInfo();
}
function closeOrderModal() {
    document.getElementById('orderModal').style.display = 'none';
}
function toggleDanaInfo() {
    var isTransfer = document.querySelector('input[name=payment_method]:checked').value === 'transfer';
    document.getElementById('danaInfo').style.display = isTransfer ? 'block' : 'none';
}
window.onclick = function(event) {
    var modal = document.getElementById('orderModal');
    if(event.target == modal) modal.style.display = 'none';
}
document.getElementById('modalAlamat').addEventListener('input', function() {
    var val = this.value;
    document.getElementById('alamatWarning').style.display = (val.length < 10) ? 'block' : 'none';
});
</script>
<style>
.mu-modal { position:fixed;z-index:999;left:0;top:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);display:none;align-items:center;justify-content:center; }
.mu-modal-content { background:#fff;border-radius:1em;padding:2em 1.5em;max-width:400px;width:95vw;box-shadow:0 8px 32px rgba(0,0,0,0.2);position:relative; margin:0 auto; display:block; }
.mu-modal-close { position:absolute;top:1em;right:1em;font-size:2em;cursor:pointer;color:#DA291C; }
.mu-badge-dana { letter-spacing:1px; }
.mu-form-group label { font-weight:600; }
.mu-form-group input[type=number], .mu-form-group textarea { margin-top:0.3em; }
.dana-transfer-box {
  display: flex;
  align-items: center;
  background: #e3f0ff;
  border: 1.5px solid #1877f2;
  border-radius: 10px;
  padding: 12px 16px;
  margin: 12px 0 8px 0;
  gap: 14px;
  min-height: 60px;
}
.dana-logo {
  width: 44px;
  height: 44px;
  object-fit: contain;
  background: #fff;
  border-radius: 8px;
  border: 1px solid #e3f0ff;
}
.dana-text {
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.dana-number {
  font-size: 1.15rem;
  font-weight: bold;
  color: #1877f2;
  letter-spacing: 1px;
  margin-bottom: 2px;
}
.dana-instruction {
  font-size: 0.97rem;
  color: #666;
  margin-top: 0;
}
.mu-input {
  width: 100%;
  box-sizing: border-box;
  padding: 0.6em 1em;
  border: 1.2px solid #ccc;
  border-radius: 7px;
  font-size: 1em;
  margin-top: 0.2em;
  margin-bottom: 0.2em;
  background: #fafbfc;
  transition: border 0.2s;
}
.mu-input:focus {
  border: 1.2px solid #1877f2;
  outline: none;
  background: #fff;
}
.mu-form-group textarea.mu-input {
  min-height: 60px;
  resize: vertical;
}
</style>
@endsection 