@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-utensils"></i> Kelola Menu Makanan</h4>
            <a href="{{ route('admin.foods.create') }}" class="mu-btn mu-btn-primary" style="margin-bottom:1.2em;"><i class="fas fa-plus"></i> Tambah Makanan</a>
            <table class="mu-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($foods as $food)
                    <tr>
                        <td>{{ $food->nama }}</td>
                        <td>{{ $food->kategori }}</td>
                        <td>Rp{{ number_format($food->harga, 0, ',', '.') }}</td>
                        <td>{{ $food->stok }}</td>
                        <td>
                            <a href="{{ route('admin.foods.edit', $food->id) }}" class="mu-btn mu-btn-outline"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.foods.destroy', $food->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mu-btn mu-btn-danger" onclick="return confirm('Yakin hapus makanan ini?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 