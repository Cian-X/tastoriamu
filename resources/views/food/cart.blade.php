@extends('layouts.app')

@section('content')
<div class="mu-container" style="max-width:900px;margin:2rem auto;">
    <div class="mu-card">
        <div class="mu-card-body">
            <h4 class="mu-title" style="margin-bottom:1.5rem;"><i class="fas fa-shopping-cart"></i> Keranjang</h4>
            @if(count($cart) > 0)
            <table class="mu-table">
                <thead>
                    <tr>
                        <th>Menu</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($cart as $id => $item)
                    @php $total += $item['harga'] * $item['qty']; @endphp
                    <tr>
                        <td>{{ $item['nama'] }}</td>
                        <td>
                            <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="number" name="qty" value="{{ $item['qty'] }}" min="1" style="width:60px;padding:0.3em;border:1px solid #ddd;border-radius:0.3em;" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                        <td>Rp{{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="mu-btn mu-btn-danger mu-btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align:right;margin-top:1.5rem;">
                <span class="mu-price" style="font-size:1.2rem;">Total: <b>Rp{{ number_format($total, 0, ',', '.') }}</b></span>
            </div>
            <div style="text-align:right;margin-top:1rem;">
                <a href="{{ route('checkout.index') }}" class="mu-btn mu-btn-primary"><i class="fas fa-credit-card"></i> Checkout</a>
            </div>
            @else
            <div style="text-align:center;padding:2.5rem 0;">
                <i class="fas fa-shopping-cart" style="font-size:3rem;color:#ccc;"></i>
                <h5 style="color:#888;">Keranjang Kosong</h5>
                <p style="color:#888;">Belum ada makanan di keranjang</p>
                <a href="{{ route('foods.index') }}" class="mu-btn" style="margin-top:1rem;"><i class="fas fa-utensils"></i> Lihat Menu</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 