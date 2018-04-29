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
                    <div class="panel-heading">Avisos para colonos</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php
                            use App\Visitante;
                            $visitantes = Visitante::all();
                            $html = "<table class='table table-bordered table-striped table-hover' id='tabla'>
                                    <thead>
                                        <tr>
                                            <td>Contenido</td>
                                            <td>Visible</td>
                                            <td></td>
                                        </tr>
                                    </thead><tbody>";
                            foreach ($visitantes as $visitante) {
                                $creado = $aviso->usuario->nombre;
                                $checked = "";
                                if ($aviso->visible) {
                                    $checked = " checked";
                                }
                                $html .= "<tr id='$aviso->id'>
                            <td>$aviso->texto</td>
                            <td align='center'><input class='form-control cambiar' type='checkbox'$checked></td>
                            <td align='center'>
                                <button class='btn btn-info editar'>
                                    <span class='glyphicon glyphicon-edit'></span>
                                </button>
                                <button class='btn btn-danger eliminar'>
                                    <span class='glyphicon glyphicon-trash'></span>
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
    {{ Html::script('js/visitantes.js') }}
@endsection