<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function guardarCoche(Request $request)
    {
        var_dump($request->input('placa'));
        var_dump($request->input('marca'));
    }

    public function cargarCoche($placa)
    {
        var_dump($placa);
    }
}
