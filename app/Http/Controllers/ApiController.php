<?php

namespace App\Http\Controllers;

use App\Acceso;
use App\Auto;
use App\Codigo;
use App\Color_Auto;
use App\Modelo_Auto;
use App\User;
use App\Visitante;
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
        $calle = Calle::where('calle', $calle)->first();
        $numeros = Numero::where('id_calle', $calle->id)->get();
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
        $marca = Marca_Auto::where('marca', $marca)->first();
        $modelos = Marca_Auto::find($marca->id)->modelos;
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

    public function cargarColonosPorCasa(Request $request)
    {
        $calle = Calle::where('calle', $request->input('calle'))->first();
        $numero = Numero::all()->where('id_calle', $calle->id)->where('numero', $request->input('numero'))->first();
        $colonos = $numero->colonos;
        $activos = array();
        foreach ($colonos as $colono) {
            if ($colono->activo && $colono->acceso_sistema)
                $activos[] = $colono;
        }
        $retorno = '{"contenido":' . json_encode($activos) . '}';
        return $retorno;
    }

    public function cargarColono(Request $request)
    {
        $calle = Calle::where('calle', $request->input('calle'))->first();
        $numero = Numero::all()->where('id_calle', $calle->id)->where('numero', $request->input('numero'))->first();
        $colono = User::all()->where('id_numero', $numero->id)->where('name', $request->input('colono'))->first();
        $retorno = "";
        if (!$colono->acepta_visitas) {
            $retorno = "Este colono por el momento no acepta visitas";
        }
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

    public function cargarVisitante(Request $request)
    {
        $auto = Auto::where('placa', $request->placa)->first();
        $visitante = Visitante::all()->where('id_auto', $auto->id)->where('nombre', $request->visitante)->first();
        $tipo = $visitante->tipo->tipo;
        $retorno = "type=$tipo";
        if (!$visitante->permitido) {
            $retorno = "El visitante no tiene permiso para acceder al fraccionamiento";
        }
        return $retorno;
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
        $comentario = $request->input('comentario');
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
        $visitante->descripcion = $comentario;
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
        $acceso->nombre_visitante = $nombre_visitante;
        $acceso->id_status = 1;
        $acceso->save();
        return "ok";
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
        $comentario = $request->input('comentario');
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
        $visitante->descripcion = $comentario;
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
        $acceso->nombre_visitante = $nombre_visitante;
        $acceso->id_status = 1;
        $acceso->save();
        return "ok";
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
        $comentario = $request->input('comentario');
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
        $visitante->descripcion = $comentario;
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
        $acceso->nombre_visitante = $visitante->nombre;
        $acceso->id_status = 1;
        $acceso->save();
        return "ok";
    }

    public function leerCodigo($contenido)
    {
        $codigo = Codigo::where('contenido', $contenido)->first();
        if ($codigo != NULL) {
            if (!$codigo->vigente || $codigo->usos_restantes <= 0) {
                return "Ese código ya no está activo debido a que ya ha excedido sus usos o ha caducado.";
            } else {
                $usos = $codigo->usos_restantes;
                $usos--;
                $codigo->usos_restantes = $usos;
                if ($usos == 0) {
                    $codigo->vigente = 0;
                }
                $codigo->save();
                $this->registrarAccesoQR($codigo);
                return "Código válido. Acceso registrado";
            }
        } else {
            return "No tenemos registrado ese código QR";
        }
    }

    private function registrarAccesoQR($codigo)
    {
        $acceso = new Acceso();
        $acceso->id_visitante = NULL;
        $acceso->id_colono = $codigo->id_usuario;
        $acceso->id_tipo_acceso = 2;
        $acceso->id_status = 1;
        $acceso->id_codigo = $codigo->id;
        $acceso->nombre_colono = $codigo->nombre_colono;
        $acceso->domicilio = $codigo->domicilio;
        $acceso->auto = "No aplica";
        $acceso->nombre_visitante = $codigo->nombre_visitante;
        $acceso->save();
    }
}
