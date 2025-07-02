@extends('layouts.app')

@section('content')
<div class="mu-container mu-auth-container" style="display:flex;justify-content:center;align-items:center;min-height:70vh;">
    <div class="mu-card" style="max-width:400px;width:100%;margin:2rem auto 2rem auto;box-shadow:0 4px 24px #DA291C22;border-radius:1.2rem;">
        <div class="mu-card-body" style="padding:2.2rem 2rem 1.5rem 2rem;">
            <div style="text-align:center;margin-bottom:1.5rem;">
                <i class="fas fa-fire" style="font-size:2.5rem;color:#DA291C;"></i>
                <div class="mu-title" style="margin-top:0.5em;font-size:1.7rem;letter-spacing:1px;">Tastoria</div>
                <div class="mu-slogan" style="color:#B3A369;font-size:1.1rem;">Masuk ke akun Anda</div>
            </div>
            @if(session('error'))
                <div class="mu-badge" style="background:#F8D7DA;color:#B71C1C;display:block;margin-bottom:1em;border-radius:8px;font-size:1rem;padding:0.7em 1em;text-align:center;">{{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mu-form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="mu-input" required autofocus style="background:#fff;">
                </div>
                <div class="mu-form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="mu-input" required style="background:#fff;">
                </div>
                <div style="margin-top:1.5rem;text-align:right;">
                    <button type="submit" class="mu-btn mu-btn-primary" style="width:100%;font-size:1.1rem;padding:0.7em 0;"><i class="fas fa-sign-in-alt"></i> Login</button>
                </div>
            </form>
            <div style="margin-top:1.5rem;text-align:center;">
                <span style="color:#888;">Belum punya akun?</span><br>
                <a href="/register" class="mu-btn mu-btn-outline" style="margin-top:0.5em;width:100%;font-size:1.05rem;"><i class="fas fa-user-plus"></i> Daftar Akun</a>
            </div>
        </div>
    </div>
</div>
@endsection 