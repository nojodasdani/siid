@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('message'))
            <div class="alert alert-success">{{ Session::get('message') }}</div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Visitantes registrados</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php
                            use App\Visitante;
                            $visitantes = Visitante::all();
                            $html = "<table class='table table-bordered table-striped table-hover' id='tabla'>
                                    <thead>
                                        <tr>
                                            <td>Placa</td>
                                            <td>Auto</td>
                                            <td>Nombre</td>
                                            <td>Última visita</td>
                                            <td>Comentarios</td>
                                            <td>Tipo</td>
                                            <td>Acceso</td>
                                        </tr>
                                    </thead><tbody>";
                            foreach ($visitantes as $visitante) {
                                $placa = $visitante->auto->placa;
                                $marca = $visitante->auto->modelo->marca->marca;
                                $modelo = $visitante->auto->modelo->modelo;
                                $color = $visitante->auto->color->color;
                                $tipo = $visitante->tipo->tipo;
                                $auto = "$marca - $modelo - $color";
                                $checked = "";
                                if ($visitante->permitido) {
                                    $checked = " checked";
                                }
                                $html .= "<tr id='$visitante->id'>
                                            <td>$placa</td>
                                            <td>$auto</td>
                                            <td>$visitante->nombre</td>
                                            <td>$visitante->ultima_visita</td>
                                            <td>$visitante->descripcion</td>
                                            <td>$tipo</td>
                                            <td align='center'><input class='form-control cambiar' type='checkbox'$checked></td>
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
    {{ Html::script('js/visitantes.js') }}
@endsection
