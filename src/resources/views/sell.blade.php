@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection
@section('content')
<div class="sell">
    <form class="sell__inner" method="POST" action="/sell" enctype="multipart/form-data">
        @csrf
        <h2 class="sell__title">商品の出品</h2>

        <section class="sell-section">
            <h3 class="sell-section__title">商品画像</h3>
            <div class="sell-image">
                <div class="sell-image__box">
                    <img class="sell-image__preview" id="sell-image-preview" alt="">
                    <label class="sell-image__button">
                        画像を選択する
                        <input type="file" name="image" accept="image/*" id="sell-image-input">
                    </label>
                    @error('image')
                    <p class="sell-field__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="sell-section">
            <h3 class="sell-section__title sell-section__title--line">商品の詳細</h3>
            <div class="sell-field">
                <label class="sell-field__label">カテゴリー</label>
                <div class="sell-category">
                    @foreach($categories as $category)
                    <label class="sell-category__label">
                        <input class="sell-category__input" type="checkbox" name="category_ids[]" value="{{ $category->id }}">
                        <span class="sell-category__text">{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
                @error('category_ids')
                <p class="sell-field__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="sell-field">
                <label class="sell-field__label" for="condition">商品の状態</label>
                <div class="sell-field__select">
                    @php $current = (string) old('condition', ''); @endphp
                    <select id="condition" name="condition">
                        <option value="" disabled @selected($current === '')>選択してください</option>
                        @foreach ($conditions as $value => $label)
                        <option value="{{ $value }}" @selected($current === (string) $value)>{{ $label}}</option>
                        @endforeach
                    </select>
                </div>
                @error('condition')
                <p class="sell-field__error">{{ $message }}</p>
                @enderror
            </div>
        </section>

        <section class="sell-section">
            <h3 class="sell-section__title sell-section__title--line">商品名と説明</h3>
            <div class="sell-field">
                <label class="sell-field__label" for="name">商品名</label>
                <input class="sell-field__input" id="name" name="name" type="text">
                @error('name')
                <p class="sell-field__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="sell-field">
                <label class="sell-field__label" for="brand">ブランド名</label>
                <input class="sell-field__input" id="brand" name="brand" type="text">
            </div>
            <div class="sell-field">
                <label class="sell-field__label" for="description">商品の説明</label>
                <textarea class="sell-field__textarea" id="description" name="description" rows="5"></textarea>
                @error('description')
                <p class="sell-field__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="sell-field">
                <label class="sell-field__label" for="price">販売価格</label>
                <div class="sell-field__price">
                    <span class="sell-field__yen">¥</span>
                    <input class="sell-field__input" id="price" name="price" type="text">
                </div>
                @error('price')
                <p class="sell-field__error">{{ $message }}</p>
                @enderror
            </div>
        </section>

        <button class="sell-submit" type="submit">出品する</button>
    </form>
</div>
<script>
    const imageInput = document.getElementById('sell-image-input');
    const imagePreview = document.getElementById('sell-image-preview');

    imageInput.addEventListener('change', () => {
        const file = imageInput.files && imageInput.files[0];
        if (!file) {
            imagePreview.removeAttribute('src');
            imagePreview.classList.remove('is-visible');
            return;
        }
        imagePreview.src = URL.createObjectURL(file);
        imagePreview.classList.add('is-visible');
    });
</script>
@endsection
