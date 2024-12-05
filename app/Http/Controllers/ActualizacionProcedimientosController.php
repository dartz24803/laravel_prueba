<?php

namespace App\Http\Controllers;

use App\Models\Model_Infosap;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ActualizacionProcedimientosController extends Controller
{
    protected $input;
    protected $Model_Infosap;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Infosap = new Model_Infosap();
    }

    public function verificarConexion()
    {
        try {
            // Realiza una consulta básica para verificar la conexión
            DB::connection('sqlsrv_dbmsrt')->getPdo();
            // DB::connection('sqlsrv_dbisig')->getPdo();
            return response()->json(['message' => 'Conexión exitosa a la base de datos SQL Server.']);
        } catch (Exception $e) {
            // Si ocurre algún error al intentar conectarse
            return response()->json(['message' => 'Error en la conexión: ' . $e->getMessage()], 500);
        }
    }

    public function index(){
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(3);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
        return view('interna.bi.actualizacion_procedimiento.index',$dato);
    }

    public function Act_Cobertura(){
        $this->Model_Infosap->act_cobertura();
    }

    public function Act_Reporte(){
        $this->Model_Infosap->act_reporte();
    }

    public function Act_Local(){
        $this->Model_Infosap->act_local();
        $this->Model_Infosap->carga_stock();
    }
}
