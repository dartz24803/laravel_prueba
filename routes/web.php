<?php

use App\Http\Controllers\AdministradorController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarteraController;
use App\Http\Controllers\FuncionTemporalController;
use App\Http\Controllers\Login;
use App\Http\Controllers\InicioController;
use App\Http\Middleware\NoCache;
use App\Http\Controllers\ReporteFotograficoController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\ReporteFotograficoAdmController;
use App\Http\Controllers\TablaCuadroControlVisualController;
use App\Http\Controllers\CuadroControlVisualController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AmonestacionController;
use App\Http\Controllers\ColaboradorConfController;

Route::middleware([NoCache::class])->group(function () {
    Route::get('/Cartera', [CarteraController::class, 'index'])->name('cartera');
    Route::get('/Inicio', [InicioController::class, 'index'])->name('inicio');
    Route::get('/ReporteFotografico', [ReporteFotograficoController::class, 'index'])->name('reportefotografico');
    Route::get('/ReporteFotograficoAdm', [ReporteFotograficoAdmController::class, 'index'])->name('tienda.administracion.ReporteFotografico.reportefotograficoadm');
});
Route::post('/ReporteFotograficoAdmListar', [ReporteFotograficoAdmController::class, 'listar']);
Route::controller(ReporteFotograficoAdmController::class)->group(function(){
    Route::get('ReporteFotograficoAdmController/ModalUpdatedReporteFotograficoAdm/{id}', 'ModalUpdatedReporteFotograficoAdm')->name('tienda.administracion.ReporteFotografico.modal_editar');
    Route::get('ReporteFotograficoAdmController/ModalRegistrarReporteFotograficoAdm', 'ModalRegistroReporteFotograficoAdm')->name('tienda.administracion.ReporteFotografico.modal_registro');
    Route::post('/Registrar_Reporte_Fotografico_Adm', 'Registrar_Reporte_Fotografico_Adm');
    Route::post('/Update_Registro_Fotografico_Adm', 'Update_Registro_Fotografico_Adm')->name('Update_Registro_Fotografico_Adm');
    Route::post('/Delete_Reporte_Fotografico_Adm', 'Delete_Reporte_Fotografico_Adm');
});
//----------------------------LOGIN-------------------------//
Route::controller(Login::class)->group(function(){
    Route::get('/', 'index')->name('login');
    Route::post('IngresarLogin', 'ingresar')->name('IngresarLogin');
    Route::get('DestruirSesion', 'logout')->name('DestruirSesion');
});
//---------------------REGISTRO FOTOGRAFICO--------------------------//
Route::controller(ReporteFotograficoController::class)->group(function(){
    Route::get('Modal_Update_Registro_Fotografico/{id}', 'ModalUpdatedReporteFotografico')->name('tienda.ReporteFotografico.modal_editar');
    Route::get('ReporteFotografico/ModalRegistrarReporteFotografico', 'ModalRegistroReporteFotografico')->name('tienda.ReporteFotografico.modal_registro');
    Route::post('/Previsualizacion_Captura2', 'Previsualizacion_Captura2');
    Route::get('/obtenerImagenes', 'obtenerImagenes');
    Route::delete('/Delete_Imagen_Temporal', 'Delete_Imagen_Temporal');
    Route::post('/Delete_Reporte_Fotografico', 'Delete_Reporte_Fotografico');
    Route::post('/Registrar_Reporte_Fotografico', 'Registrar_Reporte_Fotografico');
    Route::post('/Update_Registro_Fotografico', 'Update_Registro_Fotografico')->name('Update_Registro_Fotografico');
    Route::get('Reporte_Fotografico', 'Reporte_Fotografico');
    Route::post('/Reporte_Fotografico_Listar', 'Reporte_Fotografico_Listar');
    Route::get('Imagenes_Reporte_Fotografico', 'Imagenes_Reporte_Fotografico');
    Route::post('/Listar_Imagenes_Reporte_Fotografico', 'Listar_Imagenes_Reporte_Fotografico');
    Route::get('Modal_Detalle_RF/{id}', 'Modal_Detalle_RF');
});
//LOGÍSTICA - TRACKING
Route::controller(TrackingController::class)->group(function(){
    Route::get('tracking', 'index')->name('tracking');
    Route::post('tracking/list', 'list')->name('tracking.list');
    Route::get('tracking/create', 'create')->name('tracking.create');
    Route::post('tracking', 'store')->name('tracking.store');
    Route::post('tracking/salida_mercaderia', 'insert_salida_mercaderia')->name('tracking.salida_mercaderia');
    Route::get('tracking/{id}/detalle_transporte', 'detalle_transporte')->name('tracking.detalle_transporte');
    Route::post('tracking/mercaderia_transito', 'insert_mercaderia_transito')->name('tracking.mercaderia_transito');
    Route::post('tracking/llegada_tienda', 'insert_llegada_tienda')->name('tracking.llegada_tienda');
    Route::post('tracking/confirmacion_llegada', 'insert_confirmacion_llegada')->name('tracking.confirmacion_llegada');
    Route::post('tracking/cierre_inspeccion_fardos', 'insert_cierre_inspeccion_fardos')->name('tracking.cierre_inspeccion_fardos');
    Route::get('tracking/{id}/verificacion_fardos', 'verificacion_fardos')->name('tracking.verificacion_fardos');
    Route::post('tracking/list_archivo_inspf', 'list_archivo_inspf')->name('tracking.list_archivo_inspf');
    Route::post('tracking/previsualizacion_captura', 'previsualizacion_captura')->name('tracking.previsualizacion_captura');
    Route::delete('tracking/{id}/delete_archivo_temporal_inspf', 'delete_archivo_temporal_inspf')->name('tracking.delete_archivo_temporal_inspf');
    Route::post('tracking/reporte_inspeccion_fardo', 'insert_reporte_inspeccion_fardo')->name('tracking.reporte_inspeccion_fardo');
    Route::get('tracking/{id}/pago_transporte', 'pago_transporte')->name('tracking.pago_transporte');
    Route::post('tracking/confirmacion_pago_transporte', 'insert_confirmacion_pago_transporte')->name('tracking.confirmacion_pago_transporte');
    Route::post('tracking/conteo_mercaderia', 'insert_conteo_mercaderia')->name('tracking.conteo_mercaderia');
    Route::post('tracking/mercaderia_entregada', 'insert_mercaderia_entregada')->name('tracking.mercaderia_entregada');
    Route::get('tracking/{id}/reporte_mercaderia', 'reporte_mercaderia')->name('tracking.reporte_mercaderia');
    Route::post('tracking/reporte_mercaderia', 'insert_reporte_mercaderia')->name('tracking.insert_reporte_mercaderia');
    Route::get('tracking/{id}/cuadre_diferencia', 'cuadre_diferencia')->name('tracking.cuadre_diferencia');
    Route::post('tracking/reporte_diferencia', 'insert_reporte_diferencia')->name('tracking.insert_reporte_diferencia');
    Route::get('tracking/{id}/detalle_operacion_diferencia', 'detalle_operacion_diferencia')->name('tracking.detalle_operacion_diferencia');
    Route::post('tracking/diferencia_regularizada', 'insert_diferencia_regularizada')->name('tracking.insert_diferencia_regularizada');
    Route::get('tracking/{id}/solicitud_devolucion', 'solicitud_devolucion')->name('tracking.solicitud_devolucion');
    Route::post('tracking/reporte_devolucion', 'insert_reporte_devolucion')->name('tracking.insert_reporte_devolucion');
    Route::get('tracking/{id}/evaluacion_devolucion', 'evaluacion_devolucion')->name('tracking.evaluacion_devolucion');
    Route::post('tracking/autorizacion_devolucion', 'insert_autorizacion_devolucion')->name('tracking.insert_autorizacion_devolucion');
});
//TIENDA - FUNCIÓN TEMPORAL
Route::controller(FuncionTemporalController::class)->group(function(){
    Route::get('funcion_temporal', 'index')->name('funcion_temporal');
    Route::get('funcion_temporal/{id}/list', 'list')->name('funcion_temporal.list');
    Route::get('funcion_temporal/create', 'create')->name('funcion_temporal.create');
    Route::post('funcion_temporal', 'store')->name('funcion_temporal.store');
    Route::post('funcion_temporal/tipo_funcion', 'tipo_funcion')->name('funcion_temporal.tipo_funcion');
    Route::get('funcion_temporal/{id}', 'show')->name('funcion_temporal.show');
    Route::get('funcion_temporal/{id}/edit', 'edit')->name('funcion_temporal.edit');
    Route::put('funcion_temporal/{id}', 'update')->name('funcion_temporal.update');
    Route::delete('funcion_temporal/{id}', 'destroy')->name('funcion_temporal.destroy');
    Route::get('funcion_temporal/{id}/excel', 'excel')->name('funcion_temporal.excel');
});
//TIENDA - ADMINISTRADOR
Route::controller(AdministradorController::class)->group(function(){
    Route::get('administrador_conf', 'index_conf')->name('administrador_conf');
    Route::get('administrador_conf_st', 'index_conf_st')->name('administrador_conf_st');
    Route::get('administrador_conf_st/list', 'list_conf_st')->name('administrador_conf_st.list');
    Route::get('administrador_conf_st/{id}/create', 'create_conf_st')->name('administrador_conf_st.create');
    Route::post('administrador_conf_st', 'store_conf_st')->name('administrador_conf_st.store');
    Route::get('administrador_conf_st/{id}/edit', 'edit_conf_st')->name('administrador_conf_st.edit');
    Route::put('administrador_conf_st/{id}', 'update_conf_st')->name('administrador_conf_st.update');
    Route::delete('administrador_conf_st/{id}', 'destroy_conf_st')->name('administrador_conf_st.destroy');
    Route::get('administrador_conf_sc', 'index_conf_sc')->name('administrador_conf_sc');
    Route::post('administrador_conf_sc/list', 'list_conf_sc')->name('administrador_conf_sc.list');
    Route::get('administrador_conf_sc/{id}/create', 'create_conf_sc')->name('administrador_conf_sc.create');
    Route::post('administrador_conf_sc', 'store_conf_sc')->name('administrador_conf_sc.store');
    Route::get('administrador_conf_sc/{id}/edit', 'edit_conf_sc')->name('administrador_conf_sc.edit');
    Route::put('administrador_conf_sc/{id}', 'update_conf_sc')->name('administrador_conf_sc.update');
    Route::delete('administrador_conf_sc/{id}', 'destroy_conf_sc')->name('administrador_conf_sc.destroy');
    Route::get('administrador', 'index')->name('administrador');
    Route::get('administrador_st', 'index_st')->name('administrador_st');
    Route::post('administrador_st/list', 'list_st')->name('administrador_st.list');
    Route::get('administrador_st/create', 'create_st')->name('administrador_st.create');
    Route::post('administrador_st/previsualizacion_captura', 'previsualizacion_captura_st')->name('administrador_st.previsualizacion_captura');
    Route::post('administrador_st', 'store_st')->name('administrador_st.store');
    Route::get('administrador_st/{id}/edit', 'edit_st')->name('administrador_st.edit');
    Route::put('administrador_st/previsualizacion_captura', 'previsualizacion_captura_st')->name('administrador_st.previsualizacion_captura_put');
    Route::put('administrador_st/{id}', 'update_st')->name('administrador_st.update');
    Route::get('administrador_st/{id}/download', 'download_st')->name('administrador_st.download');
    Route::delete('administrador_st/{id}/evidencia', 'destroy_evidencia_st')->name('administrador_st.destroy_evidencia');
    Route::get('administrador_st/{id}/show', 'show_st')->name('administrador_st.show');
    Route::delete('administrador_st/{id}', 'destroy_st')->name('administrador_st.destroy');
    Route::get('administrador_st/{id}/evidencia', 'evidencia_st')->name('administrador_st.evidencia');
    Route::get('administrador_sc', 'index_sc')->name('administrador_sc');
    Route::post('administrador_sc/list', 'list_sc')->name('administrador_sc.list');
    Route::get('administrador_sc/valida', 'valida_sc')->name('administrador_sc.valida');
    Route::get('administrador_sc/create', 'create_sc')->name('administrador_sc.create');
    Route::post('administrador_sc', 'store_sc')->name('administrador_sc.store');
    Route::get('administrador_sc/{id}/edit', 'edit_sc')->name('administrador_sc.edit');
    Route::put('administrador_sc/{id}', 'update_sc')->name('administrador_sc.update');
    Route::get('administrador_sc/{id}/download', 'download_sc')->name('administrador_sc.download');
    Route::delete('administrador_sc/{id}/evidencia', 'destroy_evidencia_sc')->name('administrador_sc.destroy_evidencia');
    Route::get('administrador_sc/{id}/show', 'show_sc')->name('administrador_sc.show');
    Route::delete('administrador_sc/{id}', 'destroy_sc')->name('administrador_sc.destroy');
    Route::get('administrador_sc/{id}/evidencia', 'evidencia_sc')->name('administrador_sc.evidencia');
});
//RECURSOS HUMANOS - COLABORADOR CONFIGURABLE
Route::controller(ColaboradorConfController::class)->group(function(){
    Route::get('colaborador_conf', 'index')->name('colaborador_conf');
    Route::post('colaborador_conf/traer_gerencia', 'traer_gerencia')->name('colaborador_conf.traer_gerencia');
    Route::post('colaborador_conf/traer_sub_gerencia', 'traer_sub_gerencia')->name('colaborador_conf.traer_sub_gerencia');
    Route::post('colaborador_conf/traer_area', 'traer_area')->name('colaborador_conf.traer_area');
    Route::post('colaborador_conf/traer_puesto', 'traer_puesto')->name('colaborador_conf.traer_puesto');
    Route::get('colaborador_conf_di', 'index_di')->name('colaborador_conf_di');
    Route::get('colaborador_conf_di/list', 'list_di')->name('colaborador_conf_di.list');
    Route::get('colaborador_conf_di/create', 'create_di')->name('colaborador_conf_di.create');
    Route::post('colaborador_conf_di', 'store_di')->name('colaborador_conf_di.store');
    Route::get('colaborador_conf_di/{id}/edit', 'edit_di')->name('colaborador_conf_di.edit');
    Route::put('colaborador_conf_di/{id}', 'update_di')->name('colaborador_conf_di.update');
    Route::delete('colaborador_conf_di/{id}', 'destroy_di')->name('colaborador_conf_di.destroy');
    Route::get('colaborador_conf_ge', 'index_ge')->name('colaborador_conf_ge');
    Route::get('colaborador_conf_ge/list', 'list_ge')->name('colaborador_conf_ge.list');
    Route::get('colaborador_conf_ge/create', 'create_ge')->name('colaborador_conf_ge.create');
    Route::post('colaborador_conf_ge', 'store_ge')->name('colaborador_conf_ge.store');
    Route::get('colaborador_conf_ge/{id}/edit', 'edit_ge')->name('colaborador_conf_ge.edit');
    Route::put('colaborador_conf_ge/{id}', 'update_ge')->name('colaborador_conf_ge.update');
    Route::delete('colaborador_conf_ge/{id}', 'destroy_ge')->name('colaborador_conf_ge.destroy');
    Route::get('colaborador_conf_sg', 'index_sg')->name('colaborador_conf_sg');
    Route::get('colaborador_conf_sg/list', 'list_sg')->name('colaborador_conf_sg.list');
    Route::get('colaborador_conf_sg/create', 'create_sg')->name('colaborador_conf_sg.create');
    Route::post('colaborador_conf_sg', 'store_sg')->name('colaborador_conf_sg.store');
    Route::get('colaborador_conf_sg/{id}/edit', 'edit_sg')->name('colaborador_conf_sg.edit');
    Route::put('colaborador_conf_sg/{id}', 'update_sg')->name('colaborador_conf_sg.update');
    Route::delete('colaborador_conf_sg/{id}', 'destroy_sg')->name('colaborador_conf_sg.destroy');
    Route::get('colaborador_conf_ar', 'index_ar')->name('colaborador_conf_ar');
    Route::get('colaborador_conf_ar/list', 'list_ar')->name('colaborador_conf_ar.list');
    Route::get('colaborador_conf_ar/create', 'create_ar')->name('colaborador_conf_ar.create');
    Route::post('colaborador_conf_ar/traer_puesto_ar', 'traer_puesto_ar')->name('colaborador_conf_ar.traer_puesto');
    Route::post('colaborador_conf_ar', 'store_ar')->name('colaborador_conf_ar.store');
    Route::get('colaborador_conf_ar/{id}/edit', 'edit_ar')->name('colaborador_conf_ar.edit');
    Route::put('colaborador_conf_ar/{id}', 'update_ar')->name('colaborador_conf_ar.update');
    Route::delete('colaborador_conf_ar/{id}', 'destroy_ar')->name('colaborador_conf_ar.destroy');
    Route::get('colaborador_conf_ni', 'index_ni')->name('colaborador_conf_ni');
    Route::get('colaborador_conf_ni/list', 'list_ni')->name('colaborador_conf_ni.list');
    Route::get('colaborador_conf_ni/create', 'create_ni')->name('colaborador_conf_ni.create');
    Route::post('colaborador_conf_ni', 'store_ni')->name('colaborador_conf_ni.store');
    Route::get('colaborador_conf_ni/{id}/edit', 'edit_ni')->name('colaborador_conf_ni.edit');
    Route::put('colaborador_conf_ni/{id}', 'update_ni')->name('colaborador_conf_ni.update');
    Route::delete('colaborador_conf_ni/{id}', 'destroy_ni')->name('colaborador_conf_ni.destroy');
    Route::get('colaborador_conf_se', 'index_se')->name('colaborador_conf_se');
    Route::get('colaborador_conf_se/list', 'list_se')->name('colaborador_conf_se.list');
    Route::get('colaborador_conf_se/create', 'create_se')->name('colaborador_conf_se.create');
    Route::post('colaborador_conf_se', 'store_se')->name('colaborador_conf_se.store');
    Route::get('colaborador_conf_se/{id}/edit', 'edit_se')->name('colaborador_conf_se.edit');
    Route::put('colaborador_conf_se/{id}', 'update_se')->name('colaborador_conf_se.update');
    Route::delete('colaborador_conf_se/{id}', 'destroy_se')->name('colaborador_conf_se.destroy');
    Route::get('colaborador_conf_pu', 'index_pu')->name('colaborador_conf_pu');
    Route::get('colaborador_conf_pu/list', 'list_pu')->name('colaborador_conf_pu.list');
    Route::get('colaborador_conf_pu/create', 'create_pu')->name('colaborador_conf_pu.create');
    Route::post('colaborador_conf_pu', 'store_pu')->name('colaborador_conf_pu.store');
    Route::get('colaborador_conf_pu/{id}/edit', 'edit_pu')->name('colaborador_conf_pu.edit');
    Route::put('colaborador_conf_pu/{id}', 'update_pu')->name('colaborador_conf_pu.update');
    Route::delete('colaborador_conf_pu/{id}', 'destroy_pu')->name('colaborador_conf_pu.destroy');
    Route::get('colaborador_conf_pu/{id}/detalle', 'detalle_pu')->name('colaborador_conf_pu.detalle');
    Route::post('colaborador_conf_pu/list_funcion', 'list_funcion_pu')->name('colaborador_conf_pu.list_funcion');
    Route::post('colaborador_conf_pu/list_competencia', 'list_competencia_pu')->name('colaborador_conf_pu.list_competencia');
    Route::post('colaborador_conf_pu/{id}/proposito', 'update_proposito_pu')->name('colaborador_conf_pu.update_proposito');
    Route::post('colaborador_conf_pu/{id}/funcion', 'insert_funcion_pu')->name('colaborador_conf_pu.insert_funcion');
    Route::get('colaborador_conf_pu/{id}/edit_funcion', 'edit_funcion_pu')->name('colaborador_conf_pu.edit_funcion');
    Route::post('colaborador_conf_pu/{id}/update_funcion', 'update_funcion_pu')->name('colaborador_conf_pu.update_funcion');
    Route::delete('colaborador_conf_pu/{id}/funcion', 'delete_funcion_pu')->name('colaborador_conf_pu.delete_funcion');
    Route::post('colaborador_conf_pu/{id}/competencia', 'insert_competencia_pu')->name('colaborador_conf_pu.insert_competencia');
    Route::delete('colaborador_conf_pu/{id}/competencia', 'delete_competencia_pu')->name('colaborador_conf_pu.delete_competencia');
    Route::get('colaborador_conf_ca', 'index_ca')->name('colaborador_conf_ca');
    Route::get('colaborador_conf_ca/list', 'list_ca')->name('colaborador_conf_ca.list');
    Route::get('colaborador_conf_ca/create', 'create_ca')->name('colaborador_conf_ca.create');
    Route::post('colaborador_conf_ca', 'store_ca')->name('colaborador_conf_ca.store');
    Route::get('colaborador_conf_ca/{id}/edit', 'edit_ca')->name('colaborador_conf_ca.edit');
    Route::put('colaborador_conf_ca/{id}', 'update_ca')->name('colaborador_conf_ca.update');
    Route::delete('colaborador_conf_ca/{id}', 'destroy_ca')->name('colaborador_conf_ca.destroy');
});







//CUADRO CONTROL VISUAL ADMINISTRACION
Route::controller(TablaCuadroControlVisualController::class)->group(function(){
    //---------------------Administrable horarios---------------------------------------------//
    Route::get('TablaCuadroControlVisual', 'index')->name('TablaCuadroControlVisual');
    Route::get('Horarios_Cuadro_Control', 'Horarios_Cuadro_Control')->name('Horarios_Cuadro_Control');
    Route::get('Modal_Update_Horarios_Cuadro_Control/{id}', 'Modal_Update_Horarios_Cuadro_Control')->name('tienda.administracion.CuadroControlVisual.Horarios.modal_editar');
    Route::get('Modal_Agregar_Horarios_Cuadro_Control/{id}', 'Modal_Agregar_Horarios_Cuadro_Control')->name('tienda.administracion.CuadroControlVisual.Horarios.modal_agregar_horario');
    Route::post('/Agregar_Horarios_Cuadro_Control', 'Agregar_Horarios_Cuadro_Control');
    Route::get('/Modal_Horarios_Cuadro_Control', 'Modal_Horarios_Cuadro_Control')->name('tienda.administracion.CuadroControlVisual.Horarios.modal_registrar');
    Route::get('/Traer_Puesto_Horario', 'Traer_Puesto_Horario');
    Route::post('/Delete_Horarios_Cuadro_Control', 'Delete_Horarios_Cuadro_Control');
    Route::post('/Insert_Horarios_Cuadro_Control', 'Insert_Horarios_Cuadro_Control');
    Route::post('/Lista_Horarios_Cuadro_Control', 'Lista_Horarios_Cuadro_Control');
    Route::post('/Update_Horarios_Cuadro_Control', 'Update_Horarios_Cuadro_Control')->name('Update_Horarios_Cuadro_Control');
    //------------------------------Administrable CCV------------------------------------//
    Route::get('Cuadro_Control_Visual', 'Cuadro_Control_Visual')->name('Cuadro_Control_Visual');
    Route::post('/Lista_Cuadro_Control_Visual', 'Lista_Cuadro_Control_Visual');
    Route::post('/Insert_Cuadro_Control_Visual_Horario', 'Insert_Cuadro_Control_Visual_Horario');
    //-----------------------Administrable Programacion diaria----------------------------//
    Route::get('Programacion_Diaria', 'Programacion_Diaria')->name('Programacion_Diaria');
    Route::post('/Lista_Programacion_Diaria', 'Lista_Programacion_Diaria');
    Route::post('/Insert_Programacion_Diaria', 'Insert_Programacion_Diaria');
    Route::get('/Modal_Programacion_Diaria', 'Modal_Programacion_Diaria')->name('tienda.administracion.CuadroControlVisual.Programacion_Diaria.modal_registrar');
    Route::get('/Traer_Colaborador_Programacion_Diaria', 'Traer_Colaborador_Programacion_Diaria');
    Route::get('/Traer_Horario_Programacion_Diaria', 'Traer_Horario_Programacion_Diaria');
});
//CUADRO CONTROL VISUAL
Route::controller(CuadroControlVisualController::class)->group(function(){
    //------------------------------CCV------------------------------------//
    Route::get('Cuadro_Control_Visual_Vista', 'Cuadro_Control_Visual_Vista')->name('Cuadro_Control_Visual_Vista');
    Route::post('Lista_Cuadro_Control_Visual_Vista', 'Lista_Cuadro_Control_Visual_Vista');
    Route::post('/Insert_Cuadro_Control_Visual_Estado', 'Insert_Cuadro_Control_Visual_Estado');
    Route::post('/Insert_Cuadro_Control_Visual_Estado1', 'Insert_Cuadro_Control_Visual_Estado1');
});



























//ASISTENCIA
Route::controller(AsistenciaController::class)->group(function(){
    //------------------------------CCV------------------------------------//
    Route::get('Reporte_Control_Asistencia', 'index')->name('Reporte_Control_Asistencia');
    Route::post('Buscar_Reporte_Control_Asistencia', 'Buscar_Reporte_Control_Asistencia');
    // Route::post('/Insert_Cuadro_Control_Visual_Estado', 'Insert_Cuadro_Control_Visual_Estado');
    // Route::post('/Insert_Cuadro_Control_Visual_Estado1', 'Insert_Cuadro_Control_Visual_Estado1');
});
//AMONESTACION
Route::controller(AmonestacionController::class)->group(function(){
    //------------------------------AMONESTACIONES------------------------------------//
    Route::get('Amonestacion', 'Amonestacion')->name('Amonestacion');
    Route::get('Amonestaciones_Emitidas', 'Amonestaciones_Emitidas')->name('Amonestaciones_Emitidas');
    Route::get('Amonestaciones_Recibidas', 'Amonestaciones_Recibidas')->name('Amonestaciones_Recibidas');
    Route::post('Lista_Amonestaciones_Emitidas', 'Lista_Amonestaciones_Emitidas')->name('Lista_Amonestaciones_Emitidas');
    Route::post('Lista_Amonestaciones_Recibidas', 'Lista_Amonestaciones_Recibidas');
    Route::post('Buscar_Reporte_Control_Asistencia', 'Buscar_Reporte_Control_Asistencia');
    Route::get('/Modal_Amonestacion', 'Modal_Amonestacion');
    Route::get('/Modal_Update_Amonestacion/{id}/{num}', 'Modal_Update_Amonestacion');
    Route::post('/Insert_Amonestacion', 'Insert_Amonestacion');
    Route::post('/Update_Amonestacion', 'Update_Amonestacion');
    Route::post('/Delete_Amonestacion', 'Delete_Amonestacion');
    Route::get('/Modal_Documento_Amonestacion/{id}', 'Modal_Documento_Amonestacion');
    Route::get('Pdf_Amonestacion/{id}','Pdf_Amonestacion');
    Route::post('/Update_Documento_Amonestacion', 'Update_Documento_Amonestacion');
    Route::post('Aprobacion_Amonestacion', 'Aprobacion_Amonestacion');
});
