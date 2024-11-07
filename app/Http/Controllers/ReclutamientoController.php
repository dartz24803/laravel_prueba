<?php

namespace App\Http\Controllers;

use App\Models\Reclutamiento;
use Illuminate\Http\Request;

class ReclutamientoController extends Controller
{
    protected $input; 
    protected $modelo;

    public function __construct(Request $request)
    {
        //constructor con variables
        $this->input = $request;
        $this->modelo = new Reclutamiento();
        // $this->modeloarea = new Area();
        // $this->modelocodigos = new CodigosReporteFotografico();
        // $this->modeloarchivotmp = new ReporteFotograficoArchivoTemporal();
        // $this->modelorfa = new ReporteFotograficoAdm();
    }
}
