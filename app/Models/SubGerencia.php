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


    // Función STANDAR para obtener departamentos por módulo
    public static function list_subgerencia($subgerenciaId)
    {
        // Obtener los datos de la subgerencia y las áreas relacionadas
        $results = DB::table('sub_gerencia')
            ->leftJoin('area', 'sub_gerencia.id_sub_gerencia', '=', 'area.id_departamento')
            ->where('sub_gerencia.id_sub_gerencia', $subgerenciaId)
            ->select('sub_gerencia.nom_sub_gerencia', 'area.id_area', 'area.nom_area') // Seleccionar también nom_area
            ->get();
        // dd($results);
        // Agrupar los resultados
        $subgerencia = null;
        $areas = [];

        foreach ($results as $result) {
            if (!$subgerencia) {
                $subgerencia = $result->nom_sub_gerencia;
            }
            // Agregar tanto el id_area como el nom_area al array de áreas
            $areas[] = [
                'id_area' => $result->id_area,
                'nom_area' => $result->nom_area,
                'id_subgerencia' => $subgerenciaId // Agregar el id_subgerencia aquí
            ];
        }

        return [
            'nom_sub_gerencia' => $subgerencia,
            'areas' => $areas
        ];
    }


    // Función para obtener departamentos por módulo + DTO LOGISTICA
    public static function list_subgerencia_with_validation_tienda($subgerenciaId)
    {
        // Obtener los datos de la subgerencia y las áreas relacionadas, filtrando por id_sub_gerencia y validando si es 7
        $results = DB::table('sub_gerencia')
            ->leftJoin('area', 'sub_gerencia.id_sub_gerencia', '=', 'area.id_departamento')
            ->where(function ($query) use ($subgerenciaId) {
                $query->where('sub_gerencia.id_sub_gerencia', $subgerenciaId)
                    ->orWhere('sub_gerencia.id_sub_gerencia', 7)
                    ->orWhere('sub_gerencia.id_sub_gerencia', 3);
            })
            // Omitir áreas 
            ->whereNotIn('area.id_area', [6, 33, 35, 42, 7, 39])
            // Omitir áreas 
            ->select('sub_gerencia.nom_sub_gerencia', 'area.id_area', 'area.nom_area', 'area.cod_area') // Seleccionar también nom_area y cod_area
            ->get();

        // Agrupar los resultados
        $subgerencia_names = [];  // Array para almacenar nombres de subgerencias
        $areas = [];

        foreach ($results as $result) {
            // Agregar el nombre de la subgerencia al array si aún no está en él
            if (!in_array($result->nom_sub_gerencia, $subgerencia_names)) {
                $subgerencia_names[] = $result->nom_sub_gerencia;
            }

            // Agregar tanto el id_area como el nom_area al array de áreas
            $areas[] = [
                'id_area' => $result->id_area,
                'nom_area' => $result->nom_area,
                'id_subgerencia' => $subgerenciaId // Agregar el id_subgerencia aquí
            ];
        }

        // Concatenar los nombres de las subgerencias
        $subgerencia_concatenada = implode(' & ', $subgerencia_names);

        return [
            'nom_sub_gerencia' => $subgerencia_concatenada,  // Concatenación de subgerencias
            'areas' => $areas
        ];
    }


    public static function list_subgerencia_with_validation_comercial($subgerenciaId)
    {
        // Obtener los datos de la subgerencia y las áreas relacionadas, filtrando por id_sub_gerencia y validando si es 7
        $results = DB::table('sub_gerencia')
            ->leftJoin('area', 'sub_gerencia.id_sub_gerencia', '=', 'area.id_departamento')
            ->where(function ($query) use ($subgerenciaId) {
                $query->where('sub_gerencia.id_sub_gerencia', $subgerenciaId)
                    ->orWhere('sub_gerencia.id_sub_gerencia', 2)
                    ->orWhere('sub_gerencia.id_sub_gerencia', 7);
            })
            // Omitir áreas 
            ->whereNotIn('area.id_area', [33, 42, 6, 30, 35])
            // Omitir áreas 
            ->select('sub_gerencia.nom_sub_gerencia', 'area.id_area', 'area.nom_area', 'area.cod_area') // Seleccionar también nom_area y cod_area
            ->get();

        // Agrupar los resultados
        $subgerencia_names = [];  // Array para almacenar nombres de subgerencias
        $areas = [];

        foreach ($results as $result) {
            // Agregar el nombre de la subgerencia al array si aún no está en él
            if (!in_array($result->nom_sub_gerencia, $subgerencia_names)) {
                $subgerencia_names[] = $result->nom_sub_gerencia;
            }
            // Agregar tanto el id_area como el nom_area al array de áreas
            $areas[] = [
                'id_area' => $result->id_area,
                'nom_area' => $result->nom_area,
                'id_subgerencia' => $subgerenciaId // Agregar el id_subgerencia aquí
            ];
        }
        // Concatenar los nombres de las subgerencias
        $subgerencia_concatenada = implode(' & ', $subgerencia_names);
        return [
            'nom_sub_gerencia' => $subgerencia_concatenada,  // Concatenación de subgerencias
            'areas' => $areas
        ];
    }
}
