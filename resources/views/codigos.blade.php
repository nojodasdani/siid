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
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Tus códigos activos</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <?php
                            use App\Codigo;
                            use App\Tipo_Codigo;
                            $codigos = Codigo::where('vigente', '=', 1)->get();
                            $html = "<table class='codes table table-bordered table-condensed table-striped table-hover' id='tabla' style='border-collapse:collapse;'>
                                    <thead>
                                        <tr>
                                            <td>Fecha de creación</td>
                                            <td>Nombre del visitante</td>
                                            <td>Usos restantes</td>
                                            <td>Tipo</td>
                                            <td></td>
                                        </tr>
                                    </thead><tbody>";
                            foreach ($codigos as $codigo) {
                                $tipo = Tipo_Codigo::find($codigo->id_tipo_codigo)->nombre;
                                $html .= "<tr id='$codigo->id' data-toggle='collapse' data-target='#image$codigo->id' class='accordion-toggle'>
                                            <td>$codigo->created_at</td>
                                            <td>$codigo->nombre_visitante</td>
                                            <td>$codigo->usos_restantes</td>
                                            <td>$tipo</td>
                                            <td align='center'>
                                                <button class='btn btn-info ver'>
                                                    <span class='glyphicon glyphicon-eye-open'></span>
                                                </button>
                                                <button class='btn btn-danger eliminar'>
                                                    <span class='glyphicon glyphicon-remove'></span>
                                                </button>
                                            </td>
                                          </tr>
                                          <tr>
                                            <td colspan='5' class='hiddenRow'>
                                                <div class='accordian-body collapse' id='image$codigo->id'>
                                                    <img class='img-responsive' src='../$codigo->imagen'>
                                                </div>
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
        <div class="text-center">
            <button class='btn btn-primary' data-toggle='modal' data-target='#modalUnico'>
                Invitado
            </button>
            <button class='btn btn-warning' data-toggle='modal' data-target='#modalEvento'>
                Evento
            </button>
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
