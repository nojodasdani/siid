<?php

namespace App\Http\Controllers;

use App\Acceso;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use PDF;

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
        if (Auth::user()->hasRole('Administrador'))
            $user->email = $request->input('email');
        $user->telefono = $request->input('telefono');
        $user->id_numero = $request->input('num');
        $user->acepta_visitas = ($request->input('visitas') != NULL) ? 1 : 0;
        try{
            $user->save();
            Session::flash('message', 'Tu cuenta fue modificada exitosamente');
        }catch (\Exception $e){
            Session::flash('error', 'El correo ingresado ya está siendo utilizado por alguien más. No se guardaron los cambios.');
        }
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
    }

    public function generarReporte(Request $request)
    {
        $fechaI = $request->input('fechaI');
        $fechaF = $request->input('fechaF');
        $fechaInicial = explode('-', $fechaI);
        $fechaInicial = "$fechaInicial[2]-$fechaInicial[1]-$fechaInicial[0]";
        $raw = "CAST(created_at as date) = '" . $fechaInicial . "' ORDER BY id";
        if ($fechaF != NULL) {
            $fechaFinal = explode('-', $fechaF);
            $fechaFinal = "$fechaFinal[2]-$fechaFinal[1]-$fechaFinal[0]";
            $raw = "CAST(created_at as date) BETWEEN '$fechaInicial' AND '$fechaFinal'";
        }
        $accesos = Acceso::whereRaw($raw)->get();
        $pdf = PDF::loadView('reporte', compact('accesos'));
        return $pdf->download('reporte.pdf');
    }

}
