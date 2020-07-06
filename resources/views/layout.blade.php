<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="/css/app.css" rel="stylesheet">
        <title>@yield('title', 'Index')</title>
    </head>
    <body>
        <div class="container">
               
            <nav class="nav justify-content-center">
                <a class="nav-link" href="{{ '/' }}">{{ __('Home') }}</a>
                <a class="nav-link" href="{{ '/cart' }}">{{__('Cart')}}</a>
                @if(session()->has('auth') && session('auth'))
                <a class="nav-link" href="{{ '/products' }}">{{__('Products')}}</a>
                <a class="nav-link" href="{{ '/orders' }}">{{__('Orders')}}</a>
                @endif
                <a class="btn btn-warning" class="nav-link" href="{{ session('auth') ? '/logout' : '/login' }}">
                    {{ session('auth') ? __('Logout') : __('Login') }}
                </a>
            </nav>

            @yield('content')

        </div>
        <script src="/js/app.js"></script>
    </body>
</html> 