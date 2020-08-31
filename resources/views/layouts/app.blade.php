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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/item.css?202008270') }}">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- ヘッダーメニュー -->
                <ul class="nav navbar-nav">
                    <!-- サンプル -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle mr-4" data-toggle="dropdown">
                            @lang('common.menu.sample')<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu bg-light">
                            <li><a href="/sample">・@lang('common.menu.sample_add')</a></li>
                            <li><a href="/sampleList">・@lang('common.menu.sample_list')</a></li>
                            <li><a href="/sampleApi">・@lang('common.menu.sample_api')</a></li>
                        </ul>
                    </li>

                    <!-- 商品 -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle mr-4" data-toggle="dropdown">
                            @lang('common.menu.item')<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu bg-light">
                            <li><a href="/items">・@lang('common.menu.item_add')</a></li>
                            <li><a href="/itemList">・@lang('common.menu.item_list')</a></li>
                            <li><a href="/itemsearch">・@lang('common.menu.item_search')</a></li>
                        </ul>
                    </li>

                    <!-- 登録ユーザー -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle mr-4" data-toggle="dropdown">
                            @lang('common.menu.user')<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu bg-light">
                            <li><a href="/userList">・@lang('common.menu.user_list')</a></li>
                        </ul>
                    </li>

                    <!-- API -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle mr-4" data-toggle="dropdown">
                            @lang('common.menu.api')<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu bg-light">
                            <li><a href="/apiList">・@lang('common.menu.api_list')</a></li>
                        </ul>
                    </li>

                    <!-- 自力で -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle mr-4" data-toggle="dropdown">
                            @lang('common.menu.goods')<b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu bg-light">
                            <li><a href="/goodsSearch">・@lang('common.menu.goods_search')</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
