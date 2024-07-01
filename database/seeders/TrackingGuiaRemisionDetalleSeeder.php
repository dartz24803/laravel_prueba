<?php

namespace Database\Seeders;

use App\Models\TrackingGuiaRemisionDetalle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrackingGuiaRemisionDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $list_tracking_guia_remision_detalle = [
            ['n_guia_remision'=>'00001','color'=>'Color 00001 - 1','estilo'=>'Estilo 00001 - 1','talla'=>'Talla 00001 - 1','descripcion'=>'Descripción 00001 - 1','cantidad'=>'10'],
            ['n_guia_remision'=>'00001','color'=>'Color 00001 - 2','estilo'=>'Estilo 00001 - 2','talla'=>'Talla 00001 - 2','descripcion'=>'Descripción 00001 - 1','cantidad'=>'20'],
            ['n_guia_remision'=>'00001','color'=>'Color 00001 - 3','estilo'=>'Estilo 00001 - 3','talla'=>'Talla 00001 - 3','descripcion'=>'Descripción 00001 - 3','cantidad'=>'30'],
            ['n_guia_remision'=>'00001','color'=>'Color 00001 - 4','estilo'=>'Estilo 00001 - 4','talla'=>'Talla 00001 - 4','descripcion'=>'Descripción 00001 - 4','cantidad'=>'40'],
            ['n_guia_remision'=>'00001','color'=>'Color 00001 - 5','estilo'=>'Estilo 00001 - 5','talla'=>'Talla 00001 - 5','descripcion'=>'Descripción 00001 - 5','cantidad'=>'50'],
            ['n_guia_remision'=>'00002','color'=>'Color 00002 - 1','estilo'=>'Estilo 00002 - 1','talla'=>'Talla 00002 - 1','descripcion'=>'Descripción 00002 - 1','cantidad'=>'10'],
            ['n_guia_remision'=>'00002','color'=>'Color 00002 - 2','estilo'=>'Estilo 00002 - 2','talla'=>'Talla 00002 - 2','descripcion'=>'Descripción 00002 - 1','cantidad'=>'20'],
            ['n_guia_remision'=>'00002','color'=>'Color 00002 - 3','estilo'=>'Estilo 00002 - 3','talla'=>'Talla 00002 - 3','descripcion'=>'Descripción 00002 - 3','cantidad'=>'30'],
            ['n_guia_remision'=>'00002','color'=>'Color 00002 - 4','estilo'=>'Estilo 00002 - 4','talla'=>'Talla 00002 - 4','descripcion'=>'Descripción 00002 - 4','cantidad'=>'40'],
            ['n_guia_remision'=>'00002','color'=>'Color 00002 - 5','estilo'=>'Estilo 00002 - 5','talla'=>'Talla 00002 - 5','descripcion'=>'Descripción 00002 - 5','cantidad'=>'50'],
            ['n_guia_remision'=>'00002','color'=>'Color 00003 - 1','estilo'=>'Estilo 00003 - 1','talla'=>'Talla 00003 - 1','descripcion'=>'Descripción 00003 - 1','cantidad'=>'10'],
            ['n_guia_remision'=>'00003','color'=>'Color 00003 - 2','estilo'=>'Estilo 00003 - 2','talla'=>'Talla 00003 - 2','descripcion'=>'Descripción 00003 - 1','cantidad'=>'20'],
            ['n_guia_remision'=>'00003','color'=>'Color 00003 - 3','estilo'=>'Estilo 00003 - 3','talla'=>'Talla 00003 - 3','descripcion'=>'Descripción 00003 - 3','cantidad'=>'30'],
            ['n_guia_remision'=>'00003','color'=>'Color 00003 - 4','estilo'=>'Estilo 00003 - 4','talla'=>'Talla 00003 - 4','descripcion'=>'Descripción 00003 - 4','cantidad'=>'40'],
            ['n_guia_remision'=>'00003','color'=>'Color 00003 - 5','estilo'=>'Estilo 00003 - 5','talla'=>'Talla 00003 - 5','descripcion'=>'Descripción 00003 - 5','cantidad'=>'50'],
            ['n_guia_remision'=>'00004','color'=>'Color 00004 - 1','estilo'=>'Estilo 00004 - 1','talla'=>'Talla 00004 - 1','descripcion'=>'Descripción 00004 - 1','cantidad'=>'10'],
            ['n_guia_remision'=>'00004','color'=>'Color 00004 - 2','estilo'=>'Estilo 00004 - 2','talla'=>'Talla 00004 - 2','descripcion'=>'Descripción 00004 - 1','cantidad'=>'20'],
            ['n_guia_remision'=>'00004','color'=>'Color 00004 - 3','estilo'=>'Estilo 00004 - 3','talla'=>'Talla 00004 - 3','descripcion'=>'Descripción 00004 - 3','cantidad'=>'30'],
            ['n_guia_remision'=>'00004','color'=>'Color 00004 - 4','estilo'=>'Estilo 00004 - 4','talla'=>'Talla 00004 - 4','descripcion'=>'Descripción 00004 - 4','cantidad'=>'40'],
            ['n_guia_remision'=>'00004','color'=>'Color 00004 - 5','estilo'=>'Estilo 00004 - 5','talla'=>'Talla 00004 - 5','descripcion'=>'Descripción 00004 - 5','cantidad'=>'50'],
            ['n_guia_remision'=>'00005','color'=>'Color 00005 - 1','estilo'=>'Estilo 00005 - 1','talla'=>'Talla 00005 - 1','descripcion'=>'Descripción 00005 - 1','cantidad'=>'10'],
            ['n_guia_remision'=>'00005','color'=>'Color 00005 - 2','estilo'=>'Estilo 00005 - 2','talla'=>'Talla 00005 - 2','descripcion'=>'Descripción 00005 - 1','cantidad'=>'20'],
            ['n_guia_remision'=>'00005','color'=>'Color 00005 - 3','estilo'=>'Estilo 00005 - 3','talla'=>'Talla 00005 - 3','descripcion'=>'Descripción 00005 - 3','cantidad'=>'30'],
            ['n_guia_remision'=>'00005','color'=>'Color 00005 - 4','estilo'=>'Estilo 00005 - 4','talla'=>'Talla 00005 - 4','descripcion'=>'Descripción 00005 - 4','cantidad'=>'40'],
            ['n_guia_remision'=>'00005','color'=>'Color 00005 - 5','estilo'=>'Estilo 00005 - 5','talla'=>'Talla 00005 - 5','descripcion'=>'Descripción 00005 - 5','cantidad'=>'50'],
            ['n_guia_remision'=>'00002','color'=>'Color 00006 - 1','estilo'=>'Estilo 00006 - 1','talla'=>'Talla 00006 - 1','descripcion'=>'Descripción 00006 - 1','cantidad'=>'10'],
            ['n_guia_remision'=>'00006','color'=>'Color 00006 - 2','estilo'=>'Estilo 00006 - 2','talla'=>'Talla 00006 - 2','descripcion'=>'Descripción 00006 - 1','cantidad'=>'20'],
            ['n_guia_remision'=>'00006','color'=>'Color 00006 - 3','estilo'=>'Estilo 00006 - 3','talla'=>'Talla 00006 - 3','descripcion'=>'Descripción 00006 - 3','cantidad'=>'30'],
            ['n_guia_remision'=>'00006','color'=>'Color 00006 - 4','estilo'=>'Estilo 00006 - 4','talla'=>'Talla 00006 - 4','descripcion'=>'Descripción 00006 - 4','cantidad'=>'40'],
            ['n_guia_remision'=>'00006','color'=>'Color 00006 - 5','estilo'=>'Estilo 00006 - 5','talla'=>'Talla 00006 - 5','descripcion'=>'Descripción 00006 - 5','cantidad'=>'50'],
        ];

        foreach ($list_tracking_guia_remision_detalle as $list) {
            $tracking_grd = new TrackingGuiaRemisionDetalle();
            $tracking_grd->n_guia_remision = $list['n_guia_remision'];
            $tracking_grd->color = $list['color'];
            $tracking_grd->estilo = $list['estilo'];
            $tracking_grd->talla = $list['talla'];
            $tracking_grd->descripcion = $list['descripcion'];
            $tracking_grd->cantidad = $list['cantidad'];
            $tracking_grd->save();
        }
    }
}
