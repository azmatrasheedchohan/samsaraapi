<!DOCTYPE html>

<html>

<head>

    <title>MapQuest-Samsara | Dashboard</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <style type="text/css">

        @import url(https://fonts.googleapis.com/css?family=Raleway:300,400,600);

  

        body{

            margin: 0;

            font-size: .9rem;

            font-weight: 400;

            line-height: 1.6;

            color: #212529;

            text-align: left;

            background-color: #f5f8fa;

        }

        .navbar-laravel

        {

            box-shadow: 0 2px 4px rgba(0,0,0,.04);

        }

        .navbar-brand , .nav-link, .my-form, .login-form

        {

            font-family: Raleway, sans-serif;

        }

        .my-form

        {

            padding-top: 1.5rem;

            padding-bottom: 1.5rem;

        }

        .my-form .row

        {

            margin-left: 0;

            margin-right: 0;

        }

        .login-form

        {

            padding-top: 1.5rem;

            padding-bottom: 1.5rem;

        }

        .login-form .row

        {

            margin-left: 0;

            margin-right: 0;

        }

    </style>

</head>

<body>

    

<nav class="navbar navbar-expand-lg navbar-light navbar-laravel">
    <div class="container">
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="
                margin-left: 639px;
                font-weight: 900;
            ">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-info btn-sm logout-button" href="{{ route('logout') }}">
                                    Logout
                                </a>
                            </li>
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