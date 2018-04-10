<?php
use App\Http\Middleware\HasAccess;
use App\Http\Middleware\CheckRole;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/error', function () {
    if(Auth::user()->acceso_sistema && Auth::user()->activo) {
        return redirect('');
    }else{
        return view('error');
    }
})->name('error')->middleware('auth');

Route::get('/solicitudes/show', function () {
        return view('solicitudes');
})->middleware(['auth', HasAccess::class, CheckRole::class])->name('solicitudes');

Route::get('/avisos/show', function () {
    return view('avisos');
})->middleware(['auth', HasAccess::class, CheckRole::class])->name('avisos');

Route::get('/avisos/registrar', function () {
    return view('registrarAviso');
})->middleware(['auth', HasAccess::class, CheckRole::class]);

Route::get('/codigos/show', function () {
    return view('codigos');
})->middleware(['auth', HasAccess::class])->name('codigos');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/solicitudes/aceptarSolicitud', 'SolicitudesController@aceptar');
Route::get('/solicitudes/rechazarSolicitud', 'SolicitudesController@rechazar');

Route::get('/showNotifications', 'HomeController@cargaNotificaciones');

Route::get('/register/showNumbers', 'Auth\RegisterController@cargaNumero');

Route::post('/avisos/registrar', 'AvisosController@crear')->name('crearAviso');
Route::get('/avisos/visible', 'AvisosController@visible');
Route::get('/avisos/eliminar', 'AvisosController@eliminar');

Route::post('/codigos/show/crearUnico', 'CodigoController@crearUnico')->name('crearCodigoUnico');
Route::post('/codigos/show/crearEvento', 'CodigoController@crearEvento')->name('crearCodigoEvento');
