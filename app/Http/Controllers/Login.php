<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Exception;

class Login extends Controller
{
    protected $request;
    protected $UsuariosModel;
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->UsuariosModel = new Usuario();
    }

    public function index()
    {
        return view('login');
    }


	public function ingresar(Request $request)
    {
        $usuario = $request->input('Usuario');
        $password = $request->input('Password');
        // $usuario = '70451069';
        // $password = '123456';


        //$sesionlnu = $this->UsuariosModel->login($usuario);
        $sesionlnu = $this->UsuariosModel->login($usuario);
        $user = $sesionlnu[0];
        if ($sesionlnu) {
            if (password_verify($password, $user->usuario_password)) {
                $request->session()->put('usuario', $user);
                //return ('CarteraController');
                //return $sesionlnu;
            } else {
                return "error";
                $request->session()->flush();
            }
        } else {
            return "error";
            $request->session()->flush();
        }
    }

	public function Recuperar_Password(){
        return view('login/recuperar_contrasenia');
    }

	public function logout(Request $request){
        $request->session()->flush();
        return redirect('/');
   }
}
