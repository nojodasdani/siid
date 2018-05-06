<?php

namespace App\Http\Controllers;

use App\Acceso;
use App\Auto;
use App\Codigo;
use App\Color_Auto;
use App\Modelo_Auto;
use App\User;
use App\Visitante;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Marca_Auto;
use App\Tipo_Visitante;
use App\Calle;
use App\Numero;
use Prophecy\Call\Call;

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
        $auto = Auto::where('placa', $placa)->first();
        if (count($auto) == 0) {
            $retorno = '{"contenido":[]}';
        } else {
            $auto->visitantes;
            $auto->nombre_color = $auto->color->color;
            $auto->nombre_marca = $auto->modelo->marca->marca;
            $auto->nombre_modelo = $auto->modelo->modelo;
            $retorno = '{"contenido":[' . json_encode($auto) . ']}';
        }

        return $retorno;
    }

    public function cargarVisitantesPorAuto($auto)
    {
        $visitantes = Visitante::where('id_auto', $auto)->get();
        $retorno = '{"contenido":' . json_encode($visitantes) . '}';
        return $retorno;
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

    public function registrarAutoVisitanteAcceso(Request $request)
    {
        //recibir variables
        $placa = $request->input('placa');
        $marca = $request->input('marca');
        $modelo = $request->input('modelo');
        $color = $request->input('color');
        $calle = $request->input('calle');
        $numero = $request->input('numero');
        $domicilio = "$calle #$numero";
        $nombre_visitante = $request->input('nombre');
        $tipo = $request->input('tipo');
        $nombre_colono = $request->input('contacto');
        //buscar y modificar auto
        $auto = new Auto();
        $color_auto = Color_Auto::where("color", $color)->first();
        $marca_auto = Marca_Auto::where("marca", $marca)->first();
        $modelo_auto = Modelo_Auto::all()->where('id_marca', $marca_auto->id)->where("modelo", $modelo)->first();
        $auto->placa = $placa;
        $auto->id_modelo = $modelo_auto->id;
        $auto->id_color = $color_auto->id;
        $auto->save();
        //registrar visitante
        $visitante = new Visitante();
        $visitante->id_auto = $auto->id;
        $visitante->id_tipo_visitante = Tipo_Visitante::where('tipo', $tipo)->first()->id;
        $visitante->ultima_visita = $domicilio;
        $visitante->nombre = $nombre_visitante;
        $visitante->save();
        //buscar colono
        $calle = Calle::where("calle", $calle)->first();
        $numero = Numero::all()->where("id_calle", $calle->id)->where("numero", $numero)->first();
        $colono = User::all()->where('id_numero', $numero->id)->where('name', $nombre_colono)->first();
        $acceso = new Acceso();
        if ($colono != NULL) {
            $acceso->id_colono = $colono->id;
            $acceso->nombre_colono = $colono->name;
        } else {
            $acceso->id_colono = NULL;
            $acceso->nombre_colono = $nombre_colono;
        }
        $acceso->id_visitante = $visitante->id;
        $acceso->domicilio = $domicilio;
        $acceso->auto = "$marca - $modelo - $color";
        $acceso->id_tipo_acceso = 1;
        $acceso->id_status = 1;
        $acceso->save();
    }

    public function registrarVisitanteAcceso(Request $request)
    {
        //recibir variables
        $placa = $request->input('placa');
        $marca = $request->input('marca');
        $modelo = $request->input('modelo');
        $color = $request->input('color');
        $calle = $request->input('calle');
        $numero = $request->input('numero');
        $domicilio = "$calle #$numero";
        $nombre_visitante = $request->input('nombre');
        $tipo = $request->input('tipo');
        $nombre_colono = $request->input('contacto');
        //buscar y modificar auto
        $auto = Auto::where('placa', $placa)->first();
        $color_auto = Color_Auto::where("color", $color)->first();
        $marca_auto = Marca_Auto::where("marca", $marca)->first();
        $modelo_auto = Modelo_Auto::all()->where('id_marca', $marca_auto->id)->where("modelo", $modelo)->first();
        $auto->id_modelo = $modelo_auto->id;
        $auto->id_color = $color_auto->id;
        $auto->save();
        //registrar visitante
        $visitante = new Visitante();
        $visitante->id_auto = $auto->id;
        $visitante->id_tipo_visitante = Tipo_Visitante::where('tipo', $tipo)->first()->id;
        $visitante->ultima_visita = $domicilio;
        $visitante->nombre = $nombre_visitante;
        $visitante->save();
        //buscar colono
        $calle = Calle::where("calle", $calle)->first();
        $numero = Numero::all()->where("id_calle", $calle->id)->where("numero", $numero)->first();
        $colono = User::all()->where('id_numero', $numero->id)->where('name', $nombre_colono)->first();
        $acceso = new Acceso();
        if ($colono != NULL) {
            $acceso->id_colono = $colono->id;
            $acceso->nombre_colono = $colono->name;
        } else {
            $acceso->id_colono = NULL;
            $acceso->nombre_colono = $nombre_colono;
        }
        $acceso->id_visitante = $visitante->id;
        $acceso->domicilio = $domicilio;
        $acceso->auto = "$marca - $modelo - $color";
        $acceso->id_tipo_acceso = 1;
        $acceso->id_status = 1;
        $acceso->save();
    }

    public function registrarAcceso(Request $request)
    {
        //recibir variables
        $placa = $request->input('placa');
        $marca = $request->input('marca');
        $modelo = $request->input('modelo');
        $color = $request->input('color');
        $calle = $request->input('calle');
        $numero = $request->input('numero');
        $domicilio = "$calle #$numero";
        $visitante = $request->input('nombre');
        $tipo = $request->input('tipo');
        $nombre_colono = $request->input('contacto');
        //buscar y modificar auto
        $auto = Auto::where('placa', $placa)->first();
        $color_auto = Color_Auto::where("color", $color)->first();
        $marca_auto = Marca_Auto::where("marca", $marca)->first();
        $modelo_auto = Modelo_Auto::all()->where('id_marca', $marca_auto->id)->where("modelo", $modelo)->first();
        $auto->id_modelo = $modelo_auto->id;
        $auto->id_color = $color_auto->id;
        $auto->save();
        //buscar y modificar visitante
        $visitante = Visitante::all()->where('id_auto', $auto->id)->where('nombre', $visitante)->first();
        $visitante->id_tipo_visitante = Tipo_Visitante::where('tipo', $tipo)->first()->id;
        $visitante->ultima_visita = $domicilio;
        $visitante->save();
        //buscar colono
        $calle = Calle::where("calle", $calle)->first();
        $numero = Numero::all()->where("id_calle", $calle->id)->where("numero", $numero)->first();
        $colono = User::all()->where('id_numero', $numero->id)->where('name', $nombre_colono)->first();
        $acceso = new Acceso();
        if ($colono != NULL) {
            $acceso->id_colono = $colono->id;
            $acceso->nombre_colono = $colono->name;
        } else {
            $acceso->id_colono = NULL;
            $acceso->nombre_colono = $nombre_colono;
        }
        $acceso->id_visitante = $visitante->id;
        $acceso->domicilio = $domicilio;
        $acceso->auto = "$marca - $modelo - $color";
        $acceso->id_tipo_acceso = 1;
        $acceso->id_status = 1;
        $acceso->save();
    }

    public function registrarAccesoQR(Request $request)
    {

    }
}
