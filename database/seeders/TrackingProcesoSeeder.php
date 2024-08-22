<?php

namespace Database\Seeders;

use App\Models\TrackingProceso;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackingProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_tracking_proceso = [
            ['descripcion'=>'DESPACHO'],
            ['descripcion'=>'TRASLADO'],
            ['descripcion'=>'RECEPCIÓN DE MERCADERÍA'],
            ['descripcion'=>'INSPECCIÓN'],
            ['descripcion'=>'PAGO DE MERCADERÍA11'],
            ['descripcion'=>'INSPECCIÓN DE MERCADERÍA'],
            ['descripcion'=>'DIFERENCIAS'],
            ['descripcion'=>'DEVOLUCIÓN'],
            ['descripcion'=>'FIN'],
        ];

        foreach ($list_tracking_proceso as $list) {
            $tracking_proceso = new TrackingProceso();
            $tracking_proceso->descripcion = $list['descripcion'];
            $tracking_proceso->save();
        }
    }
}
