@extends('layouts.app')

@section('content')
    <?php
    use App\User;
    $usuarios = User::all()->where('activo', 1)->where('id', '!=', Auth::user()->id);
    ?>
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
                    <div class="panel-heading">Lista de colonos</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php
                            $html = "<table class='table table-bordered table-striped table-hover' id='tabla'>
                                    <thead>
                                        <tr>
                                            <td>Nombre</td>
                                            <td>Correo</td>
                                            <td>Domicilio</td>
                                            <td>Acceso al sistema</td>
                                            <td>Acceso al fraccionamiento</td>
                                            <td></td>
                                        </tr>
                                    </thead><tbody>";
                            foreach ($usuarios as $usuario) {
                                $calle = $usuario->numero->calle->calle;
                                $num = $usuario->numero->numero;
                                $dom = "$calle #$num";
                                $accsis = $accfrac = "";
                                if ($usuario->acceso_sistema) {
                                    $accsis = " checked";
                                }
                                if ($usuario->acceso_fraccionamiento) {
                                    $accfrac = " checked";
                                }
                                $html .= "<tr id='$usuario->id'>
                                            <td>$usuario->name</td>
                                            <td>$usuario->email</td>
                                            <td>$dom</td>
                                            <td align='center'><input class='form-control sistema' type='checkbox'$accsis></td>
                                            <td align='center'><input class='form-control fracc' type='checkbox'$accfrac></td>
                                            <td align='center'>
                                                <button class='btn btn-info editar' data-toggle='modal' data-target='#modalEditar'>
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
        <div class="modal fade" id="modalEditar" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Editar colono</h4>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                        <div class="text-center">
                            <form class="form-horizontal" method="POST" action="{{ route('editarColono') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="id_colono" id="id_colono" value="">
                                <div class="form-group">
                                    <label for="email" class="col-md-4 control-label">Correo electrónico</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email"
                                               placeholder="Correo electrónico del colono" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="calle" class="col-md-2 control-label">Calle</label>
                                    <div class="col-md-4">
                                        <select id="calle" class="form-control" name="calle" required>
                                            <?php
                                            $calles = \App\Calle::orderBy('calle')->get();
                                            $html = "<option value=''>Selecciona...</option>";
                                            foreach ($calles as $calle) {
                                                $html .= "<option value='$calle->id'>$calle->calle</option>";
                                            }
                                            echo $html;
                                            ?>
                                        </select>
                                    </div>
                                    <label for="num" class="col-md-2 control-label">Número</label>
                                    <div class="col-md-3">
                                        <select id="num" class="form-control" name="num" required>
                                            <option value=''>Selecciona...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        Guardar cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Html::script('js/colonos.js') }}
@endsection
