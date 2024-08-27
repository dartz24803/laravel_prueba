<?php

use App\Http\Controllers\AdministradorController;
use Illuminate\Support\Facades\Route;
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
use App\Http\Controllers\AperturaCierreTiendaConfController;
use App\Http\Controllers\AperturaCierreTiendaController;
use App\Http\Controllers\AsistenciaSegController;
use App\Http\Controllers\CajaInicioController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\ColaboradorConfController;
use App\Http\Controllers\ComunicadoController;
use App\Http\Controllers\ControlCamaraConfController;
use App\Http\Controllers\ControlCamaraController;
use App\Http\Controllers\SliderRRHH;
use App\Http\Controllers\Cumpleanios;
use App\Http\Controllers\InicioAdmController;
use App\Http\Controllers\InicioFrasesAdmController;
use App\Http\Controllers\LecturaServicioConfController;
use App\Http\Controllers\LecturaServicioController;
use App\Http\Controllers\PrecioSugeridoConfController;
use App\Http\Controllers\IntencionRenunciaConfController;
use App\Http\Controllers\LogisticaInicioController;
use App\Http\Controllers\ObservacionConfController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\OcurrenciaServicioConfController;



use App\Http\Controllers\OcurrenciasTiendaController;
use App\Http\Controllers\PostulanteController;
use App\Http\Controllers\ProcesosController;
use App\Http\Controllers\ReporteProveedoresController;

Route::middleware([NoCache::class])->group(function () {
    Route::get('Home', [InicioController::class, 'index'])->name('inicio');
});
Route::post('/ReporteFotograficoAdmListar', [ReporteFotograficoAdmController::class, 'listar']);
Route::controller(ReporteFotograficoAdmController::class)->group(function () {
    Route::get('/ReporteFotograficoAdm',  'index')->name('tienda.administracion.ReporteFotografico.reportefotograficoadm');
    Route::get('ReporteFotograficoAdmController/ModalUpdatedReporteFotograficoAdm/{id}', 'ModalUpdatedReporteFotograficoAdm')->name('tienda.administracion.ReporteFotografico.modal_editar');
    Route::get('ReporteFotograficoAdmController/ModalRegistrarReporteFotograficoAdm', 'ModalRegistroReporteFotograficoAdm')->name('tienda.administracion.ReporteFotografico.modal_registro');
    Route::post('/Registrar_Reporte_Fotografico_Adm', 'Registrar_Reporte_Fotografico_Adm');
    Route::post('/Update_Registro_Fotografico_Adm', 'Update_Registro_Fotografico_Adm')->name('Update_Registro_Fotografico_Adm');
    Route::post('/Delete_Reporte_Fotografico_Adm', 'Delete_Reporte_Fotografico_Adm');
    Route::get('Tabla_RF', 'Tabla_RF');
    Route::get('Codigos_Reporte_Fotografico', 'Codigos_Reporte_Fotografico');
    Route::post('/Codigos_Reporte_Fotografico_Listar', 'Codigos_Reporte_Fotografico_Listar');
    Route::get('ModalRegistroCodigosReporteFotograficoAdm', 'ModalRegistroCodigosReporteFotograficoAdm');
    Route::post('Registrar_Codigo_Reporte_Fotografico_Adm', 'Registrar_Codigo_Reporte_Fotografico_Adm');
    Route::get('ModalUpdatedCodigoReporteFotograficoAdm/{id}', 'ModalUpdatedCodigoReporteFotograficoAdm');
    Route::post('Update_Codigo_Registro_Fotografico_Adm', 'Update_Codigo_Registro_Fotografico_Adm');
    Route::post('Delete_Codigo_Reporte_Fotografico_Adm', 'Delete_Codigo_Reporte_Fotografico_Adm');
});
//----------------------------LOGIN-------------------------//
Route::controller(Login::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('IngresarLogin', 'ingresar')->name('IngresarLogin');
    Route::get('DestruirSesion', 'logout')->name('DestruirSesion');
});
//---------------------REGISTRO FOTOGRAFICO--------------------------//
Route::controller(ReporteFotograficoController::class)->group(function () {
    Route::get('/ReporteFotografico', 'index')->name('reportefotografico');
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
    Route::get('ReporteFotografico/validar_reporte_fotografico_dia_job', 'validar_reporte_fotografico_dia_job');
    Route::get('ReporteFotografico/validar_reporte_fotografico_dia_job_2', 'validar_reporte_fotografico_dia_job_2');
});
//LOGÍSTICA - TRACKING
Route::controller(TrackingController::class)->group(function () {
    //SUBIDA DE ARCHIVOS
    Route::post('tracking/list_archivo', 'list_archivo')->name('tracking.list_archivo');
    Route::post('tracking/previsualizacion_captura', 'previsualizacion_captura')->name('tracking.previsualizacion_captura');
    Route::delete('tracking/{id}/delete_archivo_temporal', 'delete_archivo_temporal')->name('tracking.delete_archivo_temporal');
    //FIN SUBIDA ARCHIVOS
    Route::get('tracking', 'index')->name('tracking');
    Route::get('tracking/iniciar_tracking', 'iniciar_tracking')->name('tracking.iniciar_tracking');
    Route::get('tracking/llegada_tienda', 'llegada_tienda')->name('tracking.llegada_tienda');
    Route::post('tracking/list', 'list')->name('tracking.list');
    Route::get('tracking/create', 'create')->name('tracking.create');
    Route::post('tracking', 'store')->name('tracking.store');
    Route::post('tracking/{id}/salida_mercaderia', 'insert_salida_mercaderia')->name('tracking.salida_mercaderia');
    Route::get('tracking/{id}/detalle_transporte', 'detalle_transporte')->name('tracking.detalle_transporte');
    Route::post('tracking/{id}/mercaderia_transito', 'insert_mercaderia_transito')->name('tracking.mercaderia_transito');
    Route::post('tracking/{id}/confirmacion_llegada', 'insert_confirmacion_llegada')->name('tracking.confirmacion_llegada');
    Route::post('tracking/{id}/cierre_inspeccion_fardos', 'insert_cierre_inspeccion_fardos')->name('tracking.cierre_inspeccion_fardos');
    Route::get('tracking/{id}/verificacion_fardos', 'verificacion_fardos')->name('tracking.verificacion_fardos');
    Route::post('tracking/reporte_inspeccion_fardo', 'insert_reporte_inspeccion_fardo')->name('tracking.reporte_inspeccion_fardo');
    Route::get('tracking/{id}/pago_transporte', 'pago_transporte')->name('tracking.pago_transporte');
    Route::post('tracking/previsualizacion_captura_pago', 'previsualizacion_captura_pago')->name('tracking.previsualizacion_captura_pago');
    Route::post('tracking/{id}/confirmacion_pago_transporte', 'insert_confirmacion_pago_transporte')->name('tracking.confirmacion_pago_transporte');
    Route::post('tracking/{id}/conteo_mercaderia', 'insert_conteo_mercaderia')->name('tracking.conteo_mercaderia');
    Route::post('tracking/{id}/mercaderia_entregada', 'insert_mercaderia_entregada')->name('tracking.mercaderia_entregada');
    Route::get('tracking/{id}/reporte_mercaderia', 'reporte_mercaderia')->name('tracking.reporte_mercaderia');
    Route::post('tracking/{id}/reporte_mercaderia', 'insert_reporte_mercaderia')->name('tracking.insert_reporte_mercaderia');
    Route::get('tracking/{id}/cuadre_diferencia', 'cuadre_diferencia')->name('tracking.cuadre_diferencia');
    Route::post('tracking/{id}/reporte_diferencia', 'insert_reporte_diferencia')->name('tracking.insert_reporte_diferencia');
    Route::get('tracking/{id}/detalle_operacion_diferencia', 'detalle_operacion_diferencia')->name('tracking.detalle_operacion_diferencia');
    Route::post('tracking/{id}/diferencia_regularizada', 'insert_diferencia_regularizada')->name('tracking.insert_diferencia_regularizada');
    Route::get('tracking/{id}/solicitud_devolucion', 'solicitud_devolucion')->name('tracking.solicitud_devolucion');
    Route::get('tracking/{id}/modal_solicitud_devolucion', 'modal_solicitud_devolucion')->name('tracking.modal_solicitud_devolucion');
    Route::post('tracking/{id}/devolucion_temporal', 'insert_devolucion_temporal')->name('tracking.insert_devolucion_temporal');
    Route::post('tracking/{id}/reporte_devolucion', 'insert_reporte_devolucion')->name('tracking.insert_reporte_devolucion');
    Route::get('tracking/{id}/evaluacion_devolucion', 'evaluacion_devolucion')->name('tracking.evaluacion_devolucion');
    Route::get('tracking/{id}/modal_evaluacion_devolucion', 'modal_evaluacion_devolucion')->name('tracking.modal_evaluacion_devolucion');
    Route::post('tracking/{id}/evaluacion_temporal', 'insert_evaluacion_temporal')->name('tracking.insert_evaluacion_temporal');
    Route::post('tracking/{id}/autorizacion_devolucion', 'insert_autorizacion_devolucion')->name('tracking.insert_autorizacion_devolucion');
    //MERCADERÍA NUEVA
    Route::get('tracking/mercaderia_nueva', 'mercaderia_nueva')->name('tracking.mercaderia_nueva');
    Route::post('tracking/list_mercaderia_nueva', 'list_mercaderia_nueva')->name('tracking.list_mercaderia_nueva');
    Route::get('tracking/{cod_base}/{estilo}/modal_mercaderia_nueva', 'modal_mercaderia_nueva')->name('tracking.modal_mercaderia_nueva');
    Route::post('tracking/mercaderia_surtida', 'insert_mercaderia_surtida')->name('tracking.insert_mercaderia_surtida');
});
//TIENDA - FUNCIÓN TEMPORAL
Route::controller(FuncionTemporalController::class)->group(function () {
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
Route::controller(AdministradorController::class)->group(function () {
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

//PROCESOS - ADMINISTRADOR
Route::controller(ProcesosController::class)->group(function () {
    Route::get('portalprocesos', 'index')->name('portalprocesos');
    Route::get('portalprocesos_lm', 'index_lm')->name('portalprocesos_lm');
    Route::get('portalprocesos_lm/list', 'list_lm')->name('portalprocesos_lm.list');
    Route::get('portalprocesos_lm/create', 'create_lm')->name('portalprocesos_lm.create');
    // Route::get('ocurrencia_conf_go/list', 'list_go')->name('ocurrencia_conf_go.list');
    // Route::get('ocurrencia_conf_go/create', 'create_go')->name('ocurrencia_conf_go.create');
    // Route::post('ocurrencia_conf_go', 'store_go')->name('ocurrencia_conf_go.store');
    // Route::get('ocurrencia_conf_go/{id}/edit', 'edit_go')->name('ocurrencia_conf_go.edit');
    // Route::put('ocurrencia_conf_go/{id}', 'update_go')->name('ocurrencia_conf_go.update');
    // Route::delete('ocurrencia_conf_go/{id}', 'destroy_go')->name('ocurrencia_conf_go.destroy');
    // Route::get('ocurrencia_conf_co', 'index_co')->name('ocurrencia_conf_co');
    // Route::get('ocurrencia_conf_co/list', 'list_coc')->name('ocurrencia_conf_co.list');
    // Route::get('ocurrencia_conf_co/create', 'create_co')->name('ocurrencia_conf_co.create');
    // Route::post('ocurrencia_conf_co', 'store_co')->name('ocurrencia_conf_co.store');
    // Route::get('ocurrencia_conf_co/{id}/edit', 'edit_co')->name('ocurrencia_conf_co.edit');
    // Route::put('ocurrencia_conf_co/{id}', 'update_co')->name('ocurrencia_conf_co.update');
    // Route::delete('ocurrencia_conf_co/{id}', 'destroy_co')->name('ocurrencia_conf_co.destroy');
    // Route::get('ocurrencia_conf_to', 'index_to')->name('ocurrencia_conf_to');
    // Route::get('ocurrencia_conf_to/list', 'list_to')->name('ocurrencia_conf_to.list');
    // Route::get('ocurrencia_conf_to/create', 'create_to')->name('ocurrencia_conf_to.create');
    // Route::post('ocurrencia_conf_to', 'store_to')->name('ocurrencia_conf_to.store');
    // Route::get('ocurrencia_conf_to/{id}/edit', 'edit_to')->name('ocurrencia_conf_to.edit');
    // Route::put('ocurrencia_conf_to/{id}', 'update_to')->name('ocurrencia_conf_to.update');
    // Route::delete('ocurrencia_conf_to/{id}', 'destroy_to')->name('ocurrencia_conf_to.destroy');
});


//RECURSOS HUMANOS - COLABORADOR CONFIGURABLE
Route::controller(ColaboradorConfController::class)->group(function () {
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
    Route::get('colaborador_conf_co', 'index_co')->name('colaborador_conf_co');
    Route::get('colaborador_conf_co/list', 'list_co')->name('colaborador_conf_co.list');
    Route::get('colaborador_conf_co/create', 'create_co')->name('colaborador_conf_co.create');
    Route::post('colaborador_conf_co', 'store_co')->name('colaborador_conf_co.store');
    Route::get('colaborador_conf_co/{id}/edit', 'edit_co')->name('colaborador_conf_co.edit');
    Route::put('colaborador_conf_co/{id}', 'update_co')->name('colaborador_conf_co.update');
    Route::delete('colaborador_conf_co/{id}', 'destroy_co')->name('colaborador_conf_co.destroy');
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
    Route::get('Index_Datacorp', 'Index_Datacorp');
    Route::post('Listar_Accesos_Datacorp', 'Listar_Accesos_Datacorp');
    Route::get('Modal_Registrar_Datacorp', 'Modal_Registrar_Datacorp');
    Route::get('Modal_Update_Datacorp/{id}', 'Modal_Update_Datacorp');
    Route::post('Registrar_Datacorp', 'Registrar_Datacorp');
    Route::post('Update_Datacorp', 'Update_Datacorp');
    Route::post('/Delete_Datacorp', 'Delete_Datacorp');
    Route::get('Index_Paginas_Web', 'Index_Paginas_Web');
    Route::post('Listar_Accesos_Pagina', 'Listar_Accesos_Pagina');
    Route::get('Modal_Registrar_Pagina', 'Modal_Registrar_Pagina');
    Route::get('Modal_Update_Pagina/{id}', 'Modal_Update_Pagina');
    Route::post('Registrar_Pagina', 'Registrar_Pagina');
    Route::post('Update_Pagina', 'Update_Pagina');
    Route::post('/Delete_Pagina', 'Delete_Pagina');
    Route::get('Index_Programas', 'Index_Programas');
    Route::post('Listar_Accesos_Programa', 'Listar_Accesos_Programa');
    Route::get('Modal_Registrar_Programa', 'Modal_Registrar_Programa');
    Route::get('Modal_Update_Programa/{id}', 'Modal_Update_Programa');
    Route::post('Registrar_Programa', 'Registrar_Programa');
    Route::post('Update_Programa', 'Update_Programa');
    Route::post('/Delete_Programa', 'Delete_Programa');
});
//SEGURIDAD - APERTURA Y CIERRE DE TIENDAS CONFIGURABLE
Route::controller(AperturaCierreTiendaConfController::class)->group(function () {
    Route::get('apertura_cierre_conf', 'index')->name('apertura_cierre_conf');
    Route::get('apertura_cierre_conf_ho', 'index_ho')->name('apertura_cierre_conf_ho');
    Route::get('apertura_cierre_conf_ho/list', 'list_ho')->name('apertura_cierre_conf_ho.list');
    Route::get('apertura_cierre_conf_ho/create', 'create_ho')->name('apertura_cierre_conf_ho.create');
    Route::post('apertura_cierre_conf_ho', 'store_ho')->name('apertura_cierre_conf_ho.store');
    Route::get('apertura_cierre_conf_ho/{id}/edit', 'edit_ho')->name('apertura_cierre_conf_ho.edit');
    Route::put('apertura_cierre_conf_ho/{id}', 'update_ho')->name('apertura_cierre_conf_ho.update');
    Route::delete('apertura_cierre_conf_ho/{id}', 'destroy_ho')->name('apertura_cierre_conf_ho.destroy');
    Route::get('apertura_cierre_conf_ob', 'index_ob')->name('apertura_cierre_conf_ob');
    Route::get('apertura_cierre_conf_ob/list', 'list_ob')->name('apertura_cierre_conf_ob.list');
    Route::get('apertura_cierre_conf_ob/create', 'create_ob')->name('apertura_cierre_conf_ob.create');
    Route::post('apertura_cierre_conf_ob', 'store_ob')->name('apertura_cierre_conf_ob.store');
    Route::get('apertura_cierre_conf_ob/{id}/edit', 'edit_ob')->name('apertura_cierre_conf_ob.edit');
    Route::put('apertura_cierre_conf_ob/{id}', 'update_ob')->name('apertura_cierre_conf_ob.update');
    Route::delete('apertura_cierre_conf_ob/{id}', 'destroy_ob')->name('apertura_cierre_conf_ob.destroy');
});
//SEGURIDAD - APERTURA Y CIERRE DE TIENDAS
Route::controller(AperturaCierreTiendaController::class)->group(function () {
    Route::get('apertura_cierre', 'index')->name('apertura_cierre');
    Route::get('apertura_cierre_reg', 'index_reg')->name('apertura_cierre_reg');
    Route::post('apertura_cierre_reg/list', 'list_reg')->name('apertura_cierre_reg.list');
    Route::get('apertura_cierre_reg/valida_modal', 'valida_modal_reg')->name('apertura_cierre_reg.valida_modal');
    Route::get('apertura_cierre_reg/create', 'create_reg')->name('apertura_cierre_reg.create');
    Route::post('apertura_cierre_reg/previsualizacion_captura', 'previsualizacion_captura_reg')->name('apertura_cierre_reg.previsualizacion_captura');
    Route::post('apertura_cierre_reg', 'store_reg')->name('apertura_cierre_reg.store');
    Route::get('apertura_cierre_reg/{id}/edit', 'edit_reg')->name('apertura_cierre_reg.edit');
    Route::put('apertura_cierre_reg/previsualizacion_captura', 'previsualizacion_captura_reg')->name('apertura_cierre_reg.previsualizacion_captura_put');
    Route::put('apertura_cierre_reg/{id}', 'update_reg')->name('apertura_cierre_reg.update');
    Route::get('apertura_cierre_reg/{id}/archivo', 'archivo_reg')->name('apertura_cierre_reg.archivo');
    Route::get('apertura_cierre_reg/{cod_base}/{fec_ini}/{fec_fin}/excel', 'excel_reg')->name('apertura_cierre_reg.excel');
    Route::get('apertura_cierre_img', 'index_img')->name('apertura_cierre_img');
    Route::post('apertura_cierre_img/list', 'list_img')->name('apertura_cierre_img.list');
    Route::get('apertura_cierre_img/{id}/show', 'show_img')->name('apertura_cierre_img.show');
});
//SEGURIDAD - CONTROL DE CÁMARAS CONFIGURABLE
Route::controller(ControlCamaraConfController::class)->group(function () {
    Route::get('control_camara_conf', 'index')->name('control_camara_conf');
    Route::get('control_camara_conf_se', 'index_se')->name('control_camara_conf_se');
    Route::get('control_camara_conf_se/list', 'list_se')->name('control_camara_conf_se.list');
    Route::get('control_camara_conf_se/create', 'create_se')->name('control_camara_conf_se.create');
    Route::post('control_camara_conf_se', 'store_se')->name('control_camara_conf_se.store');
    Route::get('control_camara_conf_se/{id}/edit', 'edit_se')->name('control_camara_conf_se.edit');
    Route::put('control_camara_conf_se/{id}', 'update_se')->name('control_camara_conf_se.update');
    Route::delete('control_camara_conf_se/{id}', 'destroy_se')->name('control_camara_conf_se.destroy');
    Route::get('control_camara_conf_ho', 'index_ho')->name('control_camara_conf_ho');
    Route::get('control_camara_conf_ho/list', 'list_ho')->name('control_camara_conf_ho.list');
    Route::get('control_camara_conf_ho/create', 'create_ho')->name('control_camara_conf_ho.create');
    Route::post('control_camara_conf_ho', 'store_ho')->name('control_camara_conf_ho.store');
    Route::get('control_camara_conf_ho/{id}/edit', 'edit_ho')->name('control_camara_conf_ho.edit');
    Route::put('control_camara_conf_ho/{id}', 'update_ho')->name('control_camara_conf_ho.update');
    Route::delete('control_camara_conf_ho/{id}', 'destroy_ho')->name('control_camara_conf_ho.destroy');
    Route::get('control_camara_conf_lo', 'index_lo')->name('control_camara_conf_lo');
    Route::get('control_camara_conf_lo/list', 'list_lo')->name('control_camara_conf_lo.list');
    Route::get('control_camara_conf_lo/create', 'create_lo')->name('control_camara_conf_lo.create');
    Route::post('control_camara_conf_lo', 'store_lo')->name('control_camara_conf_lo.store');
    Route::get('control_camara_conf_lo/{id}/edit', 'edit_lo')->name('control_camara_conf_lo.edit');
    Route::put('control_camara_conf_lo/{id}', 'update_lo')->name('control_camara_conf_lo.update');
    Route::delete('control_camara_conf_lo/{id}', 'destroy_lo')->name('control_camara_conf_lo.destroy');
    Route::get('control_camara_conf_ro', 'index_ro')->name('control_camara_conf_ro');
    Route::get('control_camara_conf_ro/list', 'list_ro')->name('control_camara_conf_ro.list');
    Route::get('control_camara_conf_ro/create', 'create_ro')->name('control_camara_conf_ro.create');
    Route::post('control_camara_conf_ro', 'store_ro')->name('control_camara_conf_ro.store');
    Route::get('control_camara_conf_ro/{id}/edit', 'edit_ro')->name('control_camara_conf_ro.edit');
    Route::put('control_camara_conf_ro/{id}', 'update_ro')->name('control_camara_conf_ro.update');
    Route::delete('control_camara_conf_ro/{id}', 'destroy_ro')->name('control_camara_conf_ro.destroy');
    Route::get('control_camara_conf_ti', 'index_ti')->name('control_camara_conf_ti');
    Route::get('control_camara_conf_ti/list', 'list_ti')->name('control_camara_conf_ti.list');
    Route::get('control_camara_conf_ti/create', 'create_ti')->name('control_camara_conf_ti.create');
    Route::post('control_camara_conf_ti', 'store_ti')->name('control_camara_conf_ti.store');
    Route::get('control_camara_conf_ti/{id}/edit', 'edit_ti')->name('control_camara_conf_ti.edit');
    Route::get('control_camara_conf_ti/traer_ronda_ti', 'traer_ronda_ti')->name('control_camara_conf_ti.traer_ronda');
    Route::put('control_camara_conf_ti/{id}', 'update_ti')->name('control_camara_conf_ti.update');
    Route::delete('control_camara_conf_ti/{id}', 'destroy_ti')->name('control_camara_conf_ti.destroy');
    Route::get('control_camara_conf_oc', 'index_oc')->name('control_camara_conf_oc');
    Route::get('control_camara_conf_oc/list', 'list_oc')->name('control_camara_conf_oc.list');
    Route::get('control_camara_conf_oc/create', 'create_oc')->name('control_camara_conf_oc.create');
    Route::post('control_camara_conf_oc', 'store_oc')->name('control_camara_conf_oc.store');
    Route::get('control_camara_conf_oc/{id}/edit', 'edit_oc')->name('control_camara_conf_oc.edit');
    Route::put('control_camara_conf_oc/{id}', 'update_oc')->name('control_camara_conf_oc.update');
    Route::delete('control_camara_conf_oc/{id}', 'destroy_oc')->name('control_camara_conf_oc.destroy');
    Route::get('control_camara_conf_ho_li', 'index_ho_li')->name('control_camara_conf_ho_li');
    Route::get('control_camara_conf_ho_li/list', 'list_ho_li')->name('control_camara_conf_ho_li.list');
    Route::get('control_camara_conf_ho_li/create', 'create_ho_li')->name('control_camara_conf_ho_li.create');
    Route::post('control_camara_conf_ho_li', 'store_ho_li')->name('control_camara_conf_ho_li.store');
    Route::get('control_camara_conf_ho_li/{id}/edit', 'edit_ho_li')->name('control_camara_conf_ho_li.edit');
    Route::put('control_camara_conf_ho_li/{id}', 'update_ho_li')->name('control_camara_conf_ho_li.update');
    Route::delete('control_camara_conf_ho_li/{id}', 'destroy_ho_li')->name('control_camara_conf_ho_li.destroy');
});
//SEGURIDAD - CONTROL DE CÁMARAS
Route::controller(ControlCamaraController::class)->group(function () {
    Route::get('control_camara', 'index')->name('control_camara');
    Route::get('control_camara_reg', 'index_reg')->name('control_camara_reg');
    Route::post('control_camara_reg/list', 'list_reg')->name('control_camara_reg.list');
    Route::get('control_camara_reg/create', 'create_reg')->name('control_camara_reg.create');
    Route::get('control_camara_reg/modal_ronda', 'create_round');
    Route::post('control_camara_reg/traer_hora_programada', 'traer_hora_programada_reg')->name('control_camara_reg.traer_hora_programada');
    Route::post('control_camara_reg/traer_hora_programada_lima', 'traer_hora_programada_lima_reg')->name('control_camara_reg.traer_hora_programada_lima');
    Route::post('control_camara_reg/traer_tienda', 'traer_tienda_reg')->name('control_camara_reg.traer_tienda');
    Route::post('control_camara_reg/traer_edificio_reg', 'traer_edificio_reg')->name('control_camara_reg.traer_edificio');
    Route::get('control_camara_reg/{id}/modal_imagen', 'modal_imagen_reg')->name('control_camara_reg.modal_imagen');
    Route::post('control_camara_reg/{id}/insert_imagen', 'insert_imagen_reg')->name('control_camara_reg.insert_imagen');
    Route::get('control_camara_reg/{id}/modal_ronda', 'modal_ronda_reg')->name('control_camara_reg.modal_ronda');
    Route::post('control_camara_reg/{id}/insert_ronda', 'insert_ronda_reg')->name('control_camara_reg.insert_ronda');
    Route::post('control_camara_reg/valida_captura', 'valida_captura_reg')->name('control_camara_reg.valida_captura');
    Route::post('control_camara_reg', 'store_reg')->name('control_camara_reg.store');
    Route::post('control_camara_reg/registrar_ronda', 'registrar_ronda')->name('control_camara_reg.registrar_ronda');
    Route::get('control_camara_reg/{id}/archivo', 'archivo_reg')->name('control_camara_reg.archivo');
    Route::get('control_camara_reg/{id_sede}/{id_local}/excel', 'excel_reg')->name('control_camara_reg.excel');
    Route::get('control_camara_img', 'index_img')->name('control_camara_img');
    Route::post('control_camara_img/list', 'list_img')->name('control_camara_img.list');
    Route::get('control_camara_img/{id}/show', 'show_img')->name('control_camara_img.show');
});
//SEGURIDAD - LECTURA SERVICIO CONFIGURABLE
Route::controller(LecturaServicioConfController::class)->group(function () {
    Route::get('lectura_servicio_conf', 'index')->name('lectura_servicio_conf');
    Route::get('lectura_servicio_conf_se', 'index_se')->name('lectura_servicio_conf_se');
    Route::get('lectura_servicio_conf_se/list', 'list_se')->name('lectura_servicio_conf_se.list');
    Route::get('lectura_servicio_conf_se/create', 'create_se')->name('lectura_servicio_conf_se.create');
    Route::post('lectura_servicio_conf_se', 'store_se')->name('lectura_servicio_conf_se.store');
    Route::get('lectura_servicio_conf_se/{id}/edit', 'edit_se')->name('lectura_servicio_conf_se.edit');
    Route::put('lectura_servicio_conf_se/{id}', 'update_se')->name('lectura_servicio_conf_se.update');
    Route::delete('lectura_servicio_conf_se/{id}', 'destroy_se')->name('lectura_servicio_conf_se.destroy');
    Route::get('lectura_servicio_conf_pr', 'index_pr')->name('lectura_servicio_conf_pr');
    Route::get('lectura_servicio_conf_pr/list', 'list_pr')->name('lectura_servicio_conf_pr.list');
    Route::get('lectura_servicio_conf_pr/create', 'create_pr')->name('lectura_servicio_conf_pr.create');
    Route::post('lectura_servicio_conf_pr', 'store_pr')->name('lectura_servicio_conf_pr.store');
    Route::get('lectura_servicio_conf_pr/{id}/edit', 'edit_pr')->name('lectura_servicio_conf_pr.edit');
    Route::put('lectura_servicio_conf_pr/{id}', 'update_pr')->name('lectura_servicio_conf_pr.update');
    Route::delete('lectura_servicio_conf_pr/{id}', 'destroy_pr')->name('lectura_servicio_conf_pr.destroy');
    Route::get('lectura_servicio_conf_da', 'index_da')->name('lectura_servicio_conf_da');
    Route::get('lectura_servicio_conf_da/list', 'list_da')->name('lectura_servicio_conf_da.list');
    Route::get('lectura_servicio_conf_da/create', 'create_da')->name('lectura_servicio_conf_da.create');
    Route::post('lectura_servicio_conf_da/traer_servicio_da', 'traer_servicio_da')->name('lectura_servicio_conf_da.traer_servicio');
    Route::post('lectura_servicio_conf_da/traer_proveedor_servicio_da', 'traer_proveedor_servicio_da')->name('lectura_servicio_conf_da.traer_proveedor_servicio');
    Route::post('lectura_servicio_conf_da', 'store_da')->name('lectura_servicio_conf_da.store');
    Route::get('lectura_servicio_conf_da/{id}/edit', 'edit_da')->name('lectura_servicio_conf_da.edit');
    Route::put('lectura_servicio_conf_da/{id}', 'update_da')->name('lectura_servicio_conf_da.update');
    Route::delete('lectura_servicio_conf_da/{id}', 'destroy_da')->name('lectura_servicio_conf_da.destroy');
});
//SEGURIDAD - LECTURA SERVICIO
Route::controller(LecturaServicioController::class)->group(function () {
    Route::get('lectura_servicio', 'index')->name('lectura_servicio');
    Route::get('lectura_servicio_reg', 'index_reg')->name('lectura_servicio_reg');
    Route::post('lectura_servicio_reg/list', 'list_reg')->name('lectura_servicio_reg.list');
    Route::get('lectura_servicio_reg/create', 'create_reg')->name('lectura_servicio_reg.create');
    Route::post('lectura_servicio_reg/traer_suministro', 'traer_suministro_reg')->name('lectura_servicio_reg.traer_suministro');
    Route::post('lectura_servicio_reg/traer_lectura', 'traer_lectura_reg')->name('lectura_servicio_reg.traer_lectura');
    Route::post('lectura_servicio_reg', 'store_reg')->name('lectura_servicio_reg.store');
    Route::post('lectura_servicio_reg/direct', 'store_directo_reg')->name('lectura_servicio_reg.store_directo');
    Route::get('lectura_servicio_reg/{id}/{tipo}/edit', 'edit_reg')->name('lectura_servicio_reg.edit');
    Route::get('lectura_servicio_reg/{id}/{tipo}/download', 'download_reg')->name('lectura_servicio_reg.download');
    Route::put('lectura_servicio_reg/{id}/{tipo}', 'update_reg')->name('lectura_servicio_reg.update');
    Route::put('lectura_servicio_reg/{id}/{tipo}/direct', 'update_directo_reg')->name('lectura_servicio_reg.update_directo');
    Route::get('lectura_servicio_reg/{id_servicio}/{mes}/{anio}/excel', 'excel_reg')->name('lectura_servicio_reg.excel');
    Route::get('lectura_servicio_ges', 'index_ges')->name('lectura_servicio_ges');
    Route::post('lectura_servicio_ges/list', 'list_ges')->name('lectura_servicio_ges.list');
    Route::get('lectura_servicio_ges/create', 'create_ges')->name('lectura_servicio_ges.create');
    Route::post('lectura_servicio_ges/traer_suministro', 'traer_suministro_reg')->name('lectura_servicio_ges.traer_suministro');
    Route::post('lectura_servicio_ges/traer_lectura', 'traer_lectura_reg')->name('lectura_servicio_ges.traer_lectura');
    Route::post('lectura_servicio_ges', 'store_reg')->name('lectura_servicio_ges.store');
    Route::post('lectura_servicio_ges/direct', 'store_directo_reg')->name('lectura_servicio_ges.store_directo');
    Route::get('lectura_servicio_ges/{id}/{tipo}/edit', 'edit_ges')->name('lectura_servicio_ges.edit');
    Route::get('lectura_servicio_ges/{id}/{tipo}/download', 'download_reg')->name('lectura_servicio_ges.download');
    Route::put('lectura_servicio_ges/{id}/{tipo}', 'update_reg')->name('lectura_servicio_ges.update');
    Route::put('lectura_servicio_ges/{id}/{tipo}/direct', 'update_directo_reg')->name('lectura_servicio_ges.update_directo');
    Route::delete('lectura_servicio_ges/{id}', 'destroy_ges')->name('lectura_servicio_ges.destroy');
    Route::get('lectura_servicio_ges/{id_servicio}/{cod_base}/{mes}/{anio}/excel', 'excel_ges')->name('lectura_servicio_ges.excel');
});

//SEGURIDAD - OCURRENCIA SERVICIO CONFIGURABLE
Route::controller(OcurrenciaServicioConfController::class)->group(function () {
    Route::get('ocurrencia_conf', 'index')->name('ocurrencia_conf');
    Route::get('ocurrencia_conf_go', 'index_go')->name('ocurrencia_conf_go');
    Route::get('ocurrencia_conf_go/list', 'list_go')->name('ocurrencia_conf_go.list');
    Route::get('ocurrencia_conf_go/create', 'create_go')->name('ocurrencia_conf_go.create');
    Route::post('ocurrencia_conf_go', 'store_go')->name('ocurrencia_conf_go.store');
    Route::get('ocurrencia_conf_go/{id}/edit', 'edit_go')->name('ocurrencia_conf_go.edit');
    Route::put('ocurrencia_conf_go/{id}', 'update_go')->name('ocurrencia_conf_go.update');
    Route::delete('ocurrencia_conf_go/{id}', 'destroy_go')->name('ocurrencia_conf_go.destroy');
    Route::get('ocurrencia_conf_co', 'index_co')->name('ocurrencia_conf_co');
    Route::get('ocurrencia_conf_co/list', 'list_coc')->name('ocurrencia_conf_co.list');
    Route::get('ocurrencia_conf_co/create', 'create_co')->name('ocurrencia_conf_co.create');
    Route::post('ocurrencia_conf_co', 'store_co')->name('ocurrencia_conf_co.store');
    Route::get('ocurrencia_conf_co/{id}/edit', 'edit_co')->name('ocurrencia_conf_co.edit');
    Route::put('ocurrencia_conf_co/{id}', 'update_co')->name('ocurrencia_conf_co.update');
    Route::delete('ocurrencia_conf_co/{id}', 'destroy_co')->name('ocurrencia_conf_co.destroy');
    Route::get('ocurrencia_conf_to', 'index_to')->name('ocurrencia_conf_to');
    Route::get('ocurrencia_conf_to/list', 'list_to')->name('ocurrencia_conf_to.list');
    Route::get('ocurrencia_conf_to/create', 'create_to')->name('ocurrencia_conf_to.create');
    Route::post('ocurrencia_conf_to', 'store_to')->name('ocurrencia_conf_to.store');
    Route::get('ocurrencia_conf_to/{id}/edit', 'edit_to')->name('ocurrencia_conf_to.edit');
    Route::put('ocurrencia_conf_to/{id}', 'update_to')->name('ocurrencia_conf_to.update');
    Route::delete('ocurrencia_conf_to/{id}', 'destroy_to')->name('ocurrencia_conf_to.destroy');
});


//CONTROL INTERNO - PRECIO SUGERIDO CONFIGURABLE
Route::controller(PrecioSugeridoConfController::class)->group(function () {
    Route::get('precio_sugerido_conf', 'index')->name('precio_sugerido_conf');
    Route::get('precio_sugerido_conf_un', 'index_un')->name('precio_sugerido_conf_un');
    Route::get('precio_sugerido_conf_un/list', 'list_un')->name('precio_sugerido_conf_un.list');
    Route::get('precio_sugerido_conf_un/create', 'create_un')->name('precio_sugerido_conf_un.create');
    Route::post('precio_sugerido_conf_un', 'store_un')->name('precio_sugerido_conf_un.store');
    Route::get('precio_sugerido_conf_un/{id}/edit', 'edit_un')->name('precio_sugerido_conf_un.edit');
    Route::put('precio_sugerido_conf_un/{id}', 'update_un')->name('precio_sugerido_conf_un.update');
    Route::delete('precio_sugerido_conf_un/{id}', 'destroy_un')->name('precio_sugerido_conf_un.destroy');
    Route::get('precio_sugerido_conf_do', 'index_do')->name('precio_sugerido_conf_do');
    Route::get('precio_sugerido_conf_do/list', 'list_do')->name('precio_sugerido_conf_do.list');
    Route::get('precio_sugerido_conf_do/create', 'create_do')->name('precio_sugerido_conf_do.create');
    Route::post('precio_sugerido_conf_do', 'store_do')->name('precio_sugerido_conf_do.store');
    Route::get('precio_sugerido_conf_do/{id}/edit', 'edit_do')->name('precio_sugerido_conf_do.edit');
    Route::put('precio_sugerido_conf_do/{id}', 'update_do')->name('precio_sugerido_conf_do.update');
    Route::delete('precio_sugerido_conf_do/{id}', 'destroy_do')->name('precio_sugerido_conf_do.destroy');
    Route::get('precio_sugerido_conf_tr', 'index_tr')->name('precio_sugerido_conf_tr');
    Route::get('precio_sugerido_conf_tr/list', 'list_tr')->name('precio_sugerido_conf_tr.list');
    Route::get('precio_sugerido_conf_tr/create', 'create_tr')->name('precio_sugerido_conf_tr.create');
    Route::post('precio_sugerido_conf_tr', 'store_tr')->name('precio_sugerido_conf_tr.store');
    Route::get('precio_sugerido_conf_tr/{id}/edit', 'edit_tr')->name('precio_sugerido_conf_tr.edit');
    Route::put('precio_sugerido_conf_tr/{id}', 'update_tr')->name('precio_sugerido_conf_tr.update');
    Route::delete('precio_sugerido_conf_tr/{id}', 'destroy_tr')->name('precio_sugerido_conf_tr.destroy');
});
//SEGURIDAD - ASISTENCIA
Route::controller(AsistenciaSegController::class)->group(function () {
    Route::get('asistencia_seg', 'index')->name('asistencia_seg');
    Route::get('asistencia_seg_lec', 'index_lec')->name('asistencia_seg_lec');
    Route::post('asistencia_seg_lec/list', 'list_lec')->name('asistencia_seg_lec.list');
    Route::post('asistencia_seg_lec', 'store_lec')->name('asistencia_seg_lec.store');
    Route::get('asistencia_seg_lec/{id}/{tipo}/edit', 'edit_lec')->name('asistencia_seg_lec.edit');
    Route::put('asistencia_seg_lec/{id}/{tipo}', 'update_lec')->name('asistencia_seg_lec.update');
    Route::get('asistencia_seg_lec/{id}/image', 'image_lec')->name('asistencia_seg_lec.image');
    Route::get('asistencia_seg_lec/{id}/download', 'download_lec')->name('asistencia_seg_lec.download');
    Route::put('asistencia_seg_lec/{id}', 'update_image_lec')->name('asistencia_seg_lec.update_image');
    Route::delete('asistencia_seg_lec/{id}', 'destroy_lec')->name('asistencia_seg_lec.destroy');
    Route::get('asistencia_seg_lec/excel', 'excel_lec')->name('asistencia_seg_lec.excel');
    Route::get('asistencia_seg_man', 'index_man')->name('asistencia_seg_man');
    Route::post('asistencia_seg_man/list', 'list_man')->name('asistencia_seg_man.list');
    Route::post('asistencia_seg_man/traer_colaborador', 'traer_colaborador_man')->name('asistencia_seg_man.traer_colaborador');
    Route::get('asistencia_seg_man/create', 'create_man')->name('asistencia_seg_man.create');
    Route::post('asistencia_seg_man', 'store_man')->name('asistencia_seg_man.store');
    Route::get('asistencia_seg_man/{id}/{tipo}/edit', 'edit_man')->name('asistencia_seg_man.edit');
    Route::get('asistencia_seg_man/{id}/image', 'image_man')->name('asistencia_seg_man.image');
    Route::get('asistencia_seg_man/{id}/obs', 'obs_man')->name('asistencia_seg_man.obs');
    Route::put('asistencia_seg_man/{id}', 'update_obs_man')->name('asistencia_seg_man.update_obs');
    Route::get('asistencia_seg_man/{cod_base}/{id_colaborador}/{inicio}/{fin}/excel', 'excel_man')->name('asistencia_seg_man.excel');
});
//RECURSOS HUMANOS - POSTULANTE
Route::controller(PostulanteController::class)->group(function () {
    //POSTULANTE
    Route::get('postulante', 'index')->name('postulante');
    Route::get('postulante_reg', 'index_reg')->name('postulante_reg');
    Route::get('postulante_tod', 'index_tod')->name('postulante_tod');
    Route::post('postulante_tod/list', 'list_tod')->name('postulante_tod.list');
    Route::put('postulante_tod/{id}', 'update_tod')->name('postulante_tod.update');
    Route::get('postulante_tod/{cod_base}/{id_colaborador}/{inicio}/{fin}/excel', 'excel_tod')->name('postulante_tod.excel');
    //REVISIÓN
    Route::get('postulante_revision', 'index_prev')->name('postulante_revision');
    Route::post('postulante_revision/list', 'list_prev')->name('postulante_revision.list');
    Route::get('postulante_revision/{id}/edit', 'edit_prev')->name('postulante_revision.edit');
    Route::put('postulante_revision/{id}', 'update_prev')->name('postulante_revision.update');
});
//ÁREA LOGÍSTICA
Route::controller(LogisticaInicioController::class)->group(function(){
    Route::get('logistica', 'index')->name('logistica');
});
//ÁREA CAJA
Route::controller(CajaInicioController::class)->group(function(){
    Route::get('caja', 'index')->name('caja');
});
//CAJA - OBSERVACIONES
Route::controller(ObservacionController::class)->group(function(){
    Route::get('observacion', 'index_reg')->name('observacion');
    Route::post('observacion/list', 'list_reg')->name('observacion.list');
    Route::get('observacion/create', 'create_reg')->name('observacion.create');
    Route::post('observacion/traer_error', 'traer_error_reg')->name('observacion.traer_error');
    Route::post('observacion/traer_datos_error', 'traer_datos_error_reg')->name('observacion.traer_datos_error');
    Route::post('observacion/traer_responsable', 'traer_responsable_reg')->name('observacion.traer_responsable');
    Route::post('observacion', 'store_reg')->name('observacion.store');
    Route::get('observacion/{id}/edit', 'edit_reg')->name('observacion.edit');
    Route::get('observacion/{id}/download', 'download_reg')->name('observacion.download');
    Route::put('observacion/{id}', 'update_reg')->name('observacion.update');
    Route::get('observacion/{id}/cambiar_estado', 'cambiar_estado_reg')->name('observacion.cambiar_estado');
    Route::delete('observacion/{id}', 'destroy_reg')->name('observacion.destroy');
    Route::get('observacion/{cod_base}/{id_colaborador}/{inicio}/{fin}/excel', 'excel_reg')->name('observacion.excel');
});
//CAJA - OBSERVACIONES CONFIGURABLE
Route::controller(ObservacionConfController::class)->group(function(){
    Route::get('observacion_conf', 'index')->name('observacion_conf');
    Route::get('observacion_conf_terr', 'index_terr')->name('observacion_conf_terr');
    Route::get('observacion_conf_terr/list', 'list_terr')->name('observacion_conf_terr.list');
    Route::get('observacion_conf_terr/create', 'create_terr')->name('observacion_conf_terr.create');
    Route::post('observacion_conf_terr', 'store_terr')->name('observacion_conf_terr.store');
    Route::get('observacion_conf_terr/{id}/edit', 'edit_terr')->name('observacion_conf_terr.edit');
    Route::put('observacion_conf_terr/{id}', 'update_terr')->name('observacion_conf_terr.update');
    Route::delete('observacion_conf_terr/{id}', 'destroy_terr')->name('observacion_conf_terr.destroy');
    Route::get('observacion_conf_err', 'index_err')->name('observacion_conf_err');
    Route::get('observacion_conf_err/list', 'list_err')->name('observacion_conf_err.list');
    Route::get('observacion_conf_err/create', 'create_err')->name('observacion_conf_err.create');
    Route::post('observacion_conf_err', 'store_err')->name('observacion_conf_err.store');
    Route::get('observacion_conf_err/{id}/edit', 'edit_err')->name('observacion_conf_err.edit');
    Route::put('observacion_conf_err/{id}', 'update_err')->name('observacion_conf_err.update');
    Route::delete('observacion_conf_err/{id}', 'destroy_err')->name('observacion_conf_err.destroy');
});






//CUADRO CONTROL VISUAL ADMINISTRACION
Route::controller(TablaCuadroControlVisualController::class)->group(function () {
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
Route::controller(CuadroControlVisualController::class)->group(function () {
    //------------------------------CCV------------------------------------//
    Route::get('Cuadro_Control_Visual_Vista', 'Cuadro_Control_Visual_Vista')->name('Cuadro_Control_Visual_Vista');
    Route::post('Lista_Cuadro_Control_Visual_Vista', 'Lista_Cuadro_Control_Visual_Vista');
    Route::post('/Insert_Cuadro_Control_Visual_Estado', 'Insert_Cuadro_Control_Visual_Estado');
    Route::post('/Insert_Cuadro_Control_Visual_Estado1', 'Insert_Cuadro_Control_Visual_Estado1');
});























Route::controller(PuestoController::class)->group(function () {
    Route::get('Traer_Puesto_Cargo_Colaborador', 'Traer_Puesto_Cargo_Colaborador');
});
//ASISTENCIA
Route::controller(AsistenciaController::class)->group(function () {
    //------------------------------CCV------------------------------------//
    Route::get('Reporte_Control_Asistencia', 'index')->name('Reporte_Control_Asistencia');
    Route::post('Buscar_Reporte_Control_Asistencia', 'Buscar_Reporte_Control_Asistencia');
    // Route::post('/Insert_Cuadro_Control_Visual_Estado', 'Insert_Cuadro_Control_Visual_Estado');
    // Route::post('/Insert_Cuadro_Control_Visual_Estado1', 'Insert_Cuadro_Control_Visual_Estado1');
});
//AMONESTACION
Route::controller(AmonestacionController::class)->group(function () {
    //------------------------------AMONESTACIONES------------------------------------//
    Route::get('Amonestacion', 'Amonestacion')->name('Amonestacion');
    Route::get('Amonestaciones_Emitidas', 'Amonestaciones_Emitidas')->name('Amonestaciones_Emitidas');
    Route::get('Amonestaciones_Recibidas', 'Amonestaciones_Recibidas')->name('Amonestaciones_Recibidas');
    Route::post('Lista_Amonestaciones_Emitidas', 'Lista_Amonestaciones_Emitidas')->name('Lista_Amonestaciones_Emitidas');
    Route::post('Lista_Amonestaciones_Recibidas', 'Lista_Amonestaciones_Recibidas');
    Route::get('/Modal_Amonestacion', 'Modal_Amonestacion');
    Route::get('/Modal_Update_Amonestacion/{id}/{num}', 'Modal_Update_Amonestacion');
    Route::post('/Insert_Amonestacion', 'Insert_Amonestacion');
    Route::post('/Update_Amonestacion', 'Update_Amonestacion');
    Route::post('/Delete_Amonestacion', 'Delete_Amonestacion');
    Route::get('/Modal_Documento_Amonestacion/{id}', 'Modal_Documento_Amonestacion');
    Route::get('Pdf_Amonestacion/{id}', 'Pdf_Amonestacion');
    Route::post('/Update_Documento_Amonestacion', 'Update_Documento_Amonestacion');
    Route::post('Aprobacion_Amonestacion', 'Aprobacion_Amonestacion');
});
Route::controller(ComunicadoController::class)->group(function () {
    Route::get('Comunicado', 'Index')->name('Comunicado');
    Route::get('Cargar_Slider_Rrhh', 'Cargar_Slider_Rrhh')->name('Cargar_Slider_Rrhh');
    Route::post('Lista_Slider_Rrhh', 'Lista_Slider_Rrhh')->name('Lista_Slider_Rrhh');
    Route::get('/Modal_Slider_Rrhh', 'Modal_Slider_Rrhh');
    Route::get('/Modal_Update_Slider_Rrhh/{id}', 'Modal_Update_Slider_Rrhh');
    Route::post('/Insert_Slider_Rrhh', 'Insert_Slider_Rrhh');
    Route::post('/Update_Slider_Rrhh', 'Update_Slider_Rrhh');
    Route::post('/Delete_Slider_Rrhh', 'Delete_Slider_Rrhh');
    Route::get('/Cargar_Anuncio_Intranet', 'Cargar_Anuncio_Intranet');
    Route::post('Lista_Anuncio_Intranet', 'Lista_Anuncio_Intranet');
    Route::get('Modal_Anuncio_Intranet', 'Modal_Anuncio_Intranet');
    Route::post('Insert_Anuncio_Intranet', 'Insert_Anuncio_Intranet');
    Route::get('Modal_Update_Anuncio_Intranet/{id}', 'Modal_Update_Anuncio_Intranet');
    Route::post('Update_Anuncio_Intranet', 'Update_Anuncio_Intranet');
    Route::post('Delete_Anuncio_Intranet', 'Delete_Anuncio_Intranet');
});
Route::controller(SliderRRHH::class)->group(function () {
    Route::get('/SliderRRHH/{base}', 'Slider_Vista_RRHH')->name('slider_rrhh');
    Route::get('/SliderRRHH', 'Slider_Vista_Tienda')->name('slider_tienda');
    Route::get('/Slider/{method}', 'remap');
});
Route::controller(Cumpleanios::class)->group(function () {
    Route::get('/RecursosHumanos/Cumpleanios/index', 'index');
    Route::get('/RecursosHumanos/Buscar_Cumpleanios', 'Buscar_Cumpleanios');
    Route::get('/RecursosHumanos/Modal_Lista_Saludo_Cumpleanio/{id}', 'Modal_Lista_Saludo_Cumpleanio');
    Route::post('/RecursosHumanos/Aprobar_Saludo_Cumpleanio', 'Aprobar_Saludo_Cumpleanio');
    Route::get('/RecursosHumanos/List_Saludo_cumpleanio', 'List_Saludo_cumpleanio');
    Route::get('/RecursosHumanos/Excel_Saludo_Cumpleanio/{id}', 'Excel_Saludo_Cumpleanio');
});
//SLIDER INICIO
Route::controller(InicioAdmController::class)->group(function () {
    Route::get('Inicio/index', 'index');
    Route::post('Inicio/Slider_Inicio_Listar', 'Slider_Inicio_Listar');
    Route::get('Inicio/Modal_Update_Slider_Inicio/{id}', 'Modal_Update_Slider_Inicio');
    Route::post('Inicio/Update_Slider_Inicio', 'Update_Slider_Inicio');
});
//FRASES INICIO
Route::controller(InicioFrasesAdmController::class)->group(function () {
    Route::get('Inicio/index_frases', 'index');
    Route::post('Inicio/Frases_Inicio_Listar', 'Frases_Inicio_Listar');
    Route::get('Inicio/Modal_Update_Frases_Inicio/{id}', 'Modal_Update_Frases_Inicio');
    Route::post('Inicio/Update_Frase_Inicio', 'Update_Frase_Inicio');
    Route::get('Inicio/Modal_Registrar_Frases_Inicio', 'Modal_Registrar_Frases_Inicio');
    Route::post('Inicio/Registrar_Frase_Inicio', 'Registrar_Frase_Inicio');
    Route::post('Inicio/Delete_Frase', 'Delete_Frase');
});

//INTENCION DE RENUNCIA
Route::controller(IntencionRenunciaConfController::class)->group(function () {
    Route::get('IntencionRenunciaConfController/index', 'index');/*
    Route::post('Inicio/Frases_Inicio_Listar', 'Frases_Inicio_Listar');
    Route::get('Inicio/Modal_Update_Frases_Inicio/{id}', 'Modal_Update_Frases_Inicio');
    Route::post('Inicio/Update_Frase_Inicio', 'Update_Frase_Inicio');
    Route::get('Inicio/Modal_Registrar_Frases_Inicio', 'Modal_Registrar_Frases_Inicio');
    Route::post('Inicio/Registrar_Frase_Inicio', 'Registrar_Frase_Inicio');
    Route::post('Inicio/Delete_Frase', 'Delete_Frase');*/
});
//Ocurrencias
Route::controller(OcurrenciasTiendaController::class)->group(function () {
    Route::get('OcurrenciaTienda/index', 'Ocurrencia_Tienda');
    Route::post('OcurrenciaTienda/ListaOcurrencia/{base}/{fec_ini}/{fec_fin}/{tipo}/{colaborador}', 'ListaOcurrencia');
    Route::get('OcurrenciaTienda/Modal_Ocurrencia_Tienda_Admin', 'Modal_Ocurrencia_Tienda_Admin');
    Route::post('OcurrenciaTienda/Insert_Ocurrencia_Tienda_Admin', 'Insert_Ocurrencia_Tienda_Admin');
    Route::get('OcurrenciaTienda/Modal_Update_Ocurrencia_Tienda_Admin/{id}', 'Modal_Update_Ocurrencia_Tienda_Admin');
    Route::post('OcurrenciaTienda/Buscar_Tipo_Ocurrencia/', 'Buscar_Tipo_Ocurrencia')->name('OcurrenciaTienda/Buscar_Tipo_Ocurrencia');
    Route::post('OcurrenciaTienda/Tipo_Piocha', 'Tipo_Piocha');
    Route::post('OcurrenciaTienda/DeleteOcurrencia', 'Delete_Ocurrencia');
    Route::post('OcurrenciaTienda/Update_Ocurrencia_Tienda', 'Update_Ocurrencia_Tienda');
    Route::post('OcurrenciaTienda/Confirmar_Revision_Ocurrencia', 'Confirmar_Revision_Ocurrencia');
    Route::get('Corporacion/Excel_Ocurrencia/{cod_base}/{fecha_inicio}/{fecha_fin}/{tipo_ocurrencia}/{colaborador}', 'Excel_Ocurrencia');
    Route::get('OcurrenciaTienda/Descargar_Archivo_Ocurrencia/{id}', 'Descargar_Archivo_Ocurrencia');
    Route::post('OcurrenciaTienda/Delete_Archivo_Ocurrencia', 'Delete_Archivo_Ocurrencia');
});
//Reporte Proveedores
Route::controller(ReporteProveedoresController::class)->group(function () {
    Route::get('RProveedores/index', 'RProveedores');
    Route::post('RProveedores/Buscar_RProveedor', 'Buscar_RProveedor');
    Route::post('RProveedores/Actualizar_Hora_RProveedor', 'Actualizar_Hora_RProveedor');
    Route::get('RProveedores/Excel_RProveedor/{base}/{estado_interno}/{fecha_inicio}/{fecha_fin}', 'Excel_RProveedor');
});

use App\Http\Controllers\InicioSeguridadController;
//Inicio Seguridad
Route::controller(InicioSeguridadController::class)->group(function(){
    Route::get('InicioSeguridad/index', 'index')->name('seguridad');
});
use App\Http\Controllers\InicioTiendaController;
//Inicio tienda
Route::controller(InicioTiendaController::class)->group(function(){
    Route::get('InicioTienda/index', 'index')->name('tienda');
});
use App\Http\Controllers\SliderMarketingController;
//Slider Marketing
Route::controller(SliderMarketingController::class)->group(function(){
    Route::get('Marketing/Slider_List_Comercial', 'index');
    Route::post('Marketing/Buscar_RProveedor', 'Buscar_RProveedor');
    Route::post('Marketing/Actualizar_Hora_RProveedor', 'Actualizar_Hora_RProveedor');
    Route::get('Marketing/Excel_RProveedor/{base}/{estado_interno}/{fecha_inicio}/{fecha_fin}', 'Excel_RProveedor');
});























