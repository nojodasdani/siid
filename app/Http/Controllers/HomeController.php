<?php

namespace App\Http\Controllers;

use App\Acceso;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function cargaNotificaciones()
    {
        $number = count(User::all()->where('visto', '=', '0'));
        $html = "quitar";
        if ($number > 0) {
            $html = $number;
        }
        return $html;
    }

    public function modificarCuenta(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->input('name');
        $user->telefono = $request->input('telefono');
        $user->id_numero = $request->input('num');
        $user->acepta_visitas = ($request->input('visitas') != NULL) ? 1 : 0;
        $user->save();
        Session::flash('message', 'Tu cuenta fue modificada exitosamente');
        return redirect('/micuenta');
    }

    public function cambiarPass(Request $request)
    {
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "La contraseña actual no coincide. Intenta de nuevo.");
        }
        if (strcmp($request->get('current-password'), $request->get('new-password')) == 0) {
            return redirect()->back()->with("error", "La nueva contraseña no puede ser igual a la actual. Intenta con una diferente.");
        }
        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        Session::flash('message', 'Tu contraseña fue modificada exitosamente');
        return redirect('/changepassword');
        //return redirect()->back()->with("success", "Password changed successfully !");
    }

    public function generarReporte(Request $request)
    {
        $fechaI = $request->input('fechaI');
        $fechaF = $request->input('fechaF');
        $raw = "DATE_FORMAT(created_at,'%d-%m-%Y') = '" . $fechaI . "' ORDER BY id";
        if ($fechaF != NULL) {
            $raw = "created_at BETWEEN STR_TO_DATE('" . $fechaI . "','%d-%m-%Y') AND
                                STR_TO_DATE('" . $fechaF . "','%d-%m-%Y')";
        }
        //echo $fechaI;
        //echo $fechaF;
        //echo $raw;
        $accesos = Acceso::whereRaw($raw)->get();
        var_dump($accesos);
    }

}
