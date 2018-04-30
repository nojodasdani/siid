<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user->hasRole('Administrador')) {
            return $next($request);
        } else {
            //Session::flash('message', 'Parece que no tienes permiso para acceder a esta sección');
            //return redirect(route('error'));
            Session::flash('redireccionar', 'No tienes permiso para acceder a esta sección.');
            return new Response(view('error'));
        }
    }
}
