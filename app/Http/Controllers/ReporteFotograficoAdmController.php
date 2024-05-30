<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteFotograficoAdm;

class ReporteFotograficoAdmController extends Controller
{
    //variables a usar
    protected $request;
    protected $modelo;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->request = $request;
        $this->modelo = new ReporteFotograficoAdm();
    }

    public function index(){
        //retornar vista si esta logueado
        if (session('usuario')) {
            return view('administracion.tienda.ReporteFotografico.reportefotograficoadm');
        }else{
            return redirect('/');
        }
    }
}
