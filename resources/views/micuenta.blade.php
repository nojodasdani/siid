@extends('layouts.app')

@section('content')
    <?php
    $usuario = Auth::user();
    $id_calle = $usuario->numero->calle->id;
    $id_num = $usuario->numero->id;
    $htmlcalle = "<div class='form-group'>
                    <label for='calle' class='col-md-2 control-label'>Calle</label>
                    <div class='col-md-4'>
                        <select id='calle' class='form-control' name='calle' required>";
    $calles = \App\Calle::all();
    $numeros = \App\Numero::where('id_calle', $id_calle)->get();
    foreach ($calles as $c) {
        $selected = "";
        if ($c->id == $id_calle) {
            $selected = " selected";

        }
        $htmlcalle .= "<option value='$c->id'$selected>$c->calle</option>";
    }
    $htmlcalle .= "</select>
                    </div>
                    <label for='num' class='col-md-2 control-label'>Número</label>
                    <div class='col-md-3'>
                        <select id='num' class='form-control' name='num' required>
                            <option value=''>Seleccionar...</option>";
    foreach ($numeros as $numero) {
        $selected = "";
        if ($numero->id == $id_num) {
            $selected = " selected";
        }
        $htmlcalle .= "<option value='$numero->id'$selected>$numero->numero</option>";
    }
    $htmlcalle .= "</select></div></div>";
    ?>
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        @if (!$usuario->hasRole('Administrador'))
            <div class='alert alert-warning'>
                Para cambiar tu correo o tu domicilio, pónte en contacto con un administrador.
            </div>
            <?php
            $calle = $usuario->numero->calle->calle;
            $num = $usuario->numero->numero;
            $htmlcalle = "<div class='form-group'>
                    <label for='calle' class='col-md-2 control-label'>Calle</label>
                    <div class='col-md-4'>
                        <input type='text' id='calle' class='form-control' name='calle' required readonly value='$calle'>
                    </div>
                    <label for='num' class='col-md-2 control-label'>Número</label>
                    <div class='col-md-3'>
                        <input type='hidden' name='num' value='$id_num' id='num'>
                        <input type='text' id='numero' class='form-control' name='numero' required readonly value='$num'>
                    </div>
                  </div>";
            ?>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Modifica tu cuenta</div>
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('modify') }}">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Nombre</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{$usuario->name}}" required>
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">Correo electrónico</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{$usuario->email}}" required readonly>
                                </div>
                            </div>
                            <?php
                            $acepta = "";
                            $valor = 0;
                            if ($usuario->acepta_visitas) {
                                $acepta = " checked";
                                $valor = 1;
                            }
                            ?>
                            <div class="form-group">
                                <label for="visitas" class="col-md-4 control-label">¿Recibes visitas?</label>
                                <div class="col-md-6">
                                    <input id="visitas" type="checkbox" class="form-control" name="visitas"
                                           {{$acepta}} value="{{$valor}}">
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                                <label for="telefono" class="col-md-4 control-label">Teléfono de contacto</label>
                                <div class="col-md-6">
                                    <input id="telefono" type="tel" class="form-control" name="telefono"
                                           value="{{$usuario->telefono}}" required>
                                </div>
                            </div>
                            <?php echo $htmlcalle;?>
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-5">
                                    <button type="submit" class="btn btn-primary">
                                        Modificar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Html::script('js/registro.js') }}
@endsection