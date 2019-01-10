<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/main.css') }} ">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<body>

<div class="container-fluid text-center logo">
    <img src="{{ asset('img/logo.png') }}" alt="/">
</div>


<nav class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="{{url('home')}}"><span class="glyphicon glyphicon-home"></span></a></li>
                <li class="divider-vertical"></li>
                <li><a href="#">O nás</a></li>
                <li class="divider-vertical"></li>
                <li><a href="#">Služby</a></li>
                <li class="divider-vertical"></li>
                <li><a href="#">Produkty</a></li>
                <li class="divider-vertical"></li>
                <li><a href="#">Kontakt</a></li>
                <li class="divider-vertical"></li>
                <li><a href="#">Administratíva</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                @guest
                    <li><a href="{{url('login')}}">Prihlásenie</a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="{{url('register')}}">Registrácia</a></li>
                @else
                    <li><a><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }} </a></li>
                    <li class="divider-vertical"></li>
                    <li><a href="{{url('logout')}}"><span class="glyphicon glyphicon-log-out"></span> Odhlásiť </a> </li>
                @endguest
            </ul>
        </div>
</nav>


@yield('content')




<!-- Footer -->
<footer class="container-fluid bg-4 text-center home-block footer">
    <a href="#top"><i class="fa fa-angle-up fa-3x "></i></a>
    <div>
            <a href="https://www.facebook.com"><i class="fa fa-facebook-square fa-3x "></i></a>
            <a href="mailto:carworld@gmail.com"><i class="fa fa-envelope-square fa-3x gmail"></i></a>
            <p><i class="fa fa-phone fa-3x"></i> +421 339-2889</p>
    </div>
</footer>

</body>
</html>