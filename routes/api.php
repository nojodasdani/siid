<?php

use Illuminate\Http\Request;

//Llenar información inicial del sistema
Route::get("/cargarCalles", "ApiController@cargarCalles");
Route::get("/cargarNumeros/{calle}", "ApiController@cargarNumeros");
Route::get("/cargarMarcas", "ApiController@cargarMarcas");
Route::get("/cargarModelos/{marca}", "ApiController@cargarModelos");
Route::get("/cargarColores", "ApiController@cargarColores");
Route::get("/cargarTiposVisitante", "ApiController@cargarTiposVisitante");

//cargar info según manipula la interfaz
Route::get("/cargarColonos/{domicilio}", "ApiController@cargarColonosPorCasa");
Route::get("/cargarColono/{id_colono}", "ApiController@cargarColono");
Route::get("/cargarAuto/{placa}", "ApiController@cargarAuto");
Route::get("/cargarVisitantesPorAuto/{id_auto}", "ApiController@cargarVisitantesPorAuto");
Route::get("/cargarVisitante/{id_visitante}", "ApiController@cargarVisitante");

//lectura de códigos
Route::get("/leerCodigo", "ApiController@leerCodigo");

//realizar registros desde la interfaz
Route::get("/registrarAcceso", "ApiController@registrarAcceso");
Route::get("/registrarVisitanteAcceso", "ApiController@registrarVisitanteAcceso");
Route::get("/registrarAutoVisitanteAcceso", "ApiController@registrarAutoVisitanteAcceso");