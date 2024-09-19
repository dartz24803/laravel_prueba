<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubGerencia extends Model
{
    use HasFactory;

    protected $table = 'sub_gerencia';
    protected $primaryKey = 'id_sub_gerencia';

    public $timestamps = false;

    protected $fillable = [
        'id_direccion',
        'id_gerencia',
        'nom_sub_gerencia',
        'estado',
        'fec_reg',
        'user_reg',
        'fec_act',
        'user_act',
        'fec_eli',
        'user_eli'
    ];

    public static function list_subgerencia($subgerenciaId)
    {
        // Obtener los datos de la subgerencia y las áreas relacionadas
        $results = DB::table('sub_gerencia')
            ->leftJoin('area', 'sub_gerencia.id_sub_gerencia', '=', 'area.id_departamento')
            ->where('sub_gerencia.id_sub_gerencia', $subgerenciaId)
            ->select('sub_gerencia.nom_sub_gerencia', 'area.nom_area')
            ->get();

        // Agrupar los resultados
        $subgerencia = null;
        $areas = [];

        foreach ($results as $result) {
            if (!$subgerencia) {
                $subgerencia = $result->nom_sub_gerencia;
            }
            $areas[] = $result->nom_area;
        }

        return [
            'nom_sub_gerencia' => $subgerencia,
            'areas' => $areas
        ];
    }
}
