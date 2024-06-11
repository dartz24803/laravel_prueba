<?php

namespace Database\Seeders;

use App\Models\TareasFuncionTemporal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TareasFuncionTemporalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_tareas_funcion_temporal = [
            ['descripcion'=>'Repartir volantes'],
            ['descripcion'=>'Limpieza (espejo, vitrina, techo, cuarto de servicio técnico, pasadiso, entre otros)'],
            ['descripcion'=>'Animación'],
            ['descripcion'=>'Amarrado de Ganchos'],
            ['descripcion'=>'Ir al banco (sencillar, hacer cola)'],
            ['descripcion'=>'Ir a Municipalidad'],
            ['descripcion'=>'Ordenar precios'],
            ['descripcion'=>'Comprar requisición'],
            ['descripcion'=>'Colocar ganchos / sacar prendas de almacén'],
            ['descripcion'=>'Buscar material de campaña'],
            ['descripcion'=>'Surtido'],
            ['descripcion'=>'Envío/recojo de activo'],
            ['descripcion'=>'Bailar en ingreso'],
            ['descripcion'=>'Dejar sobre activos a base'],
            ['descripcion'=>'Separación de prendas para inventario'],
            ['descripcion'=>'Revisar prendas'],
            ['descripcion'=>'Activación globos sorpresa'],
            ['descripcion'=>'Llevar caja a grael / buscar nota de crédito'],
            ['descripcion'=>'Otros'],
        ];

        foreach ($list_tareas_funcion_temporal as $list) {
            TareasFuncionTemporal::create([
                'descripcion' => $list['descripcion'],
            ]);
        }
    }
}
