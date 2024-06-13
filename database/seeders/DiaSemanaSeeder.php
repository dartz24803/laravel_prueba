<?php

namespace Database\Seeders;

use App\Models\DiaSemana;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiaSemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_dia_semana = [
            ['nombre'=>'Lunes'],
            ['nombre'=>'Martes'],
            ['nombre'=>'Miércoles'],
            ['nombre'=>'Jueves'],
            ['nombre'=>'Viernes'],
            ['nombre'=>'Sábado'],
            ['nombre'=>'Domingo'],
        ];

        foreach ($list_dia_semana as $list) {
            DiaSemana::create([
                'nombre' => $list['nombre'],
            ]);
        }
    }
}
