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
            ['n_requerimiento'=>'00001','n_guia_remision'=>'00001','sku'=>'10001','color'=>'Color 00001 - 1','estilo'=>'Estilo 00001 - 1','talla'=>'Talla 00001 - 1','descripcion'=>'Descripción 00001 - 1','cantidad'=>'10'],
            ['n_requerimiento'=>'00001','n_guia_remision'=>'00001','sku'=>'10002','color'=>'Color 00001 - 2','estilo'=>'Estilo 00001 - 2','talla'=>'Talla 00001 - 2','descripcion'=>'Descripción 00001 - 2','cantidad'=>'20'],
            ['n_requerimiento'=>'00001','n_guia_remision'=>'00001','sku'=>'10003','color'=>'Color 00001 - 3','estilo'=>'Estilo 00001 - 3','talla'=>'Talla 00001 - 3','descripcion'=>'Descripción 00001 - 3','cantidad'=>'30'],
            ['n_requerimiento'=>'00001','n_guia_remision'=>'00001','sku'=>'10004','color'=>'Color 00001 - 4','estilo'=>'Estilo 00001 - 4','talla'=>'Talla 00001 - 4','descripcion'=>'Descripción 00001 - 4','cantidad'=>'40'],
            ['n_requerimiento'=>'00001','n_guia_remision'=>'00001','sku'=>'10005','color'=>'Color 00001 - 5','estilo'=>'Estilo 00001 - 5','talla'=>'Talla 00001 - 5','descripcion'=>'Descripción 00001 - 5','cantidad'=>'50'],
            ['n_requerimiento'=>'00002','n_guia_remision'=>'00002','sku'=>'20001','color'=>'Color 00002 - 1','estilo'=>'Estilo 00002 - 1','talla'=>'Talla 00002 - 1','descripcion'=>'Descripción 00002 - 1','cantidad'=>'10'],
            ['n_requerimiento'=>'00002','n_guia_remision'=>'00002','sku'=>'20002','color'=>'Color 00002 - 2','estilo'=>'Estilo 00002 - 2','talla'=>'Talla 00002 - 2','descripcion'=>'Descripción 00002 - 2','cantidad'=>'20'],
            ['n_requerimiento'=>'00002','n_guia_remision'=>'00002','sku'=>'20003','color'=>'Color 00002 - 3','estilo'=>'Estilo 00002 - 3','talla'=>'Talla 00002 - 3','descripcion'=>'Descripción 00002 - 3','cantidad'=>'30'],
            ['n_requerimiento'=>'00002','n_guia_remision'=>'00002','sku'=>'20004','color'=>'Color 00002 - 4','estilo'=>'Estilo 00002 - 4','talla'=>'Talla 00002 - 4','descripcion'=>'Descripción 00002 - 4','cantidad'=>'40'],
            ['n_requerimiento'=>'00002','n_guia_remision'=>'00002','sku'=>'20005','color'=>'Color 00002 - 5','estilo'=>'Estilo 00002 - 5','talla'=>'Talla 00002 - 5','descripcion'=>'Descripción 00002 - 5','cantidad'=>'50'],
            ['n_requerimiento'=>'00003','n_guia_remision'=>'00003','sku'=>'30001','color'=>'Color 00003 - 1','estilo'=>'Estilo 00003 - 1','talla'=>'Talla 00003 - 1','descripcion'=>'Descripción 00003 - 1','cantidad'=>'10'],
            ['n_requerimiento'=>'00003','n_guia_remision'=>'00003','sku'=>'30002','color'=>'Color 00003 - 2','estilo'=>'Estilo 00003 - 2','talla'=>'Talla 00003 - 2','descripcion'=>'Descripción 00003 - 2','cantidad'=>'20'],
            ['n_requerimiento'=>'00003','n_guia_remision'=>'00003','sku'=>'30003','color'=>'Color 00003 - 3','estilo'=>'Estilo 00003 - 3','talla'=>'Talla 00003 - 3','descripcion'=>'Descripción 00003 - 3','cantidad'=>'30'],
            ['n_requerimiento'=>'00003','n_guia_remision'=>'00003','sku'=>'30004','color'=>'Color 00003 - 4','estilo'=>'Estilo 00003 - 4','talla'=>'Talla 00003 - 4','descripcion'=>'Descripción 00003 - 4','cantidad'=>'40'],
            ['n_requerimiento'=>'00003','n_guia_remision'=>'00003','sku'=>'30005','color'=>'Color 00003 - 5','estilo'=>'Estilo 00003 - 5','talla'=>'Talla 00003 - 5','descripcion'=>'Descripción 00003 - 5','cantidad'=>'50'],
            ['n_requerimiento'=>'00004','n_guia_remision'=>'00004','sku'=>'40001','color'=>'Color 00004 - 1','estilo'=>'Estilo 00004 - 1','talla'=>'Talla 00004 - 1','descripcion'=>'Descripción 00004 - 1','cantidad'=>'10'],
            ['n_requerimiento'=>'00004','n_guia_remision'=>'00004','sku'=>'40002','color'=>'Color 00004 - 2','estilo'=>'Estilo 00004 - 2','talla'=>'Talla 00004 - 2','descripcion'=>'Descripción 00004 - 2','cantidad'=>'20'],
            ['n_requerimiento'=>'00004','n_guia_remision'=>'00004','sku'=>'40003','color'=>'Color 00004 - 3','estilo'=>'Estilo 00004 - 3','talla'=>'Talla 00004 - 3','descripcion'=>'Descripción 00004 - 3','cantidad'=>'30'],
            ['n_requerimiento'=>'00004','n_guia_remision'=>'00004','sku'=>'40004','color'=>'Color 00004 - 4','estilo'=>'Estilo 00004 - 4','talla'=>'Talla 00004 - 4','descripcion'=>'Descripción 00004 - 4','cantidad'=>'40'],
            ['n_requerimiento'=>'00004','n_guia_remision'=>'00004','sku'=>'40005','color'=>'Color 00004 - 5','estilo'=>'Estilo 00004 - 5','talla'=>'Talla 00004 - 5','descripcion'=>'Descripción 00004 - 5','cantidad'=>'50'],
            ['n_requerimiento'=>'00005','n_guia_remision'=>'00005','sku'=>'50001','color'=>'Color 00005 - 1','estilo'=>'Estilo 00005 - 1','talla'=>'Talla 00005 - 1','descripcion'=>'Descripción 00005 - 1','cantidad'=>'10'],
            ['n_requerimiento'=>'00005','n_guia_remision'=>'00005','sku'=>'50002','color'=>'Color 00005 - 2','estilo'=>'Estilo 00005 - 2','talla'=>'Talla 00005 - 2','descripcion'=>'Descripción 00005 - 2','cantidad'=>'20'],
            ['n_requerimiento'=>'00005','n_guia_remision'=>'00005','sku'=>'50003','color'=>'Color 00005 - 3','estilo'=>'Estilo 00005 - 3','talla'=>'Talla 00005 - 3','descripcion'=>'Descripción 00005 - 3','cantidad'=>'30'],
            ['n_requerimiento'=>'00005','n_guia_remision'=>'00005','sku'=>'50004','color'=>'Color 00005 - 4','estilo'=>'Estilo 00005 - 4','talla'=>'Talla 00005 - 4','descripcion'=>'Descripción 00005 - 4','cantidad'=>'40'],
            ['n_requerimiento'=>'00005','n_guia_remision'=>'00005','sku'=>'50005','color'=>'Color 00005 - 5','estilo'=>'Estilo 00005 - 5','talla'=>'Talla 00005 - 5','descripcion'=>'Descripción 00005 - 5','cantidad'=>'50'],
            ['n_requerimiento'=>'00006','n_guia_remision'=>'00006','sku'=>'60001','color'=>'Color 00006 - 1','estilo'=>'Estilo 00006 - 1','talla'=>'Talla 00006 - 1','descripcion'=>'Descripción 00006 - 1','cantidad'=>'10'],
            ['n_requerimiento'=>'00006','n_guia_remision'=>'00006','sku'=>'60002','color'=>'Color 00006 - 2','estilo'=>'Estilo 00006 - 2','talla'=>'Talla 00006 - 2','descripcion'=>'Descripción 00006 - 2','cantidad'=>'20'],
            ['n_requerimiento'=>'00006','n_guia_remision'=>'00006','sku'=>'60003','color'=>'Color 00006 - 3','estilo'=>'Estilo 00006 - 3','talla'=>'Talla 00006 - 3','descripcion'=>'Descripción 00006 - 3','cantidad'=>'30'],
            ['n_requerimiento'=>'00006','n_guia_remision'=>'00006','sku'=>'60004','color'=>'Color 00006 - 4','estilo'=>'Estilo 00006 - 4','talla'=>'Talla 00006 - 4','descripcion'=>'Descripción 00006 - 4','cantidad'=>'40'],
            ['n_requerimiento'=>'00006','n_guia_remision'=>'00006','sku'=>'60005','color'=>'Color 00006 - 5','estilo'=>'Estilo 00006 - 5','talla'=>'Talla 00006 - 5','descripcion'=>'Descripción 00006 - 5','cantidad'=>'50'],
        ];

        foreach ($list_tracking_guia_remision_detalle as $list) {
            TrackingGuiaRemisionDetalle::create([
                'n_requerimiento' => $list['n_requerimiento'],
                'n_guia_remision' => $list['n_guia_remision'],
                'sku' => $list['sku'],
                'color' => $list['color'],
                'estilo' => $list['estilo'],
                'talla' => $list['talla'],
                'descripcion' => $list['descripcion'],
                'cantidad' => $list['cantidad']
            ]);
        }
    }
}
