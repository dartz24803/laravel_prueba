<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Base;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Datos a insertar
        $list_base = [
            ['cod_base'=>'B01','nom_base'=>'BASE 01','id_empresa'=>'4','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150115','direccion'=>'AV. MEXICO NRO. 1609 INT. C','estado'=>'1'],
            ['cod_base'=>'B03','nom_base'=>'BASE 03','id_empresa'=>'33','id_departamento'=>'2','id_provincia'=>'218','id_distrito'=>'21801','direccion'=>'JR. LEONCIO PRADO NRO. 560 (CASCO URBANO)','estado'=>'1'],
            ['cod_base'=>'B04','nom_base'=>'BASE 04','id_empresa'=>'34','id_departamento'=>'24','id_provincia'=>'2403','id_distrito'=>'240301','direccion'=>'AV. REPUBLICA DEL PERU NRO 213 INT. 1','estado'=>'1'],
            ['cod_base'=>'B05','nom_base'=>'BASE 05','id_empresa'=>'29','id_departamento'=>'20','id_provincia'=>'2006','id_distrito'=>'200601','direccion'=>'AV. JOSE DE LAMA NRO. 147 C.P. BARRIO NORTE','estado'=>'1'],
            ['cod_base'=>'B06','nom_base'=>'BASE 06','id_empresa'=>'30','id_departamento'=>'4','id_provincia'=>'401','id_distrito'=>'40101','direccion'=>'CALLE MERCADERES NRO. 324','estado'=>'1'],
            ['cod_base'=>'B07','nom_base'=>'BASE 07','id_empresa'=>'30','id_departamento'=>'14','id_provincia'=>'1401','id_distrito'=>'140101','direccion'=>'AV. JOSE BALTA NRO. 1311 CERCADO DE CHICLAYO','estado'=>'1'],
            ['cod_base'=>'B08','nom_base'=>'BASE 08','id_empresa'=>'33','id_departamento'=>'6','id_provincia'=>'601','id_distrito'=>'60101','direccion'=>'CAL.APURIMAC NRO. 0971 BAR. LA MERCED','estado'=>'1'],
            ['cod_base'=>'B09','nom_base'=>'BASE 09','id_empresa'=>'32','id_departamento'=>'16','id_provincia'=>'1601','id_distrito'=>'160101','direccion'=>'JR. PROSPERO NRO. 1010','estado'=>'1'],
            ['cod_base'=>'B10','nom_base'=>'BASE 10','id_empresa'=>'28','id_departamento'=>'13','id_provincia'=>'1301','id_distrito'=>'130101','direccion'=>'JR. ZELA NRO. 212 BARRIO CHICAGO','estado'=>'1'],
            ['cod_base'=>'B11','nom_base'=>'BASE 11','id_empresa'=>'30','id_departamento'=>'11','id_provincia'=>'1102','id_distrito'=>'110201','direccion'=>'AV. MCAL OSCAR R.BENAVIDES NRO. 351','estado'=>'1'],
            ['cod_base'=>'B13','nom_base'=>'BASE 13','id_empresa'=>'2','id_departamento'=>'16','id_provincia'=>'1601','id_distrito'=>'160101','direccion'=>'JR. PROSPERO NRO. 996 SEC. 4','estado'=>'1'],
            ['cod_base'=>'B14','nom_base'=>'BASE 14','id_empresa'=>'5','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150115','direccion'=>'JR. MARISCAL AGUSTIN GAMARRA NRO. 404 URB. SAN PABLO','estado'=>'1'],
            ['cod_base'=>'B15','nom_base'=>'BASE 15','id_empresa'=>'28','id_departamento'=>'13','id_provincia'=>'1301','id_distrito'=>'130101','direccion'=>'JR. GAMARRA NRO. 784','estado'=>'1'],
            ['cod_base'=>'B18','nom_base'=>'BASE 18','id_empresa'=>'28','id_departamento'=>'13','id_provincia'=>'1301','id_distrito'=>'130101','direccion'=>'JR. GAMARRA NRO. 753 URB. CENTRO CIVICO','estado'=>'1'],
            ['cod_base'=>'OFC','nom_base'=>'OFC - FM','id_empresa'=>'8','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150115','direccion'=>'AV. IQUITOS NRO. 926','estado'=>'1'],
            ['cod_base'=>'OFC','nom_base'=>'OFC - DSC','id_empresa'=>'7','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150115','direccion'=>'AV. IQUITOS NRO. 926','estado'=>'1'],
            ['cod_base'=>'OFC','nom_base'=>'OFC - AYV','id_empresa'=>'10','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150115','direccion'=>'AV. IQUITOS 918-926 MZA. 53 LOTE. 2 URB. SANTA TERESA','estado'=>'1'],
            ['cod_base'=>'OFC','nom_base'=>'OFC - PB','id_empresa'=>'9','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 ZARATE (BLOQUE B OFICINA 102)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - DSC','id_empresa'=>'7','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 ZARATE (SECTOR D)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - TT','id_empresa'=>'33','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D -6)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - TR','id_empresa'=>'28','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D - 3)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - MN','id_empresa'=>'30','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D - 5)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - CB','id_empresa'=>'31','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D - 1)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - IT','id_empresa'=>'32','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D - 2)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - EC','id_empresa'=>'29','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D - 4)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - FM','id_empresa'=>'8','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. LOTIZACION RUSTICA-ZARATE (BLOQUE C - PISO 2)','estado'=>'1'],
            ['cod_base'=>'B16','nom_base'=>'BASE 16','id_empresa'=>'31','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. CAJAMARQUILLA NRO. 1349 URB. ZARATE (PISO 2)','estado'=>'1'],
            ['cod_base'=>'ZET','nom_base'=>'ZETATRON','id_empresa'=>'11','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150113','direccion'=>'AV. HORACIO URTEAGA NRO. 502 DPTO. 1801','estado'=>'1'],
            ['cod_base'=>'DEED','nom_base'=>'DEED','id_empresa'=>'12','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150113','direccion'=>'AV. HORACIO URTEAGA NRO. 502 DPTO. 1801','estado'=>'1'],
            ['cod_base'=>'B02','nom_base'=>'BASE 02','id_empresa'=>'4','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150101','direccion'=>'JR. DE LA UNION 431','estado'=>'1'],
            ['cod_base'=>'B12','nom_base'=>'BASE 12','id_empresa'=>'29','id_departamento'=>'20','id_provincia'=>'2001','id_distrito'=>'200101','direccion'=>'AV. GRAU 373 - A','estado'=>'1'],
            ['cod_base'=>'EXT','nom_base'=>'EXT - OFC','id_empresa'=>'7','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150115','direccion'=>'AV. IQUITOS NRO. 926','estado'=>'1'],
            ['cod_base'=>'B17','nom_base'=>'BASE 17','id_empresa'=>'27','id_departamento'=>'25','id_provincia'=>'2501','id_distrito'=>'250101','direccion'=>'JR. RAYMONDI NRO 532-534','estado'=>'1'],
            ['cod_base'=>'AMT','nom_base'=>'AMAUTAS','id_empresa'=>'8','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'JR. LOS AMAUTAS (URB- ZARATE) 752 - SAN JUAN DE LURIGANCHO','estado'=>'1'],
            ['cod_base'=>'BV','nom_base'=>'BASE VIRTUAL','id_empresa'=>'9','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'','estado'=>'1'],
            ['cod_base'=>'B00','nom_base'=>'BASE 00','id_empresa'=>'0','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150101','direccion'=>'Jirón Mariano Carranza 724 Dpto. 504','estado'=>'1'],
            ['cod_base'=>'B19','nom_base'=>'BASE 19','id_empresa'=>'27','id_departamento'=>'16','id_provincia'=>'1601','id_distrito'=>'160101','direccion'=>'AV. JOSE ABELARDO QUIÑONEZ LOTE. 2 OTR. ZONA URBANA SAN JUAN BAUTISTA (LC B-2008, B-2010, B-2012 -MALL AVENTURA) LORETO - MAYNAS - IQUITOS','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - ECM','id_empresa'=>'27','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'AV. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D-7)','estado'=>'1'],
            ['cod_base'=>'CD','nom_base'=>'CD - ICI','id_empresa'=>'34','id_departamento'=>'15','id_provincia'=>'1501','id_distrito'=>'150132','direccion'=>'AV. CAJAMARQUILLA NRO. 1349 URB. ZARATE (SECTOR D-8)','estado'=>'1'],
        ];

        // Crear y guardar registros usando el método save
        foreach ($list_base as $list) {
            Base::create([
                'cod_base' => $list['cod_base'],
                'nom_base' => $list['nom_base'],
                'id_empresa' => $list['id_empresa'],
                'id_departamento' => $list['id_departamento'],
                'id_provincia' => $list['id_provincia'],
                'id_distrito' => $list['id_distrito'],
                'direccion' => $list['direccion'],
                'estado' => $list['estado'],
            ]);
        }
    }
}