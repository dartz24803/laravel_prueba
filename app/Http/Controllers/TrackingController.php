<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tracking;
use App\Models\BaseModel;

class TrackingController extends Controller
{
    protected $modelo;
    protected $modelobase;

    public function __construct()
    {
        $this->modelo = new Tracking();
        $this->modelobase = new BaseModel();
    }

    public function index()
    {
        return view('tracking.index');
    }

    public function list()
    {
        $list_tracking = $this->modelo->get_list_tracking();
        return view('tracking.lista', compact('list_tracking'));
    }

    public function create()
    {
        $list_base = $this->modelobase->get_list_base_tracking();
        return view('tracking.modal_registrar', compact('list_base'));
    }

    public function store(Request $request)
    {
        $tracking = new Tracking();
        $tracking->n_requerimiento = $request->n_requerimiento;
        $tracking->semana = $request->semana;
        $tracking->desde = $request->desde;
        $tracking->hacia = $request->hacia;
        $tracking->estado = 1;
        $tracking->fec_reg = now();
        $tracking->save();
    }
}
