<?php

use App\Http\Middleware\HasAccess;
use App\Http\Middleware\CheckRole;

$admin = ['auth', HasAccess::class, CheckRole::class];
$normal = ['auth', HasAccess::class];

Route::get('/', function () {
    return view('welcome');
});

Route::get('/error', function () {
    if (Auth::user()->acceso_sistema && Auth::user()->activo) {
        return redirect('');
    } else {
        return view('error');
    }
})->name('error')->middleware('auth');

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

Route::get('/solicitudes/aceptarSolicitud', 'SolicitudesController@aceptar')->middleware(['auth', HasAccess::class, CheckRole::class]);
Route::get('/solicitudes/rechazarSolicitud', 'SolicitudesController@rechazar')->middleware(['auth', HasAccess::class, CheckRole::class]);

Route::get('/showNotifications', 'HomeController@cargaNotificaciones')->middleware(['auth', HasAccess::class, CheckRole::class]);

Route::get('/register/showNumbers', 'Auth\RegisterController@cargaNumero');//->middleware(['auth', HasAccess::class, CheckRole::class]);

Route::post('/avisos/registrar', 'AvisosController@crear')->name('crearAviso')->middleware(['auth', HasAccess::class, CheckRole::class]);
Route::get('/avisos/visible', 'AvisosController@visible')->middleware(['auth', HasAccess::class, CheckRole::class]);
Route::get('/avisos/eliminar', 'AvisosController@eliminar')->middleware(['auth', HasAccess::class, CheckRole::class]);

Route::post('/codigos/show/crearUnico', 'CodigoController@crearUnico')->name('crearCodigoUnico')->middleware(['auth', HasAccess::class]);
Route::post('/codigos/show/crearEvento', 'CodigoController@crearEvento')->name('crearCodigoEvento')->middleware(['auth', HasAccess::class]);
Route::get('/codigos/eliminar', 'CodigoController@eliminar')->middleware(['auth', HasAccess::class]);

