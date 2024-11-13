<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ContactosController extends Controller
{
    protected $input;
    protected $Model_Users;
    // protected $Model_Perfil;

    public function __construct(Request $request)
    {
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Users = new Usuario();
        // $this->Model_Permiso = new PermisoPapeletasSalida();
        // $this->Model_Perfil = new Model_Perfil();
    }

    public function Lista_Directorio_Telefonico(){
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        $dato['list_directorio_telefonico'] = Usuario::select('users.*', 'puesto.nom_puesto', 'area.nom_area')
                        ->leftJoin('puesto', 'puesto.id_puesto', '=', 'users.id_puesto')
                        ->leftJoin('area', 'area.id_area', '=', 'puesto.id_area')
                        ->where('users.directorio', 1)
                        ->where('users.estado', 1)
                        ->get();
        return view('Contactos.index',$dato);
    }
}
