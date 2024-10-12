<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Model_Infosap extends Model
{
    use HasFactory;

    function act_cobertura(){
        // echo "si";
        DB::connection('sqlsrv_dbmsrt')->statement('EXEC usp_Genera_tabla_Cobertura');
    }

    function act_reporte(){
        // echo "si";
        DB::connection('sqlsrv_dbmsrt')->statement('EXEC usp_Genera_tabla_REPEST');
    }

    function act_local(){
        // echo "si";
        DB::connection('sqlsrv_dbisig')->statement('EXEC sp_SIG_carga_datos_local_bases');
    }

    function carga_stock(){
        // echo "si";
        DB::connection('sqlsrv_dbisig')->statement('EXEC usp_Genera_tabla_Cobertura');
    }
    static function get_list_requerimiento($semana = null, $anio = null){
        if (isset($semana) && $semana > 0 && isset($anio) && $anio > 0) {
            $sql = "SELECT * FROM  pedido_lnuno WHERE estado IN (1, 3) AND semana=$semana AND anio=$anio";
        } else {
            $semana = date('W');
            $anio = date('Y');
            $sql = "SELECT * FROM  pedido_lnuno WHERE estado IN (1, 3) AND semana=$semana AND anio=$anio";
        }
        DB::connection('sqlsrv')->select($sql);
    }
    static function get_list_semanas(){
        $sql = "SELECT semana from  pedido_lnuno group by semana ORDER BY semana ASC";
        DB::connection('sqlsrv')->select($sql);
    }
}
