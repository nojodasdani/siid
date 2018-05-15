@extends('layouts.app')

@section('content')
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
                    <div class="panel-heading">Accesos al fraccionamiento</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php
                            use App\Acceso;
                            $accesos = Acceso::all();
                            $html = "<table class='table table-bordered table-condensed table-striped table-hover' id='tabla'>
                                    <thead>
                                        <tr>
                                            <td>Fecha</td>
                                            <td>Visitante</td>
                                            <td>Auto</td>
                                            <td>Colono</td>
                                            <td>Domicilio</td>
                                            <td>Tipo</td>
                                        </tr>
                                    </thead><tbody>";
                            foreach ($accesos as $acceso) {
                                $tipo = $acceso->tipo_acceso;
                                if ($tipo->nombre != "Acceso normal") {
                                    $visitante = $acceso->codigo->nombre_visitante;
                                    $auto = "Acceso con código, auto no registrado";
                                } else {
                                    $visitante = $acceso->visitante->nombre;
                                    $auto = $acceso->auto;
                                }
                                $html .= "<tr id='$acceso->id'>
                                            <td>$acceso->created_at</td>
                                            <td>$visitante</td>
                                            <td>$auto</td>
                                            <td>$acceso->nombre_colono</td>
                                            <td>$acceso->domicilio</td>
                                            <td>$tipo->nombre</td>
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
    {{ Html::script('js/accesos.js') }}
@endsection
