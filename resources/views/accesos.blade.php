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
                            $accesos = Acceso::orderBy('created_at', 'desc')->get();
                            $html = "<table class='codes table table-bordered table-condensed table-striped table-hover' id='tabla'>
                                    <thead>
                                        <tr>
                                            <td>Fecha de creación</td>
                                            <td>Nombre del visitante</td>
                                            <td>Usos restantes</td>
                                            <td>Tipo</td>
                                        </tr>
                                    </thead><tbody>";
                            foreach ($accesos as $acceso) {
                                $html .= "<tr id='$acceso->id'>
                                            <td>$acceso->created_at</td>
                                            <td>$acceso->nombre_visitante</td>
                                            <td>$acceso->usos_restantes</td>
                                            <td></td>
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
        <!-- Modal -->
        <div class="modal fade" id="modalUnico" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Generación de código para un visitante</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="{{ route('crearCodigoUnico') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="nombre" class="col-md-4 control-label">Nombre</label>
                                <div class="col-md-7">
                                    <input type="text" id="nombre" class="form-control" name="nombre"
                                           placeholder="Nombre(s) de tu visitante" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="apeP" class="col-md-4 control-label">Apellido Paterno</label>
                                <div class="col-md-7">
                                    <input type="text" id="apeP" class="form-control" name="apeP"
                                           placeholder="Apellido Paterno de tu visitante" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="apeM" class="col-md-4 control-label">Apellido Materno</label>
                                <div class="col-md-7">
                                    <input type="text" id="apeM" class="form-control" name="apeM"
                                           placeholder="(Opcional) Apellido Materno de tu visitante">
                                </div>
                            </div>
                            <label style="color: red">Por tu seguridad y la de todos los colonos, favor de introducir
                                datos reales</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generar</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalEvento" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Generación de código para un evento</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="{{ route('crearCodigoEvento') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="invitados" class="col-md-4 control-label">Invitados</label>
                                <div class="col-md-7">
                                    <input type="number" id="invitados" class="form-control" name="invitados"
                                           placeholder="Número de invitados esperados" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="descripcion" class="col-md-4 control-label">Descripción</label>
                                <div class="col-md-7">
                                    <textarea rows="2" id="descripcion" class="form-control" name="descripcion"
                                              placeholder="Breve descripción del evento" required></textarea>
                                </div>
                            </div>
                            <label style="color: red">Por tu seguridad y la de todos los colonos, favor de introducir
                                datos reales</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Generar</button>
                        </form>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Html::script('js/codigos.js') }}
@endsection
