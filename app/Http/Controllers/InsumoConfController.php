<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Banco;
use App\Models\Insumo;
use App\Models\Notificacion;
use App\Models\Proveedor;
use App\Models\Usuario;
use Illuminate\Http\Request;

class InsumoConfController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('caja.administracion.insumo.index', compact('list_notificacion'));
    }

    public function index_in()
    {
        return view('caja.administracion.insumo.insumo.index');
    }

    public function list_in()
    {
        $list_insumo = Insumo::select('id_insumo', 'nom_insumo')->where('estado', 1)->get();
        return view('caja.administracion.insumo.insumo.lista', compact('list_insumo'));
    }

    public function create_in()
    {
        return view('caja.administracion.insumo.insumo.modal_registrar');
    }

    public function store_in(Request $request)
    {
        $request->validate([
            'nom_insumo' => 'required',
        ], [
            'nom_insumo.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Insumo::where('nom_insumo', $request->nom_insumo)->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            Insumo::create([
                'nom_insumo' => $request->nom_insumo,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_in($id)
    {
        $get_id = Insumo::findOrFail($id);
        return view('caja.administracion.insumo.insumo.modal_editar', compact('get_id'));
    }

    public function update_in(Request $request, $id)
    {
        $request->validate([
            'nom_insumoe' => 'required',
        ], [
            'nom_insumoe.required' => 'Debe ingresar nombre.',
        ]);

        $valida = Insumo::where('nom_insumo', $request->nom_insumoe)->where('estado', 1)->where('id_insumo', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            Insumo::findOrFail($id)->update([
                'nom_insumo' => $request->nom_insumoe,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_in($id)
    {
        Insumo::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function index_pr()
    {
        return view('caja.administracion.insumo.proveedor.index');
    }

    public function list_pr()
    {
        $list_proveedor = Proveedor::from('proveedor AS pr')
                        ->select('pr.id_proveedor','pr.nom_proveedor','pr.ruc_proveedor',
                        'pr.direccion_proveedor','pr.telefono_proveedor','pr.celular_proveedor',
                        'pr.email_proveedor','pr.web_proveedor','pr.contacto_proveedor',
                        'pr.proveedor_codigo','pr.proveedor_password','ba.nom_banco','pr.num_cuenta',
                        'ar.nom_area')
                        ->leftjoin('banco AS ba','ba.id_banco','=','pr.id_banco')
                        ->leftjoin('area AS ar','ar.id_area','=','pr.id_area')
                        ->where('pr.tipo',5)->where('pr.estado',1)->get();
        return view('caja.administracion.insumo.proveedor.lista', compact('list_proveedor'));
    }

    public function create_pr()
    {
        $list_banco = Banco::select('id_banco','nom_banco')->where('estado',1)
                    ->orderBy('nom_banco','ASC')->get();
        $list_area = Area::select('id_area','nom_area')->where('estado',1)->orderBy('nom_area','ASC')
                    ->get();
        return view('caja.administracion.insumo.proveedor.modal_registrar',compact('list_banco','list_area'));
    }

    public function store_pr(Request $request)
    {
        $request->validate([
            'nom_proveedor' => 'required',
            'ruc_proveedor' => 'required'
        ], [
            'nom_proveedor.required' => 'Debe ingresar razón social.',
            'ruc_proveedor.required' => 'Debe ingresar RUC.'
        ]);

        $valida = Proveedor::where('tipo',5)->where('ruc_proveedor', $request->ruc_proveedor)
                ->where('estado', 1)->exists();
        if ($valida) {
            echo "error";
        } else {
            Proveedor::create([
                'tipo' => 5,
                'nom_proveedor' => $request->nom_proveedor,
                'ruc_proveedor' => $request->ruc_proveedor,
                'direccion_proveedor' => $request->direccion_proveedor,
                'telefono_proveedor' => $request->telefono_proveedor,
                'celular_proveedor' => $request->celular_proveedor,
                'email_proveedor' => $request->email_proveedor,
                'web_proveedor' => $request->web_proveedor,
                'contacto_proveedor' => $request->contacto_proveedor,
                'proveedor_codigo' => $request->proveedor_codigo,
                'proveedor_password' => $request->proveedor_password,
                'id_area' => $request->id_area,
                'id_banco' => $request->id_banco,
                'num_cuenta' => $request->num_cuenta,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function edit_pr($id)
    {
        $get_id = Proveedor::findOrFail($id);
        $list_banco = Banco::select('id_banco','nom_banco')->where('estado',1)
                    ->orderBy('nom_banco','ASC')->get();
        $list_area = Area::select('id_area','nom_area')->where('estado',1)->orderBy('nom_area','ASC')
                    ->get();
        return view('caja.administracion.insumo.proveedor.modal_editar', compact('get_id','list_banco','list_area'));
    }

    public function update_pr(Request $request, $id)
    {
        $request->validate([
            'nom_proveedore' => 'required',
            'ruc_proveedore' => 'required'
        ], [
            'nom_proveedore.required' => 'Debe ingresar razón social.',
            'ruc_proveedore.required' => 'Debe ingresar RUC.'
        ]);

        $valida = Proveedor::where('tipo',5)->where('ruc_proveedor', $request->ruc_proveedore)
                ->where('estado', 1)->where('id_proveedor', '!=', $id)->exists();
        if ($valida) {
            echo "error";
        } else {
            Proveedor::findOrFail($id)->update([
                'nom_proveedor' => $request->nom_proveedore,
                'ruc_proveedor' => $request->ruc_proveedore,
                'direccion_proveedor' => $request->direccion_proveedore,
                'telefono_proveedor' => $request->telefono_proveedore,
                'celular_proveedor' => $request->celular_proveedore,
                'email_proveedor' => $request->email_proveedore,
                'web_proveedor' => $request->web_proveedore,
                'contacto_proveedor' => $request->contacto_proveedore,
                'proveedor_codigo' => $request->proveedor_codigoe,
                'proveedor_password' => $request->proveedor_passworde,
                'id_area' => $request->id_areae,
                'id_banco' => $request->id_bancoe,
                'num_cuenta' => $request->num_cuentae,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function destroy_pr($id)
    {
        Proveedor::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }
}
