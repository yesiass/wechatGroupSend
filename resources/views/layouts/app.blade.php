<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>管理系统</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        管理系统
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">登录</a></li>
                            {{--<li><a href="{{ route('register') }}">Register</a></li>--}}
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            退出登录
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @guest
        @else
        <div class="container">
            <div class="row" >

                <nav class="navbar navbar-default" role="navigation">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="/home">管理系统</a>
                        </div>
                        <div>
                            <ul class="nav navbar-nav">
                                <li class="{{$_SERVER['REQUEST_URI'] == '/home'?'active':''}}"><a href="/home">Home</a></li>
                                <li class="{{$_SERVER['REQUEST_URI'] == '/account'?'active':''}}"><a href="/account">微信账号管理</a></li>
                                {{--<li class="{{$_SERVER['REQUEST_URI'] == '/customerservice'?'active':''}}" ><a href="/customerservice">微信客服管理</a></li>--}}
                                <li class="dropdown {{$_SERVER['REQUEST_URI'] == '/interfaceLog'?'active':''}}">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        操作日志
                                        <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li class="{{$_SERVER['REQUEST_URI'] == '/interfaceLog'?'active':''}}"><a href="/interfaceLog">接口调用日志</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            @if(\Illuminate\Support\Facades\Session::has('message'))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">
                    &times;
                </button>
                {{\Illuminate\Support\Facades\Session::get('message')}}
            </div>
            @endif
            @endguest
        @yield('content')
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
