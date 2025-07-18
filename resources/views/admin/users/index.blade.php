@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:1100px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-users"></i> Kelola User</h4>
            <a href="{{ route('admin.users.create') }}" class="mu-btn mu-btn-primary" style="margin-bottom:1.2em;"><i class="fas fa-plus"></i> Tambah User</a>
            <table class="mu-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="mu-btn mu-btn-outline"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mu-btn mu-btn-danger" onclick="return confirm('Yakin hapus user ini?')"><i class="fas fa-trash"></i></button>
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

@push('styles')
<style>
.mu-table th {
    background: #DA291C !important;
    color: #fff !important;
}
.mu-btn.mu-btn-danger {
    background: #DA291C;
    color: #fff;
    border: none;
    border-radius: 0.7em;
    font-weight: 700;
    padding: 0.5em 1.1em;
    font-size: 1.1em;
    transition: background 0.2s, box-shadow 0.2s;
    box-shadow: 0 2px 8px #da291c22;
}
.mu-btn.mu-btn-danger:hover {
    background: #B71C1C;
    color: #fff;
}
</style>
@endpush 