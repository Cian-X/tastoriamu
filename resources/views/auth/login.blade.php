@extends('layouts.app')

@section('content')
<div class="mu-container mu-auth-container">
    <div class="mu-card">
        <div class="mu-card-body">
            <div style="text-align:center;margin-bottom:1.5rem;">
                <i class="fas fa-fire" style="font-size:2.5rem;color:#DA291C;"></i>
                <div class="mu-title" style="margin-top:0.5em;">Tastoria</div>
                <div class="mu-slogan" style="color:#B3A369;">Masuk ke akun Anda</div>
            </div>
            @if(session('error'))
                <div class="mu-badge" style="background:#DA291C;color:#fff;display:block;margin-bottom:1em;">{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mu-form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="mu-input" required autofocus>
                </div>
                <div class="mu-form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="mu-input" required>
                </div>
                <div style="margin-top:1.5rem;text-align:right;">
                    <button type="submit" class="mu-btn mu-btn-primary"><i class="fas fa-sign-in-alt"></i> Login</button>
                </div>
            </form>
            <div style="margin-top:1.5rem;text-align:center;">
                <span style="color:#888;">Belum punya akun?</span><br>
                <a href="/register" class="mu-btn mu-btn-outline" style="margin-top:0.5em;"><i class="fas fa-user-plus"></i> Daftar Akun</a>
            </div>
        </div>
    </div>
</div>
@endsection 