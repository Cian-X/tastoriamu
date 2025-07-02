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
                    <input type="text" name="nama_pemesan" id="nama_pemesan" class="mu-input" value="{{ old('nama_pemesan', auth()->user()->name ?? '') }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="alamat">Alamat Pengiriman</label>
                    <textarea name="alamat" id="alamat" class="mu-input" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="mu-form-group">
                    <label for="catatan">Catatan (Opsional)</label>
                    <input type="text" name="catatan" id="catatan" class="mu-input" value="{{ old('catatan') }}">
                </div>
                <div style="text-align:right;margin-top:1.5rem;">
                    <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-check"></i> Proses Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 