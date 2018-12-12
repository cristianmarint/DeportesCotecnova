<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'auth'], function() {

    Route::get('/admin', function() {
        return view('index');
    });

    // Routes Institution
    Route::resource('/institutos', 'InstitutoController');
    Route::get('/institutos/municipios/{id_departamento}', 'InstitutoController@getMunicipio');

    // Routes equipos
    Route::resource('/equipos', 'EquipoController');

    // Routes temporadas
    Route::resource('/temporadas', 'TemporadaController');

    // Routes categorias
    Route::resource('/categorias', 'CategoriaController');

    // Routes torneo
    Route::resource('/torneos', 'TorneoController');

    // Routes inscripciones_equipo equipo
    Route::resource('/inscripciones_equipo', 'InscripcionEquiposController');
    Route::get('/inscripciones_equipo/torneo/{id_torneo}', 'InscripcionEquiposController@getEquipo');


//    Routes for data delete
    Route::resource('/institutos_delete', 'Instituto_deleteController');
    Route::resource('/equipos_delete', 'Equipo_deleteController');
    Route::resource('/temporadas_delete', 'Temporada_deleteController');
    Route::resource('/categorias_delete', 'Categoria_deleteController');
    Route::resource('/torneos_delete', 'Torneo_deleteController');
    Route::resource('/inscripciones_equipo_delete', 'InscripcionEquipos_deleteController');
});