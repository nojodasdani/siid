<?php

use App\Http\Middleware\HasAccess;
use App\Http\Middleware\CheckRole;

$admin = ['auth', HasAccess::class, CheckRole::class];
$normal = ['auth', HasAccess::class];

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::get('/solicitudes/show', function () {
    return view('solicitudes');
})->name('solicitudes')->middleware($admin);

Route::get('/avisos/show', function () {
    return view('avisos');
})->name('avisos')->middleware($admin);

Route::get('/avisos/registrar', function () {
    return view('registrarAviso');
})->middleware($admin);

Route::get('/codigos/show', function () {
    return view('codigos');
})->name('codigos')->middleware($normal);

Auth::routes();

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware($normal);

Route::get('/micuenta', function () {
    return view('micuenta');
})->middleware($normal)->name('micuenta');
Route::post('/micuenta/modificar', 'HomeController@modificarCuenta')->name('modify')->middleware($normal);

Route::get('/changepassword', function () {
    return view('changepass');
})->middleware($normal);
Route::post('/changepassword/modificar', 'HomeController@cambiarPass')->name('changePassword')->middleware($normal);

Route::get('/solicitudes/aceptarSolicitud', 'SolicitudesController@aceptar')->middleware($admin);
Route::get('/solicitudes/rechazarSolicitud', 'SolicitudesController@rechazar')->middleware($admin);

Route::get('/showNotifications', 'HomeController@cargaNotificaciones')->middleware($admin);

Route::get('/register/showNumbers', 'Auth\RegisterController@cargaNumero');//->middleware(['auth', HasAccess::class, CheckRole::class]);

Route::post('/avisos/registrar', 'AvisosController@crear')->name('crearAviso')->middleware($admin);
Route::get('/avisos/visible', 'AvisosController@visible')->middleware($admin);
Route::get('/avisos/eliminar', 'AvisosController@eliminar')->middleware($admin);

Route::post('/codigos/show/crearUnico', 'CodigoController@crearUnico')->name('crearCodigoUnico')->middleware($normal);
Route::post('/codigos/show/crearEvento', 'CodigoController@crearEvento')->name('crearCodigoEvento')->middleware($normal);
Route::get('/codigos/eliminar', 'CodigoController@eliminar')->middleware($normal);

//atrapar todas las rutas que no existan
Route::any('/{any}', function () {
    Session::flash('redireccionar', 'Parece que la página que ingresaste no existe.');
    return view('error');
})->where('any', '.*');

