<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Notificacion;
use App\Models\ProveedorGeneral;
use App\Models\Provincia;
use App\Models\SubGerencia;
use App\Models\TipoServicio;
use App\Models\TipoTransporteProduccion;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class AsignacionVisitaConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(4);
        return view('manufactura.produccion.administracion.asignacion_visita.index', compact(
            'list_notificacion', 
            'list_subgerencia'
        ));
    }

    public function index_ts()
    {
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_servicio.index');
    }

    public function list_ts()
    {
        $list_tipo_servicio = TipoServicio::select('id_tipo_servicio',
                            'nom_tipo_servicio')->where('estado',1)->get();
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_servicio.lista', compact(
            'list_tipo_servicio'
        ));
    }

    public function create_ts()
    {
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_servicio.modal_registrar');
    }

    public function store_ts(Request $request)
    {
        $request->validate([
            'nom_tipo_servicio' => 'required'
        ], [
            'nom_tipo_servicio.required' => 'Debe ingresar nombre.'
        ]);

        $valida = TipoServicio::where('nom_tipo_servicio', $request->nom_tipo_servicio)
                ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            TipoServicio::create([
                'nom_tipo_servicio' => $request->nom_tipo_servicio,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_ts($id)
    {
        $get_id = TipoServicio::findOrFail($id);
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_servicio.modal_editar', compact(
            'get_id'
        ));
    }

    public function update_ts(Request $request, $id)
    {
        $request->validate([
            'nom_tipo_servicioe' => 'required'
        ], [
            'nom_tipo_servicioe.required' => 'Debe ingresar nombre.'
        ]);

        $valida = TipoServicio::where('nom_tipo_servicio', $request->nom_tipo_servicioe)
                ->where('estado', 1)->where('id_tipo_servicio', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            TipoServicio::findOrFail($id)->update([
                'nom_tipo_servicio' => $request->nom_tipo_servicioe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_ts($id)
    {
        TipoServicio::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_pr(Request $request)
    {
        $tipo = $request->tipo;
        return view('manufactura.produccion.administracion.asignacion_visita.proveedor.index', compact(
            'tipo'
        ));
    }

    public function list_pr(Request $request)
    {
        $list_proveedor = ProveedorGeneral::select('id_proveedor','ruc_proveedor','nombre_proveedor',
                        'responsable','celular_proveedor','email_proveedor','direccion_proveedor',
                        'coordsltd','coordslgt')->where('id_proveedor_mae',$request->tipo)
                        ->where('estado',1)->get();
        return view('manufactura.produccion.administracion.asignacion_visita.proveedor.lista', compact(
            'list_proveedor'
        ));
    }

    public function create_pr($tipo)
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        //REPORTE BI CON ID
        $list_subgerencia = SubGerencia::list_subgerencia(4);
        if($tipo=="1"){
            $nom_tipo = "tela";
        }else{
            $nom_tipo = "taller";
        }
        $list_departamento = Departamento::select('id_departamento','nombre_departamento')
                            ->where('estado',1)->get();
        $list_tipo_servicio = TipoServicio::select('id_tipo_servicio','nom_tipo_servicio')
                            ->where('estado',1)->get();
        $list_banco = Banco::select('id_banco','nom_banco')->where('estado',1)->get();                            
        return view('manufactura.produccion.administracion.asignacion_visita.proveedor.registrar', compact(
            'list_notificacion',
            'list_subgerencia',
            'tipo',
            'nom_tipo',
            'list_departamento',
            'list_tipo_servicio',
            'list_banco'
        ));
    }

    public function consultar_ruc_pr(Request $request)
    {
        $request->validate([
            'ruc' => 'required|size:11'
        ], [
            'ruc.required' => 'Debe ingresar RUC.',
            'ruc.size' => 'Debe ingresar RUC válido (11 dígitos).'
        ]);

        $client = new Client();
        $body = '';
        $request = new Psr7Request('GET', 'https://dniruc.apisperu.com/api/v1/ruc/'.$request->ruc.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InNpc3RlbWFzbGFudW1lcm91bm9AZ21haWwuY29tIn0.FP8eTZr1p_oKvGXN3Wcc8mZd4fBuyAYvSYy28Qkgg0E', [], $body);
        $res = $client->sendAsync($request)->wait();
        $responseData = json_decode($res->getBody(), true);

        if(isset($responseData['success'])){
            echo "error@@@".$responseData['message'];
        }else{
            echo $responseData['razonSocial']."@@@".$responseData['direccion'];
        }
    }

    public function traer_provincia_pr(Request $request)
    {
        $id_departamento = str_pad($request->id_departamento,2,"0",STR_PAD_LEFT);
        $list_provincia = Provincia::select('id_provincia', 'nombre_provincia')
                        ->where('id_departamento', $id_departamento)->where('estado', 1)->get();
        return view('rrhh.postulante.provincia', compact('list_provincia'));
    }

    public function traer_distrito_pr(Request $request)
    {
        $id_provincia = str_pad($request->id_provincia,4,"0",STR_PAD_LEFT);
        $list_distrito = Distrito::select('id_distrito', 'nombre_distrito')
                        ->where('id_provincia', $id_provincia)->where('estado', 1)->get();
        return view('rrhh.postulante.distrito', compact('list_distrito'));
    }

    public function store_pr(Request $request)
    {
        $request->validate([
            'ruc_proveedor' => 'required|size:11',
            'nombre_proveedor' => 'required',
            'id_departamento' => 'not_in:0',
            'id_provincia' => 'not_in:0',
            'id_distrito' => 'not_in:0',
            'responsable' => 'required'
        ], [
            'ruc_proveedor.required' => 'Debe ingresar RUC.',
            'ruc_proveedor.size' => 'Debe ingresar RUC válido (11 dígitos).',
            'nombre_proveedor.required' => 'Debe ingresar razón social.',
            'id_departamento.not_in' => 'Debe seleccionar departamento',
            'id_provincia.not_in' => 'Debe seleccionar provincia',
            'id_distrito.not_in' => 'Debe seleccionar distrito',
            'responsable.required' => 'Debe ingresar responsable.'
        ]);

        $valida = ProveedorGeneral::where('id_proveedor_mae',$request->id_proveedor_mae)
                ->where('ruc_proveedor', $request->ruc_proveedor)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            ProveedorGeneral::create([
                'id_proveedor_mae' => $request->id_proveedor_mae,
                'tipo_proveedor' => 0,
                'ruc_proveedor' => $request->ruc_proveedor,
                'nombre_proveedor' => $request->nombre_proveedor,
                'direccion_proveedor' => $request->direccion_proveedor,
                'referencia_proveedor' => $request->referencia_proveedor,
                'id_departamento' => $request->id_departamento,
                'id_provincia' => $request->id_provincia,
                'id_distrito' => $request->id_distrito,
                'id_tipo_servicio' => $request->id_tipo_servicio,
                'responsable' => $request->responsable,
                'telefono_proveedor' => $request->telefono_proveedor,
                'celular_proveedor' => $request->celular_proveedor,
                'email_proveedor' => $request->email_proveedor,
                'web_proveedor' => $request->web_proveedor,
                'id_banco' => $request->id_banco,
                'num_cuenta' => $request->num_cuenta,
                'coordsltd' => $request->coordsltd,
                'coordslgt' => $request->coordslgt,
                'id_area' => 5,
                'ubigeo' => $request->id_distrito,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }
    
    public function destroy_pr($id)
    {
        ProveedorGeneral::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_tt()
    {
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.index');
    }

    public function list_tt()
    {
        $list_tipo_transporte = TipoTransporteProduccion::select('id_tipo_transporte',
                                'nom_tipo_transporte')->where('estado',1)->get();
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.lista', compact(
            'list_tipo_transporte'
        ));
    }

    public function create_tt()
    {
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.modal_registrar');
    }

    public function store_tt(Request $request)
    {
        $request->validate([
            'nom_tipo_transporte' => 'required'
        ], [
            'nom_tipo_transporte.required' => 'Debe ingresar nombre.'
        ]);

        $valida = TipoTransporteProduccion::where('nom_tipo_transporte', $request->nom_tipo_transporte)
                ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            TipoTransporteProduccion::create([
                'nom_tipo_transporte' => $request->nom_tipo_transporte,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_tt($id)
    {
        $get_id = TipoTransporteProduccion::findOrFail($id);
        return view('manufactura.produccion.administracion.asignacion_visita.tipo_transporte.modal_editar', compact(
            'get_id'
        ));
    }

    public function update_tt(Request $request, $id)
    {
        $request->validate([
            'nom_tipo_transportee' => 'required'
        ], [
            'nom_tipo_transportee.required' => 'Debe ingresar nombre.'
        ]);

        $valida = TipoTransporteProduccion::where('nom_tipo_transporte', $request->nom_tipo_transportee)
                ->where('estado', 1)->where('id_tipo_transporte', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            TipoTransporteProduccion::findOrFail($id)->update([
                'nom_tipo_transporte' => $request->nom_tipo_transportee,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_tt($id)
    {
        TipoTransporteProduccion::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
