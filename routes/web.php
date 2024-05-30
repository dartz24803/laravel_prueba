<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarteraController;
use App\Http\Controllers\Login;
use App\Http\Controllers\Inicio;
use App\Http\Middleware\NoCache;
use App\Http\Controllers\ReporteFotograficoController;
use App\Http\Controllers\OldController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ReporteFotograficoAdmController;

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
    Route::get('/ReporteFotografico', [ReporteFotograficoController::class, 'index'])->name('reportefotografico');
    Route::get('/ReporteFotograficoAdm', [ReporteFotograficoAdmController::class, 'index'])->name('tienda.administracion.ReporteFotografico.reportefotograficoadm');
});
Route::post('/ReporteFotograficoAdmListar', [ReporteFotograficoAdmController::class, 'listar']);
Route::controller(ReporteFotograficoAdmController::class)->group(function(){
    Route::get('ReporteFotograficoAdmController/ModalUpdatedReporteFotograficoAdm/{id}', 'ModalUpdatedReporteFotograficoAdm')->name('tienda.administracion.ReporteFotografico.modal_editar');
    Route::get('ReporteFotograficoAdmController/ModalRegistrarReporteFotograficoAdm', 'ModalRegistroReporteFotograficoAdm')->name('tienda.administracion.ReporteFotografico.modal_registro');
});
Route::post('/Registrar_Reporte_Fotografico_Adm', [ReporteFotograficoAdmController::class, 'Registrar_Reporte_Fotografico_Adm']);
Route::post('/Update_Registro_Fotografico_Adm', [ReporteFotograficoAdmController::class, 'Update_Registro_Fotografico_Adm'])->name('Update_Registro_Fotografico_Adm');
Route::post('/Delete_Reporte_Fotografico_Adm', [ReporteFotograficoAdmController::class, 'Delete_Reporte_Fotografico_Adm']);
//LOGIN
Route::get('/', [Login::class, 'index'])->name('login');
Route::post('IngresarLogin', [Login::class, 'ingresar'])->name('IngresarLogin');
Route::get('DestruirSesion', [Login::class, 'logout'])->name('DestruirSesion');
//REGISTRO FOTOGRAFICO
Route::post('/ReporteFotograficoListar', [ReporteFotograficoController::class, 'listar']);
//Route::get('/ModalUpdatedReporteFotografico', [ReporteFotografico::class, 'ModalUpdatedReporteFotografico'])->name('modal_editar');
Route::controller(ReporteFotograficoController::class)->group(function(){
    Route::get('ReporteFotografico/ModalUpdatedReporteFotografico/{id}', 'ModalUpdatedReporteFotografico')->name('tienda.ReporteFotografico.modal_editar');
    Route::get('ReporteFotografico/ModalRegistrarReporteFotografico', 'ModalRegistroReporteFotografico')->name('tienda.ReporteFotografico.modal_registro');
});
Route::post('/Previsualizacion_Captura2', [ReporteFotograficoController::class, 'Previsualizacion_Captura2']);
Route::get('/obtenerImagenes', [ReporteFotograficoController::class, 'obtenerImagenes']);
Route::delete('/Delete_Imagen_Temporal', [ReporteFotograficoController::class, 'Delete_Imagen_Temporal']);
Route::post('/Delete_Reporte_Fotografico', [ReporteFotograficoController::class, 'Delete_Reporte_Fotografico']);
Route::post('/Registrar_Reporte_Fotografico', [ReporteFotograficoController::class, 'Registrar_Reporte_Fotografico']);
Route::post('/Update_Registro_Fotografico', [ReporteFotograficoController::class, 'Update_Registro_Fotografico'])->name('Update_Registro_Fotografico');
//PRUEBA INDEX antiguo
Route::get('old', [OldController::class, 'index'])->name('old');
//TRACKING
Route::controller(TrackingController::class)->group(function(){
    Route::get('tracking', 'index')->name('tracking');
    Route::post('tracking/list', 'list')->name('tracking.list');
    Route::get('tracking/create', 'create')->name('tracking.create');
    Route::post('tracking', 'store')->name('tracking.store');
    Route::post('tracking/salida_mercaderia', 'insert_salida_mercaderia')->name('tracking.salida_mercaderia');
    Route::get('tracking/{id}/detalle_transporte', 'detalle_transporte')->name('tracking.detalle_transporte');
});


























//