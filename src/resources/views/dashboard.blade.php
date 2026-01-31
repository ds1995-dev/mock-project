@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection
@section('content')
<nav class="tab-bar">
    <a class="tab {{ request('tab', 'recommend') === 'recommend' ? 'active' : '' }}"
        href="/?tab=recommend">おすすめ</a>
    <a class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}"
        href="/?tab=mylist">マイリスト</a>
</nav>

<div class="item">
    @forelse ($items as $item)
    <div class="item-card">
        <div class="item-image">
            <a href="{{ route('items.show', ['item_id' => $item->id]) }}">
                <img class="item-image"src="{{ asset('storage/'.$item->image) }}" alt="{{ $item['name'] }}">
            </a>
        </div>
        <div class="item-name">
            {{ $item['name'] }}
            @if ($item->status == 1)
            <span class="item-sold">"SOLD"</span>
            @endif
        </div>
    </div>
    @empty
    <p class="empty-text">表示できる商品がありません。</p>
    @endforelse
</div>
@endsection
