<?php

namespace App\Http\Controllers;

use App\Http\Middleware\HasAccess;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware(['auth', HasAccess::class]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function cargaNotificaciones(){
        $number = count(User::all()->where('visto','=','0'));
        $html = "quitar";
        if($number>0){
            $html = $number;
        }
        return $html;
    }
}
