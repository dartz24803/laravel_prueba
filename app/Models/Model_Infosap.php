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
}
