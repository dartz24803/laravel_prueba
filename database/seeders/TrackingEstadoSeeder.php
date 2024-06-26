<?php

namespace Database\Seeders;

use App\Models\TrackingEstado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackingEstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_tracking_estado = [
            ['id_proceso'=>'1','descripcion'=>'MERCADERÍA POR SALIR'],
            ['id_proceso'=>'1','descripcion'=>'MERCADERÍA LISTA'],
            ['id_proceso'=>'1','descripcion'=>'SALIDA DE MERCADERÍA'],
            ['id_proceso'=>'2','descripcion'=>'MERCADERÍA EN TRÁNSITO'],
            ['id_proceso'=>'3','descripcion'=>'LLEGADA A TIENDA'],
            ['id_proceso'=>'3','descripcion'=>'CONFIRMACIÓN DE LLEGADA'],
            ['id_proceso'=>'3','descripcion'=>'MERCADERÍA LLEGÓ A TIENDA'],
            ['id_proceso'=>'4','descripcion'=>'REPORTE DE INSPECCIÓN DE FARDOS'],
            ['id_proceso'=>'4','descripcion'=>'CIERRE DE INSPECCIÓN DE FARDOS'],
            ['id_proceso'=>'5','descripcion'=>'CONFIRMACIÓN DE PAGO A TRANSPORTE'],
            ['id_proceso'=>'5','descripcion'=>'MERCADERÍA PAGADA'],
            ['id_proceso'=>'6','descripcion'=>'INSPECCIÓN DE MERCADERÍA'],
            ['id_proceso'=>'6','descripcion'=>'CONTEO DE MERCADERÍA'],
            ['id_proceso'=>'7','descripcion'=>'SOLICITUD DE DIFERENCIA'],
            ['id_proceso'=>'7','descripcion'=>'REPORTE DE DIFERENCIAS'],
            ['id_proceso'=>'7','descripcion'=>'DIFERENCIAS REGULARIZADAS'],
            ['id_proceso'=>'8','descripcion'=>'SOLICITUD DE DEVOLUCIÓN'],
            ['id_proceso'=>'8','descripcion'=>'REPORTE DE DEVOLUCIÓN'],
            ['id_proceso'=>'8','descripcion'=>'AUTORIZACIÓN DE DEVOLUCIÓN'],
            ['id_proceso'=>'8','descripcion'=>'CIERRE DE INCONFORMIDADES DE DEVOLUCIÓN'],
            ['id_proceso'=>'9','descripcion'=>'MERCADERÍA ENTREGADA'],
        ];

        foreach ($list_tracking_estado as $list) {
            $tracking_estado = new TrackingEstado();
            $tracking_estado->id_proceso = $list['id_proceso'];
            $tracking_estado->descripcion = $list['descripcion'];
            $tracking_estado->save();
        }
    }
}
