<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="img/favicon.ico"/>
    <link rel="stylesheet" media="screen" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600"/>
    <link rel="stylesheet" media="screen"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"/>
    <link href="{{ asset('css/error.css') }}" rel="stylesheet">
    <title>{{ config('app.name') }}</title>
</head>
<body class="plain error-page-wrapper background-color background-image">
<div class="content-container">
    <div class="head-line secondary-text-color">
        Lo sentimos
    </div>
    <div class="subheader primary-text-color">
        {{Session::get('message')}}
    </div>
    <hr>
    <div class="clearfix"></div>
    <div class="context primary-text-color">
        <p>
            ¿Crees que se trata de un error?
            Contacta al administrador o reporta el problema.
        </p>
    </div>
    <div class="buttons-container">
        <a class="border-button" href="http://opion-tech.com" target="_blank">Reporta tu problema</a>
        <a class='border-button' href="{{ route('logout') }}"
           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
            Cerrar sesión
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST"
              style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>
<script src="{{ asset('js/error.js') }}"></script>
</body>
</html>