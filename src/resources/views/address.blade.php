@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection
@section('content')
<div class="address-setup">
    <h2 class="address-setup__title">住所の変更</h2>

    <form class="address-setup__form" method="POST" action="{{ route('address.update', ['item_id' => $item->id]) }}">
        @csrf
        <label class="address-setup__label" for="postal_code">郵便番号</label>
        <input class="address-setup__input" id="postal_code" name="postal_code" type="text" value="{{ old('postal_code', $user->postal_code ?? '') }}" placeholder="">
        @error('postal_code')
        <p class="error">{{ $message }}</p>
        @enderror

        <label class="address-setup__label" for="address">住所</label>
        <input class="address-setup__input" id="address" name="address" type="text" value="{{ old('address', $user->address ?? '') }}" placeholder="">
        @error('address')
        <p class="error">{{ $message }}</p>
        @enderror

        <label class="address-setup__label" for="building">建物名</label>
        <input class="address-setup__input" id="building" name="building" type="text" value="{{ old('building', $user->building ?? '') }}" placeholder="">

        <button class="address-setup__submit" type="submit">更新する</button>
    </form>
</div>
@endsection
