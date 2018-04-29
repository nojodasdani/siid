<?php

namespace App\Http\Controllers;

use App\Aviso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AvisosController extends Controller
{
    public function crear(Request $request)
    {
        Aviso::create([
            "texto" => $request->input('texto'),
            "creado_por" => Auth::user()->id,
        ]);
        Session::flash('message', 'El aviso fue creado exitosamente');
        return redirect('/avisos/show');
    }

    public function visible(Request $request)
    {
        $id = $request->input('id');
        $aviso = Aviso::find($id);
        $aviso->visible = $request->input('valor');
        $aviso->save();
    }

    public function eliminar(Request $request)
    {
        $id = $request->input('id');
        Aviso::destroy($id);
        Session::flash('message', 'El aviso fue eliminado exitosamente');
    }

    public function editar(Request $request)
    {
        $id = $request->input('id');
        var_dump($request->input('valor'));
        $aviso = Aviso::find($id);
        $aviso->texto = $request->input('valor');
        $aviso->save();
    }
}
