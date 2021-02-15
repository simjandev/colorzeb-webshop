<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=700, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Colorzeb</title>
    <link rel="icon" href="/images/colorzeb.png" type="image/png">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/ui_custom.css') }}" rel="stylesheet">
    
    <script>
         window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/hu_HU/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    @yield('head')
</head>
<body>
    <!-- Your Chat Plugin code -->
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div class="fb-customerchat"
        attribution="setup_tool"
        page_id="100314631740005"
        theme_color="#0A7CFF"
        logged_in_greeting="Üdv!"
        logged_out_greeting="Üdv!">
    </div>
    <div id="app" class="d-flex flex-column min-vh-100">
        <nav id="navbar" class="navbar navbar-expand-md navbar-light sticky-top shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <div id="logo-box">
                        <img src="/images/logo0.png">
                        <img class="logo-animation-image" src="/images/logo1.png">
                        <img class="logo-animation-image" src="/images/logo2.png">
                        <img class="logo-animation-image" src="/images/logo3.png">
                        <img class="logo-animation-image" src="/images/logo4.png">
                    </div>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if (Auth::user()->hasRight('admin'))
                                <li class="nav-item">
                                    <a class="nav-link" href="/admin/orders"><i class="fa fa-file"></i>&nbsp;Admin</a>
                                </li>

                                <li class="nav-item dropdown">
                                    <a id="navbar-admin-others" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Egyéb <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbar-admin-others">
                                    <a class="dropdown-item" href="/products"><i class="fa fa-shopping-bag"></i> Termékek</a>    
                                        <a class="dropdown-item" href="/"><i class="fa fa-home"></i> Főoldal</a>
                                        <a class="dropdown-item" href="/"><i class="fa fa-heart"></i> ColorZeb</a>
                                        <a class="dropdown-item" href="/contact"><i class="fa fa-envelope"></i> Kapcsolat</a>
                                    </div>
                                </li>
                            @else 

                                <li class="nav-item">
                                    <a class="nav-link" href="/"><i class="fa fa-home"></i> Főoldal</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="/products"><i class="fa fa-shopping-bag"></i> Termékek</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="/"><i class="fa fa-heart"></i> ColorZeb</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="/contact"><i class="fa fa-envelope"></i> Kapcsolat</a>
                                </li>

                                <nav-product-search-component></nav-product-search-component>
                            @endif
                        @endauth

                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="/"><i class="fa fa-home"></i> Főoldal</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/products"><i class="fa fa-shopping-bag"></i> Termékek</a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link" href="/"><i class="fa fa-heart"></i> ColorZeb</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="/contact"><i class="fa fa-envelope"></i> Kapcsolat</a>
                            </li>

                            <nav-product-search-component></nav-product-search-component>
                        @endguest 
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @php
                            $cartValue = \App\Cart::getNumberOfItems();
                        @endphp
                        <navbar-cart-component :_value="{{ $cartValue }}"></navbar-cart-component>
                        @guest
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user"></i>&nbsp;&nbsp; Belépés
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        Bejelentkezés
                                    </a>

                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        Regisztráció
                                    </a>
                                </div>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa fa-user"></i>&nbsp;&nbsp;{{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @auth
                                        <a class="dropdown-item" href="/user/data">
                                            Adataim
                                        </a>
                                        <a class="dropdown-item" href="/user/orders">
                                            Megrendeléseim
                                        </a>
                                    @endauth
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        Kijelentkezés
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

        <div class="row col-sm-12" id="content">
            @yield('content')
        </div>

        <footer id="footer" class="mt-auto">
            <ul>
                <li class="footer-item">
                    <a href="/contact" class="footer-link">Kapcsolat</a>
                </li>
                <li class="footer-item">
                    <a href="#" class="footer-link">Rendelés</a>
                </li>
                <li class="footer-item">
                    <a href="#" class="footer-link">Szállítás</a>
                </li>
                <li class="footer-item">
                    <a href="#" class="footer-link">ÁSZF</a>
                </li>
                <li class="footer-item right">
                    <a target="_blank" class="footer-image-link" href="https://www.instagram.com/colorzeb_design/"><i class="fa fa-instagram"></i></a>
                </li>
                <li class="footer-item right">
                    <a target="_blank" class="footer-image-link" href="https://www.facebook.com/ColorZebDesign/"><i class="fa fa-facebook"></i></a>
                </li>
            </ul>
        </footer>
    </div>
</body>
</html>
