<?php

namespace Database\Seeders;

use App\Models\Mes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_mes = [
            ['cod_mes'=>'01','nom_mes'=>'Enero','abr_mes'=>'Ene'],
            ['cod_mes'=>'02','nom_mes'=>'Febrero','abr_mes'=>'Feb'],
            ['cod_mes'=>'03','nom_mes'=>'Marzo','abr_mes'=>'Mar'],
            ['cod_mes'=>'04','nom_mes'=>'Abril','abr_mes'=>'Abr'],
            ['cod_mes'=>'05','nom_mes'=>'Mayo','abr_mes'=>'May'],
            ['cod_mes'=>'06','nom_mes'=>'Junio','abr_mes'=>'Jun'],
            ['cod_mes'=>'07','nom_mes'=>'Julio','abr_mes'=>'Jul'],
            ['cod_mes'=>'08','nom_mes'=>'Agosto','abr_mes'=>'Ago'],
            ['cod_mes'=>'09','nom_mes'=>'Setiembre','abr_mes'=>'Set'],
            ['cod_mes'=>'10','nom_mes'=>'Octubre','abr_mes'=>'Oct'],
            ['cod_mes'=>'11','nom_mes'=>'Noviembre','abr_mes'=>'Nov'],
            ['cod_mes'=>'12','nom_mes'=>'Diciembre','abr_mes'=>'Dic'],
        ];

        foreach ($list_mes as $list) {
            Mes::create([
                'cod_mes' => $list['cod_mes'],
                'nom_mes' => $list['nom_mes'],
                'abr_mes' => $list['abr_mes'],
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => 1,
            ]);
        }
    }
}
