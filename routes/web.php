<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\MultiplexController;
use App\Http\Controllers\PeliculaController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return csrf_token();
    return view('welcome');
});

Route::resource('multiplex', MultiplexController::class);
Route::resource('pelicula', PeliculaController::class);
Route::resource('cliente', ClienteController::class);
Route::resource('compra', CompraController::class);
Route::resource('proyeccion', Proyeccion::class);

Route::get('ver-funciones', function () {
    $funciones = DB::select('SELECT * FROM cine_distrito.proyeccion proy JOIN cine_distrito.pelicula peli ON proy.K_PELICULA=peli.K_PELICULA');

    $asientos = DB::select('SELECT * FROM cine_distrito.proyeccion_asiento');
    return response()->json(
        [
            'asientos' => $asientos,
            'funciones' => $funciones,
        ]
    );
});
