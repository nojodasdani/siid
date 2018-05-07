@extends('layouts.app')

@section('content')
    <?php
    use App\Aviso;
    ?>
    <div class="container">
        @if (Auth::user()->hasRole("Administrador"))
            <div class="row">
                <div class="col-md-6">
                    Gráfica 1
                </div>
                <div class="col-md-6">
                    Gráfica 2
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    Gráfica 3
                </div>
                <div class="col-md-6">
                    Gráfica 4
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
