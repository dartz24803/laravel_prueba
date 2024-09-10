<?php

namespace App\Http\Controllers;

use App\Models\Anio;
use App\Models\Base;
use App\Models\CambioPrenda;
use App\Models\CambioPrendaDetalle;
use App\Models\MotivoCprenda;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CambioPrendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index_reg()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_anio = Anio::where('estado',1)->orderBy('cod_anio','DESC')->get();
        return view('caja.cambio_prenda.index',compact('list_notificacion','list_anio'));
    }

    public function list_reg(Request $request)
    {
        $list_cambio_prenda = CambioPrenda::get_list_cambio_prenda(['anio'=>$request->anio,'tipo'=>$request->tipo]);
        $tipo = $request->tipo;
        return view('caja.cambio_prenda.lista', compact('list_cambio_prenda','tipo'));
    }
    
    public function create_reg_con()
    {
        $list_base = Base::get_list_bases_tienda();
        $list_motivo = MotivoCprenda::where('estado',1)->get();
        return view('caja.cambio_prenda.modal_registrar',compact('list_base','list_motivo'));
    }

    public function comprobante_reg(Request $request)
    {
        $request->validate([
            'base' => 'not_in:0',
            'tipo_comprobante' => 'not_in:0',
            'serie' => 'required',
            'n_documento' => 'required',
        ], [
            'base.not_in' => 'Debe seleccionar base.',
            'tipo_comprobante.not_in' => 'Debe seleccionar tipo comprobante.',
            'serie.required' => 'Debe ingresar serie.',
            'n_documento.required' => 'Debe ingresar número de documento.',
        ]);

        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_web_ver_ncredito_x_doc_central ?,?,?,?', [
            $request->base,
            $request->tipo_comprobante,
            $request->serie,
            $request->n_documento
        ]);

        if(count($list_detalle)>0){
            $valida = $request->valida;
            return view('caja.cambio_prenda.detalle',compact('list_detalle','valida'));
        }else{
            echo "error";
        }
    }

    public function store_reg_con(Request $request)
    {
        $request->validate([
            'base' => 'not_in:0',
            'tipo_comprobante' => 'not_in:0',
            'serie' => 'required',
            'n_documento' => 'required',
            'id_motivo' => 'gt:0',
            'otro' => 'required_if:id_motivo,6',
            'devolver' => 'required'
        ], [
            'base.not_in' => 'Debe seleccionar base.',
            'tipo_comprobante.not_in' => 'Debe seleccionar tipo comprobante.',
            'serie.required' => 'Debe ingresar serie.',
            'n_documento.required' => 'Debe ingresar número de documento.',
            'id_motivo.gt' => 'Debe seleccionar motivo.',
            'otro.required_if' => 'Debe ingresar otro motivo.',
            'devolver.required' => 'Debe seleccionar algún producto de cambio.'
        ]);

        $errors = [];
        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_web_ver_ncredito_x_doc_central ?,?,?,?', [
            $request->base,
            $request->tipo_comprobante,
            $request->serie,
            $request->n_documento
        ]);
        foreach($list_detalle as $list){
            if(in_array($list->c_nume_docu.'_'.$list->n_codi_arti,$request->devolver)){
                $cantidad = $request->input('cant_'.$list->c_nume_docu.'_'.$list->n_codi_arti);
                if($cantidad<1 || $cantidad>$list->n_cant_vent){
                    $errors['cantidad'] = ['Verificar cantidad de devolución del producto '.$list->n_codi_arti.'.'];
                    break;
                }
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $total = CambioPrenda::count();
        $anio = substr(date('Y'), 2,2);

        if($total<9){
            $cod_cambio="CP".$anio."0000".($total+1);
        }
        if($total>8 && $total<99){
            $cod_cambio="CP".$anio."000".($total+1);
        }
        if($total>98 && $total<999){
            $cod_cambio="CP".$anio."00".($total+1);
        }
        if($total>998 && $total<9999){
            $cod_cambio="CP".$anio."0".($total+1);
        }
        if($total>9998){
            $cod_cambio="CP".$anio.($total+1);
        }

        $cambio_prenda = CambioPrenda::create([
            'cod_cambio' => $cod_cambio,
            'id_usuario' => session('usuario')->id_usuario,
            'tipo_boleta' => 1,
            'base' => $request->base,
            'tipo_comprobante' => $request->tipo_comprobante,
            'serie' => $request->serie,
            'n_documento' => $request->n_documento,
            'estado_cambio' => 1,
            'id_motivo' => $request->id_motivo,
            'otro' => $request->otro,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        foreach($list_detalle as $list){
            if(in_array($list->c_nume_docu.'_'.$list->n_codi_arti,$request->devolver)){
                CambioPrendaDetalle::create([
                    'id_cambio_prenda' => $cambio_prenda->id_cambio_prenda,
                    'n_codi_arti' => $list->n_codi_arti,
                    'n_cant_vent' => $list->n_cant_vent,
                    'c_arti_desc' => $list->c_arti_desc
                ]);
            }
        }
    }

    public function create_reg_sin()
    {
        $list_base = Base::get_list_bases_tienda();
        $list_motivo = MotivoCprenda::where('estado',1)->get();
        return view('caja.cambio_prenda.modal_registrar_sin',compact('list_base','list_motivo'));
    }

    public function producto_reg(Request $request)
    {
        $request->validate([
            'n_codi_arti' => 'required'
        ], [
            'n_codi_arti.required' => 'Debe ingresar código de producto.'
        ]);

        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_datos_producto ?', [
            $request->n_codi_arti
        ]);

        if(count($list_detalle)>0){
            $valida = $request->valida;
            return view('caja.cambio_prenda.detalle_sin',compact('list_detalle','valida'));
        }else{
            echo "error";
        }
    }

    public function store_reg_sin(Request $request)
    {
        $request->validate([
            'base' => 'not_in:0',
            'art_codigo' => 'required',
            'n_cant_vent' => 'gt:0',
            'nom_cliente' => 'required',
            'id_motivo' => 'gt:0',
            'otro' => 'required_if:id_motivo,6'
        ], [
            'base.not_in' => 'Debe seleccionar base.',
            'art_codigo.required' => 'Debe ingresar código de producto.',
            'n_cant_vent.gt' => 'Debe seleccionar cantidad.',
            'nom_cliente.required' => 'Debe ingresar nombre.',
            'id_motivo.gt' => 'Debe seleccionar motivo.',
            'otro.required_if' => 'Debe ingresar otro motivo.'
        ]);

        $total = CambioPrenda::count();
        $anio = substr(date('Y'), 2,2);

        if($total<9){
            $cod_cambio="CP".$anio."0000".($total+1);
        }
        if($total>8 && $total<99){
            $cod_cambio="CP".$anio."000".($total+1);
        }
        if($total>98 && $total<999){
            $cod_cambio="CP".$anio."00".($total+1);
        }
        if($total>998 && $total<9999){
            $cod_cambio="CP".$anio."0".($total+1);
        }
        if($total>9998){
            $cod_cambio="CP".$anio.($total+1);
        }

        $cambio_prenda = CambioPrenda::create([
            'cod_cambio' => $cod_cambio,
            'id_usuario' => session('usuario')->id_usuario,
            'tipo_boleta' => 2,
            'base' => $request->base,
            'nom_cliente' => $request->nom_cliente,
            'telefono' => $request->telefono,
            'vendedor' => $request->vendedor,
            'num_caja' => $request->num_caja,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado_cambio' => 2,
            'id_motivo' => $request->id_motivo,
            'otro' => $request->otro,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_datos_producto ?', [
            $request->n_codi_arti
        ]);
        $get_detalle = $list_detalle[0];

        CambioPrendaDetalle::create([
            'id_cambio_prenda' => $cambio_prenda->id_cambio_prenda,
            'n_codi_arti' => $get_detalle->codigo,
            'n_cant_vent' => $request->n_cant_vent,
            'c_arti_desc' => $get_detalle->descripcion,
            'color' => $get_detalle->color,
            'talla' => $get_detalle->talla
        ]);
    }

    public function edit_reg($id)
    {
        $get_id = CambioPrenda::get_list_cambio_prenda(['id_cambio_prenda'=>$id]);
        $list_base = Base::get_list_bases_tienda();
        $list_motivo = MotivoCprenda::where('estado',1)->get();
        if($get_id->tipo_boleta=="1"){
            $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_web_ver_ncredito_x_doc_central ?,?,?,?', [
                $get_id->base,
                $get_id->tipo_comprobante,
                $get_id->serie,
                $get_id->n_documento
            ]);
            $get_detalle = CambioPrendaDetalle::where('id_cambio_prenda',$id)->get()->toArray();
            return view('caja.cambio_prenda.modal_editar',compact('get_id','list_base','list_motivo','list_detalle','get_detalle'));
        }else{
            $list_detalle = CambioPrendaDetalle::where('id_cambio_prenda',$id)->get();
            return view('caja.cambio_prenda.modal_editar_sin',compact('get_id','list_base','list_motivo','list_detalle'));
        }
    }

    public function update_reg_con(Request $request, $id)
    {
        $request->validate([
            'basee' => 'not_in:0',
            'tipo_comprobantee' => 'not_in:0',
            'seriee' => 'required',
            'n_documentoe' => 'required',
            'id_motivoe' => 'gt:0',
            'otroe' => 'required_if:id_motivoe,6',
            'devolvere' => 'required'
        ], [
            'basee.not_in' => 'Debe seleccionar base.',
            'tipo_comprobantee.not_in' => 'Debe seleccionar tipo comprobante.',
            'seriee.required' => 'Debe ingresar serie.',
            'n_documentoe.required' => 'Debe ingresar número de documento.',
            'id_motivoe.gt' => 'Debe seleccionar motivo.',
            'otroe.required_if' => 'Debe ingresar otro motivo.',
            'devolvere.required' => 'Debe seleccionar algún producto de cambio.'
        ]);

        $errors = [];
        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_web_ver_ncredito_x_doc_central ?,?,?,?', [
            $request->basee,
            $request->tipo_comprobantee,
            $request->seriee,
            $request->n_documentoe
        ]);
        foreach($list_detalle as $list){
            if(in_array($list->c_nume_docu.'_'.$list->n_codi_arti,$request->devolvere)){
                $cantidad = $request->input('cant_'.$list->c_nume_docu.'_'.$list->n_codi_arti.'e');
                if($cantidad<1 || $cantidad>$list->n_cant_vent){
                    $errors['cantidad'] = ['Verificar cantidad de devolución del producto '.$list->n_codi_arti.'.'];
                    break;
                }
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        CambioPrenda::findOrFail($id)->update([
            'base' => $request->basee,
            'tipo_comprobante' => $request->tipo_comprobantee,
            'serie' => $request->seriee,
            'n_documento' => $request->n_documentoe,
            'id_motivo' => $request->id_motivoe,
            'otro' => $request->otroe,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        CambioPrendaDetalle::where('id_cambio_prenda', $id)->delete();
        foreach($list_detalle as $list){
            if(in_array($list->c_nume_docu.'_'.$list->n_codi_arti,$request->devolvere)){
                CambioPrendaDetalle::create([
                    'id_cambio_prenda' => $id,
                    'n_codi_arti' => $list->n_codi_arti,
                    'n_cant_vent' => $list->n_cant_vent,
                    'c_arti_desc' => $list->c_arti_desc
                ]);
            }
        }
    }

    public function update_reg_sin(Request $request, $id)
    {
        $request->validate([
            'basee' => 'not_in:0',
            'art_codigoe' => 'required',
            'n_cant_vente' => 'gt:0',
            'nom_clientee' => 'required',
            'id_motivoe' => 'gt:0',
            'otroe' => 'required_if:id_motivoe,6'
        ], [
            'basee.not_in' => 'Debe seleccionar base.',
            'art_codigoe.required' => 'Debe ingresar código de producto.',
            'n_cant_vente.gt' => 'Debe seleccionar cantidad.',
            'nom_clientee.required' => 'Debe ingresar nombre.',
            'id_motivoe.gt' => 'Debe seleccionar motivo.',
            'otroe.required_if' => 'Debe ingresar otro motivo.'
        ]);

        CambioPrenda::findOrFail($id)->update([
            'base' => $request->basee,
            'nom_cliente' => $request->nom_clientee,
            'telefono' => $request->telefonoe,
            'vendedor' => $request->vendedore,
            'num_caja' => $request->num_cajae,
            'fecha' => $request->fechae,
            'hora' => $request->horae,
            'id_motivo' => $request->id_motivoe,
            'otro' => $request->otroe,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        $list_detalle = DB::connection('sqlsrv')->select('EXEC usp_datos_producto ?', [
            $request->n_codi_artie
        ]);
        $get_detalle = $list_detalle[0];

        CambioPrendaDetalle::where('id_cambio_prenda', $id)->delete();
        CambioPrendaDetalle::create([
            'id_cambio_prenda' => $id,
            'n_codi_arti' => $get_detalle->codigo,
            'n_cant_vent' => $request->n_cant_vente,
            'c_arti_desc' => $get_detalle->descripcion,
            'color' => $get_detalle->color,
            'talla' => $get_detalle->talla
        ]);
    }

    public function cambiar_estado_reg(Request $request, $id)
    {
        CambioPrenda::findOrFail($id)->update([
            'estado_cambio' => $request->estado_cambio,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy_reg($id)
    {
        CambioPrenda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function modal_finalizar_reg($id)
    {
        return view('caja.cambio_prenda.modal_finalizar',compact('id'));
    }

    public function finalizar_reg(Request $request, $id)
    {
        $request->validate([
            'nuevo_num_serief' => 'required',
            'nuevo_num_comprobantef' => 'required'
        ], [
            'nuevo_num_serief.required' => 'Debe ingresar serie.',
            'nuevo_num_comprobantef.required' => 'Debe ingresar número de documento.'
        ]);

        CambioPrenda::findOrFail($id)->update([
            'nuevo_num_comprobante' => $request->nuevo_num_comprobantef,
            'nuevo_num_serie' => $request->nuevo_num_serief,
            'estado_cambio' => 4,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function detalle_reg($id)
    {
        $get_id = CambioPrenda::findOrFail($id);
        $list_detalle = CambioPrendaDetalle::where('id_cambio_prenda',$id)->get();
        $list_base = Base::get_list_bases_tienda();
        $list_motivo = MotivoCprenda::where('estado',1)->get();
        return view('caja.cambio_prenda.modal_detalle',compact('get_id','list_detalle','list_base','list_motivo'));
    }
}
