<?php

namespace App\Http\Controllers;

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

}
