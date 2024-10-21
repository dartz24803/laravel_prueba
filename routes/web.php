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
use App\Http\Controllers\BiReporteController;
use App\Http\Controllers\BiReporteDepartamentoController;
use App\Http\Controllers\CajaChicaConfController;
use App\Http\Controllers\CajaChicaController;
use App\Http\Controllers\CajaInicioController;
use App\Http\Controllers\CambioPrendaConfController;
use App\Http\Controllers\CambioPrendaController;
use App\Http\Controllers\CapacitacionCajeroController;
use App\Http\Controllers\CargaInventarioController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\ColaboradorConfController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\ComunicadoController;
use App\Http\Controllers\ConsumibleConfController;
use App\Http\Controllers\ConsumibleController;
use App\Http\Controllers\ControlCamaraConfController;
use App\Http\Controllers\ControlCamaraController;
use App\Http\Controllers\SliderRRHH;
use App\Http\Controllers\Cumpleanios;
use App\Http\Controllers\DuracionTransaccionController;
use App\Http\Controllers\ErroresPickingConfController;
use App\Http\Controllers\ErroresPickingController;
use App\Http\Controllers\FinanzaInicioController;
use App\Http\Controllers\FinanzasInicioController;
use App\Http\Controllers\InicioAdmController;
use App\Http\Controllers\InicioFrasesAdmController;
use App\Http\Controllers\InsumoConfController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\LecturaServicioConfController;
use App\Http\Controllers\LecturaServicioController;
use App\Http\Controllers\PrecioSugeridoConfController;
use App\Http\Controllers\IntencionRenunciaConfController;
use App\Http\Controllers\InternaInicioController;
use App\Http\Controllers\LetraCobrarController;
use App\Http\Controllers\LineaCarreraConfController;
use App\Http\Controllers\LineaCarreraController;
use App\Http\Controllers\LogisticaInicioController;
use App\Http\Controllers\ManufacturaController;
use App\Http\Controllers\ManufacturaInicioController;
use App\Http\Controllers\MercaderiaEnviarFotografia;
use App\Http\Controllers\NotificacionConfController;
use App\Http\Controllers\ObservacionConfController;
use App\Http\Controllers\ObservacionController;
use App\Http\Controllers\OcurrenciaServicioConfController;



use App\Http\Controllers\OcurrenciasTiendaController;
use App\Http\Controllers\PostulanteController;
use App\Http\Controllers\ProcesosController;
use App\Http\Controllers\ProduccionController;
use App\Http\Controllers\RecursosHumanosInicioController;
use App\Http\Controllers\RegistroChequeConfController;
use App\Http\Controllers\RegistroChequeController;
use App\Http\Controllers\RegistroLetraController;
use App\Http\Controllers\RegistroServicioController;
use App\Http\Controllers\ReporteProveedoresController;
use App\Http\Controllers\RequisicionTiendaConfController;
use App\Http\Controllers\RequisicionTiendaController;
use App\Http\Controllers\SalidaInsumoController;
use App\Http\Controllers\SoporteConfController;
use App\Http\Controllers\SoporteController;
use App\Http\Controllers\StockInfosapController;
use App\Http\Controllers\TablaMaestraTesoreriaController;

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
    Route::get('tracking', 'index')->name('tracking');
    //SUBIDA DE ARCHIVOS
    Route::post('tracking/list_archivo', 'list_archivo')->name('tracking.list_archivo');
    Route::post('tracking/previsualizacion_captura', 'previsualizacion_captura')->name('tracking.previsualizacion_captura');
    Route::delete('tracking/{id}/delete_archivo_temporal', 'delete_archivo_temporal')->name('tracking.delete_archivo_temporal');
    //FIN SUBIDA ARCHIVOS
    Route::get('tracking/index', 'index_tra')->name('tracking_index');
    Route::get('tracking/iniciar_tracking', 'iniciar_tracking')->name('tracking.iniciar_tracking');
    Route::get('tracking/llegada_tienda', 'llegada_tienda')->name('tracking.llegada_tienda');
    Route::post('tracking/list', 'list')->name('tracking.list');
    Route::get('tracking/create', 'create')->name('tracking.create');
    Route::post('tracking', 'store')->name('tracking.store');
    Route::get('tracking/detalle_transporte_inicial', 'detalle_transporte_inicial')->name('tracking.detalle_transporte_inicial');
    Route::post('tracking/insert_detalle_transporte_inicial', 'insert_detalle_transporte_inicial')->name('tracking.insert_detalle_transporte_inicial');
    Route::get('tracking/{id}/detalle_transporte', 'detalle_transporte')->name('tracking.detalle_transporte');
    Route::post('tracking/{id}/insert_detalle_transporte', 'insert_detalle_transporte')->name('tracking.insert_detalle_transporte');
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
    Route::post('tracking/{id}/validacion_diferencia', 'validacion_diferencia')->name('tracking.validacion_diferencia');
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
    Route::get('tracking/{cod_base}/mercaderia_nueva_tusu', 'mercaderia_nueva_tusu')->name('tracking.mercaderia_nueva_tusu');
    Route::get('tracking/{cod_base}/mercaderia_nueva_tpre', 'mercaderia_nueva_tpre')->name('tracking.mercaderia_nueva_tpre');
    Route::get('tracking/{cod_base}/{estilo}/modal_mercaderia_nueva', 'modal_mercaderia_nueva')->name('tracking.modal_mercaderia_nueva');
    //BD TRACKING
    Route::get('tracking_bd', 'index_bd')->name('tracking_bd');
    Route::post('tracking_bd/list', 'list_bd')->name('tracking_bd.list');
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




//STOCK INFOSAP
Route::controller(StockInfosapController::class)->group(function () {
    Route::get('infosapstock', 'index')->name('infosapstock');
    Route::get('infosapstock/list', 'list_infosap')->name('infosapstock.list');
});



// CARGA DE INVENTARIOS
Route::controller(CargaInventarioController::class)->group(function () {
    Route::get('cargainventario', 'index')->name('cargainventario');
    Route::get('cargainventario/list', 'list_ci')->name('cargainventario.list');
    Route::get('cargainventario/{id}/edit', 'edit_ci')->name('cargainventario.edit');
    Route::get('cargainventario/create', 'create_ci')->name('cargainventario.create');
    Route::post('cargainventario/{id}/destroy', 'destroy_ci')->name('cargainventario.destroy');
    Route::post('cargainventario/store', 'store_ci')->name('cargainventario.store');
    Route::post('cargainventario/{id}', 'update_ci')->name('cargainventario.update');

    Route::get('cargainventario/formato', 'formato_carga_inventario')->name('cargainventario.formato');
});

// CONSUMIBLES
Route::controller(ConsumibleController::class)->group(function () {
    Route::get('consumible', 'index')->name('consumible');
    Route::get('consumible/list', 'list_cons')->name('consumible.list');
    Route::get('consumible/{id}/edit', 'edit_cons')->name('consumible.edit');
    Route::get('consumible/create', 'create_cons')->name('consumible.create');
    Route::delete('consumible/{id}', 'destroy_cons')->name('consumible.destroy');
    Route::post('consumible/store', 'store_cons')->name('consumible.store');
    Route::post('consumible/{id}', 'update_cons')->name('consumible.update');
});

// MERCADERIA FOTOGRAFICA
Route::controller(MercaderiaEnviarFotografia::class)->group(function () {
    Route::get('mercaderiafotografia', 'index')->name('mercaderiafotografia');
    Route::get('mercaderiafotografia/list', 'list_merc_foto')->name('mercaderiafotografia.list');
    Route::get('mercaderiafotografia/{id}/edit', 'edit_merc_foto')->name('mercaderiafotografia.edit');
    Route::get('mercaderiafotografia/create', 'create_merc_foto')->name('mercaderiafotografia.create');
    Route::post('mercaderiafotografia/store', 'store_merc_foto')->name('mercaderiafotografia.store');
    Route::post('mercaderiafotografia/delete', 'delete_merc_foto')->name('mercaderiafotografia.delete');

    Route::post('mercaderiafotografia/enviar_oficina', 'enviar_oficina')->name('mercaderiafotografia.enviar_oficina');
    Route::get('mercaderiafotografia/formato', 'formato_mercaderia_fotografica')->name('mercaderiafotografia.formato');
    Route::get('mercaderiafotografia/requerimiento_surtido', 'requerimiento_surtido')->name('mercaderiafotografia.requerimiento_surtido');

    Route::post('mercaderiafotografia/{id}', 'update_merc_foto')->name('mercaderiafotografia.update');
});


Route::controller(ConsumibleConfController::class)->group(function () {
    // ADMINISTRABLE ARTICULO
    Route::get('consumible_art', 'index_cons')->name('consumible_art');
    Route::get('consumibleart', 'indexart')->name('consumibleart');
    Route::get('consumible_art/list', 'list_art')->name('consumible_art.list');
    Route::get('consumible_art/{id}/edit', 'edit_art')->name('consumible_art.edit');
    Route::get('consumible_art/create', 'create_art')->name('consumible_art.create');
    Route::delete('consumible_art/{id}', 'destroy_art')->name('consumible_art.destroy');
    Route::post('consumible_art/store', 'store_art')->name('consumible_art.store');
    Route::post('consumible_art/{id}', 'update_art')->name('consumible_art.update');


    // ADMINISTRABLE UNIDAD
    Route::get('consumibleuni', 'indexuni')->name('consumibleuni');
    Route::get('consumible_uni/list', 'list_uni')->name('consumible_uni.list');
    Route::get('consumible_uni/{id}/edit', 'edit_uni')->name('consumible_uni.edit');
    Route::get('consumible_uni/create', 'create_uni')->name('consumible_uni.create');
    Route::delete('consumible_uni/{id}', 'destroy_uni')->name('consumible_uni.destroy');
    Route::post('consumible_uni/store', 'store_uni')->name('consumible_uni.store');
    Route::post('consumible_uni/{id}', 'update_uni')->name('consumible_uni.update');
});


//ERRORES PICKING
Route::controller(ErroresPickingController::class)->group(function () {
    Route::get('errorespicking', 'index')->name('errorespicking');
    Route::get('errorespicking/list', 'list_le')->name('errorespicking.list');
    Route::get('errorespicking/{id}/edit', 'edit_le')->name('errorespicking.edit');
    Route::get('errorespicking/create', 'create_le')->name('errorespicking.create');
    Route::get('errorespicking/vercontenido', 'ver_le')->name('errorespicking.vercontenido');
    Route::delete('errorespicking/{id}', 'destroy_le')->name('errorespicking.destroy');
    Route::post('errorespicking/store', 'store_le')->name('errorespicking.store');
    Route::post('errorespicking/{id}', 'update_le')->name('errorespicking.update');
    Route::get('errorespicking/{id}/ver', 'ver_le')->name('errorespicking.ver');
});


Route::controller(ErroresPickingConfController::class)->group(function () {
    // ADMINISTRABLE TALLA
    Route::get('errorespickingta_conf', 'index')->name('errorespickingta_conf');
    Route::get('errorespickingta', 'indexerpi')->name('errorespickingta');
    Route::get('errorespicking_ta/list', 'list_ta')->name('errorespicking_ta.list');
    Route::get('errorespicking_ta/{id}/edit', 'edit_ta')->name('errorespicking_ta.edit');
    Route::get('errorespicking_ta/create', 'create_ta')->name('errorespicking_ta.create');
    Route::delete('errorespicking_ta/{id}', 'destroy_ta')->name('errorespicking_ta.destroy');
    Route::post('errorespicking_ta/store', 'store_ta')->name('errorespicking_ta.store');
    Route::post('errorespicking_ta/{id}', 'update_ta')->name('errorespicking_ta.update');
});






//PROCESOS - ADMINISTRADOR
Route::controller(ProcesosController::class)->group(function () {
    Route::get('portalprocesos', 'index')->name('portalprocesos');
    Route::get('portalprocesos_lm', 'index_lm')->name('portalprocesos_lm');
    Route::get('portalprocesos_lm/list', 'list_lm')->name('portalprocesos_lm.list');
    Route::get('portalprocesos_lm/create', 'create_lm')->name('portalprocesos_lm.create');
    Route::get('portalprocesos_lm/{cod_base}/{fec_ini}/{fec_fin}/excel', 'excel_lm')->name('portalprocesos_lm.excel');
    Route::get('portalprocesos_lm/store', 'store_lm')->name('portalprocesos_lm.store');
    Route::get('portalprocesos_lm/{id}/image', 'image_lm')->name('portalprocesos_lm.image');
    Route::delete('portalprocesos_lm/{id}', 'destroy_lm')->name('portalprocesos_lm.destroy');
    Route::post('portalprocesos_lm/{id}', 'approve_lm')->name('portalprocesos_lm.approve');
    Route::get('portalprocesos_lm/{id}/edit', 'edit_lm')->name('portalprocesos_lm.edit');
    Route::put('portalprocesos_lm/{id}/version', 'version_lm')->name('portalprocesos_lm.version');
    Route::put('portalprocesos_lm/{id}', 'update_lm')->name('portalprocesos_lm.update');
    Route::get('temas_por_areas', 'getTemasPorAreas')->name('temas_por_areas');
    Route::get('capacitadores_por_areas', 'getCapacitadoresPorAreas')->name('capacitadores_por_areas');
    Route::get('puestos-por-areas', 'getPuestosPorAreas')->name('puestos_por_areas');


    // CONFIGURABLES - ADMINISTRABLES
    Route::get('portalprocesos_lm_conf', 'index_lm_conf')->name('portalprocesos_lm_conf');

    // CAPACITACIÓN
    Route::get('portalprocesoscap', 'indexcap')->name('portalprocesoscap');
    Route::get('portalprocesos_cap', 'index_cap')->name('portalprocesos_cap');
    Route::get('portalprocesos_cap/list', 'list_cap')->name('portalprocesos_cap.list');
    Route::get('portalprocesos_cap/create', 'create_cap')->name('portalprocesos_cap.create');
    Route::post('portalprocesos_cap', 'store_cap')->name('portalprocesos_cap.store');
    Route::delete('portalprocesos_cap/{id}', 'destroy_cap')->name('portalprocesos_cap.destroy');
    // ADMINISTRABLES - CAPACITACIÓN
    Route::get('portalprocesoscap_conf', 'indexcap_conf')->name('portalprocesoscap_conf');
    Route::get('portalprocesos_cap_conf', 'index_cap_conf')->name('portalprocesos_cap_conf');
    Route::get('portalprocesos_cap_conf/list', 'list_cap_conf')->name('portalprocesos_cap_conf.list');
    Route::get('portalprocesos_cap_conf/{id}/edit', 'edit_cap_conf')->name('portalprocesos_cap_conf.edit');
    Route::delete('portalprocesos_cap_conf/{id}', 'destroy_cap_conf')->name('portalprocesos_cap_conf.destroy');
    Route::post('portalprocesos_cap_conf/{id}', 'update_cap_conf')->name('portalprocesos_cap_conf.update');
    Route::get('portalprocesos_cap_conf/create', 'create_cap_conf')->name('portalprocesos_cap_conf.create');
    Route::post('portalprocesos_cap_conf', 'store_cap_conf')->name('portalprocesos_cap_conf.store');
});


//SOPORTE - ADMINISTRADOR
Route::controller(SoporteController::class)->group(function () {
    Route::get('soporte', 'index')->name('soporte');;
    Route::get('soporte_ticket/list', 'list_tick')->name('soporte_ticket.list');
    Route::get('soporte_ticket/create', 'create_tick')->name('soporte_ticket.create');
    Route::get('soporte_ticket/{cod_base}/{fec_ini}/{fec_fin}/excel', 'excel_tick')->name('soporte_ticket.excel');
    Route::post('soporte_ticket/store', 'store_tick')->name('soporte_ticket.store');
    Route::get('soporte_ticket/{id}/image', 'image_tick')->name('soporte_ticket.image');
    Route::delete('soporte_ticket/{id}', 'destroy_tick')->name('soporte_ticket.destroy');
    Route::post('soporte_ticket/{id}', 'approve_tick')->name('soporte_ticket.approve');
    Route::get('soporte_ticket/{id}/edit', 'edit_tick')->name('soporte_ticket.edit');

    Route::get('soporte_nivel_por_sede', 'getSoporteNivelPorSede')->name('soporte_nivel_por_sede');
    Route::get('soporte_areaespecifica_por_nivel', 'getAreaEspeficaPorNivel')->name('soporte_areaespecifica_por_nivel');
    Route::get('elemento_por_especialidad', 'getElementoPorEspecialidad')->name('elemento_por_especialidad');
    Route::get('asunto_por_elemento', 'getAsuntoPorElemento')->name('asunto_por_elemento');


    // SOPORTE MASTER
    Route::get('soporte_master', 'index_master')->name('soporte_master');
    Route::get('soporte_ticket_master/list', 'list_tick_master')->name('soporte_ticket_master.list');
    Route::get('soporte_ticket_master/ver/{id}', 'ver_tick_master')->name('soporte_ticket_master.ver');
    Route::get('soporte_ticket_master/edit/{id}', 'edit_tick_master')->name('soporte_ticket_master.edit');
    Route::get('soporte_ticket_master/edit/{id}', 'edit_tick_master')->name('soporte_ticket_master.edit');
    Route::post('soporte_ticket_master/{id}', 'update_tick_master')->name('soporte_ticket_master.update');
});

// ADMINISTRABLES - TICKETS SOPORTE

Route::controller(SoporteConfController::class)->group(function () {

    Route::get('soporteticket_conf', 'indexsop_conf')->name('soporteticket_conf');
    Route::get('soporte_asunto_conf', 'index_asu_conf')->name('soporte_asunto_conf');
    Route::get('soporte_elemento_conf', 'index_ele_conf')->name('soporte_elemento_conf');
    Route::get('soporte_especialidad_conf', 'index_esp_conf')->name('soporte_especialidad_conf');

    // ADMINISTRABLE ASUNTO
    Route::get('soporte_asunto_conf/list', 'list_asunto_conf')->name('soporte_asunto_conf.list');
    Route::get('soporte_asunto_conf/{id}/edit', 'edit_asunto_conf')->name('soporte_asunto_conf.edit');
    Route::post('soporte_asunto_conf/delete/{id}', 'destroy_asunto_conf')->name('soporte_asunto_conf.destroy');
    Route::post('soporte_asunto_conf/{id}', 'update_asunto_conf')->name('soporte_asunto_conf.update');
    Route::get('soporte_asunto_conf/create', 'create_asunto_conf')->name('soporte_asunto_conf.create');
    Route::post('soporte_asunto_conf', 'store_asunto_conf')->name('soporte_asunto_conf.store');
    // ADMINISTRABLE ELEMENTO
    Route::get('soporte_elemento_conf/list', 'list_elemento_conf')->name('soporte_elemento_conf.list');
    Route::get('soporte_elemento_conf/{id}/edit', 'edit_elemento_conf')->name('soporte_elemento_conf.edit');
    Route::post('soporte_elemento_conf/delete/{id}', 'destroy_elemento_conf')->name('soporte_elemento_conf.destroy');
    Route::post('soporte_elemento_conf/{id}', 'update_elemento_conf')->name('soporte_elemento_conf.update');
    Route::get('soporte_elemento_conf/create', 'create_elemento_conf')->name('soporte_elemento_conf.create');
    Route::post('soporte_elemento_conf', 'store_elemento_conf')->name('soporte_elemento_conf.store');
    // ADMINISTRABLE ESPECIALIDAD
    Route::get('soporte_especialidad_conf/list', 'list_especialidad_conf')->name('soporte_especialidad_conf.list');
    Route::get('soporte_especialidad_conf/{id}/edit', 'edit_especialidad_conf')->name('soporte_especialidad_conf.edit');
    Route::post('soporte_especialidad_conf/{id}/destroy', 'destroy_especialidad_conf')->name('soporte_especialidad_conf.destroy');
    Route::post('soporte_especialidad_conf/{id}', 'update_especialidad_conf')->name('soporte_especialidad_conf.update');
    Route::get('soporte_especialidad_conf/create', 'create_especialidad_conf')->name('soporte_especialidad_conf.create');
    Route::post('soporte_especialidad_conf', 'store_especialidad_conf')->name('soporte_especialidad_conf.store');
});


//BI REPORTES -
Route::controller(BiReporteController::class)->group(function () {
    Route::get('bireporte', 'index')->name('bireporte');
    Route::get('bireporte_ra', 'index_ra')->name('bireporte_ra');
    Route::get('bireporte_ra/list', 'list_ra')->name('bireporte_ra.list');
    Route::get('bireporte_ra/create', 'create_ra')->name('bireporte_ra.create');
    Route::post('bireporte_ra', 'store_ra')->name('bireporte_ra.store');
    Route::delete('bireporte_ra/{id}', 'destroy_ra')->name('bireporte_ra.destroy');
    Route::get('bireporte_ra/{id}/edit', 'edit_ra')->name('bireporte_ra.edit');
    Route::post('bireporte_ra/{id}', 'update_ra')->name('bireporte_ra.update');
    Route::post('bireporte_ra/{id}/valid', 'update_valid')->name('bireporte_ra.valid');
    Route::get('puestos-por-areas-bi', 'getPuestosPorAreasBi')->name('puestos_por_areas_bi');
    Route::get('usuarios_por_area', 'getUsuariosPorArea')->name('usuarios_por_area');
    Route::get('areas_por_base', 'getAreasPorBase')->name('areas_por_base_bi');
    Route::get('db_por_sistema_bi', 'getDBPorSistema')->name('db_por_sistema_bi');
    Route::get('tb_por_db_bi', 'getTBPorDB')->name('tb_por_db_bi');
    Route::get('ubicacion_por_sede', 'getUbicacionPorSede')->name('ubicacion_por_sede');
    Route::get('areas_por_ubicacion', 'getAreasPorUbicacion')->name('areas_por_ubicacion');
    Route::get('area_por_usuario', 'getAreaPorUsuario')->name('area_por_usuario');
    Route::get('bireporte_ra/{id}/image', 'image_ra')->name('bireporte_ra.image');
    Route::post('bireporte_ra_excel', 'importarExcel')->name('bireporte_ra_excel.excelupdate');


    // REPORTE x INDICADORES
    Route::get('bireporte_ind', 'index_ind')->name('bireporte_ind');
    Route::get('bireporte_ind/list', 'list_ind')->name('bireporte_ind.list');
    Route::get('bireporte_ind/{cod_base}/{fec_ini}/{fec_fin}/excel', 'excel_rebi')->name('bireporte_ind.excel');

    // REPORTE x BASE DE DATOS
    Route::get('bireporte_db', 'index_db')->name('bireporte_db');
    Route::get('bireporte_db/list', 'list_db')->name('bireporte_db.list');
    Route::get('bireporte_db/{cod_base}/{fec_ini}/{fec_fin}/excel', 'excel_rebi')->name('bireporte_db.excel');




    // ADMINISTRABLES -
    Route::get('bireporte_ra_conf', 'index_ra_conf')->name('bireporte_ra_conf');
    Route::get('bireporte_ti_conf', 'index_ti_conf')->name('bireporte_ti_conf');
    Route::get('bireporte_sisbd_conf', 'index_sis_conf')->name('bireporte_sisbd_conf');
    Route::get('bireporte_tbbd_conf', 'index_tb_conf')->name('bireporte_tbbd_conf');

    // Tipo Indicadores
    Route::get('bireporte_ti_conf/list', 'list_tind')->name('bireporte_ti_conf.list');
    Route::get('bireporte_ti_conf/{id}/edit', 'edit_tind')->name('bireporte_ti_conf.edit');
    Route::delete('bireporte_ti_conf/{id}', 'destroy_tind')->name('bireporte_ti_conf.destroy');
    Route::put('bireporte_ti_conf/{id}', 'update_tind')->name('bireporte_ti_conf.update');
    Route::get('bireporte_ti_conf/create', 'create_tind')->name('bireporte_ti_conf.create');
    Route::post('bireporte_ti_conf', 'store_tind')->name('bireporte_ti_conf.store');
    // Sistema
    Route::get('bireporte_sisbd_conf/list', 'list_sis')->name('bireporte_sisbd_conf.list');
    Route::get('bireporte_sisbd_conf/{id}/edit', 'edit_sis')->name('bireporte_sisbd_conf.edit');
    Route::delete('bireporte_sisbd_conf/{id}', 'destroy_sis')->name('bireporte_sisbd_conf.destroy');
    Route::put('bireporte_sisbd_conf/{id}', 'update_sis')->name('bireporte_sisbd_conf.update');
    Route::get('bireporte_sisbd_conf/create', 'create_sis')->name('bireporte_sisbd_conf.create');
    Route::get('bireporte_sistema_conf/create', 'create_sistema')->name('bireporte_sistema_conf.create');
    Route::post('bireporte_sisbd_conf', 'store_sis')->name('bireporte_sisbd_conf.store');
    Route::post('bireporte_sistema_conf', 'store_sistema')->name('bireporte_sistema_conf.store');

    // TABLAS
    Route::get('bireporte_tbbd_conf/list', 'list_tb')->name('bireporte_tbbd_conf.list');
    Route::get('bireporte_tbbd_conf/{id}/edit', 'edit_tb')->name('bireporte_tbbd_conf.edit');
    Route::delete('bireporte_tbbd_conf/{id}', 'destroy_tb')->name('bireporte_tbbd_conf.destroy');
    Route::put('bireporte_tbbd_conf/{id}', 'update_tb')->name('bireporte_tbbd_conf.update');
    Route::get('bireporte_tbbd_conf/create', 'create_tb')->name('bireporte_tbbd_conf.create');
    Route::post('bireporte_tbbd_conf', 'store_tb')->name('bireporte_tbbd_conf.store');
});

//BI REPORTES - TIENDA
Route::controller(BiReporteDepartamentoController::class)->group(function () {
    Route::get('reportenewp/{id_area}/{id_subgerencia}', 'handleAreaP')->name('reporte_primario');
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
    Route::get('Index_Programas', 'Index_Programas');
    Route::post('ColaboradorConfController/Estado_Civil', 'Estado_Civil');
    Route::get('ColaboradorConfController/Modal_Estado_Civil', 'Modal_Estado_Civil');
    Route::get('ColaboradorConfController/Modal_Update_Estado_Civil/{id}', 'Modal_Update_Estado_Civil');
    Route::post('ColaboradorConfController/Insert_Estado_Civil', 'Insert_Estado_Civil');
    Route::post('ColaboradorConfController/Update_Estado_Civil', 'Update_Estado_Civil');
    Route::post('ColaboradorConfController/Delete_Estado_Civil', 'Delete_Estado_Civil');
    Route::post('ColaboradorConfController/Idioma', 'Idioma');
    Route::get('ColaboradorConfController/Modal_Idioma', 'Modal_Idioma');
    Route::get('ColaboradorConfController/Modal_Update_Idioma/{id}', 'Modal_Update_Idioma');
    Route::post('ColaboradorConfController/Insert_Idioma', 'Insert_Idioma');
    Route::post('ColaboradorConfController/Update_Idioma', 'Update_Idioma');
    Route::post('ColaboradorConfController/Delete_Idioma', 'Delete_Idioma');
    Route::post('ColaboradorConfController/Nacionalidad', 'Nacionalidad');
    Route::get('ColaboradorConfController/Modal_Nacionalidad', 'Modal_Nacionalidad');
    Route::get('ColaboradorConfController/Modal_Update_Nacionalidad/{id}', 'Modal_Update_Nacionalidad');
    Route::post('ColaboradorConfController/Insert_Nacionalidad', 'Insert_Nacionalidad');
    Route::post('ColaboradorConfController/Update_Nacionalidad', 'Update_Nacionalidad');
    Route::post('ColaboradorConfController/Delete_Nacionalidad', 'Delete_Nacionalidad');
    Route::post('ColaboradorConfController/Parentesco', 'Parentesco');
    Route::get('ColaboradorConfController/Modal_Parentesco', 'Modal_Parentesco');
    Route::get('ColaboradorConfController/Modal_Update_Parentesco/{id}', 'Modal_Update_Parentesco');
    Route::post('ColaboradorConfController/Insert_Parentesco', 'Insert_Parentesco');
    Route::post('ColaboradorConfController/Update_Parentesco', 'Update_Parentesco');
    Route::post('ColaboradorConfController/Delete_Parentesco', 'Delete_Parentesco');
    Route::post('ColaboradorConfController/Referencia_Laboral', 'Referencia_Laboral');
    Route::get('ColaboradorConfController/Modal_Referencia_Laboral', 'Modal_Referencia_Laboral');
    Route::get('ColaboradorConfController/Modal_Update_Referencia_Laboral/{id}', 'Modal_Update_Referencia_Laboral');
    Route::post('ColaboradorConfController/Insert_Referencia_Laboral', 'Insert_Referencia_Laboral');
    Route::post('ColaboradorConfController/Update_Referencia_Laboral', 'Update_Referencia_Laboral');
    Route::post('ColaboradorConfController/Delete_Referencia_Laboral', 'Delete_Referencia_Laboral');
    Route::post('ColaboradorConfController/Regimen', 'Regimen');
    Route::get('ColaboradorConfController/Modal_Regimen', 'Modal_Regimen');
    Route::get('ColaboradorConfController/Modal_Update_Regimen/{id}', 'Modal_Update_Regimen');
    Route::post('ColaboradorConfController/Insert_Regimen', 'Insert_Regimen');
    Route::post('ColaboradorConfController/Update_Regimen', 'Update_Regimen');
    Route::post('ColaboradorConfController/Delete_Regimen', 'Delete_Regimen');
    Route::post('ColaboradorConfController/Situacion_Laboral', 'Situacion_Laboral');
    Route::get('ColaboradorConfController/Modal_Situacion_Laboral', 'Modal_Situacion_Laboral');
    Route::get('ColaboradorConfController/Modal_Update_Situacion_Laboral/{id}', 'Modal_Update_Situacion_Laboral');
    Route::post('ColaboradorConfController/Insert_Situacion_Laboral', 'Insert_Situacion_Laboral');
    Route::post('ColaboradorConfController/Update_Situacion_Laboral', 'Update_Situacion_Laboral');
    Route::post('ColaboradorConfController/Delete_Situacion_Laboral', 'Delete_Situacion_Laboral');
    Route::post('ColaboradorConfController/Tipo_Contrato', 'Tipo_Contrato');
    Route::get('ColaboradorConfController/Modal_Tipo_Contrato', 'Modal_Tipo_Contrato');
    Route::get('ColaboradorConfController/Modal_Update_Tipo_Contrato/{id}', 'Modal_Update_Tipo_Contrato');
    Route::post('ColaboradorConfController/Insert_Tipo_Contrato', 'Insert_Tipo_Contrato');
    Route::post('ColaboradorConfController/Update_Tipo_Contrato', 'Update_Tipo_Contrato');
    Route::post('ColaboradorConfController/Delete_Tipo_Contrato', 'Delete_Tipo_Contrato');
    Route::post('ColaboradorConfController/Tipo_Documento', 'Tipo_Documento');
    Route::get('ColaboradorConfController/Modal_Tipo_Documento', 'Modal_Tipo_Documento');
    Route::get('ColaboradorConfController/Modal_Update_Tipo_Documento/{id}', 'Modal_Update_Tipo_Documento');
    Route::post('ColaboradorConfController/Insert_Tipo_Documento', 'Insert_Tipo_Documento');
    Route::post('ColaboradorConfController/Update_Tipo_Documento', 'Update_Tipo_Documento');
    Route::post('ColaboradorConfController/Delete_Tipo_Documento', 'Delete_Tipo_Documento');
    Route::post('ColaboradorConfController/Grupo_Sanguineo', 'Grupo_Sanguineo');
    Route::get('ColaboradorConfController/Modal_Grupo_Sanguineo', 'Modal_Grupo_Sanguineo');
    Route::get('ColaboradorConfController/Modal_Update_Grupo_Sanguineo/{id}', 'Modal_Update_Grupo_Sanguineo');
    Route::post('ColaboradorConfController/Insert_Grupo_Sanguineo', 'Insert_Grupo_Sanguineo');
    Route::post('ColaboradorConfController/Update_Grupo_Sanguineo', 'Update_Grupo_Sanguineo');
    Route::post('ColaboradorConfController/Delete_Grupo_Sanguineo', 'Delete_Grupo_Sanguineo');
    /*-------------------------------------------------Paolo--------------------------------------*/
    Route::post('ColaboradorConfController/Tipo_Via', 'Tipo_Via');
    Route::get('ColaboradorConfController/Modal_Tipo_Via', 'Modal_Tipo_Via');
    Route::get('ColaboradorConfController/Modal_Update_Tipo_Via/{id}', 'Modal_Update_Tipo_Via');
    Route::post('ColaboradorConfController/Insert_Tipo_Via', 'Insert_Tipo_Via');
    Route::post('ColaboradorConfController/Update_Tipo_Via', 'Update_Tipo_Via');
    Route::post('ColaboradorConfController/Delete_Tipo_Via', 'Delete_Tipo_Via');
    Route::post('ColaboradorConfController/Tipo_Vivienda', 'Tipo_Vivienda');
    Route::get('ColaboradorConfController/Modal_Tipo_Vivienda', 'Modal_Tipo_Vivienda');
    Route::get('ColaboradorConfController/Modal_Update_Tipo_Vivienda/{id}', 'Modal_Update_Tipo_Vivienda');
    Route::post('ColaboradorConfController/Insert_Tipo_Vivienda', 'Insert_Tipo_Vivienda');
    Route::post('ColaboradorConfController/Update_Tipo_Vivienda', 'Update_Tipo_Vivienda');
    Route::post('ColaboradorConfController/Delete_Tipo_Vivienda', 'Delete_Tipo_Vivienda');
    Route::post('ColaboradorConfController/Empresa', 'Empresa');
    Route::get('ColaboradorConfController/Modal_Empresa', 'Modal_Empresa');
    Route::get('ColaboradorConfController/Modal_Update_Empresa/{id}', 'Modal_Update_Empresa');
    Route::post('ColaboradorConfController/Insert_Empresa', 'Insert_Empresa');
    Route::post('ColaboradorConfController/Update_Empresa', 'Update_Empresa');
    Route::post('ColaboradorConfController/Delete_Empresa', 'Delete_Empresa');
    Route::post('ColaboradorConfController/Banco', 'Banco');
    Route::get('ColaboradorConfController/Modal_Banco', 'Modal_Banco');
    Route::get('ColaboradorConfController/Modal_Update_Banco/{id}', 'Modal_Update_Banco');
    Route::post('ColaboradorConfController/Insert_Banco', 'Insert_Banco');
    Route::post('ColaboradorConfController/Update_Banco', 'Update_Banco');
    Route::post('ColaboradorConfController/Delete_Banco', 'Delete_Banco');
    Route::post('ColaboradorConfController/Provincia', 'Provincia');
    Route::post('ColaboradorConfController/Distrito', 'Distrito');
    Route::post('ColaboradorConfController/Genero', 'Genero');
    Route::get('ColaboradorConfController/Modal_Genero', 'Modal_Genero');
    Route::get('ColaboradorConfController/Modal_Update_Genero/{id}', 'Modal_Update_Genero');
    Route::post('ColaboradorConfController/Insert_Genero', 'Insert_Genero');
    Route::post('ColaboradorConfController/Update_Genero', 'Update_Genero');
    Route::post('ColaboradorConfController/Delete_Genero', 'Delete_Genero');
    Route::post('ColaboradorConfController/Accesorio', 'Accesorio');
    Route::get('ColaboradorConfController/Modal_Accesorio', 'Modal_Accesorio');
    Route::get('ColaboradorConfController/Modal_Update_Accesorio/{id}', 'Modal_Update_Accesorio');
    Route::post('ColaboradorConfController/Insert_Accesorio', 'Insert_Accesorio');
    Route::post('ColaboradorConfController/Update_Accesorio', 'Update_Accesorio');
    Route::post('ColaboradorConfController/Delete_Accesorio', 'Delete_Accesorio');
    Route::post('ColaboradorConfController/Talla', 'Talla');
    Route::get('ColaboradorConfController/Modal_Talla', 'Modal_Talla');
    Route::get('ColaboradorConfController/Modal_Update_Talla/{id}', 'Modal_Update_Talla');
    Route::post('ColaboradorConfController/Insert_Talla', 'Insert_Talla');
    Route::post('ColaboradorConfController/Update_Talla', 'Update_Talla');
    Route::post('ColaboradorConfController/Delete_Talla', 'Delete_Talla');
    Route::post('ColaboradorConfController/Grado_Instruccion', 'Grado_Instruccion');
    Route::get('ColaboradorConfController/Modal_Grado_Instruccion', 'Modal_Grado_Instruccion');
    Route::get('ColaboradorConfController/Modal_Update_Grado_Instruccion/{id}', 'Modal_Update_Grado_Instruccion');
    Route::post('ColaboradorConfController/Insert_Grado_Instruccion', 'Insert_Grado_Instruccion');
    Route::post('ColaboradorConfController/Update_Grado_Instruccion', 'Update_Grado_Instruccion');
    Route::post('ColaboradorConfController/Delete_Grado_Instruccion', 'Delete_Grado_Instruccion');
    Route::post('ColaboradorConfController/Zona', 'Zona');
    Route::get('ColaboradorConfController/Modal_Zona', 'Modal_Zona');
    Route::get('ColaboradorConfController/Modal_Update_Zona/{id}', 'Modal_Update_Zona');
    Route::post('ColaboradorConfController/Insert_Zona', 'Insert_Zona');
    Route::post('ColaboradorConfController/Update_Zona', 'Update_Zona');
    Route::post('ColaboradorConfController/Delete_Zona', 'Delete_Zona');
    Route::get('ColaboradorConfController/Excel_ZonaPL', 'Excel_ZonaPL');
    Route::post('ColaboradorConfController/Comision_AFP', 'Comision_AFP');
    Route::get('ColaboradorConfController/Modal_Comision_AFP', 'Modal_Comision_AFP');
    Route::get('ColaboradorConfController/Modal_Update_Comision_AFP/{id}', 'Modal_Update_Comision_AFP');
    Route::post('ColaboradorConfController/Insert_Comision_AFP', 'Insert_Comision_AFP');
    Route::post('ColaboradorConfController/Update_Comision_AFP', 'Update_Comision_AFP');
    Route::post('ColaboradorConfController/Delete_Comision_AFP', 'Delete_Comision_AFP');
    Route::post('ColaboradorConfController/Turno', 'Turno');
    Route::get('ColaboradorConfController/Modal_Turno', 'Modal_Turno');
    Route::get('ColaboradorConfController/Modal_Update_Turno/{id}', 'Modal_Update_Turno');
    Route::post('ColaboradorConfController/Insert_Turno', 'Insert_Turno');
    Route::post('ColaboradorConfController/Update_Turno', 'Update_Turno');
    Route::post('ColaboradorConfController/Delete_Turno', 'Delete_Turno');
    Route::post('ColaboradorConfController/Horario', 'Horario');
    Route::post('ColaboradorConfController/Lista_Horario', 'Lista_Horario');
    Route::post('ColaboradorConfController/Busca_Turno_XBase', 'Busca_Turno_XBase');
    Route::get('ColaboradorConfController/Modal_Horario', 'Modal_Horario');
    Route::get('ColaboradorConfController/Modal_Update_Horario/{id}', 'Modal_Update_Horario');
    Route::post('ColaboradorConfController/Insert_Horario', 'Insert_Horario');
    Route::post('ColaboradorConfController/Update_Horario', 'Update_Horario');
    Route::post('ColaboradorConfController/Delete_Horario', 'Delete_Horario');
    /*----------------------------------------Paolo----------------------------------*/
    // ----------------------------------------bryan----------------------------------*/

    Route::get('colaborador_conf_ubi', 'index_ubi')->name('colaborador_conf_ubi');
    Route::get('colaborador_conf_ubi/list', 'list_ubi')->name('colaborador_conf_ubi.list');
    Route::get('colaborador_conf_ubi/create', 'create_ubi')->name('colaborador_conf_ubi.create');
    Route::post('colaborador_ccolaborador_conf_ubionf_ubi', 'store_ubi')->name('colaborador_conf_ubi.store');
    Route::get('colaborador_conf_ubi/{id}/edit', 'edit_ubi')->name('colaborador_conf_ubi.edit');
    Route::put('colaborador_conf_ubi/{id}', 'update_ubi')->name('colaborador_conf_ubi.update');
    Route::delete('colaborador_conf_ubi/{id}', 'destroy_ubi')->name('colaborador_conf_ubi.destroy');
    // ----------------------------------------bryan----------------------------------*/

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
Route::controller(LogisticaInicioController::class)->group(function () {
    Route::get('logistica', 'index')->name('logistica');
});
//ÁREA CAJA
Route::controller(CajaInicioController::class)->group(function () {
    Route::get('caja', 'index')->name('caja');
});
//CAJA - OBSERVACIONES
Route::controller(ObservacionController::class)->group(function () {
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
Route::controller(ObservacionConfController::class)->group(function () {
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
//ÁREA RECURSOS HUMANOS
Route::controller(RecursosHumanosInicioController::class)->group(function () {
    Route::get('recursos_humanos', 'index')->name('recursos_humanos');
});
//RECURSOS HUMANOS - COLABORADOR
Route::controller(ColaboradorController::class)->group(function () {
    Route::get('colaborador', 'index')->name('colaborador');
    Route::get('colaborador_co', 'index_co')->name('colaborador_co');
    Route::post('colaborador_co/list', 'list_co')->name('colaborador_co.list');
    Route::post('colaborador_co/mail', 'mail_co')->name('colaborador_co.mail');
    Route::get('colaborador_co/{id}/edit', 'edit_co')->name('colaborador_co.edit');
    Route::put('colaborador_co/{id}', 'update_co')->name('colaborador_co.update');
    Route::get('colaborador_co/{id}/download', 'download_co')->name('colaborador_co.download');
    Route::get('colaborador_co/{id}/pdf_perfil', 'pdf_perfil_co')->name('colaborador_co.pdf_perfil');
    Route::get('colaborador_co/{id_gerencia}/excel', 'excel_co')->name('colaborador_co.excel');
    Route::get('colaborador_ce', 'index_ce')->name('colaborador_ce');
    Route::post('colaborador_ce/list', 'list_ce')->name('colaborador_ce.list');
    Route::post('colaborador_ce/mail', 'mail_co')->name('colaborador_ce.mail');
    Route::get('colaborador_ce/{id}/edit', 'edit_ce')->name('colaborador_ce.edit');
    Route::put('colaborador_ce/{id}', 'update_co')->name('colaborador_ce.update');
    Route::get('colaborador_ce/{id}/download', 'download_co')->name('colaborador_ce.download');
    Route::get('colaborador_ce/{id}/pdf_perfil', 'pdf_perfil_co')->name('colaborador_ce.pdf_perfil');
    Route::get('colaborador_ce/{id_gerencia}/excel', 'excel_ce')->name('colaborador_ce.excel');
    Route::get('ColaboradorController/Mi_Perfil/{id}', 'Mi_Perfil');
    Route::get('ColaboradorController/Perfil/{id}', 'Perfil');
    Route::get('ColaboradorController/Modal_Update_Historico_Base_Colaborador/{id}', 'Modal_Update_Historico_Base_Colaborador');
    Route::get('ColaboradorController/Modal_Update_Historico_Modalidad_Colaborador/{id}', 'Modal_Update_Historico_Modalidad_Colaborador');
    Route::get('ColaboradorController/Modal_Update_Historico_Horario_Colaborador/{id}', 'Modal_Update_Historico_Horario_Colaborador');
    Route::get('ColaboradorController/Modal_Update_Historico_Horas_Semanales_Colaborador/{id}', 'Modal_Update_Historico_Horas_Semanales_Colaborador');
    Route::get('ColaboradorController/Modal_Detalle_Historico_Colaborador', 'Modal_Detalle_Historico_Colaborador');
    Route::post('ColaboradorController/List_Datos_Laborales', 'List_Datos_Laborales');
    Route::post('ColaboradorController/Update_Historico_Base', 'Update_Historico_Base');
    Route::post('ColaboradorController/Update_Historico_Modalidad', 'Update_Historico_Modalidad');
    Route::post('ColaboradorController/Update_Historico_Horario', 'Update_Historico_Horario');
    Route::post('ColaboradorController/Update_Historico_Horas_Semanales', 'Update_Historico_Horas_Semanales');
    Route::get('ColaboradorController/Modal_Update_Historico_Puesto/{id}', 'Modal_Update_Historico_Puesto');
    Route::post('ColaboradorController/Update_Historico_Puesto', 'Update_Historico_Puesto');
    Route::get('ColaboradorController/Busca_Sub_Gerencia_Hp', 'Busca_Sub_Gerencia_Hp');
    Route::get('ColaboradorController/Busca_Area_Hp', 'Busca_Area_Hp');
    Route::get('ColaboradorController/Busca_Puesto_Hp', 'Busca_Puesto_Hp');
    Route::get('ColaboradorController/Modal_Detalle_Historico_Colaborador/{id}/{tipo}', 'Modal_Detalle_Historico_Colaborador');
    Route::post('ColaboradorController/Valida_Planilla_Activa', 'Valida_Planilla_Activa');
    Route::get('ColaboradorController/Modal_Dato_Planilla/{id}/{count}', 'Modal_Dato_Planilla');
    Route::post('ColaboradorController/List_datosgenerales_planilla', 'List_datosgenerales_planilla');
    Route::post('ColaboradorController/List_datos_planilla', 'List_datos_planilla');
    Route::post('ColaboradorController/Btn_Planilla_Perfil', 'Btn_Planilla_Perfil');
    Route::post('ColaboradorController/Enviar_Correo_Bienvenida/{id}', 'Enviar_Correo_Bienvenida');
    Route::get('ColaboradorController/Modal_Enviar_Correo_Bienvenida/{id_user}', 'Modal_Enviar_Correo_Bienvenida');
    Route::post('ColaboradorController/Enviar_Correo_Colaborador', 'Enviar_Correo_Colaborador');
    Route::get('ColaboradorController/Modal_Enviar_Correo_Colaborador/{id_user}', 'Modal_Enviar_Correo_Colaborador');
    Route::post('ColaboradorController/Update_Adjuntar_DocumentacionRRHH', 'Update_Adjuntar_DocumentacionRRHH');
    Route::post('ColaboradorController/Insert_Directorio_Telefonico', 'Insert_Directorio_Telefonico');
    Route::post('ColaboradorController/Update_GDatosP', 'Update_GDatosP');
    Route::post('ColaboradorController/Lista_GDatosP', 'Lista_GDatosP');
    Route::post('ColaboradorController/Habilitar_Edicion_Perfil', 'Habilitar_Edicion_Perfil');
    Route::post('ColaboradorController/Confirmar_Revision_Perfil', 'Confirmar_Revision_Perfil');
    Route::post('ColaboradorController/Update_GustosP', 'Update_GustosP');
    Route::post('ColaboradorController/Update_DomilcilioP', 'Update_DomilcilioP');
    Route::post('ColaboradorController/Update_DomilcilioP_Titulo', 'Update_DomilcilioP_Titulo');
    Route::post('ColaboradorController/Detalle_Referencia_Familiar', 'Detalle_Referencia_Familiar');
    Route::post('ColaboradorController/Update_ReferenciaF', 'Update_ReferenciaF');
    Route::post('ColaboradorController/MDatos_ReferenciaF', 'MDatos_ReferenciaF');
    Route::post('ColaboradorController/Insert_ReferenciaF', 'Insert_ReferenciaF');
    Route::post('ColaboradorController/Delete_Referencia_Familiar', 'Delete_Referencia_Familiar');
    Route::post('ColaboradorController/Lista_Hijos', 'Lista_Hijos');
    Route::post('ColaboradorController/Insert_Hijos_Usuario', 'Insert_Hijos_Usuario');
    Route::post('ColaboradorController/Detalle_Hijos_Usuario', 'Detalle_Hijos_Usuario');
    Route::post('ColaboradorController/Update_Hijos', 'Update_Hijos');
    Route::post('ColaboradorController/MDatos_Hijos', 'MDatos_Hijos');
    Route::post('ColaboradorController/Delete_Hijos_Usuario', 'Delete_Hijos_Usuario');
    Route::post('ColaboradorController/Insert_ContactoE', 'Insert_ContactoE');
    Route::post('ColaboradorController/Update_ContactoE', 'Update_ContactoE');
    Route::post('ColaboradorController/MDatos_ContactoE', 'MDatos_ContactoE');
    Route::post('ColaboradorController/Detalle_ContactoE', 'Detalle_ContactoE');
    Route::post('ColaboradorController/Delete_ContactoE', 'Delete_ContactoE');
    Route::post('ColaboradorController/Lista_EstudiosG', 'Lista_EstudiosG');
    Route::post('ColaboradorController/Insert_EstudiosG', 'Insert_EstudiosG');
    Route::post('ColaboradorController/Detalle_EstudiosG', 'Detalle_EstudiosG');
    Route::post('ColaboradorController/MDatos_EstudiosG', 'MDatos_EstudiosG');
    Route::post('ColaboradorController/Update_EstudiosG', 'Update_EstudiosG');
    Route::post('ColaboradorController/Delete_EstudiosG', 'Delete_EstudiosG');
    Route::post('ColaboradorController/Update_Conoci_Office', 'Update_Conoci_Office');
    Route::post('ColaboradorController/Insert_Conoci_Idiomas', 'Insert_Conoci_Idiomas');
    Route::post('ColaboradorController/MDatos_Idiomas', 'MDatos_Idiomas');
    Route::post('ColaboradorController/Update_Conoci_Idiomas', 'Update_Conoci_Idiomas');
    Route::post('ColaboradorController/Detalle_Conoci_Idiomas', 'Detalle_Conoci_Idiomas');
    Route::post('ColaboradorController/Delete_Conoci_Idiomas', 'Delete_Conoci_Idiomas');
    Route::post('ColaboradorController/Lista_CursosC', 'Lista_CursosC');
    Route::post('ColaboradorController/Insert_CursosC', 'Insert_CursosC');
    Route::post('ColaboradorController/Update_CursosC', 'Update_CursosC');
    Route::post('ColaboradorController/MDatos_CursosC', 'MDatos_CursosC');
    Route::post('ColaboradorController/Detalle_CursosC', 'Detalle_CursosC');
    Route::post('ColaboradorController/Delete_CursosC', 'Delete_CursosC');
    Route::post('ColaboradorController/Lista_ExperenciaL', 'Lista_ExperenciaL');
    Route::post('ColaboradorController/Insert_ExperenciaL', 'Insert_ExperenciaL');
    Route::post('ColaboradorController/Update_ExperenciaL', 'Update_ExperenciaL');
    Route::post('ColaboradorController/MDatos_ExperenciaL', 'MDatos_ExperenciaL');
    Route::post('ColaboradorController/Detalle_ExperenciaL', 'Detalle_ExperenciaL');
    Route::post('ColaboradorController/Delete_ExperenciaL', 'Delete_ExperenciaL');
    Route::post('ColaboradorController/Insert_Enfermedades', 'Insert_Enfermedades');
    Route::post('ColaboradorController/Update_Enfermedades', 'Update_Enfermedades');
    Route::post('ColaboradorController/Detalle_Enfermedades', 'Detalle_Enfermedades');
    Route::post('ColaboradorController/MDatos_Enfermedades', 'MDatos_Enfermedades');
    Route::post('ColaboradorController/Delete_Enfermedades', 'Delete_Enfermedades');
    Route::post('ColaboradorController/Update_Gestacion', 'Update_Gestacion');
    Route::post('ColaboradorController/Insert_Alergia', 'Insert_Alergia');
    Route::post('ColaboradorController/Update_Alergia', 'Update_Alergia');
    Route::post('ColaboradorController/Detalle_Alergia', 'Detalle_Alergia');
    Route::post('ColaboradorController/MDatos_Alergias', 'MDatos_Alergias');
    Route::post('ColaboradorController/Delete_Alergia', 'Delete_Alergia');
    Route::post('ColaboradorController/Lista_Otros', 'Lista_Otros');
    Route::post('ColaboradorController/Update_Otros', 'Update_Otros');
    Route::post('ColaboradorController/Update_Referencia_Convocatoria', 'Update_Referencia_Convocatoria');
    Route::post('ColaboradorController/Update_Adjuntar_Documentacion', 'Update_Adjuntar_Documentacion');
    Route::post('ColaboradorController/Lista_Adjuntar_Documentacion', 'Lista_Adjuntar_Documentacion');
    Route::post('ColaboradorController/Update_Talla_Indica', 'Update_Talla_Indica');
    Route::post('ColaboradorController/Update_Sistema_Pensionario', 'Update_Sistema_Pensionario');
    Route::post('ColaboradorController/Update_Numero_Cuenta', 'Update_Numero_Cuenta');
    Route::post('ColaboradorController/Terminos', 'Terminos');
    Route::post('ColaboradorController/GuardarCambiosCI/{id}', 'GuardarCambiosCI');
    Route::post('ColaboradorController/Update_Datos_Completos/{id}', 'Update_Datos_Completos');
    // Route::post('ColaboradorController/', '');
    // Route::post('ColaboradorController/', '');
    // Route::post('ColaboradorController/', '');
    // Route::post('ColaboradorController/', '');
    // Route::post('ColaboradorController/', '');
    // Route::post('ColaboradorController/', '');
    // Route::get('ColaboradorController/Modal_Dato_Planilla/{id}/{count}', 'Modal_Dato_Planilla');
});
//ÁREA INTERNA
Route::controller(InternaInicioController::class)->group(function () {
    Route::get('interna', 'index')->name('interna');
});
//CAJA - LÍNEA DE CARRERA
Route::controller(LineaCarreraController::class)->group(function () {
    Route::get('linea_carrera', 'index')->name('linea_carrera');
    Route::get('linea_carrera_so', 'index_so')->name('linea_carrera_so');
    Route::post('linea_carrera_so/list', 'list_so')->name('linea_carrera_so.list');
    Route::get('linea_carrera_so/{id}/obs', 'obs_so')->name('linea_carrera_so.obs');
    Route::get('linea_carrera_so/{id}/edit', 'edit_so')->name('linea_carrera_so.edit');
    Route::post('linea_carrera_so/{id}', 'update_so')->name('linea_carrera_so.update');
    Route::get('linea_carrera_en', 'index_en')->name('linea_carrera_en');
    Route::post('linea_carrera_en/list', 'list_en')->name('linea_carrera_en.list');
    Route::get('linea_carrera_en/{id}/evaluacion', 'evaluacion_en')->name('linea_carrera_en.evaluacion');
    Route::put('linea_carrera_en/{id}', 'update_en')->name('linea_carrera_en.update');
    Route::get('linea_carrera_en/update_estado_entrenamiento', 'update_estado_entrenamiento')->name('linea_carrera_en.update_estado_entrenamiento');
    Route::get('linea_carrera/{id}/evaluacion', 'evaluacion_ev')->name('linea_carrera.evaluacion');
    Route::post('linea_carrera_ev/{id}/iniciar_evaluacion', 'iniciar_evaluacion_ev')->name('linea_carrera_ev.iniciar_evaluacion');
    Route::post('linea_carrera_ev/examen', 'examen_en')->name('linea_carrera_ev.examen');
    Route::post('linea_carrera_ev/{id}/terminar_evaluacion', 'terminar_evaluacion_ev')->name('linea_carrera_ev.terminar_evaluacion');
    Route::get('linea_carrera_re', 'index_re')->name('linea_carrera_re');
    Route::get('linea_carrera_re/list', 'list_re')->name('linea_carrera_re.list');
    Route::get('linea_carrera_re/{id}/edit', 'edit_re')->name('linea_carrera_re.edit');
    Route::put('linea_carrera_re/{id}', 'update_re')->name('linea_carrera_re.update');
    Route::get('linea_carrera_re/{id}/show', 'show_re')->name('linea_carrera_re.show');
});
//CAJA - LÍNEA DE CARRERA CONFIGURABLE
Route::controller(LineaCarreraConfController::class)->group(function () {
    Route::get('linea_carrera_conf', 'index')->name('linea_carrera_conf');
    Route::get('linea_carrera_conf_pre', 'index_pre')->name('linea_carrera_conf_pre');
    Route::get('linea_carrera_conf_pre/list', 'list_pre')->name('linea_carrera_conf_pre.list');
    Route::get('linea_carrera_conf_pre/create', 'create_pre')->name('linea_carrera_conf_pre.create');
    Route::post('linea_carrera_conf_pre', 'store_pre')->name('linea_carrera_conf_pre.store');
    Route::get('linea_carrera_conf_pre/{id}/edit', 'edit_pre')->name('linea_carrera_conf_pre.edit');
    Route::put('linea_carrera_conf_pre/{id}', 'update_pre')->name('linea_carrera_conf_pre.update');
    Route::get('linea_carrera_conf_pre/{id}/show', 'show_pre')->name('linea_carrera_conf_pre.show');
    Route::delete('linea_carrera_conf_pre/{id}', 'destroy_pre')->name('linea_carrera_conf_pre.destroy');
});
//INTERNA - NOTIFICACIÓN CONFIGURABLE
Route::controller(NotificacionConfController::class)->group(function () {
    Route::get('notificacion_conf', 'index')->name('notificacion_conf');
    Route::get('notificacion_conf_ti', 'index_ti')->name('notificacion_conf_ti');
    Route::get('notificacion_conf_ti/list', 'list_ti')->name('notificacion_conf_ti.list');
    Route::get('notificacion_conf_ti/create', 'create_ti')->name('notificacion_conf_ti.create');
    Route::post('notificacion_conf_ti', 'store_ti')->name('notificacion_conf_ti.store');
    Route::get('notificacion_conf_ti/{id}/edit', 'edit_ti')->name('notificacion_conf_ti.edit');
    Route::put('notificacion_conf_ti/{id}', 'update_ti')->name('notificacion_conf_ti.update');
    Route::delete('notificacion_conf_ti/{id}', 'destroy_ti')->name('notificacion_conf_ti.destroy');
    Route::put('notificacion/{id}/leido', 'update_leido')->name('notificacion.update_leido');
});
//CAJA - CAMBIO DE PRENDA
Route::controller(CambioPrendaController::class)->group(function () {
    Route::get('cambio_prenda', 'index_reg')->name('cambio_prenda');
    Route::post('cambio_prenda/list', 'list_reg')->name('cambio_prenda.list');
    Route::get('cambio_prenda_con/create', 'create_reg_con')->name('cambio_prenda_con.create');
    Route::post('cambio_prenda/comprobante', 'comprobante_reg')->name('cambio_prenda.comprobante');
    Route::post('cambio_prenda_con', 'store_reg_con')->name('cambio_prenda_con.store');
    Route::get('cambio_prenda_sin/create', 'create_reg_sin')->name('cambio_prenda_sin.create');
    Route::post('cambio_prenda/producto', 'producto_reg')->name('cambio_prenda.producto');
    Route::post('cambio_prenda_sin', 'store_reg_sin')->name('cambio_prenda_sin.store');
    Route::get('cambio_prenda/{id}/edit', 'edit_reg')->name('cambio_prenda.edit');
    Route::put('cambio_prenda_con/{id}', 'update_reg_con')->name('cambio_prenda_con.update');
    Route::put('cambio_prenda_sin/{id}', 'update_reg_sin')->name('cambio_prenda_sin.update');
    Route::put('cambio_prenda/{id}/cambiar_estado', 'cambiar_estado_reg')->name('cambio_prenda.cambiar_estado');
    Route::delete('cambio_prenda/{id}', 'destroy_reg')->name('cambio_prenda.destroy');
    Route::get('cambio_prenda/{id}/modal_finalizar', 'modal_finalizar_reg')->name('cambio_prenda.modal_finalizar');
    Route::put('cambio_prenda/{id}/finalizar', 'finalizar_reg')->name('cambio_prenda.finalizar');
    Route::get('cambio_prenda/{id}/detalle', 'detalle_reg')->name('cambio_prenda.detalle');
});
//CAJA - CAMBIO DE PRENDA CONFIGURABLE
Route::controller(CambioPrendaConfController::class)->group(function () {
    Route::get('cambio_prenda_conf', 'index')->name('cambio_prenda_conf');
    Route::get('cambio_prenda_conf_mo', 'index_mo')->name('cambio_prenda_conf_mo');
    Route::get('cambio_prenda_conf_mo/list', 'list_mo')->name('cambio_prenda_conf_mo.list');
    Route::get('cambio_prenda_conf_mo/create', 'create_mo')->name('cambio_prenda_conf_mo.create');
    Route::post('cambio_prenda_conf_mo', 'store_mo')->name('cambio_prenda_conf_mo.store');
    Route::get('cambio_prenda_conf_mo/{id}/edit', 'edit_mo')->name('cambio_prenda_conf_mo.edit');
    Route::put('cambio_prenda_conf_mo/{id}', 'update_mo')->name('cambio_prenda_conf_mo.update');
    Route::delete('cambio_prenda_conf_mo/{id}', 'destroy_mo')->name('cambio_prenda_conf_mo.destroy');
});
//CAJA - DURACIÓN DE TRANSACCIONES
Route::controller(DuracionTransaccionController::class)->group(function () {
    Route::get('duracion_transaccion', 'index')->name('duracion_transaccion');
    Route::post('duracion_transaccion/list', 'list')->name('duracion_transaccion.list');
    Route::get('duracion_transaccion/{inicio}/{fin}/excel', 'excel')->name('duracion_transaccion.excel');
});

//PRODUCCIÓN - PRODUCCIÓN
Route::controller(ProduccionController::class)->group(function () {
    // ASIGNAR VISITAS
    Route::get('produccionav', 'indexav')->name('produccionav');
    Route::get('produccionrev', 'indexrev')->name('produccionrev');
    Route::get('produccionft', 'indexft')->name('produccionft');
    Route::get('produccion_av', 'index_av')->name('produccion_av');
    Route::get('produccion_av/list', 'list_av')->name('produccion_av.list');
    Route::get('produccion_av/create', 'create_av')->name('produccion_av.create');
    Route::post('produccion_av', 'store_av')->name('produccion_av.store');
    Route::get('produccion_av/{id}/edit', 'edit_av')->name('produccion_av.edit');
    Route::put('produccion_av/{id}', 'update_av')->name('produccion_av.update');
    Route::post('produccion_detalle_av/{id}', 'update_detalle_av')->name('produccion_detalle_av.update');
    Route::get('produccion_av/{id}/detalle', 'detalle_av')->name('produccion_av.detalle');
    Route::delete('produccion_av/{id}', 'destroy_av')->name('produccion_av.destroy');
    Route::post('Produccion/ListaAsignacionVisitas/{fec_ini}/{fec_fin}', 'ListaAsignacionVisitas');
    // REGISTRAR VISITAS
    Route::get('produccion_rv', 'index_rv')->name('produccion_rv');
    Route::get('produccion_rv/list', 'list_rv')->name('produccion_rv.list');
    Route::get('produccion_rv/create', 'create_rv')->name('produccion_rv.create');
    Route::post('produccion_rv', 'store_rv')->name('produccion_rv.store');
    Route::get('produccion_rv/{id}/edit', 'edit_rv')->name('produccion_rv.edit');
    Route::put('produccion_rv/{id}', 'update_rv')->name('produccion_rv.update');
    Route::delete('produccion_rv/{id}', 'destroy_rv')->name('produccion_rv.destroy');
    Route::post('Produccion/ListaRegistroVisitas/{fec_ini}/{fec_fin}', 'ListaRegistroVisitas');

    Route::post('produccion_rv/{id}/iniciar', 'iniciar_rv')->name('produccion_rv.iniciar');
    Route::post('produccion_rv/{id}/finalizar', 'finalizar_rv')->name('produccion_rv.finalizar');
    Route::get('produccion_rv/{id}/detalle', 'detalle_rv')->name('produccion_rv.detalle');

    // FICHAS TÉCNICAS
    Route::get('produccion_ft', 'index_ft')->name('produccion_ft');
    Route::get('produccion_ft/list', 'list_ft')->name('produccion_ft.list');
    Route::get('produccion_ft/create', 'create_ft')->name('produccion_ft.create');
    Route::post('produccion_ft', 'store_ft')->name('produccion_ft.store');
    Route::get('produccion_ft/{id}/edit', 'edit_ft')->name('produccion_ft.edit');
    Route::delete('produccion_ft/{id}', 'destroy_ft')->name('produccion_ft.destroy');
    Route::get('produccion_ft/{id}/image', 'image_ft')->name('produccion_ft.image');

    Route::post('produccion_ft/{id}/iniciar', 'iniciar_rv')->name('produccion_ft.iniciar');
    Route::post('produccion_ft/{id}/finalizar', 'finalizar_rv')->name('produccion_ft.finalizar');
    Route::get('produccion_ft/{id}/detalle', 'detalle_rv')->name('produccion_ft.detalle');
});



//ÁREA FINANZAS
Route::controller(FinanzasInicioController::class)->group(function () {
    Route::get('finanzas', 'index')->name('finanzas');
});
//ÁREA MANUFACTURA
Route::controller(ManufacturaInicioController::class)->group(function () {
    Route::get('manufactura', 'index')->name('manufactura');
});
//TESORERÍA - CAJA CHICA CONFIGURABLE
Route::controller(CajaChicaConfController::class)->group(function () {
    Route::get('caja_chica_conf', 'index')->name('caja_chica_conf');
    Route::get('caja_chica_conf_ca', 'index_ca')->name('caja_chica_conf_ca');
    Route::get('caja_chica_conf_ca/list', 'list_ca')->name('caja_chica_conf_ca.list');
    Route::get('caja_chica_conf_ca/create', 'create_ca')->name('caja_chica_conf_ca.create');
    Route::post('caja_chica_conf_ca', 'store_ca')->name('caja_chica_conf_ca.store');
    Route::get('caja_chica_conf_ca/{id}/edit', 'edit_ca')->name('caja_chica_conf_ca.edit');
    Route::put('caja_chica_conf_ca/{id}', 'update_ca')->name('caja_chica_conf_ca.update');
    Route::delete('caja_chica_conf_ca/{id}', 'destroy_ca')->name('caja_chica_conf_ca.destroy');
    Route::get('caja_chica_conf_sc', 'index_sc')->name('caja_chica_conf_sc');
    Route::get('caja_chica_conf_sc/list', 'list_sc')->name('caja_chica_conf_sc.list');
    Route::get('caja_chica_conf_sc/create', 'create_sc')->name('caja_chica_conf_sc.create');
    Route::post('caja_chica_conf_sc/traer_categoria', 'traer_categoria_sc')->name('caja_chica_conf_sc.traer_categoria');
    Route::post('caja_chica_conf_sc', 'store_sc')->name('caja_chica_conf_sc.store');
    Route::get('caja_chica_conf_sc/{id}/edit', 'edit_sc')->name('caja_chica_conf_sc.edit');
    Route::put('caja_chica_conf_sc/{id}', 'update_sc')->name('caja_chica_conf_sc.update');
    Route::delete('caja_chica_conf_sc/{id}', 'destroy_sc')->name('caja_chica_conf_sc.destroy');
});
//TESORERÍA - CAJA CHICA
Route::controller(CajaChicaController::class)->group(function () {
    Route::get('caja_chica', 'index')->name('caja_chica');
    Route::post('caja_chica/list', 'list')->name('caja_chica.list');
    Route::get('caja_chica/create_mo', 'create_mo')->name('caja_chica.create_mo');
    Route::post('caja_chica/traer_sub_categoria_mo', 'traer_sub_categoria_mo')->name('caja_chica.traer_sub_categoria_mo');
    Route::get('caja_chica/list_tmp_mo', 'list_tmp_mo')->name('caja_chica.list_tmp_mo');
    Route::post('caja_chica/store_tmp_mo', 'store_tmp_mo')->name('caja_chica.store_tmp_mo');
    Route::delete('caja_chica/{id}/destroy_tmp_mo', 'destroy_tmp_mo')->name('caja_chica.destroy_tmp_mo');
    Route::get('caja_chica/total_tmp_mo', 'total_tmp_mo')->name('caja_chica.total_tmp_mo');
    Route::post('caja_chica_mo', 'store_mo')->name('caja_chica.store_mo');
    Route::get('caja_chica/create_pv', 'create_pv')->name('caja_chica.create_pv');
    Route::post('caja_chica/traer_categoria_pv', 'traer_categoria_pv')->name('caja_chica.traer_categoria_pv');
    Route::post('caja_chica/traer_sub_categoria_pv', 'traer_sub_categoria_pv')->name('caja_chica.traer_sub_categoria_pv');
    Route::post('caja_chica/traer_tipo_pago', 'traer_tipo_pago')->name('caja_chica.traer_tipo_pago');
    Route::post('caja_chica/consultar_ruc', 'consultar_ruc')->name('caja_chica.consultar_ruc');
    Route::get('caja_chica/list_tmp_pv', 'list_tmp_pv')->name('caja_chica.list_tmp_pv');
    Route::post('caja_chica/store_tmp_pv', 'store_tmp_pv')->name('caja_chica.store_tmp_pv');
    Route::delete('caja_chica/{id}/destroy_tmp_pv', 'destroy_tmp_pv')->name('caja_chica.destroy_tmp_pv');
    Route::get('caja_chica/total_tmp_pv', 'total_tmp_pv')->name('caja_chica.total_tmp_pv');
    Route::post('caja_chica_pv', 'store_pv')->name('caja_chica.store_pv');
    Route::get('caja_chica/{id}/show', 'show')->name('caja_chica.show');
    Route::get('caja_chica/{id}/edit', 'edit')->name('caja_chica.edit');
    Route::get('caja_chica/{id}/list_ruta_mo', 'list_ruta_mo')->name('caja_chica.list_ruta_mo');
    Route::put('caja_chica/{id}/store_ruta_mo', 'store_ruta_mo')->name('caja_chica.store_ruta_mo');
    Route::delete('caja_chica/{id}/destroy_ruta_mo', 'destroy_ruta_mo')->name('caja_chica.destroy_ruta_mo');
    Route::get('caja_chica/{id}/total_ruta_mo', 'total_ruta_mo')->name('caja_chica.total_ruta_mo');
    Route::put('caja_chica_mo/{id}', 'update_mo')->name('caja_chica.update_mo');
    Route::get('caja_chica/{id}/list_producto_pv', 'list_producto_pv')->name('caja_chica.list_producto_pv');
    Route::put('caja_chica/{id}/store_producto_pv', 'store_producto_pv')->name('caja_chica.store_producto_pv');
    Route::delete('caja_chica/{id}/destroy_producto_pv', 'destroy_producto_pv')->name('caja_chica.destroy_producto_pv');
    Route::get('caja_chica/{id}/total_producto_pv', 'total_producto_pv')->name('caja_chica.total_producto_pv');
    Route::put('caja_chica_pv/{id}', 'update_pv')->name('caja_chica.update_pv');
    Route::get('caja_chica/{id}/download', 'download')->name('caja_chica.download');
    Route::get('caja_chica/{id}/validar', 'validar')->name('caja_chica.validar');
    Route::put('caja_chica_mo/{id}/validar', 'validar_mo')->name('caja_chica.validar_mo');
    Route::put('caja_chica_pv/{id}/validar', 'validar_pv')->name('caja_chica.validar_pv');
    Route::get('caja_chica/{id}/credito', 'credito')->name('caja_chica.credito');
    Route::get('caja_chica/list_credito', 'list_credito')->name('caja_chica.list_credito');
    Route::get('caja_chica/{id}/saldo', 'saldo')->name('caja_chica.saldo');
    Route::post('caja_chica_cr/{id}', 'store_cr')->name('caja_chica.store_cr');
    Route::delete('caja_chica_cr/{id}', 'destroy_cr')->name('caja_chica.destroy_cr');
    Route::put('caja_chica/{id}/anular', 'anular')->name('caja_chica.anular');
    Route::delete('caja_chica/{id}', 'destroy')->name('caja_chica.destroy');
    Route::get('caja_chica/{fec_inicio}/{fec_fin}/excel', 'excel')->name('caja_chica.excel');
});
//CAJA - INSUMOS CONFIGURABLE
Route::controller(InsumoConfController::class)->group(function () {
    Route::get('insumo_conf', 'index')->name('insumo_conf');
    Route::get('insumo_conf_in', 'index_in')->name('insumo_conf_in');
    Route::get('insumo_conf_in/list', 'list_in')->name('insumo_conf_in.list');
    Route::get('insumo_conf_in/create', 'create_in')->name('insumo_conf_in.create');
    Route::post('insumo_conf_in', 'store_in')->name('insumo_conf_in.store');
    Route::get('insumo_conf_in/{id}/edit', 'edit_in')->name('insumo_conf_in.edit');
    Route::put('insumo_conf_in/{id}', 'update_in')->name('insumo_conf_in.update');
    Route::delete('insumo_conf_in/{id}', 'destroy_in')->name('insumo_conf_in.destroy');
    Route::get('insumo_conf_pr', 'index_pr')->name('insumo_conf_pr');
    Route::get('insumo_conf_pr/list', 'list_pr')->name('insumo_conf_pr.list');
    Route::get('insumo_conf_pr/create', 'create_pr')->name('insumo_conf_pr.create');
    Route::post('insumo_conf_pr', 'store_pr')->name('insumo_conf_pr.store');
    Route::get('insumo_conf_pr/{id}/edit', 'edit_pr')->name('insumo_conf_pr.edit');
    Route::put('insumo_conf_pr/{id}', 'update_pr')->name('insumo_conf_pr.update');
    Route::delete('insumo_conf_pr/{id}', 'destroy_pr')->name('insumo_conf_pr.destroy');
});
//CAJA - INSUMOS
Route::controller(InsumoController::class)->group(function () {
    Route::get('insumo', 'index')->name('insumo');
    Route::get('insumo_en', 'index_en')->name('insumo_en');
    Route::get('insumo_en/list', 'list_en')->name('insumo_en.list');
    Route::get('insumo_en/create', 'create_en')->name('insumo_en.create');
    Route::post('insumo_en', 'store_en')->name('insumo_en.store');
    Route::get('insumo_en/{id}/edit', 'edit_en')->name('insumo_en.edit');
    Route::get('insumo_en/{id}/{tipo}/download', 'download_en')->name('insumo_en.download');
    Route::put('insumo_en/{id}', 'update_en')->name('insumo_en.update');
    Route::delete('insumo_en/{id}', 'destroy_en')->name('insumo_en.destroy');
    Route::get('insumo_ra', 'index_ra')->name('insumo_ra');
    Route::get('insumo_ra/list_izquierda', 'list_izquierda_ra')->name('insumo_ra.list_izquierda');
    Route::get('insumo_ra/list_derecha', 'list_derecha_ra')->name('insumo_ra.list_derecha');
    Route::get('insumo_ra/create', 'create_ra')->name('insumo_ra.create');
    Route::post('insumo_ra', 'store_ra')->name('insumo_ra.store');
    Route::get('insumo_ra/{id}/edit', 'edit_ra')->name('insumo_ra.edit');
    Route::put('insumo_ra/{id}', 'update_ra')->name('insumo_ra.update');
    Route::delete('insumo_ra/{id}', 'destroy_ra')->name('insumo_ra.destroy');
    Route::get('insumo_ra/excel_izquierda', 'excel_izquierda_ra')->name('insumo_ra.excel_izquierda');
    Route::get('insumo_ra/excel_derecha', 'excel_derecha_ra')->name('insumo_ra.excel_derecha');
    Route::get('insumo_sa', 'index_sa')->name('insumo_sa');
    Route::post('insumo_sa/list', 'list_sa')->name('insumo_sa.list');
    Route::get('insumo_sa/{id}/edit', 'edit_sa')->name('insumo_sa.edit');
    Route::put('insumo_sa/{id}', 'update_sa')->name('insumo_sa.update');
    Route::get('insumo_sa/{cod_base}/{id_insumo}/{inicio}/{fin}/excel', 'excel_sa')->name('insumo_sa.excel');
    Route::get('insumo_ro', 'index_ro')->name('insumo_ro');
    Route::get('insumo_ro/list_izquierda', 'list_izquierda_ro')->name('insumo_ro.list_izquierda');
    Route::get('insumo_ro/list_derecha', 'list_derecha_ro')->name('insumo_ro.list_derecha');
    Route::get('insumo_ro/excel_izquierda', 'excel_izquierda_ro')->name('insumo_ro.excel_izquierda');
    Route::get('insumo_ro/excel_derecha', 'excel_derecha_ro')->name('insumo_ro.excel_derecha');
});
//CAJA - SALIDA DE INSUMO
Route::controller(SalidaInsumoController::class)->group(function () {
    Route::get('salida_insumo', 'index')->name('salida_insumo');
    Route::get('salida_insumo/list_izquierda', 'list_izquierda')->name('salida_insumo.list_izquierda');
    Route::get('salida_insumo/list_derecha', 'list_derecha')->name('salida_insumo.list_derecha');
    Route::get('salida_insumo/create', 'create')->name('salida_insumo.create');
    Route::post('salida_insumo', 'store')->name('salida_insumo.store');
});
//CAJA - CAPACITACIÓN CAJEROS
Route::controller(CapacitacionCajeroController::class)->group(function () {
    Route::get('capacitacion_cajero', 'index')->name('capacitacion_cajero');
    Route::get('capacitacion_cajero/list', 'list')->name('capacitacion_cajero.list');
    Route::get('capacitacion_cajero/excel', 'excel')->name('capacitacion_cajero.excel');
});
//CAJA - REQUISICIÓN TIENDA CONFIGURABLE
Route::controller(RequisicionTiendaConfController::class)->group(function () {
    Route::get('requisicion_tienda_conf', 'index')->name('requisicion_tienda_conf');
    Route::get('requisicion_tienda_conf_ma', 'index_ma')->name('requisicion_tienda_conf_ma');
    Route::get('requisicion_tienda_conf_ma/list', 'list_ma')->name('requisicion_tienda_conf_ma.list');
    Route::get('requisicion_tienda_conf_ma/create', 'create_ma')->name('requisicion_tienda_conf_ma.create');
    Route::post('requisicion_tienda_conf_ma', 'store_ma')->name('requisicion_tienda_conf_ma.store');
    Route::get('requisicion_tienda_conf_ma/{id}/edit', 'edit_ma')->name('requisicion_tienda_conf_ma.edit');
    Route::put('requisicion_tienda_conf_ma/{id}', 'update_ma')->name('requisicion_tienda_conf_ma.update');
    Route::delete('requisicion_tienda_conf_ma/{id}', 'destroy_ma')->name('requisicion_tienda_conf_ma.destroy');
    Route::get('requisicion_tienda_conf_mo', 'index_mo')->name('requisicion_tienda_conf_mo');
    Route::get('requisicion_tienda_conf_mo/list', 'list_mo')->name('requisicion_tienda_conf_mo.list');
    Route::get('requisicion_tienda_conf_mo/create', 'create_mo')->name('requisicion_tienda_conf_mo.create');
    Route::post('requisicion_tienda_conf_mo', 'store_mo')->name('requisicion_tienda_conf_mo.store');
    Route::get('requisicion_tienda_conf_mo/{id}/edit', 'edit_mo')->name('requisicion_tienda_conf_mo.edit');
    Route::put('requisicion_tienda_conf_mo/{id}', 'update_mo')->name('requisicion_tienda_conf_mo.update');
    Route::delete('requisicion_tienda_conf_mo/{id}', 'destroy_mo')->name('requisicion_tienda_conf_mo.destroy');
    Route::get('requisicion_tienda_conf_co', 'index_co')->name('requisicion_tienda_conf_co');
    Route::get('requisicion_tienda_conf_co/list', 'list_co')->name('requisicion_tienda_conf_co.list');
    Route::get('requisicion_tienda_conf_co/create', 'create_co')->name('requisicion_tienda_conf_co.create');
    Route::post('requisicion_tienda_conf_co', 'store_co')->name('requisicion_tienda_conf_co.store');
    Route::get('requisicion_tienda_conf_co/{id}/edit', 'edit_co')->name('requisicion_tienda_conf_co.edit');
    Route::put('requisicion_tienda_conf_co/{id}', 'update_co')->name('requisicion_tienda_conf_co.update');
    Route::delete('requisicion_tienda_conf_co/{id}', 'destroy_co')->name('requisicion_tienda_conf_co.destroy');
    Route::get('requisicion_tienda_conf_um', 'index_um')->name('requisicion_tienda_conf_um');
    Route::get('requisicion_tienda_conf_um/list', 'list_um')->name('requisicion_tienda_conf_um.list');
    Route::get('requisicion_tienda_conf_um/create', 'create_um')->name('requisicion_tienda_conf_um.create');
    Route::post('requisicion_tienda_conf_um', 'store_um')->name('requisicion_tienda_conf_um.store');
    Route::get('requisicion_tienda_conf_um/{id}/edit', 'edit_um')->name('requisicion_tienda_conf_um.edit');
    Route::put('requisicion_tienda_conf_um/{id}', 'update_um')->name('requisicion_tienda_conf_um.update');
    Route::delete('requisicion_tienda_conf_um/{id}', 'destroy_um')->name('requisicion_tienda_conf_um.destroy');
    Route::get('requisicion_tienda_conf_es', 'index_es')->name('requisicion_tienda_conf_es');
    Route::get('requisicion_tienda_conf_es/list', 'list_es')->name('requisicion_tienda_conf_es.list');
    Route::get('requisicion_tienda_conf_es/create', 'create_es')->name('requisicion_tienda_conf_es.create');
    Route::post('requisicion_tienda_conf_es', 'store_es')->name('requisicion_tienda_conf_es.store');
    Route::get('requisicion_tienda_conf_es/{id}/edit', 'edit_es')->name('requisicion_tienda_conf_es.edit');
    Route::put('requisicion_tienda_conf_es/{id}', 'update_es')->name('requisicion_tienda_conf_es.update');
    Route::delete('requisicion_tienda_conf_es/{id}', 'destroy_es')->name('requisicion_tienda_conf_es.destroy');
    Route::get('requisicion_tienda_conf_ca', 'index_ca')->name('requisicion_tienda_conf_ca');
    Route::get('requisicion_tienda_conf_ca/list', 'list_ca')->name('requisicion_tienda_conf_ca.list');
    Route::get('requisicion_tienda_conf_ca/create', 'create_ca')->name('requisicion_tienda_conf_ca.create');
    Route::post('requisicion_tienda_conf_ca', 'store_ca')->name('requisicion_tienda_conf_ca.store');
    Route::get('requisicion_tienda_conf_ca/{id}/edit', 'edit_ca')->name('requisicion_tienda_conf_ca.edit');
    Route::put('requisicion_tienda_conf_ca/{id}', 'update_ca')->name('requisicion_tienda_conf_ca.update');
    Route::delete('requisicion_tienda_conf_ca/{id}', 'destroy_ca')->name('requisicion_tienda_conf_ca.destroy');
    Route::get('requisicion_tienda_conf_pr', 'index_pr')->name('requisicion_tienda_conf_pr');
    Route::get('requisicion_tienda_conf_pr/list', 'list_pr')->name('requisicion_tienda_conf_pr.list');
    Route::get('requisicion_tienda_conf_pr/create', 'create_pr')->name('requisicion_tienda_conf_pr.create');
    Route::post('requisicion_tienda_conf_pr/traer_modelo', 'traer_modelo_pr')->name('requisicion_tienda_conf_pr.traer_modelo');
    Route::post('requisicion_tienda_conf_pr', 'store_pr')->name('requisicion_tienda_conf_pr.store');
    Route::get('requisicion_tienda_conf_pr/{id}/edit', 'edit_pr')->name('requisicion_tienda_conf_pr.edit');
    Route::put('requisicion_tienda_conf_pr/{id}', 'update_pr')->name('requisicion_tienda_conf_pr.update');
    Route::delete('requisicion_tienda_conf_pr/{id}', 'destroy_pr')->name('requisicion_tienda_conf_pr.destroy');
});
//CAJA - REQUISICIÓN TIENDA
Route::controller(RequisicionTiendaController::class)->group(function () {
    Route::get('requisicion_tienda', 'index')->name('requisicion_tienda');
    Route::post('requisicion_tienda/list', 'list')->name('requisicion_tienda.list');
    Route::get('requisicion_tienda/create', 'create')->name('requisicion_tienda.create');
    Route::get('requisicion_tienda/list_tmp', 'list_tmp')->name('requisicion_tienda.list_tmp');
    Route::post('requisicion_tienda_tmp', 'store_tmp')->name('requisicion_tienda.store_tmp');
    Route::delete('requisicion_tienda_tmp/{id}', 'destroy_tmp')->name('requisicion_tienda.destroy_tmp');
    Route::post('requisicion_tienda', 'store')->name('requisicion_tienda.store');
    Route::get('requisicion_tienda/{id}/edit', 'edit')->name('requisicion_tienda.edit');
    Route::put('requisicion_tienda/{id}', 'update')->name('requisicion_tienda.update');
    Route::get('requisicion_tienda/{id}/show', 'show')->name('requisicion_tienda.show');
    Route::get('requisicion_tienda/{id}/list_detalle', 'list_detalle')->name('requisicion_tienda.list_detalle');
    Route::post('requisicion_tienda/{id}/detalle', 'store_detalle')->name('requisicion_tienda.store_detalle');
    Route::get('requisicion_tienda/{id}/edit_detalle', 'edit_detalle')->name('requisicion_tienda.edit_detalle');
    Route::get('requisicion_tienda/cancelar_detalle', 'cancelar_detalle')->name('requisicion_tienda.cancelar_detalle');
    Route::post('requisicion_tienda_detalle/{id}/update_detalle', 'update_detalle')->name('requisicion_tienda.update_detalle');
    Route::delete('requisicion_tienda/{id}/detalle', 'destroy_detalle')->name('requisicion_tienda.destroy_detalle');
    Route::put('requisicion_tienda/{id}/aprobar', 'aprobar')->name('requisicion_tienda.aprobar');
    Route::delete('requisicion_tienda/{id}', 'destroy')->name('requisicion_tienda.destroy');
});
//TESORERÍA - TABLA MAESTRA
Route::controller(TablaMaestraTesoreriaController::class)->group(function () {
    Route::get('tabla_maestra_tesoreria', 'index')->name('tabla_maestra_tesoreria');
    Route::get('tabla_maestra_tesoreria/list', 'list')->name('tabla_maestra_tesoreria.list');
});
//TESORERÍA - REGISTRO LETRAS
Route::controller(RegistroLetraController::class)->group(function () {
    Route::get('registro_letra', 'index')->name('registro_letra');
    Route::post('registro_letra/list', 'list')->name('registro_letra.list');
    Route::get('registro_letra/create', 'create')->name('registro_letra.create');
    Route::post('registro_letra', 'store')->name('registro_letra.store');
    Route::get('registro_letra/import', 'import')->name('registro_letra.import');
    Route::get('registro_letra/excel_plantilla', 'excel_plantilla')->name('registro_letra.excel_plantilla');
    Route::post('registro_letra/store_imp', 'store_imp')->name('registro_letra.store_imp');
    Route::get('registro_letra/excel_error', 'excel_error')->name('registro_letra.excel_error');
    Route::get('registro_letra/{id}/edit', 'edit')->name('registro_letra.edit');
    Route::put('registro_letra/{id}', 'update')->name('registro_letra.update');
    Route::get('registro_letra/{id}/{tipo}/unico', 'unico')->name('registro_letra.unico');
    Route::put('registro_letra/{id}/update_unico', 'update_unico')->name('registro_letra.update_unico');
    Route::get('registro_letra/{id}/{tipo}/estado', 'estado')->name('registro_letra.estado');
    Route::put('registro_letra/{id}/update_estado', 'update_estado')->name('registro_letra.update_estado');
    Route::delete('registro_letra/{id}', 'destroy')->name('registro_letra.destroy');
    Route::get('registro_letra/{estado}/{id_empresa}/{id_aceptante}/{tipo_fecha}/{mes}/{anio}/excel', 'excel')->name('registro_letra.excel');
});
//TESORERÍA - LETRAS POR COBRAR
Route::controller(LetraCobrarController::class)->group(function () {
    Route::get('letra_cobrar', 'index')->name('letra_cobrar');
    Route::post('letra_cobrar/list', 'list')->name('letra_cobrar.list');
    Route::get('letra_cobrar/create', 'create')->name('letra_cobrar.create');
    Route::post('letra_cobrar', 'store')->name('letra_cobrar.store');
    Route::get('letra_cobrar/{id}/edit', 'edit')->name('letra_cobrar.edit');
    Route::put('letra_cobrar/{id}', 'update')->name('letra_cobrar.update');
    Route::get('letra_cobrar/{id}/{tipo}/unico', 'unico')->name('letra_cobrar.unico');
    Route::put('letra_cobrar/{id}/update_unico', 'update_unico')->name('letra_cobrar.update_unico');
    Route::get('letra_cobrar/{id}/{tipo}/estado', 'estado')->name('letra_cobrar.estado');
    Route::put('letra_cobrar/{id}/update_estado', 'update_estado')->name('letra_cobrar.update_estado');
    Route::delete('letra_cobrar/{id}', 'destroy')->name('letra_cobrar.destroy');
    Route::get('letra_cobrar/{estado}/{id_empresa}/{id_cliente}/{mes}/{anio}/excel', 'excel')->name('letra_cobrar.excel');
});
//TESORERÍA - REGISTRO DE SERVICIOS
Route::controller(RegistroServicioController::class)->group(function () {
    Route::get('registro_servicio', 'index')->name('registro_servicio');
    Route::post('registro_servicio/list', 'list')->name('registro_servicio.list');
    Route::get('registro_servicio/create', 'create')->name('registro_servicio.create');
    Route::post('registro_servicio/traer_lugar', 'traer_lugar')->name('registro_servicio.traer_lugar');
    Route::post('registro_servicio/traer_servicio', 'traer_servicio')->name('registro_servicio.traer_servicio');
    Route::post('registro_servicio/traer_proveedor', 'traer_proveedor')->name('registro_servicio.traer_proveedor');
    Route::post('registro_servicio/traer_lectura', 'traer_lectura')->name('registro_servicio.traer_lectura');
    Route::post('registro_servicio/traer_suministro', 'traer_suministro')->name('registro_servicio.traer_suministro');
    Route::post('registro_servicio', 'store')->name('registro_servicio.store');
    Route::get('registro_servicio/{id}/edit', 'edit')->name('registro_servicio.edit');
    Route::put('registro_servicio/{id}', 'update')->name('registro_servicio.update');
    Route::get('registro_servicio/{id}/estado', 'estado')->name('registro_servicio.estado');
    Route::put('registro_servicio/{id}/update_estado', 'update_estado')->name('registro_servicio.update_estado');
    Route::delete('registro_servicio/{id}', 'destroy')->name('registro_servicio.destroy');
    Route::get('registro_servicio/{todos}/{cod_base}/{estado}/{id_servicio}/{id_lugar_servicio}/{mes}/{anio}/excel', 'excel')->name('registro_servicio.excel');
});
//TESORERÍA - REGISTRO DE CHEQUES CONFIGURABLE
Route::controller(RegistroChequeConfController::class)->group(function () {
    Route::get('registro_cheque_conf', 'index')->name('registro_cheque_conf');
    Route::get('registro_cheque_conf_co', 'index_co')->name('registro_cheque_conf_co');
    Route::get('registro_cheque_conf_co/list', 'list_co')->name('registro_cheque_conf_co.list');
    Route::get('registro_cheque_conf_co/create', 'create_co')->name('registro_cheque_conf_co.create');
    Route::post('registro_cheque_conf_co', 'store_co')->name('registro_cheque_conf_co.store');
    Route::get('registro_cheque_conf_co/{id}/edit', 'edit_co')->name('registro_cheque_conf_co.edit');
    Route::put('registro_cheque_conf_co/{id}', 'update_co')->name('registro_cheque_conf_co.update');
    Route::delete('registro_cheque_conf_co/{id}', 'destroy_co')->name('registro_cheque_conf_co.destroy');
});
//TESORERÍA - REGISTRO DE CHEQUES
Route::controller(RegistroChequeController::class)->group(function () {
    Route::get('registro_cheque', 'index')->name('registro_cheque');
    Route::post('registro_cheque/list', 'list')->name('registro_cheque.list');
    Route::get('registro_cheque/create', 'create')->name('registro_cheque.create');
    Route::post('registro_cheque', 'store')->name('registro_cheque.store');
    Route::get('registro_cheque/{id}/edit', 'edit')->name('registro_cheque.edit');
    Route::put('registro_cheque/{id}', 'update')->name('registro_cheque.update');
    Route::put('registro_cheque/{id}/update_estado', 'update_estado')->name('registro_cheque.update_estado');
    Route::get('registro_cheque/{id}/modal_cancelar', 'modal_cancelar')->name('registro_cheque.modal_cancelar');
    Route::put('registro_cheque/{id}/cancelar', 'cancelar')->name('registro_cheque.cancelar');
    Route::get('registro_cheque/{id}/modal_motivo', 'modal_motivo')->name('registro_cheque.modal_motivo');
    Route::put('registro_cheque/{id}/update_motivo', 'update_motivo')->name('registro_cheque.update_motivo');
    Route::get('registro_cheque/{id}/modal_archivo', 'modal_archivo')->name('registro_cheque.modal_archivo');
    Route::put('registro_cheque/{id}/update_archivo', 'update_archivo')->name('registro_cheque.update_archivo');
    Route::get('registro_cheque/{id}/modal_anular', 'modal_anular')->name('registro_cheque.modal_anular');
    Route::delete('registro_cheque/{id}', 'destroy')->name('registro_cheque.destroy');
    Route::get('registro_cheque/{todos}/{id_empresa}/{estado}/{fec_inicio}/{fec_fin}/{tipo_fecha}/excel', 'excel')->name('registro_cheque.excel');
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
    Route::get('OcurrenciaTienda/index', 'Ocurrencia_Tienda')->name('ocurrencia_tienda');
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
    Route::get('OcurrenciaTienda/Traer_Tipo_Ocurrencia_Busq', 'Traer_Tipo_Ocurrencia_Busq');
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
Route::controller(InicioSeguridadController::class)->group(function () {
    Route::get('InicioSeguridad/index', 'index')->name('seguridad');
});

use App\Http\Controllers\InicioTiendaController;
//Inicio tienda
Route::controller(InicioTiendaController::class)->group(function () {
    Route::get('InicioTienda/index', 'index')->name('tienda');
});

use App\Http\Controllers\InicioComercialController;

Route::controller(InicioComercialController::class)->group(function () {
    Route::get('Comercial/InicioComercial', 'index');
});

use App\Http\Controllers\SliderMarketingController;
//Slider Marketing
Route::controller(SliderMarketingController::class)->group(function () {
    Route::get('Marketing/Slider_List_Comercial', 'index');
    Route::post('Marketing/Buscar_Base_Slide_Comercial', 'Buscar_Base_Slide_Comercial');
    Route::get('Marketing/Modal_Slide_Insertar_Comercial', 'Modal_Slide_Insertar_Comercial');
    Route::post('Marketing/Insert_Slide_Comercial', 'Insert_Slide_Comercial');
    Route::get('Marketing/Modal_Update_Slide_Comercial/{id}', 'Modal_Update_Slide_Comercial');
    Route::post('Marketing/Update_Slide_Comercial', 'Update_Slide_Comercial');
    Route::get('Marketing/SliderComercial/{funcion}/{base}', 'Slider_Vista_Comercial');
});

use App\Http\Controllers\ReprocesoController;

Route::controller(ReprocesoController::class)->group(function () {
    Route::get('Reproceso/index', 'Reproceso');
    Route::post('Reproceso/Lista_Reproceso', 'Lista_Reproceso');
    Route::get('Reproceso/Modal_Reproceso', 'Modal_Reproceso');
    Route::post('Reproceso/Insert_Reproceso', 'Insert_Reproceso');
    Route::get('Reproceso/Modal_Update_Reproceso/{id}', 'Modal_Update_Reproceso');
    Route::get('Reproceso/Modal_Ver_Reproceso/{id}', 'Modal_Ver_Reproceso');
    Route::post('Reproceso/Update_Reproceso', 'Update_Reproceso');
    Route::post('Reproceso/Delete_Reproceso', 'Delete_Reproceso');
    Route::get('Reproceso/Excel_Reproceso', 'Excel_Reproceso');
});


use App\Http\Controllers\PapeletasConfController;

Route::controller(PapeletasConfController::class)->group(function () {
    Route::get('PapeletasConf/TablaPapeleta_Seguridad', 'TablaPapeleta_Seguridad');
    Route::get('PapeletasConf/Permisos_Papeletas_Salidas', 'Permisos_Papeletas_Salidas');
    Route::get('PapeletasConf/Modal_Permisos_Papeletas_Salidas', 'Modal_Permisos_Papeletas_Salidas');
    Route::post('PapeletasConf/Insert_Permisos_Papeletas_Salidas', 'Insert_Permisos_Papeletas_Salidas');
    Route::post('PapeletasConf/Delete_Permisos_Papeletas_Salidas', 'Delete_Permisos_Papeletas_Salidas');
    Route::get('PapeletasConf/Destino', 'Destino');
    Route::get('PapeletasConf/Modal_Destino', 'Modal_Destino');
    Route::post('PapeletasConf/Insert_Destino', 'Insert_Destino');
    Route::get('PapeletasConf/Modal_Update_Destino/{id}', 'Modal_Update_Destino');
    Route::post('PapeletasConf/Update_Destino', 'Update_Destino');
    Route::post('PapeletasConf/Delete_Destino', 'Delete_Destino');
    Route::get('PapeletasConf/Tramite', 'Tramite');
    Route::post('PapeletasConf/Traer_Destino', 'Traer_Destino');
    Route::get('PapeletasConf/Modal_Tramite', 'Modal_Tramite');
    Route::post('PapeletasConf/Insert_Tramite', 'Insert_Tramite');
    Route::get('PapeletasConf/Modal_Update_Tramite/{id}', 'Modal_Update_Tramite');
    Route::post('PapeletasConf/Update_Tramite', 'Update_Tramite');
    Route::post('PapeletasConf/Delete_Tramite', 'Delete_Tramite');
});







use App\Http\Controllers\MercaderiaExtraerController;

Route::controller(MercaderiaExtraerController::class)->group(function () {
    Route::get('MercaderiaExtraer/Mercaderia', 'Mercaderia');
    Route::post('MercaderiaExtraer/Buscar_Mercaderia', 'Buscar_Mercaderia');
    Route::get('MercaderiaExtraer/Excel_MTotal/{sem}', 'Excel_MTotal');
    Route::post('MercaderiaExtraer/Cierre_Mercaderia', 'Cierre_Mercaderia');
    Route::get('MercaderiaExtraer/Excel_Mercaderia/{usu}/{sem}/{anio}/{cierre}', 'Excel_Mercaderia');
});

use App\Http\Controllers\MercaderiaConfController;

Route::controller(MercaderiaConfController::class)->group(function () {
    Route::get('MercaderiaConf/TablaMercaderia', 'TablaMercaderia');
    Route::get('MercaderiaConf/Percha', 'Percha');
    Route::get('MercaderiaConf/Modal_Percha', 'Modal_Percha');
    Route::post('MercaderiaConf/Insert_Percha', 'Insert_Percha');
    Route::get('MercaderiaConf/Modal_Update_Percha/{id}', 'Modal_Update_Percha');
    Route::post('MercaderiaConf/Update_Percha', 'Update_Percha');
    Route::post('MercaderiaConf/Delete_Percha', 'Delete_Percha');
    Route::get('MercaderiaConf/Nicho', 'Nicho');
    Route::get('MercaderiaConf/Modal_Nicho', 'Modal_Nicho');
    Route::post('MercaderiaConf/Insert_Nicho', 'Insert_Nicho');
    Route::get('MercaderiaConf/Modal_Update_Nicho/{id}', 'Modal_Update_Nicho');
    Route::post('MercaderiaConf/Update_Nicho', 'Update_Nicho');
    Route::post('MercaderiaConf/Delete_Nicho', 'Delete_Nicho');
});

use App\Http\Controllers\ControlUbicacionesController;

Route::controller(ControlUbicacionesController::class)->group(function () {
    Route::get('ControlUbicaciones/index', 'index');
    Route::get('ControlUbicaciones/Cargar_Control_Ubicacion/{t}', 'Cargar_Control_Ubicacion');
    Route::get('ControlUbicaciones/Excel_Control_Ubicacion/{t}', 'Excel_Control_Ubicacion');
    Route::get('ControlUbicaciones/Excel_Control_Ubicacion_Error', 'Excel_Control_Ubicacion_Error');
    Route::get('ControlUbicaciones/Modal_Carga_Masiva', 'Modal_Carga_Masiva');
    Route::get('ControlUbicaciones/Formato_Carga_Ubicacion', 'Formato_Carga_Ubicacion');
    Route::post('ControlUbicaciones/Insert_Carga_Masiva', 'Insert_Carga_Masiva');
    Route::get('ControlUbicaciones/Modal_Control_Ubicaciones', 'Modal_Control_Ubicaciones');
    Route::post('ControlUbicaciones/Insert_Control_Ubicaciones', 'Insert_Control_Ubicaciones');
    Route::get('ControlUbicaciones/Modal_Update_Control_Ubicaciones/{id}', 'Modal_Update_Control_Ubicaciones');
    Route::post('ControlUbicaciones/Update_Control_Ubicaciones', 'Update_Control_Ubicaciones');
    Route::post('ControlUbicaciones/Delete_Control_Ubicacion', 'Delete_Control_Ubicacion');
});


use App\Http\Controllers\ControlSalidaMercaderiaController;

Route::controller(ControlSalidaMercaderiaController::class)->group(function () {
    Route::get('ControlSalidaMercaderia/index', 'index');
    Route::post('ControlSalidaMercaderia/Buscar_Control_Mercaderia_Activo', 'Buscar_Control_Mercaderia_Activo');
    Route::post('ControlSalidaMercaderia/Update_Estado_Control_Mercaderia_Activo', 'Update_Estado_Control_Mercaderia_Activo');
});

use App\Http\Controllers\RequerimientoPrendaController;

Route::controller(RequerimientoPrendaController::class)->group(function () {
    Route::get('RequerimientoPrenda/index', 'index');
    Route::post('RequerimientoPrenda/Busqueda_Requerimiento_Prenda', 'Busqueda_Requerimiento_Prenda');
    Route::get('RequerimientoPrenda/Modal_Requerimiento_Prenda', 'Modal_Requerimiento_Prenda');
    Route::get('RequerimientoPrenda/Formato_Mercaderia_Fotografia', 'Formato_Mercaderia_Fotografia');
    Route::post('RequerimientoPrenda/Insert_Requerimiento_Prenda', 'Insert_Requerimiento_Prenda');
    Route::get('RequerimientoPrenda/Modal_Update_Requerimiento_Prenda/{cod}/{mes}/{anio}', 'Modal_Update_Requerimiento_Prenda');
    Route::post('RequerimientoPrenda/Update_Requerimiento_Prenda', 'Update_Requerimiento_Prenda');
    Route::post('RequerimientoPrenda/Delete_Requerimiento_Prenda', 'Delete_Requerimiento_Prenda');
    Route::post('RequerimientoPrenda/Delete_Todo_Requerimiento_Prenda', 'Delete_Todo_Requerimiento_Prenda');
});

use App\Http\Controllers\SugerenciadePreciosController;

Route::controller(SugerenciadePreciosController::class)->group(function () {
    Route::get('SugerenciadePrecios/index', 'index')->name('SugerenciadePrecios.index');
    Route::post('SugerenciadePrecios/Busqueda_Sugerencia_Precio', 'Busqueda_Sugerencia_Precio')->name('SugerenciadePrecios.Busqueda_Sugerencia_Precio');
    Route::get('SugerenciadePrecios/Modal_Requerimiento_Prenda', 'Modal_Requerimiento_Prenda')->name('SugerenciadePrecios.Modal_Requerimiento_Prenda');
    Route::get('SugerenciadePrecios/Formato_Requerimiento_Precios/{base}/{categoria}', 'Formato_Requerimiento_Precios')->name('SugerenciadePrecios.Formato_Requerimiento_Precios');
    Route::post('SugerenciadePrecios/Insert_Requerimiento_Prenda', 'Insert_Requerimiento_Prenda')->name('SugerenciadePrecios.Insert_Requerimiento_Prenda');
    Route::get('SugerenciadePrecios/Modal_Update_Requerimiento_Prenda/{cod}/{mes}/{anio}', 'Modal_Update_Requerimiento_Prenda')->name('SugerenciadePrecios.Modal_Update_Requerimiento_Prenda');
    Route::post('SugerenciadePrecios/Update_Requerimiento_Prenda', 'Update_Requerimiento_Prenda')->name('SugerenciadePrecios.Update_Requerimiento_Prenda');
    Route::post('SugerenciadePrecios/Delete_Requerimiento_Prenda', 'Delete_Requerimiento_Prenda')->name('SugerenciadePrecios.Delete_Requerimiento_Prenda');
    Route::post('SugerenciadePrecios/Delete_Todo_Requerimiento_Prenda', 'Delete_Todo_Requerimiento_Prenda')->name('SugerenciadePrecios.Delete_Todo_Requerimiento_Prenda');
});

use App\Http\Controllers\RequerimientoSurtidoController;

Route::controller(RequerimientoSurtidoController::class)->group(function () {
    Route::get('RequerimientoSurtido/index', 'index');
    Route::post('RequerimientoSurtido/Buscar_Semana', 'Buscar_Semana');
    Route::get('RequerimientoSurtido/Modal_Requerimiento', 'Modal_Requerimiento');
    Route::get('RequerimientoSurtido/Formato_Mercaderia_Fotografia', 'Formato_Mercaderia_Fotografia');
    Route::post('RequerimientoSurtido/Insert_Requerimiento', 'Insert_Requerimiento');
    Route::get('RequerimientoSurtido/Modal_Update_Requerimiento_Prenda/{cod}/{mes}/{anio}', 'Modal_Update_Requerimiento_Prenda');
    Route::post('RequerimientoSurtido/Update_Requerimiento_Prenda', 'Update_Requerimiento_Prenda');
    Route::post('RequerimientoSurtido/Delete_Requerimiento_Prenda', 'Delete_Requerimiento_Prenda');
    Route::post('RequerimientoSurtido/Delete_Todo_Requerimiento_Prenda', 'Delete_Todo_Requerimiento_Prenda');
    Route::get('RequerimientoSurtido/Excel_Duplicado/{us}/{sem}', 'Excel_Duplicado');
});

use App\Http\Controllers\ActualizacionProcedimientosController;

Route::controller(ActualizacionProcedimientosController::class)->group(function () {
    Route::get('ActualizacionProcedimientos/index', 'index');
    Route::post('ActualizacionProcedimientos/Act_Cobertura', 'Act_Cobertura');
    Route::post('ActualizacionProcedimientos/Act_Reporte', 'Act_Reporte');
    Route::post('ActualizacionProcedimientos/Act_Local', 'Act_Local');
    Route::get('ActualizacionProcedimientos/verificar-conexion', 'verificarConexion');
});

use App\Http\Controllers\ContadorVisitasController;

Route::controller(ContadorVisitasController::class)->group(function () {
    Route::get('ContadorVisitas/index', 'index');
    Route::post('ContadorVisitas/Visualizar_Insert_Contador_Visitas', 'Visualizar_Insert_Contador_Visitas');
});





















































































































use App\Http\Controllers\PapeletasController;

Route::controller(PapeletasController::class)->group(function () {
    Route::get('Papeletas/Lista_Papeletas_Salida_seguridad', 'Lista_Papeletas_Salida_seguridad');
    Route::get('Papeletas/Permisos_Papeletas_Salidas', 'Permisos_Papeletas_Salidas');
    Route::post('Papeletas/Buscar_Base_Papeletas_Seguridad', 'Buscar_Base_Papeletas_Seguridad');
    Route::post('Papeletas/Buscar_Estado_Solicitud_Papeletas_Salida_Usuario', 'Buscar_Estado_Solicitud_Papeletas_Salida_Usuario');
    Route::get('Papeletas/Buscar_Papeleta_Registro', 'Buscar_Papeleta_Registro');
    Route::get('Papeletas/Modal_Papeletas_Salida/{id}', 'Modal_Papeletas_Salida');
    Route::post('Papeletas/Cambiar_Motivo', 'Cambiar_Motivo');
    Route::get('Papeletas/Modal_Tramite', 'Modal_Tramite');
    Route::post('Papeletas/Traer_Tramite', 'Traer_Tramite');
    Route::post('Papeletas/Insert_or_Update_Papeletas_Salida', 'Insert_or_Update_Papeletas_Salida');
    Route::get('Papeletas/Buscar_Papeleta_Aprobacion', 'Buscar_Papeleta_Aprobacion');
    Route::post('Papeletas/Buscar_Papeletas_Salida_Aprobacion', 'Buscar_Papeletas_Salida_Aprobacion');
    Route::post('Papeletas/Aprobado_solicitud_papeletas_1', 'Aprobado_solicitud_papeletas_1');
    Route::post('Papeletas/Anular_solicitud_papeletas_1', 'Anular_solicitud_papeletas_1');
    // Route::get('Papeletas/Destino', 'Destino');
    // Route::get('Papeletas/Modal_Destino', 'Modal_Destino');
    // Route::get('Papeletas/Modal_Update_Destino/{id}', 'Modal_Update_Destino');
    // Route::post('Papeletas/Update_Destino', 'Update_Destino');
});
