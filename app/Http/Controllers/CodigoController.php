<?php

namespace App\Http\Controllers;

use App\Codigo;
use App\Tipo_Codigo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;

class CodigoController extends Controller
{

    public function crearUnico(Request $request)
    {
        $usuario = Auth::user();
        $nombre_visitante = $request->input('nombre') . " " . $request->input('apeP');
        $fecha = date('jmyhis');
        if ($request->input('apeM') != NULL) {
            $nombre_visitante .= " " . $request->input('apeM');
        }
        $nombreEncriptado = md5($nombre_visitante);
        $creadorEncriptado = md5($usuario->id);
        $aleatorio = $this->generateRandomString(7);
        $imagen = "img/codigos/$fecha$usuario->id$aleatorio.png";
        $contenido = $fecha . $nombreEncriptado . $creadorEncriptado . $aleatorio;
        $tipo_codigo = Tipo_Codigo::where('nombre', '=', 'Personal')->get()->first()->id;
        $numero = "#" . $usuario->numero->numero;
        $calle = $usuario->numero->calle->calle;
        Codigo::create([
            'id_usuario' => $usuario->id,
            'id_tipo_codigo' => $tipo_codigo,
            'nombre_visitante' => $nombre_visitante,
            'domicilio' => $calle . " " . $numero,
            'contenido' => $contenido,
            'imagen' => $imagen,
            'nombre_colono' => $usuario->name
        ]);
        QrCode::format('png')->size(400)->generate($contenido, "../public/$imagen");
        Session::flash('message', 'El código fue creado exitosamente');
        return redirect('/codigos/show');
    }

    public function crearEvento(Request $request)
    {
        $usuario = Auth::user();
        $nombre_visitante = $request->input('descripcion');
        $fecha = date('jmyhis');
        $nombreEncriptado = md5($nombre_visitante);
        $creadorEncriptado = md5($usuario->id);
        $aleatorio = $this->generateRandomString(7);
        $imagen = "img/codigos/$fecha$usuario->id$aleatorio.png";
        $contenido = $fecha . $nombreEncriptado . $creadorEncriptado . $aleatorio;
        $tipo_codigo = Tipo_Codigo::where('nombre', '=', 'Evento')->get()->first()->id;
        $numero = "#" . $usuario->numero->numero;
        $calle = $usuario->numero->calle->calle;
        Codigo::create([
            'id_usuario' => $usuario->id,
            'id_tipo_codigo' => $tipo_codigo,
            'nombre_visitante' => $nombre_visitante,
            'usos_restantes' => $request->input('invitados'),
            'domicilio' => $calle . " " . $numero,
            'contenido' => $contenido,
            'imagen' => $imagen,
            'nombre_colono' => $usuario->name
        ]);
        QrCode::format('png')->size(400)->generate($contenido, "../public/$imagen");
        Session::flash('message', 'El código fue creado exitosamente');
        return redirect('/codigos/show');
    }

    function generateRandomString($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function eliminar(Request $request)
    {
        $codigo = Codigo::find($request->input('id'));
        $codigo->vigente = 0;
        $codigo->save();
        Session::flash('message', 'El código fue eliminado exitosamente');
        //return redirect('/codigos/show');
    }

    public function guardarImagen($id)
    {
        $codigo = Codigo::find($id);
        $filepath = public_path("$codigo->imagen");
        $headers = array(
            'Content-Type' => 'image/png'
        );
        return Response::download($filepath, $codigo->nombre_visitante . ".png", $headers);
    }
}
