@extends('layouts.app')

@section('content')
<style>
    /* Inline style untuk memastikan input login benar-benar rapi dan konsisten */
    .mu-input-auth {
        width: 100%;
        box-sizing: border-box;
        padding: 0.7em 1em;
        border-radius: 8px;
        border: 1.5px solid #ccc;
        background: #fff;
        font-size: 1rem;
        margin-top: 0.2em;
        transition: box-shadow 0.18s, border-color 0.18s;
    }
    .mu-input-auth:focus {
        outline: none;
        border-color: #DA291C;
        box-shadow: 0 0 0 2px #DA291C22;
    }
    input.mu-input-auth:-webkit-autofill {
        box-shadow: 0 0 0 1000px #fff inset !important;
        -webkit-text-fill-color: #111 !important;
        border-radius: 8px;
    }
    /* Alert login modern tanpa gradient */
    .mu-alert-login {
        background: #DA291C;
        color: #fff;
        border-radius: 16px;
        padding: 1em 1.3em;
        font-size: 1.08rem;
        font-weight: bold;
        margin-bottom: 1.2em;
        text-align: center;
        box-shadow: 0 4px 18px #DA291C22;
        display: flex;
        align-items: center;
        gap: 1em;
        justify-content: center;
        animation: popIn 0.5s cubic-bezier(.68,-0.55,.27,1.55);
    }
    .mu-alert-login i {
        font-size: 1.5em;
        color: #fff;
        animation: shake 0.7s cubic-bezier(.36,.07,.19,.97) both;
    }
    @keyframes popIn {
        0% { transform: scale(0.7); opacity: 0; }
        80% { transform: scale(1.1); opacity: 1; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes shake {
        10%, 90% { transform: translateX(-1px); }
        20%, 80% { transform: translateX(2px); }
        30%, 50%, 70% { transform: translateX(-4px); }
        40%, 60% { transform: translateX(4px); }
    }
</style>
<div class="mu-container mu-auth-container" style="display:flex;justify-content:center;align-items:center;min-height:70vh;">
    <div class="mu-card" style="max-width:400px;width:100%;margin:2rem auto 2rem auto;box-shadow:0 4px 24px #DA291C22;border-radius:1.2rem;">
        <div class="mu-card-body" style="padding:2.2rem 2rem 1.5rem 2rem;">
            <div style="text-align:center;margin-bottom:1.5rem;">
                <i class="fas fa-fire" style="font-size:2.5rem;color:#DA291C;"></i>
                <div class="mu-title" style="margin-top:0.5em;font-size:1.7rem;letter-spacing:1px;">Tastoria</div>
                <div class="mu-slogan" style="color:#B3A369;font-size:1.1rem;">Masuk ke akun Anda</div>
            </div>
            @if(session('error'))
                <div class="mu-alert-login"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mu-form-group" style="margin-bottom:1.3em;">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="mu-input mu-input-auth" required autofocus autocomplete="email">
                </div>
                <div class="mu-form-group" style="margin-bottom:1.3em;">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="mu-input mu-input-auth" required autocomplete="current-password">
                </div>
                <div style="margin-top:1.2rem;text-align:right;">
                    <button type="submit" class="mu-btn mu-btn-primary" style="width:100%;font-size:1.1rem;padding:0.7em 0;"><i class="fas fa-sign-in-alt"></i> Login</button>
                </div>
            </form>
            <div style="margin-top:1.2rem;text-align:center;">
                <span style="color:#888;">Belum punya akun?</span><br>
                <a href="/register" class="mu-btn mu-btn-outline" style="margin-top:0.7em;width:100%;font-size:1.05rem;padding:0.7em 0;border-width:2px;"><i class="fas fa-user-plus"></i> Daftar Akun</a>
            </div>
        </div>
    </div>
</div>
@endsection 