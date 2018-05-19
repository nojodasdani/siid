@extends('layouts.app')

@section('content')
    <?php
    use App\Aviso;
    ?>
    <div class="container">
        @if (Auth::user()->hasRole("Administrador"))
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/visitante.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor">
                            <h4><b>Visitantes</b></h4>
                            <p>Hoy</p>
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/usuarios.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor text-left">
                            <h4><b>Colonos</b></h4>
                            <p>Hoy</p>
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/accesos.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor">
                            <h4><b>Accesos</b></h4>
                            <p>Hoy</p>
                            <p>Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="card">
                        <img src="img/qr.png" alt="Avatar" class="img-responsive" style="margin: 0 auto;">
                        <div class="contenedor">
                            <h4><b>Accesos con QR</b></h4>
                            <p>Hoy</p>
                            <p>Total</p>
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
