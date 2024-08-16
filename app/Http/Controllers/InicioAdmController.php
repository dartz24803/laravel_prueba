<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Base;
use App\Models\SliderInicio;
use Illuminate\Support\Facades\Validator;

class InicioAdmController extends Controller
{
    protected $modelobase;

    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index(){
        return view('Inicio/slider/index');
    }

    public function Slider_Inicio_Listar(){
        $list = SliderInicio::get();
        return view('Inicio/slider/lista', compact('list'));
    }

    public function Modal_Update_Slider_Inicio($id){
        $dato['get_id'] = SliderInicio::where('id', $id)->get();
        return view('Inicio/slider/modal_editar',$dato);
    }

    public function Update_Slider_Inicio(Request $request){
        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'required'
        ], [
            'titulo.required' => 'Titulo: Campo obligatorio',
            'descripcion.required' => 'Descripcion: Campo obligatorio',
        ]);

        $dato['titulo'] = $request->input("titulo");
        $dato['descripcion'] = $request->input("descripcion");
        $dato['link'] = $request->input("link");
        SliderInicio::where('id', $request->input("id"))->update($dato);
    }
}
