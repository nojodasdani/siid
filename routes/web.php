<?php
use App\Http\Middleware\HasAccess;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/error', function () {
    if(Auth::user()->acceso_sistema) {
        return redirect('');
    }else{
        return view('error');
    }
})->name('error')->middleware('auth');

Route::get('/solicitudes/show', function () {
        return view('solicitudes');
})->middleware(['auth', HasAccess::class, CheckRole::class])->name('solicitudes');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/solicitudes/aceptarSolicitud', 'SolicitudesController@aceptar');
Route::get('/solicitudes/rechazarSolicitud', 'SolicitudesController@rechazar');

Route::get('/showNotifications', 'HomeController@cargaNotificaciones');

Route::get('/register/showNumbers', 'Auth\RegisterController@cargaNumero');
