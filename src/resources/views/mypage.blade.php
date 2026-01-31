@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection
@section('content')
<div class="profile-header">
    <div class="profile-user">
        <img class="profile-avatar" src="{{ asset('storage/'.$user->avatar_url) }}" alt="">
        <p class="profile-name">{{ $user->name }}</p>
    </div>
    <a class="profile-edit" href="/mypage/profile">プロフィールを編集</a>
</div>
<nav class="tab-bar">
    <a class="tab {{ request('page', 'sell') === 'sell' ? 'active' : '' }}"
        href="/mypage?page=sell">出品した商品</a>
    <a class="tab {{ request('page') === 'buy' ? 'active' : '' }}"
        href="/mypage?page=buy">購入した商品</a>
</nav>
<div class="item">
    @forelse ($items as $item)
    <div class="item-card">
        <div class="item-image">
            <a href="{{ route('items.show', ['item_id' => $item->id]) }}">
                <img class="item-image" src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}">
            </a>
        </div>
        <div class="item-name">
            {{ $item->name }}
        </div>
    </div>
    @empty
    <p class="empty-text">表示できる商品がありません。</p>
    @endforelse
</div>
@endsection
