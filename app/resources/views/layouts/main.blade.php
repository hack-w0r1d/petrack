<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/34862077a1.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div id="app">
        <div class="container-fluid">
                <div class="d-none d-md-block">
                    <!-- 左サイドバー -->
                    <nav class="vh-100 d-flex flex-column text-white border-right p-3 sidebar">
                        <!-- タイトル -->
                        <div class="py-4 pl-3" style="font-size: 1.25rem;">
                            <a href="{{ route('home') }}" class="text-white h2">
                                {{ config('app.name', 'Laravel') }}
                            </a>
                        </div>
                        <!-- メインメニュー -->
                        <ul class="nav flex-column">
                            <li class="nav-item my-3">
                                <a class="nav-link text-white h5" href="{{ route('home') }}">
                                    <i class="bi bi-house-door-fill mr-3"></i>ホーム</a>
                            </li>
                            <li class="nav-item my-3">
                                <a class="nav-link text-white h5" href="">
                                    <i class="bi bi-search mr-3"></i>検索</a>
                            </li>
                            <li class="nav-item my-3">
                                <a class="nav-link text-white h5" href="{{ route('explore') }}">
                                    <i class="bi bi-compass-fill mr-3"></i>発見</a>
                            </li>
                            <li class="nav-item my-3">
                                <a class="nav-link text-white h5" href="{{ route('posts.create') }}">
                                    <i class="bi bi-plus-square-fill mr-3"></i>作成</a>
                            </li>
                            <li class="nav-item my-3">
                                <a class="nav-link text-white h5" href="{{ route('profile.show', auth()->id()) }}">
                                    <i class="bi bi-person-fill mr-3"></i>プロフィール</a>
                            </li>
                        </ul>

                        <!-- サイドメニュー -->
                        <ul class="nav flex-column mt-auto">
                            <li class="nav-item dropup">
                                <a id="navbarDropdown" class="nav-link text-white h5" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="bi bi-list mr-3"></i>
                                    その他
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>

                <!-- メインコンテンツ -->
                <main role="main" id="main-container" class="p-3">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</body>
</html>
