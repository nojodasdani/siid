<?php

namespace App\Http\Controllers;

use App\Color_Auto;
use Illuminate\Http\Request;
use App\Marca_Auto;
use App\Tipo_Visitante;
use App\Calle;
use App\Numero;

class ApiController extends Controller
{
    public function cargarCalles()
    {
        $calles = Calle::all();
        return json_encode($calles);
    }

    public function cargarNumeros($calle)
    {
        $numeros = Numero::all()->where('id_calle', $calle);
        return json_encode($numeros);
    }

    public function cargarMarcas()
    {
        $marcas = Marca_Auto::all();
        return json_encode($marcas);
    }

    public function cargarModelos($marca)
    {
        $modelos = Marca_Auto::find($marca)->modelos;
        return json_encode($modelos);
    }

    public function cargarColores()
    {
        $colores = Color_Auto::all();
        return json_encode($colores);
    }

    public function cargarTiposVisitante()
    {
        $tv = Tipo_Visitante::all();
        return json_encode($tv);
    }

    public function cargarColonos($domicilio)
    {
        $colonos = Numero::find($domicilio)->colonos;
        return json_encode($colonos);
    }

    public function cargarCoche($placa)
    {
        var_dump($placa);
    }
}
