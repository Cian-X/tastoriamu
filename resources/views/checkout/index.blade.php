@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:700px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-credit-card"></i> Checkout</h4>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                <div class="mu-form-group">
                    <label for="nama_pemesan">Nama Pemesan</label>
                    <input type="text" name="nama_pemesan" id="nama_pemesan" class="mu-input" value="{{ auth()->user()->name ?? '' }}" readonly>
                </div>
                <div class="mu-form-group">
                    <label for="alamat">Alamat Pengiriman</label>
                    <textarea name="alamat" id="alamat" class="mu-input" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="mu-form-group">
                    <label for="catatan">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="mu-input" value="{{ old('catatan') }}">
                </div>
                <div class="mu-form-group">
                    <label for="payment_method">Metode Pembayaran</label>
                    <div style="display:flex;gap:1.2em;align-items:center;">
                        <label style="display:flex;align-items:center;gap:0.5em;">
                            <input type="radio" name="payment_method" value="cash" checked> Cash
                        </label>
                        <label style="display:flex;align-items:center;gap:0.5em;opacity:0.6;cursor:not-allowed;">
                            <input type="radio" name="payment_method" value="online" disabled> Online <span style="font-size:0.95em;color:#B3A369;">(Belum tersedia)</span>
                        </label>
                    </div>
                </div>
                <div style="text-align:right;margin-top:1.5rem;">
                    <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-check"></i> Proses Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 