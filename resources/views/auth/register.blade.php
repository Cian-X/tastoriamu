@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:400px;margin:3rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <div style="text-align:center;margin-bottom:1.5rem;">
                <i class="fas fa-user-plus" style="font-size:2.5rem;color:#DA291C;"></i>
                <div class="mu-title" style="margin-top:0.5em;">Daftar Akun</div>
                <div class="mu-slogan" style="color:#B3A369;">Buat akun baru untuk Tastoria</div>
            </div>
            @if($errors->any())
                <div class="mu-badge" style="background:#DA291C;color:#fff;display:block;margin-bottom:1em;">
                    {{ $errors->first() }}
                </div>
            @endif
            @if(session('admin_limit'))
                <div class="mu-badge" style="background:#DA291C;color:#fff;display:block;margin-bottom:1em;">
                    {{ session('admin_limit') }}
                </div>
            @endif
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mu-form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" id="name" class="mu-input" value="{{ old('name') }}" required autofocus>
                </div>
                <div class="mu-form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="mu-input" value="{{ old('email') }}" required>
                </div>
                <div class="mu-form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="mu-input" required>
                </div>
                <div class="mu-form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mu-input" required>
                </div>
                <div class="mu-form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="mu-input" required>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="kurir" {{ old('role') == 'kurir' ? 'selected' : '' }}>Kurir</option>
                        @if(isset($adminCount) && $adminCount == 0)
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        @endif
                    </select>
                </div>
                <div style="margin-top:1.5rem;text-align:right;">
                    <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-user-plus"></i> Daftar</button>
                </div>
            </form>
            <div style="margin-top:1.5rem;text-align:center;">
                <span style="color:#888;">Sudah punya akun?</span><br>
                <a href="{{ route('login') }}" class="mu-btn mu-btn-outline" style="margin-top:0.5em;"><i class="fas fa-sign-in-alt"></i> Login</a>
            </div>
        </div>
    </div>
</div>
@endsection 