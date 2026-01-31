<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coachtech</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap">

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__inner-logo" href="/">
                <img src="{{ asset('images/COACHTECHヘッダーロゴ.png') }}">
            </a>
            @unless(request()->routeIs('login', 'register', 'auth.verify', 'verification.notice', 'verification.verify'))
            <form action="/" method="GET" class="header__inner-search">
                <input type="hidden" name="tab" value="{{ request('tab', 'recommend') }}">
                <input class="header__inner-search__form" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="          何をお探しですか？">
            </form>
            <div class="header__inner-href">
                @auth
                <form method="POST" action="/logout">
                    @csrf
                    <button class="header__inner-href__logout" type="submit">ログアウト</button>
                </form>
                @else
                <a class="header__inner-href__login" href="/login">ログイン</a>
                @endauth
                <a class="header__inner-href__mypage" href="/mypage">マイページ</a>
                <a class="header__inner-href__post" href="/sell">出品</a>
            </div>
            @endunless
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>

</html>
