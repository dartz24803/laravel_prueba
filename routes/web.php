<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarteraController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/CarteraController', function () {
    return view('cartera');
});
Route::post('/Carteralistar', [CarteraController::class, 'listar']);
Route::get('/NHExtornoController', function () {
    return view('nhextorno');
});
Route::post('registraryeditarCartera', [CarteraController::class, 'registraryeditar']);
Route::get('buscarCartera', [CarteraController::class, 'buscar']);
Route::get('eliminarCartera', [CarteraController::class, 'eliminar']);
