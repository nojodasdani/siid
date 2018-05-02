<?php

namespace App\Http\Controllers;

use App\Acceso;
use App\Auto;
use App\Codigo;
use App\Color_Auto;
use App\User;
use App\Visitante;
use Illuminate\Auth\Access\Response;
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
        $retorno = '{"contenido":' . json_encode($calles) . '}';
        return $retorno;
    }

    public function cargarNumeros($calle)
    {
        $numeros = Numero::where('id_calle', $calle)->get();
        $retorno = '{"contenido":' . json_encode($numeros) . '}';
        return $retorno;
    }

    public function cargarMarcas()
    {
        $marcas = Marca_Auto::all();
        $retorno = '{"contenido":' . json_encode($marcas) . '}';
        return $retorno;
    }

    public function cargarModelos($marca)
    {
        $modelos = Marca_Auto::find($marca)->modelos;
        $retorno = '{"contenido":' . json_encode($modelos) . '}';
        return $retorno;
    }

    public function cargarColores()
    {
        $colores = Color_Auto::all();
        $retorno = '{"contenido":' . json_encode($colores) . '}';
        return $retorno;
    }

    public function cargarTiposVisitante()
    {
        $tv = Tipo_Visitante::all();
        $retorno = '{"contenido":' . json_encode($tv) . '}';
        return $retorno;
    }

    public function cargarColonosPorCasa($domicilio)
    {
        $numero = Numero::find($domicilio);
        $colonos = $numero->colonos;
        $activos = array();
        foreach ($colonos as $colono) {
            if ($colono->activo && $colono->acceso_sistema)
                $activos[] = $colono;
        }
        $retorno = '{"contenido":' . json_encode($activos) . '}';
        return $retorno;
    }

    public function cargarColono($id)
    {
        $colono = User::find($id);
        $retorno = '{"contenido":' . json_encode($colono) . '}';
        return $retorno;
    }

    public function cargarAuto($placa)
    {
        $auto = Auto::where('placa', $placa)->get();
        $retorno = '{"contenido":' . json_encode($auto) . '}';
        return $retorno;
    }

    public function registrarAuto(Request $request)
    {
        $auto = new Auto();
        $auto->placa = $request->input('placa');
        $auto->id_modelo = $request->input('modelo');
        $auto->color = $request->input('color');
        $auto->save();
        return $auto->id;
    }

    public function cargarVisitantesPorAuto($auto)
    {
        $visitantes = Visitante::where('id_auto', $auto)->get();
        $retorno = '{"contenido":' . json_encode($visitantes) . '}';
        return $retorno;
    }

    public function registrarVisitante(Request $request)
    {
        $visitante = new Visitante();
        $visitante->id_auto = $request->input('auto');
        $visitante->id_tipo_visitante = $request->input('tipo_visitante');
        $visitante->nombre = $request->input('nombre');
        $visitante->descripcion = ($request->input('descripcion') == NULL) ? NULL : $request->input('descripcion');
        $visitante->save();
        return $visitante->id;
    }

    public function cargarVisitante($id)
    {
        $visitante = Visitante::find($id);
        $retorno = '{"contenido":' . json_encode($visitante) . '}';
        return $retorno;
    }

    public function leerCodigo(Request $request)
    {
        $contenido = $request->input('contenido');
        $codigo = Codigo::where('contenido', $contenido)->first();
        if ($codigo != NULL) {
            if (!$codigo->vigente || $codigo->usos_restantes <= 0) {
                return "Ese código ya no está activo debido a que ya ha excedido sus usos o ha caducado.";
            } else {
                return "Código válido";
            }
        } else {
            return "No tenemos registrado ese código QR";
        }
    }

    public function registrarAcceso(Request $request)
    {
        $acceso = new Acceso();
        $visitante = Visitante::find($request->input('visitante'));
        $visitante->ultima_visita = $request->input('domicilio');
        $visitante->save();
        $colono = User::find($request->input('colono'));
        $acceso->id_visitante = $visitante->id;
        $acceso->id_colono = $colono->id;
        $acceso->id_tipo_acceso = 1;
        $acceso->id_status = 1;
        $acceso->nombre_colono = $colono->name;
        $acceso->domicilio = "";
        $acceso->save();
    }

    public function registrarAccesoQR(Request $request)
    {

    }
}
