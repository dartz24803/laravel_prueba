<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\FrasesInicio;
use Illuminate\Support\Facades\Validator;
use App\Models\Notificacion;

class InicioFrasesAdmController extends Controller
{
    protected $modelobase;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index(){
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        return view('interna/administracion/Inicio/frases/index', compact('list_notificacion'));
    }

    public function Frases_Inicio_Listar(){
        $list = FrasesInicio::where('estado', 1)->get();
        return view('interna/administracion/Inicio/frases/lista', compact('list'));
    }

    public function Modal_Update_Frases_Inicio($id){
        $dato['get_id'] = FrasesInicio::where('id', $id)->get();
        return view('interna/administracion/Inicio/frases/modal_editar',$dato);
    }

    public function Modal_Registrar_Frases_Inicio(){
        return view('interna/administracion/Inicio/frases/modal_registrar');
    }

    public function Registrar_Frase_Inicio(Request $request){
        $request->validate([
            'frase' => 'required',
        ], [
            'frase.required' => 'Frase: Campo obligatorio',
        ]);

        $valida = FrasesInicio::where('frase', $request->frase)
                    ->where('estado', 1)
                    ->exists();

        if ($valida){
            echo "error";
        }else{
            $dato['frase'] = $request->input("frase");
            $dato['estado'] = 1;
            $dato['user_reg'] = session('usuario')->id_usuario;
            $dato['fec_reg'] = now();
            $dato['user_act'] = session('usuario')->id_usuario;
            $dato['fec_act'] = now();
            FrasesInicio::insert($dato);
        }
    }

    public function Update_Frase_Inicio(Request $request){
        $request->validate([
            'frase' => 'required',
        ], [
            'frase.required' => 'Frase: Campo obligatorio',
        ]);

        $dato['frase'] = $request->input("frase");
        $dato['user_act'] = session('usuario')->id_usuario;
        $dato['fec_act'] = now();
        FrasesInicio::where('id', $request->input("id"))->update($dato);
    }

    public function Delete_Frase(Request $request){
        $dato['estado'] = 2;
        $dato['user_eli'] = session('usuario')->id_usuario;
        $dato['fec_eli'] = now();
        FrasesInicio::where('id', $request->input("id"))->update($dato);
    }
}
