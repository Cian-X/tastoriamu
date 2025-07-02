@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:700px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-plus"></i> Tambah Makanan</h4>
            <form action="{{ route('admin.foods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mu-form-group">
                    <label for="nama">Nama Makanan</label>
                    <input type="text" name="nama" id="nama" class="mu-input" required>
                </div>
                <div class="mu-form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" name="kategori" id="kategori" class="mu-input" required>
                </div>
                <div class="mu-form-group">
                    <label for="harga">Harga</label>
                    <input type="number" name="harga" id="harga" class="mu-input" required>
                </div>
                <div class="mu-form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" class="mu-input" required>
                </div>
                <div class="mu-form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="mu-input">
                </div>
                <div class="mu-form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="mu-input" required></textarea>
                </div>
                <div style="text-align:right;margin-top:1.5rem;">
                    <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 