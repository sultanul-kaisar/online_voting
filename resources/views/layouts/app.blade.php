
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Voting App</title>
    <link href="images/favicon.ico" rel="icon">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/jquery.fancybox.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/tooltipster.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/cubeportfolio.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/revolution/navigation.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/revolution/settings.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/custom.css')}}">
</head>
<body>
<!--PreLoader-->
<div class="loader">
    <div class="loader-inner">
        <div class="cssload-loader"></div>
    </div>
</div>
<!--PreLoader Ends-->
<!-- header -->
<header class="site-header">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('home') }}">
                Voting App
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

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
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</header>
<section id="our-blog" class="bglight padding">
    <div class="container">

        @yield('content')
    </div>
</section>


<!--Footer ends-->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{asset('assets/frontend/js/jquery-3.4.1.min.js')}}"></script>
<!--Bootstrap Core-->
<script src="{{asset('assets/frontend/js/propper.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/bootstrap.min.js')}}"></script>
<!--to view items on reach-->
<script src="{{asset('assets/frontend/js/jquery.appear.js')}}"></script>
<!--Owl Slider-->
<script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
<!--number counters-->
<script src="{{asset('assets/frontend/js/jquery-countTo.js')}}"></script>
<!--Parallax Background-->
<script src="{{asset('assets/frontend/js/parallaxie.js')}}"></script>
<!--Cubefolio Gallery-->
<script src="{{asset('assets/frontend/js/jquery.cubeportfolio.min.js')}}"></script>
<!--Fancybox js-->
<script src="{{asset('assets/frontend/js/jquery.fancybox.min.js')}}"></script>
<!--tooltip js-->
<script src="{{asset('assets/frontend/js/tooltipster.min.js')}}"></script>
<!--wow js-->
<script src="{{asset('assets/frontend/js/wow.js')}}"></script>
<!--Revolution SLider-->
<script src="{{asset('assets/frontend/js/revolution/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/jquery.themepunch.revolution.min.js')}}"></script>
<!-- SLIDER REVOLUTION 5.0 EXTENSIONS -->
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.actions.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.carousel.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.migration.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.navigation.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.parallax.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/revolution/extensions/revolution.extension.video.min.js')}}"></script>
<!--custom functions and script-->
<script src="{{asset('assets/frontend/js/functions.js')}}"></script>
</body>
</html>
