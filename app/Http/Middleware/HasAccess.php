<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;


class HasAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->acceso_sistema) {
            return $next($request);
        } else {
            //Session::flash('message', 'Parece que no tienes permiso para acceder al sistema');
            //return redirect(route('error'));
            Session::flash('redireccionar', 'No tienes permiso para acceder al sistema.');
            return new Response(view('error'));
        }
    }
}
