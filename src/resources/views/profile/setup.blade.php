@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/setup.css') }}">
@endsection
@section('content')
<div class="profile-setup">
    <h2 class="profile-setup__title">プロフィール設定</h2>

    <form class="profile-setup__form" method="POST" action="{{ $formAction ?? '/profile/setup' }}" enctype="multipart/form-data">
        @csrf
        <div class="profile-setup__avatar">
            <div class="profile-setup__avatar-circle">
                <img class="profile-setup__avatar-preview {{ $user->avatar_url ? 'is-visible' : '' }}" id="avatar-preview" src="{{ $user->avatar_url ? asset('storage/'.$user->avatar_url) : '' }}" alt="">
            </div>
            <label class="profile-setup__file-button">
                画像を選択する
                <input type="file" name="avatar" accept="image/*" id="avatar-input">
            </label>
        </div>

        <label class="profile-setup__label" for="name">ユーザー名</label>
        <input class="profile-setup__input" id="name" name="display_name" value="{{ old('display_name' , $user->name ?? '') }}" type="text" placeholder="">
        @error('display_name')
        <p class="error">{{ $message }}</p>
        @enderror


        <label class="profile-setup__label" for="postal_code">郵便番号</label>
        <input class="profile-setup__input" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->postal_code ?? '') }}" type="text" placeholder="">
        @error('postal_code')
        <p class="error">{{ $message }}</p>
        @enderror

        <label class="profile-setup__label" for="address">住所</label>
        <input class="profile-setup__input" id="address" name="address" value="{{ old('address' , $user->address ?? '') }}" type="text" placeholder="">
        @error('address')
        <p class="error">{{ $message }}</p>
        @enderror


        <label class="profile-setup__label" for="building">建物名</label>
        <input class="profile-setup__input" id="building" name="building" value="{{ old('building' , $user->building ?? '') }}" type="text" placeholder="">

        <button class="profile-setup__submit" type="submit">更新する</button>
    </form>
</div>
<script>
    const avatarInput = document.getElementById('avatar-input');
    const avatarPreview = document.getElementById('avatar-preview');

    avatarInput.addEventListener('change', () => {
        const file = avatarInput.files && avatarInput.files[0];
        if (!file) {
            avatarPreview.removeAttribute('src');
            avatarPreview.classList.remove('is-visible');
            return;
        }
        avatarPreview.src = URL.createObjectURL(file);
        avatarPreview.classList.add('is-visible');
    });
</script>
@endsection
