<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    <!-- Styles -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
</head>
<body>
<?php
use Illuminate\Support\Facades\Request;
?>
<div id="app">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('register') }}">Regístrate</a></li>
                    @else
                        @if (Auth::user()->hasRole("Administrador"))
                            <?php
                            if (Request::is('avisos/*')) {
                                echo "<li class='active'>";
                            } else {
                                echo "<li>";
                            }
                            ?>
                            <a id="avisos" href="{{ url('avisos/show') }}">
                                <span class='glyphicon glyphicon-comment'></span>
                                &nbsp;
                                Avisos
                            </a>
                            </li>
                        @endif
                        <?php
                        if (Request::is('codigos/*')) {
                            echo "<li class='active'>";
                        } else {
                            echo "<li>";
                        }
                        ?>
                        <a id="codigos" href="{{ url('codigos/show') }}">
                            <span class='glyphicon glyphicon-qrcode'></span>
                            &nbsp;
                            Códigos
                        </a>
                        </li>
                        @if (Auth::user()->hasRole("Administrador"))
                            <?php
                            if (Request::is('solicitudes/show')) {
                                echo "<li class='active'>";
                            } else {
                                echo "<li>";
                            }
                            ?>
                            <a id="solicitudes" href="{{ url('solicitudes/show') }}">
                                <span class='glyphicon glyphicon-bell'></span>
                                &nbsp;
                                Solicitudes
                                <span id='numNot' class='badge'
                                      style='background-color: #2a88bd; color: whitesmoke'></span>
                            </a>
                            </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-expanded="false" aria-haspopup="true">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ url('micuenta') }}">
                                        Mi cuenta
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Cerrar sesión
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
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

    @yield('content')
</div>
</body>
</html>
