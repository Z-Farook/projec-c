<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="icon" href="/img/favicon.png" type="image/png"/>
    <link rel="shortcut icon" href="/img/favicon.png" type="image/png"/>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    
<div id="app">
    <nav class="navbar navbar-expand-md navbar-dark navbar-laravel"> <!-- class="fixed-top" -->
        <div class="container">
            <a class="navbar-brand" href="/">
                <img class="d-inline-block" src="/img/logo.png" height="40" alt="" />
                <span class="navbar-brand-name">{{ config('app.name', 'Laravel') }}</span>
            </a>

            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    {{-- so, this flowing line is impoting the Food.vue file via router.index file
                            this is equal to HARD CODED refrence likeL: <food> </food>
                    --}}
                    <router-link class="nav-link" :to="{name: 'food'}">Food</router-link>
                </li>
               
                <search></search>
                <!-- Authentication Links -->
                @auth
                    <favorite-nav-icon></favorite-nav-icon>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                    
                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('account') }}">Account</a>
                            <a class="dropdown-item" href="\reservations">Bestelgeschiedenis</a>

                            @if(Auth::user()->admin)
                                <a class="dropdown-item" href="{{ route('admin') }}">Admin</a>
                            @endif
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
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>
    @yield('content')
</div>
</body>
</html>
