<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
</head>
<body>
<?php
$html = "<h3 class='text-center text-info'>Accesos al fraccionamiento</h3><table class='table table-bordered table-striped'>
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
</body>
</html>
