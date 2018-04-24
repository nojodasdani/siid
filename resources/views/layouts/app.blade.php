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
    <link href="{{ asset('css/iziToast.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/iziToast.min.js') }}"></script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<?php
use Illuminate\Support\Facades\Request;
$flag = false;
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
                            if (Request::is('colonos/show')) {
                                echo "<li class='active'>";
                            } else {
                                echo "<li>";
                            }
                            ?>
                            <a id="colonos" href="{{ url('colonos/show') }}">
                                <span class='glyphicon glyphicon-home'></span>
                                &nbsp
                                Colonos
                            </a>
                            </li>
                        @endif
                        @if (Auth::user()->hasRole("Administrador"))
                            <?php
                            if (Request::is('visitantes/show')) {
                                echo "<li class='active'>";
                            } else {
                                echo "<li>";
                            }
                            ?>
                            <a id="colonos" href="{{ url('visitantes/show') }}">
                                <span class='glyphicon glyphicon-user'></span>
                                &nbsp
                                Visitantes
                            </a>
                            </li>
                        @endif
                        <?php
                        if (Auth::user()->hasRole("Administrador")) {
                            $flag = true;
                        }
                        ?>
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
                                &nbsp
                                Solicitudes
                                <span id='numNot' class='badge'
                                      style='background-color: #2a88bd; color: whitesmoke'></span>
                            </a>
                            </li>
                        @endif
                        <?php
                        $clase = "";
                        if (Request::is('micuenta') || Request::is('changepassword')) {
                            $clase = " active";
                        }
                        ?>
                        <li class="dropdown{{$clase}}">
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
                                    <a href="{{ url('changepassword') }}">
                                        Cambiar contraseña
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
    <script>
        var flag = "<?php echo $flag ?>";
    </script>
    <script src="{{ asset('js/index.js') }}"></script>
    @yield('content')
</div>
</body>
</html>
