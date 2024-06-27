<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CodigosReporteFotografico extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'codigos_reporte_fotografico';

    protected $fillable = [
        'id',
        'descripcion',
        'tipo',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public function buscar($id){
        return $this->where('id', $id)->get()->toArray();
    }

    public function listar(){
        return $this->select('descripcion')->distinct()->get()->toArray();
    }
    
    public function listar_tipos(){
        return $this->select('tipo')->distinct()->get()->toArray();
    }

    public function listar_codigos($base,$codigo){
        if($base==0){
            $parte1 = "";
        }else{
            $parte1 = " AND crf.base = '$base'";
        }

        if($codigo==0){
            $parte3 = "";
        }else{
            $parte3 = " AND crf.tipo = '$codigo'";
        }

        $query = "select crf.id,crf.descripcion,crf.base,rfa.categoria from codigos_reporte_fotografico crf 
        LEFT JOIN reporte_fotografico_adm rfa ON crf.tipo=rfa.id where crf.estado=1 $parte1 $parte3 ";

        $result = DB::select($query);

        // Convertir el resultado a un array
        return json_decode(json_encode($result), true);
    }
}
