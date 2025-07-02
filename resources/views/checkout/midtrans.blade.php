@extends('layouts.app')

@section('title', 'Pembayaran Midtrans')

@section('content')
<div class="mu-container" style="max-width:600px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body" style="text-align:center;">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-credit-card"></i> Pembayaran Midtrans</h4>
            <p class="mu-badge" style="margin-bottom:1.2em;">Silakan lanjutkan pembayaran melalui Midtrans.</p>
            <div style="margin-bottom:2em;">
                <a href="/orders" class="mu-btn mu-btn-primary"><i class="fas fa-list"></i> Lihat Riwayat Pesanan</a>
            </div>
            <div class="mu-card" style="margin-bottom:1.5rem;">
                <div class="mu-card-body">
                    <h6 class="mu-card-title"><i class="fas fa-info-circle"></i> Info</h6>
                    <p>Setelah pembayaran berhasil, status pesanan Anda akan otomatis diperbarui.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    document.getElementById('pay-button').onclick = function(){
        window.snap.pay(@json($snapToken), {
            onSuccess: function(result){
                alert('Pembayaran berhasil!');
                window.location.href = '/orders';
            },
            onPending: function(result){
                alert('Pembayaran pending!');
                window.location.href = '/orders';
            },
            onError: function(result){
                alert('Pembayaran gagal!');
            }
        });
    }
</script>
@endsection 