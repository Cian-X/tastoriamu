@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:700px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-edit"></i> Edit Makanan</h4>
            <form action="{{ route('admin.foods.update', $food->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mu-form-group">
                    <label for="nama">Nama Makanan</label>
                    <input type="text" name="nama" id="nama" class="mu-input" value="{{ $food->nama }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="mu-input" value="{{ $food->kategori }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="mu-input" value="{{ $food->harga }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" class="mu-input" value="{{ $food->stok }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="mu-input">
                    @if($food->gambar)
                        <img src="{{ asset('storage/' . $food->gambar) }}" alt="{{ $food->nama }}" style="max-width:120px;margin-top:0.7em;">
                    @endif
                </div>
                <div class="mu-form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="mu-input" required>{{ $food->deskripsi }}</textarea>
                </div>
                <div style="text-align:right;margin-top:1.5rem;">
                    <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 