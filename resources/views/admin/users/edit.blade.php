@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:700px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-user-edit"></i> Edit User</h4>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mu-form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="mu-input" value="{{ $user->name }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="mu-input" value="{{ $user->email }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="mu-input">
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div style="text-align:right;margin-top:1.5rem;">
                    <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 