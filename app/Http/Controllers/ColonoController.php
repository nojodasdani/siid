<?php

namespace App\Http\Controllers;

use Dompdf\Exception;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;

class ColonoController extends Controller
{
    public function verColono(Request $request)
    {
        $usuario = User::find($request->input('id'));
        $usuario->calle = $usuario->numero->calle->id;
        echo json_encode($usuario);
    }

    public function editarColono(Request $request)
    {
        $usuario = User::find($request->input('id_colono'));
        $usuario->id_numero = $request->input('num');
        $usuario->email = $request->input('email');
        try {
            $usuario->save();
            Session::flash('message', 'El usuario fue modificado exitosamente');
        } catch (\Exception $e) {
            Session::flash('error', 'El usuario no pudo ser modificado debido a que el correo que escribiste ya está en uso. Intenta de nuevo');
        }
        return redirect('/colonos/show');
    }

    public function eliminarColono(Request $request)
    {
        $usuario = User::find($request->input('id_colono'));
        $usuario->activo = 0;
        //try {
        $usuario->save();
        Session::flash('message', 'El usuario fue eliminado exitosamente');
        /*} catch (\Exception $e) {
            Session::flash('error', 'El usuario no pudo ser eliminado. Intenta de nuevo');
        }
        return redirect('/colonos/show');*/
    }

    public function accesoSistema(Request $request)
    {
        $usuario = User::find($request->input('id_colono'));
        $usuario->acceso_sistema = $request->input('valor');
        $usuario->save();
    }

    public function accesoFracc(Request $request)
    {
        $usuario = User::find($request->input('id_colono'));
        $usuario->acceso_fraccionamiento = $request->input('valor');
        $usuario->save();
    }
}
