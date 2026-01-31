@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
@endsection
@section('content')
<div class="item-detail">
    <div class="item-left">
        <img class="item-image" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}">
    </div>
    <div class="item-right">
        <div class="item-title">
            <h2 class="item-name">{{ $item->name }}</h2>
            <p class="item-brand">{{ $item->brand }}</p>
            <p class="item-price">¥{{ $item->price }}(税込)</p>
            <div class="item-actions">
                <form class="item-actions_i" method="POST" action="{{ route('items.like', ['item_id' => $item->id]) }}">
                    @csrf
                    <button type="submit" class="like-button">
                        <i class="{{ $item->likes->contains(auth()->id()) ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                        <span class="item-actions_count">{{ $item->likes_count }}</span>
                    </button>
                </form>
                <div class="item-actions_i">
                    <i class="fa-regular fa-comment"></i>
                    <span class="item-actions_count">{{ $item->comments_count }}</span>
                </div>
            </div>
        </div>
        <a class="purchase" href="{{ route('purchase.index', ['item_id' => $item->id]) }}">購入手続きへ</a>
        <div class="item-description">
            <h2 class="item-description__title">商品説明</h2>
            <p class="item-description__content">{{ $item->description }}</p>
        </div>
        <div class="item-info">
            <h2 class="item-info__title">商品の情報</h2>
            <div class="category-tags">
                <p class="category-title">カテゴリ</p>
                @foreach ($item->categories as $category)
                <span class="tag">{{ $category->name }}</span>
                @endforeach
            </div>
            <div class="category-tags">
                <p class="category-title">商品の状態</p>
                <span class="condition">{{ \App\Models\Item::CONDITIONS[$item->condition] ?? '不明' }}</span>
            </div>
        </div>
        <div class="item-comments">
            <p class="count-comment">コメント<span>({{ $item->comments_count}})</span></p>
            <div class="comment">
                @foreach ($comments as $comment)
                <img class="user-avatar" src="{{ asset('storage/'.$comment->user->avatar_url) }}" alt="">
                <span class="user-name">{{ $comment->user->name }}</span>
                <div class="show-comment">
                    <p class="user-comment">{{ $comment->body }}</p>
                </div>
                @endforeach
            </div>
            <div class="comment-form">
                <p>商品へのコメント</p>
                <form class="comment-form__textarea" action="{{ route('items.comment.store', ['item_id' => $item->id]) }}" method="post">
                    @csrf
                    <textarea name="body" cols="24" rows="15"></textarea>
                    <button class="comment-form__btn" type="submit">コメントを送信する</button>
                    @error('body')
                    <p class='error'>{{ $message }}</p>
                    @enderror
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
