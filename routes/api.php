<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get("/cargarCalles", "ApiController@cargarCalles");
Route::get("/cargarNumeros/{calle}", "ApiController@cargarNumeros");
Route::get("/cargarMarcas", "ApiController@cargarMarcas");
Route::get("/cargarModelos/{marca}", "ApiController@cargarModelos");
Route::get("/cargarColores", "ApiController@cargarColores");
Route::get("/cargarTiposVisitante", "ApiController@cargarTiposVisitante");
Route::get("/cargarColonos/{domicilio}", "ApiController@cargarColonos");


Route::post("/guardarCoche", "ApiController@guardarCoche");

Route::get("/cargarCoche/{placa}", "ApiController@cargarCoche");