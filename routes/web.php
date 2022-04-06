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
    return view('app');
    return csrf_token();
});

Route::resource('multiplex', MultiplexController::class);
Route::resource('pelicula', PeliculaController::class);
Route::resource('cliente', ClienteController::class);
Route::resource('compra', CompraController::class);
Route::resource('proyeccion', Proyeccion::class);

Route::get('ver-funciones', function () {
    $funciones = DB::select('SELECT * FROM cine_distrito.proyeccion proy JOIN cine_distrito.pelicula peli ON proy.K_PELICULA=peli.K_PELICULA ORDER BY proy.F_PROYECCION ASC');

    $asientos = DB::select('SELECT * FROM cine_distrito.proyeccion_asiento');
    return response()->json(
        [
            'asientos' => $asientos,
            'funciones' => $funciones,
        ]
    );
});

Route::get('ver-snacks', function () {
    $snacks = DB::select('SELECT * FROM cine_distrito.snack WHERE Q_SNACK>0');

    return response()->json(
        [
            'snacks' => $snacks,
        ]
    );
});
