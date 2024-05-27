<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarteraController;
use App\Http\Controllers\Login;
use App\Http\Controllers\Inicio;
use App\Http\Middleware\NoCache;
use App\Http\Controllers\ReporteFotografico;
use App\Http\Controllers\OldController;

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

Route::middleware([NoCache::class])->group(function () {
    Route::get('/Cartera', [CarteraController::class, 'index'])->name('cartera');
    Route::get('/Inicio', [Inicio::class, 'index'])->name('inicio');
    Route::get('/ReporteFotografico', [ReporteFotografico::class, 'index'])->name('reportefotografico');
});
Route::post('/Carteralistar', [CarteraController::class, 'listar']);
Route::post('registraryeditarCartera', [CarteraController::class, 'registraryeditar']);
Route::get('buscarCartera', [CarteraController::class, 'buscar']);
Route::get('eliminarCartera', [CarteraController::class, 'eliminar']);
//LOGIN
Route::get('/', [Login::class, 'index'])->name('login');
Route::post('IngresarLogin', [Login::class, 'ingresar'])->name('IngresarLogin');
Route::get('DestruirSesion', [Login::class, 'logout']);
//REGISTRO FOTOGRAFICO
Route::post('/ReporteFotograficoListar', [ReporteFotografico::class, 'listar']);
Route::get('/modalRegistrarReporteFotografico', [ReporteFotografico::class, 'modalRegistrarReporteFotografico'])->name('modal_registrar');
//PRUEBA INDEX antiguo
Route::get('old', [OldController::class, 'index'])->name('old');
