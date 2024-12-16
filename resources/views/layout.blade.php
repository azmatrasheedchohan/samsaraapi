<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Performance Horse Network</title>
    <meta property="og:site_name" content="Performance Horse Hotline" />
    <meta property="og:image"
        content="https://horsehotline.com/img/share/Performance-Horse-Hotline-powered-by-passion-black-bg.jpg" />
    <meta property="og:url" content="https://horsehotline.com" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <link rel="stylesheet" href="{{ asset('assets-sentra/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-sentra/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-sentra/css/fontAwesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-sentra/css/light-box.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-sentra/css/owl-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-sentra/css/templatemo-style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <script src="assets-sentra/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" style="position: absolute; z-index: 99999999; width: 100%;">
        <div class="container">
            <div class="row w-100">
                <div class="col-8"></div>
                <div class="col-2">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                </li>
                            @else
                                {{-- <li class="nav-item">
                                    <a class="btn btn-danger btn-sm logout-button" href="{{ route('logout') }}">
                                        Logout
                                    </a>
                                </li> --}}
                            @endguest
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    @yield('content')
</body>
</html>
