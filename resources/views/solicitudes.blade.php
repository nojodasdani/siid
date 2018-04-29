@extends('layouts.app')

@section('content')
    <?php
    use App\User;
    $users = User::all()->where('visto', '=', '0');
    foreach ($users as $user) {
        $user->visto = 1;
        $user->save();
    }
    $users = User::orderBy('created_at', 'DESC')->get()->where('aceptado', '=', '0');
    ?>
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        @if (Session::has('warning'))
            <div class="alert alert-warning">{{ Session::get('warning') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Solicitudes de acceso</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php
                            $html = "<table class='table table-bordered table-striped table-hover' id='tabla'>
                                    <thead>
                                        <tr>
                                            <td>Nombre</td>
                                            <td>Correo</td>
                                            <td>Domicilio</td>
                                            <td>Teléfono</td>
                                            <td></td>
                                        </tr>
                                    </thead><tbody>";
                            foreach ($users as $user) {
                                $numero = "#" . $user->numero->numero;
                                $calle = $user->numero->calle->calle;
                                $html .= "<tr id='$user->id'>
                            <td>$user->name</td>
                            <td>$user->email</td>
                            <td>$calle $numero</td>
                            <td>$user->telefono</td>
                            <td align='center'>
                                <button class='btn btn-success aceptar'>
                                    <span class='glyphicon glyphicon-ok'></span>
                                </button>
                                <button class='btn btn-danger rechazar'>
                                    <span class='glyphicon glyphicon-remove'></span>
                                </button>
                            </td>
                          </tr>";
                            }
                            $html .= "</tbody></table>";
                            echo $html;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Html::script('js/solicitudes.js') }}
@endsection
