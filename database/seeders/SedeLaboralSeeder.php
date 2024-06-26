<?php

namespace Database\Seeders;

use App\Models\SedeLaboral;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SedeLaboralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_sede_laboral = [
            ['descripcion'=>'AMT'],
            ['descripcion'=>'CD'],
            ['descripcion'=>'EXT'],
            ['descripcion'=>'OFC'],
            ['descripcion'=>'REMOTO'],
            ['descripcion'=>'TIENDAS'],
        ];

        foreach ($list_sede_laboral as $list) {
            SedeLaboral::create([
                'descripcion' => $list['descripcion'],
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => 0,
                'fec_act' => now(),
                'user_act' => 0
            ]);
        }
    }
}
