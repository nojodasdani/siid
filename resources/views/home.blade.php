@extends('layouts.app')

@section('content')
    <?php
    use App\Aviso;
    use App\Visitante;
    use App\User;
    use App\Acceso;
    //estadística Colonos
    $colonosTotal = User::all()->count();
    $visitado = Acceso::select('id_colono', 'nombre_colono', 'domicilio')
        ->selectRaw('COUNT(*) AS total')
        ->groupBy('id_colono', 'nombre_colono', 'domicilio')
        ->where('id_colono', '!=', NULL)
        ->orderByRaw('COUNT(*) DESC')
        ->first();
    $visitado = "$visitado->nombre_colono - $visitado->domicilio ($visitado->total)";
    //estadística Visitantes
    $visitantesTotal = Visitante::all()->count();
    $visitante = Acceso::select('id_visitante', 'nombre_visitante', 'domicilio', 'auto')
        ->selectRaw('COUNT(*) AS total')
        ->groupBy('id_visitante', 'nombre_visitante', 'domicilio', 'auto')
        ->where('id_visitante', '!=', NULL)
        ->orderByRaw('COUNT(*) DESC')
        ->first();
    $visitante = "$visitante->nombre_visitante, $visitante->auto, $visitante->domicilio ($visitante->total)";
    //estadística Accesos
    $hoy = date('Y-m-d');
    $accesosTotal = Acceso::where('id_tipo_acceso', 1)->count();
    $accesosHoy = Acceso::whereRaw("id_tipo_acceso = 1 AND CAST(created_at as date) = '$hoy'")->count();
    $accesosTotalQr = Acceso::where('id_tipo_acceso', 2)->count();
    $accesosHoyQr = Acceso::whereRaw("id_tipo_acceso = 2 AND CAST(created_at as date) = '$hoy'")->count();
    ?>
    <div class="container">
        @if (Auth::user()->hasRole("Administrador"))
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/accesos.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor">
                            <h4><b>Accesos</b></h4>
                            <p>Hoy: {{$accesosHoy}}</p>
                            <p>Total: {{$accesosTotal}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/qr.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor">
                            <h4><b>Accesos con QR</b></h4>
                            <p>Hoy: {{$accesosHoyQr}}</p>
                            <p>Total: {{$accesosTotalQr}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/visitante.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor">
                            <h4><b>Visitantes</b></h4>
                            <p>Más concurrente: {{$visitante}}</p>
                            <p>Total: {{$visitantesTotal}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/usuarios.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor text-left">
                            <h4><b>Colonos</b></h4>
                            <p>Más visitado: {{$visitado}}</p>
                            <p>Total: {{$colonosTotal}}</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <?php
            $avisos = Aviso::all()->where('visible', '=', 1);
            $i = 1;
            foreach ($avisos as $aviso) {
                if ($i == 5) $i = 1;
                switch ($i) {
                    case 1:
                        $clase = "alert-info";
                        break;
                    case 2:
                        $clase = "alert-success";
                        break;
                    case 3:
                        $clase = "alert-danger";
                        break;
                    case 4:
                        $clase = "alert-warning";
                        break;
                }
                echo "<div class='alert $clase alert-dismissible'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    $aviso->texto
                  </div>";
                $i++;
            }
            ?>
        @endif
    </div>
@endsection
