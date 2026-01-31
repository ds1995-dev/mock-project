@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection
@section('content')
<div class="purchase">
    <div class="purchase-main">
        <section class="purchase-item">
            <img class="purchase-item__image" src="{{ asset('storage/'.$item->image) }}">
            <div class="purchase-item__info">
                <h2 class="purchase-item__name">{{ $item->name }}</h2>
                <p class="purchase-item__price">¥{{ $item->price }}</p>
            </div>
        </section>

        <form method="POST" action="{{ route('purchase.store', ['item_id' => $item->id]) }}">
            @csrf
            <div class="purchase-divider"></div>
            <section class="purchase-payment">
                <h3 class="purchase-section__title">支払い方法</h3>
                <div class="purchase-payment__select">
                    <select name="payment" id="payment-method">
                        <option value="">選択してください</option>
                        <option value="card" selected>コンビニ払い</option>
                        <option value="card">クレジットカード</option>
                    </select>
                    @error('payment')
                    <p class="purchase-payment__error">{{ $message }}</p>
                    @enderror
                </div>
            </section>

            <div class="purchase-divider"></div>

            <section class="purchase-shipping">
                <div class="purchase-shipping__head">
                    <h3 class="purchase-section__title">配送先</h3>
                    <a class="purchase-shipping__change" href="{{ route('address.show', ['item_id' => $item->id]) }}">変更する</a>
                </div>
                <div class="purchase-shipping__address">
                    <p>〒 {{ $user->postal_code }}</p>
                    <p>{{ $user->address }} {{ $user->building }}</p>
                </div>
            </section>

            <div class="purchase-divider"></div>
    </div>

    <aside class="purchase-side">
        <div class="purchase-summary">
            <div class="purchase-summary__row">
                <span>商品代金</span>
                <span>¥{{ $item->price }}</span>
            </div>
            <div class="purchase-summary__row">
                <span>支払い方法</span>
                <span id="payment-summary">コンビニ払い</span>
            </div>
        </div>
        <button class="purchase-submit" type="submit">購入する</button>
        </form>
    </aside>
</div>
<script>
    const paymentSelect = document.getElementById('payment-method');
    const paymentSummary = document.getElementById('payment-summary');

    paymentSelect.addEventListener('change', () => {
        const selectedText = paymentSelect.options[paymentSelect.selectedIndex]?.text || '選択してください';
        paymentSummary.textContent = selectedText;
    });
</script>
@endsection
