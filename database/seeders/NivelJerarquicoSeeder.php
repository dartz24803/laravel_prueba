<?php

namespace Database\Seeders;

use App\Models\NivelJerarquico;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivelJerarquicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_nivel_jerarquico = [
            ['nom_nivel'=>'DIRECTOR'],
            ['nom_nivel'=>'GERENTE'],
            ['nom_nivel'=>'JEFE'],
            ['nom_nivel'=>'COORDINADOR'],
            ['nom_nivel'=>'ANALISTA'],
            ['nom_nivel'=>'ASISTENTE'],
            ['nom_nivel'=>'AUXILIAR'],
            ['nom_nivel'=>'PRACTICANTE'],
            ['nom_nivel'=>'OPERATIVO'],
        ];

        foreach ($list_nivel_jerarquico as $list) {
            NivelJerarquico::create([
                'nom_nivel' => $list['nom_nivel'],
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => 0,
                'fec_act' => now(),
                'user_act' => 0
            ]);
        }
    }
}
