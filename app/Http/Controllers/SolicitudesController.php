<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Middleware\HasAccess;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Session;

class SolicitudesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', HasAccess::class, CheckRole::class]);
    }

    public function aceptar(Request $request){
        $user = User::find($request->input('id'));
        $user->aceptado=1;
        $user->acceso_sistema=1;
        $user->save();
        Session::flash('message', 'El usuario ahora tendrá acceso al sitema');
        //return redirect(route('solicitudes'));
    }

    public function rechazar(Request $request){
        $user = User::find($request->input('id'));
        $user->aceptado=1;
        $user->acceso_sistema=0;
        $user->save();
        Session::flash('warning', 'Se le negó acceso al sistema. El usuario no podrá acceder');
        //return redirect(route('solicitudes'));
    }
}
