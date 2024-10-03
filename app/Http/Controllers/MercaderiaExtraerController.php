<?php

namespace App\Http\Controllers;

use App\Models\Mercaderia;
use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class MercaderiaExtraerController extends Controller
{
    protected $Model_Perfil;
    protected $input;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->Model_Perfil = new Model_Perfil();
        $this->input = $request;
    }

    public function Mercaderia(){
            $dato['list_mercaderia'] = Mercaderia::get_list_mercaderia();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            //REPORTE BI CON ID
            $dato['list_subgerencia'] = SubGerencia::list_subgerencia(7);
            //NOTIFICACIONES
            $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('logistica.Mercaderia.index', $dato);
    }
    
    public function Buscar_Mercaderia(){
            $dato['semana']= $this->input->post("semana");
            $dato['anio']= $this->input->post("anio");
            $dato['list_mercaderia'] = Mercaderia::get_list_mercaderia($dato);
            return view('logistica.Mercaderia.lista', $dato);
    }

    public function Cierre_Mercaderia(){
        $this->input->validate([
            'anio' => 'not_in:0',
            'semana' => 'not_in:0',
        ], [
            'anio.not_in' => 'Debe seleccionar un año.',
            'semana.not_in' => 'Debe seleccionar una semana.',
        ]);
            $semana = $this->input->post("semana");
            $anio = $this->input->post("anio");
            $valida_cierre= Mercaderia::get_valida_cierre($semana,$anio);
            $cant = Mercaderia::get_num_cierre($semana,$anio);
            if($valida_cierre){
                $cantcierre=$cant[0]['cantidad']+1;
                Mercaderia::cierre_mercaderia($semana,$cantcierre,$anio);
            }else{
                echo "error";
            }
    }
    
    public function Excel_MTotal($semana){
        set_time_limit(300);
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Mercaderia');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->setCellValue("A1", 'Empresa');
        $sheet->setCellValue("B1", "Costo");
        $sheet->setCellValue("C1", "PC");
        $sheet->setCellValue("D1", 'PV');
        $sheet->setCellValue("E1", "PP");
        $sheet->setCellValue("F1", "PC B4");
        $sheet->setCellValue("G1", 'PV B4');
        $sheet->setCellValue("H1", "PP B4");
        $sheet->setCellValue("I1", "Usuario");
        $sheet->setCellValue("J1", 'Tipo de prenda');
        $sheet->setCellValue("K1", "Codigo_Barra");
        $sheet->setCellValue("L1", "Autogenerado");
        $sheet->setCellValue("M1", 'EstiloProd');
        $sheet->setCellValue("N1", "Descripción");
        $sheet->setCellValue("O1", "Color");
        $sheet->setCellValue("P1", 'Talla');
        $sheet->setCellValue("Q1", "Stock disponible");
        $sheet->setCellValue("R1", "TOTAL");
        $sheet->setCellValue("S1", 'OBS');
        $sheet->setCellValue("T1", "B01");
        $sheet->setCellValue("U1", "B02");
        $sheet->setCellValue("V1", 'B03');
        $sheet->setCellValue("W1", "B04");
        $sheet->setCellValue("X1", "B05");
        $sheet->setCellValue("Y1", 'B06');
        $sheet->setCellValue("Z1", "B07");
        $sheet->setCellValue("AA1", "B08");
        $sheet->setCellValue("AB1", 'B09');
        $sheet->setCellValue("AC1", "B10");
        $sheet->setCellValue("AD1", "B11");
        $sheet->setCellValue("AE1", 'B13');
        $sheet->setCellValue("AF1", "B14");
        $sheet->setCellValue("AG1", 'B15');
        $sheet->setCellValue("AH1", "B16");
        $sheet->setCellValue("AI1", "B17");
        $sheet->setCellValue("AJ1", 'B18');
        $sheet->setCellValue("AK1", "USU. SISTEMA");
        $data = Mercaderia::get_list_mercaderiat($semana);
        $fila=1;
        
        foreach($data as $d){
            $fila = $fila+1;
            $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", $d['empresa']);
            $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $d['costo']);
            $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", $d['pc']);
            $spreadsheet->getActiveSheet()->setCellValue("D{$fila}", $d['pv']);
            $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", $d['pp']);
            $spreadsheet->getActiveSheet()->setCellValue("F{$fila}", $d['pc_b4']);
            $spreadsheet->getActiveSheet()->setCellValue("G{$fila}", $d['pv_b4']);
            $spreadsheet->getActiveSheet()->setCellValue("H{$fila}", $d['pp_b4']);
            $spreadsheet->getActiveSheet()->setCellValue("I{$fila}", $d['tipo_usuario']);
            $spreadsheet->getActiveSheet()->setCellValue("J{$fila}", $d['tipo_prenda']);
            $spreadsheet->getActiveSheet()->setCellValue("K{$fila}", $d['codigo_barra']);
            $spreadsheet->getActiveSheet()->setCellValue("L{$fila}", $d['autogenerado']);
            $spreadsheet->getActiveSheet()->setCellValue("M{$fila}", $d['estilo']);
            $spreadsheet->getActiveSheet()->setCellValue("N{$fila}", $d['decripcion']);
            $spreadsheet->getActiveSheet()->setCellValue("O{$fila}", $d['color']);
            $spreadsheet->getActiveSheet()->setCellValue("P{$fila}", $d['talla']);
            $spreadsheet->getActiveSheet()->setCellValue("Q{$fila}", $d['stock']);
            $spreadsheet->getActiveSheet()->setCellValue("R{$fila}", $d['total']);
            $spreadsheet->getActiveSheet()->setCellValue("S{$fila}", $d['observacion']);
            $spreadsheet->getActiveSheet()->setCellValue("T{$fila}", $d['B01']);
            $spreadsheet->getActiveSheet()->setCellValue("U{$fila}", $d['B02']);
            $spreadsheet->getActiveSheet()->setCellValue("V{$fila}", $d['B03']);
            $spreadsheet->getActiveSheet()->setCellValue("W{$fila}", $d['B04']);
            $spreadsheet->getActiveSheet()->setCellValue("X{$fila}", $d['B05']);
            $spreadsheet->getActiveSheet()->setCellValue("Y{$fila}", $d['B06']);
            $spreadsheet->getActiveSheet()->setCellValue("Z{$fila}", $d['B07']);
            $spreadsheet->getActiveSheet()->setCellValue("AA{$fila}", $d['B08']);
            $spreadsheet->getActiveSheet()->setCellValue("AB{$fila}", $d['B09']);
            $spreadsheet->getActiveSheet()->setCellValue("AC{$fila}", $d['B10']);
            $spreadsheet->getActiveSheet()->setCellValue("AD{$fila}", $d['B11']);
            $spreadsheet->getActiveSheet()->setCellValue("AE{$fila}", $d['B13']);
            $spreadsheet->getActiveSheet()->setCellValue("AF{$fila}", $d['B14']);
            $spreadsheet->getActiveSheet()->setCellValue("AG{$fila}", $d['B15']);
            $spreadsheet->getActiveSheet()->setCellValue("AH{$fila}", $d['B16']);
            $spreadsheet->getActiveSheet()->setCellValue("AI{$fila}", $d['B17']);
            $spreadsheet->getActiveSheet()->setCellValue("AJ{$fila}", $d['B18']);
            $spreadsheet->getActiveSheet()->setCellValue("AK{$fila}", $d['user_reg']);
            //border
            $sheet->getStyle("A{$fila}:AK{$fila}")->applyFromArray($styleThinBlackBorderOutline);
        }

        $sheet->getStyle('A1:AK1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		//$sheet->getStyle('A2:F100')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setWidth(14);
        $sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(10);
		$sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(12);
        $sheet->getColumnDimension('G')->setWidth(10);
		$sheet->getColumnDimension('H')->setWidth(14);
        $sheet->getColumnDimension('I')->setWidth(12);
        $sheet->getColumnDimension('J')->setWidth(10);
		$sheet->getColumnDimension('K')->setWidth(14);
        $sheet->getColumnDimension('L')->setWidth(12);
        $sheet->getColumnDimension('M')->setWidth(10);
		$sheet->getColumnDimension('N')->setWidth(14);
        $sheet->getColumnDimension('O')->setWidth(12);
        $sheet->getColumnDimension('P')->setWidth(10);
		$sheet->getColumnDimension('Q')->setWidth(14);
        $sheet->getColumnDimension('R')->setWidth(12);
        $sheet->getColumnDimension('S')->setWidth(10);
		$sheet->getColumnDimension('T')->setWidth(14);
        $sheet->getColumnDimension('U')->setWidth(12);
        $sheet->getColumnDimension('V')->setWidth(10);
		$sheet->getColumnDimension('W')->setWidth(14);
        $sheet->getColumnDimension('X')->setWidth(12);
        $sheet->getColumnDimension('Y')->setWidth(10);
		$sheet->getColumnDimension('Z')->setWidth(14);
        $sheet->getColumnDimension('AA')->setWidth(12);
        $sheet->getColumnDimension('AB')->setWidth(10);
		$sheet->getColumnDimension('AC')->setWidth(14);
        $sheet->getColumnDimension('AD')->setWidth(12);
        $sheet->getColumnDimension('AE')->setWidth(10);
		$sheet->getColumnDimension('AF')->setWidth(14);
        $sheet->getColumnDimension('AG')->setWidth(12);
        $sheet->getColumnDimension('AH')->setWidth(10);
		$sheet->getColumnDimension('AI')->setWidth(14);
        $sheet->getColumnDimension('AJ')->setWidth(12);
        $sheet->getColumnDimension('AK')->setWidth(12);
        
        //final part
		$writer = new Xlsx($spreadsheet);
		$filename = 'Mercaderia_Total_Semana_'.$semana;
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }

    public function Excel_Mercaderia($usuario, $semana, $anio, $cierre=null){
        $dato['list_control'] = Mercaderia::get_list_control_ubicaciones();
        $dato['list_nicho'] = Mercaderia::get_list_nicho($id_percha=null);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->setTitle('Mercaderia');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $data = Mercaderia::get_list_reparto($usuario, $semana, $anio, $cierre);
        $start = 1;
        $x = $start + 1;
        $j = 1;
		foreach($data as $cabe){
            $par_desusuario=$cabe['Usuario'];
            $sfa_descrip=$cabe['sfa_descrip'];
            $art_estiloprd=$cabe['art_estiloprd'];
            $sheet->setCellValue("A{$start}", "Nombres y Apellidos: ");
            $sheet->setCellValue("A{$x}", "Usuario");
            $sheet->setCellValue("B{$x}", "Tipo de Prenda");
            $sheet->setCellValue("C{$x}", 'Ubicacion');
            $sheet->setCellValue("D{$x}", "SKU");
            $sheet->setCellValue("E{$x}", "Estilo");
            $sheet->setCellValue("F{$x}", "Color");
            $sheet->setCellValue("G{$x}", "Talla");
            $sheet->setCellValue("H{$x}", "Pedido");
            $sheet->setCellValue("I{$x}", "B01");
            $sheet->setCellValue("J{$x}", "B02");
            $sheet->setCellValue("K{$x}", "B03");
            $sheet->setCellValue("L{$x}", "B04");
            $sheet->setCellValue("M{$x}", "B05");
            $sheet->setCellValue("N{$x}", "B06");
            $sheet->setCellValue("O{$x}", "B07");
            $sheet->setCellValue("P{$x}", "B08");
            $sheet->setCellValue("Q{$x}", "B09");
            $sheet->setCellValue("R{$x}", "B10");
            $sheet->setCellValue("S{$x}", "B11");
            $sheet->setCellValue("T{$x}", "B12");
            $sheet->setCellValue("U{$x}", "B13");
            $sheet->setCellValue("V{$x}", "B14");
            $sheet->setCellValue("W{$x}", "B15");
            $sheet->setCellValue("X{$x}", "B16");
            $sheet->setCellValue("Y{$x}", "B17");
            $sheet->setCellValue("Z{$x}", "B18");
            $sheet->setCellValue("AA{$x}", "B19");
            $sheet->setCellValue("AB{$x}", "B20");
            $sheet->setCellValue("AC{$x}", "BEC");
            $sheet->setCellValue("AD{$x}", "Saldo");
            $sheet->setCellValue("AE{$x}", "Req");

            $sheet->getStyle("A{$x}:AE{$x}")->getFont()->setBold(true);
            $sheet->getStyle("A{$start}:C{$start}")->getFont()->setBold(true);

            $detalle = Mercaderia::get_list_repartod($par_desusuario, $sfa_descrip,
            $art_estiloprd, $usuario, $semana, $anio, $cierre);

            $fila = $x;
            $stock = 0;
            $B01 = 0;
            $B02 = 0;
            $B03 = 0;
            $B04 = 0;
            $B05 = 0;
            $B06 = 0;
            $B07 = 0;
            $B08 = 0;
            $B09 = 0;
            $B10 = 0;
            $B11 = 0;
            $B12 = 0;
            $B13 = 0;
            $B14 = 0;
            $B15 = 0;
            $B16 = 0;
            $B17 = 0;
            $B18 = 0;
            $B19 = 0;
            $B20 = 0;
            $BEC = 0;
            $total = 0;
            $observacion = 0;
		    foreach($detalle as $d){
                $fila = $fila+1;
                $busqueda = in_array($cabe['art_estiloprd'], array_column($dato['list_control'], 'estilo'));
                $posicion = array_search($cabe['art_estiloprd'], array_column($dato['list_control'], 'estilo'));
                if ($busqueda!= false) { 
                    $ubicacion="";
                    $percha="";
                    if($dato['list_control'][$posicion]['id_nicho']!=""){
                        $control2=explode(",",$dato['list_control'][$posicion]['id_nicho']);
                        $contador=0;
                        
                        while($contador<count($control2)){
                            $posicion_puesto=array_search($control2[$contador],array_column($dato['list_nicho'],'id_nicho'));
                            $ubicacion=$ubicacion.$dato['list_nicho'][$posicion_puesto]['nom_percha'].$dato['list_nicho'][$posicion_puesto]['numero'].",";
                            $percha=$percha.$dato['list_nicho'][$posicion_puesto]['nom_percha'].",";
                            $contador++;
                        }
                        
                    }
                    $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", substr($ubicacion,0,-1));
                }
                $busqueda = in_array($cabe['art_estiloprd'], array_column($dato['list_control'], 'estilo'));
                $posicion = array_search($cabe['art_estiloprd'], array_column($dato['list_control'], 'estilo'));
                if ($busqueda!= false) { 
                    $ubicacion="";
                    $percha="";
                    if($dato['list_control'][$posicion]['id_nicho']!=""){
                        $control2=explode(",",$dato['list_control'][$posicion]['id_nicho']);
                        $contador=0;
                        
                        while($contador<count($control2)){
                            $posicion_puesto=array_search($control2[$contador],array_column($dato['list_nicho'],'id_nicho'));
                            $ubicacion=$ubicacion.$dato['list_nicho'][$posicion_puesto]['nom_percha'].$dato['list_nicho'][$posicion_puesto]['numero'].",";
                            $percha=$percha.$dato['list_nicho'][$posicion_puesto]['nom_percha'].",";
                            $contador++;
                        }
                        
                    }
                    $spreadsheet->getActiveSheet()->setCellValue("C{$fila}", substr($ubicacion,0,-1));
                }
                $spreadsheet->getActiveSheet()->setCellValue("D{$fila}", $d['SKU']);
                $spreadsheet->getActiveSheet()->setCellValue("E{$fila}", $cabe['art_estiloprd']);
                $spreadsheet->getActiveSheet()->setCellValue("A{$fila}", $cabe['Usuario']);
                $spreadsheet->getActiveSheet()->setCellValue("B{$fila}", $cabe['sfa_descrip']);
                
                $spreadsheet->getActiveSheet()->setCellValue("F{$fila}", $d['par_desccolor']);
                $spreadsheet->getActiveSheet()->setCellValue("G{$fila}", $d['tall_nombre']);
                if($d['total']!=0){$spreadsheet->getActiveSheet()->setCellValue("H{$fila}", $d['total']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("H{$fila}", "");}
                if($d['B01']!=0){$spreadsheet->getActiveSheet()->setCellValue("I{$fila}", $d['B01']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("I{$fila}", "");}                
                if($d['B02']!=0){$spreadsheet->getActiveSheet()->setCellValue("J{$fila}", $d['B02']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("J{$fila}", "");}
                if($d['B03']!=0){$spreadsheet->getActiveSheet()->setCellValue("K{$fila}", $d['B03']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("K{$fila}", "");}
                if($d['B04']!=0){$spreadsheet->getActiveSheet()->setCellValue("L{$fila}", $d['B04']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("L{$fila}", "");}
                if($d['B05']!=0){$spreadsheet->getActiveSheet()->setCellValue("M{$fila}", $d['B05']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("M{$fila}", "");}
                if($d['B06']!=0){$spreadsheet->getActiveSheet()->setCellValue("N{$fila}", $d['B06']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("N{$fila}", "");}
                if($d['B07']!=0){$spreadsheet->getActiveSheet()->setCellValue("O{$fila}", $d['B07']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("O{$fila}", "");}
                if($d['B08']!=0){$spreadsheet->getActiveSheet()->setCellValue("P{$fila}", $d['B08']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("P{$fila}", "");}
                if($d['B09']!=0){$spreadsheet->getActiveSheet()->setCellValue("Q{$fila}", $d['B09']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("Q{$fila}", "");}
                if($d['B10']!=0){$spreadsheet->getActiveSheet()->setCellValue("R{$fila}", $d['B10']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("R{$fila}", "");}
                if($d['B11']!=0){$spreadsheet->getActiveSheet()->setCellValue("S{$fila}", $d['B11']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("S{$fila}", "");}
                if($d['B12']!=0){$spreadsheet->getActiveSheet()->setCellValue("T{$fila}", $d['B12']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("T{$fila}", "");}
                if($d['B13']!=0){$spreadsheet->getActiveSheet()->setCellValue("U{$fila}", $d['B13']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("U{$fila}", "");}
                if($d['B14']!=0){$spreadsheet->getActiveSheet()->setCellValue("V{$fila}", $d['B14']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("V{$fila}", "");}
                if($d['B15']!=0){$spreadsheet->getActiveSheet()->setCellValue("W{$fila}", $d['B15']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("W{$fila}", "");}
                if($d['B16']!=0){$spreadsheet->getActiveSheet()->setCellValue("X{$fila}", $d['B16']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("X{$fila}", "");}
                if($d['B17']!=0){$spreadsheet->getActiveSheet()->setCellValue("Y{$fila}", $d['B17']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("Y{$fila}", "");}
                if($d['B18']!=0){$spreadsheet->getActiveSheet()->setCellValue("Z{$fila}", $d['B18']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("Z{$fila}", "");}
                if($d['B19']!=0){$spreadsheet->getActiveSheet()->setCellValue("AA{$fila}", $d['B19']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("AA{$fila}", "");}
                if($d['B20']!=0){$spreadsheet->getActiveSheet()->setCellValue("AB{$fila}", $d['B20']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("AB{$fila}", "");}
                if($d['BEC']!=0){$spreadsheet->getActiveSheet()->setCellValue("AC{$fila}", $d['BEC']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("AC{$fila}", "");}
                if($d['observacion']!=0){$spreadsheet->getActiveSheet()->setCellValue("AD{$fila}", $d['observacion']);}
                else{$spreadsheet->getActiveSheet()->setCellValue("AD{$fila}", "");}
                $spreadsheet->getActiveSheet()->setCellValue("AE{$fila}", $d['RN' ]);
                $stock=$stock + $d['stock'];
                $B01 = $B01 + $d['B01'];
                $B02 = $B02 + $d['B02'];
                $B03 = $B03 + $d['B03'];
                $B04 = $B04 + $d['B04'];
                $B05 = $B05 + $d['B05'];
                $B06 = $B06 + $d['B06'];
                $B07 = $B07 + $d['B07'];
                $B08 = $B08 + $d['B08'];
                $B09 = $B09 + $d['B09'];
                $B10 = $B10 + $d['B10'];
                $B11 = $B11 + $d['B11'];
                $B12 = $B12 + $d['B12'];
                $B13 = $B13 + $d['B13'];
                $B14 = $B14 + $d['B14'];
                $B15 = $B15 + $d['B15'];
                $B16 = $B16 + $d['B16'];
                $B17 = $B17 + $d['B17'];
                $B18 = $B18 + $d['B18'];
                $B19 = $B19 + $d['B19'];
                $B20 = $B20 + $d['B20'];
                $BEC = $BEC + $d['BEC'];
                $total = $total + $d['total'];
                $observacion = $observacion + $d['observacion'];
                //border
                $sheet->getStyle("A{$x}:AE{$x}")->applyFromArray($styleThinBlackBorderOutline);
                $sheet->getStyle("A{$fila}:AE{$fila}")->applyFromArray($styleThinBlackBorderOutline);
            }
            $j=$fila+1;
            $spreadsheet->getActiveSheet()->setCellValue("H{$j}", $total);
            $spreadsheet->getActiveSheet()->setCellValue("I{$j}", $B01);
            $spreadsheet->getActiveSheet()->setCellValue("J{$j}", $B02);
            $spreadsheet->getActiveSheet()->setCellValue("K{$j}", $B03);
            $spreadsheet->getActiveSheet()->setCellValue("L{$j}", $B04);
            $spreadsheet->getActiveSheet()->setCellValue("M{$j}", $B05);
            $spreadsheet->getActiveSheet()->setCellValue("N{$j}", $B06);
            $spreadsheet->getActiveSheet()->setCellValue("O{$j}", $B07);
            $spreadsheet->getActiveSheet()->setCellValue("P{$j}", $B08);
            $spreadsheet->getActiveSheet()->setCellValue("Q{$j}", $B09);
            $spreadsheet->getActiveSheet()->setCellValue("R{$j}", $B10);
            $spreadsheet->getActiveSheet()->setCellValue("S{$j}", $B11);
            $spreadsheet->getActiveSheet()->setCellValue("T{$j}", $B12);
            $spreadsheet->getActiveSheet()->setCellValue("U{$j}", $B13);
            $spreadsheet->getActiveSheet()->setCellValue("V{$j}", $B14);
            $spreadsheet->getActiveSheet()->setCellValue("W{$j}", $B15);
            $spreadsheet->getActiveSheet()->setCellValue("X{$j}", $B16);
            $spreadsheet->getActiveSheet()->setCellValue("Y{$j}", $B17);
            $spreadsheet->getActiveSheet()->setCellValue("Z{$j}", $B18);
            $spreadsheet->getActiveSheet()->setCellValue("AA{$j}", $B19);
            $spreadsheet->getActiveSheet()->setCellValue("AB{$j}", $B20);
            $spreadsheet->getActiveSheet()->setCellValue("AC{$j}", $BEC);
            $spreadsheet->getActiveSheet()->setCellValue("AD{$j}", $observacion);

            $start = $fila+3;
            $x = $start+1;
		}

        $sheet->getStyle('A1:AE1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

		//Custom width for Individual Columns
		$sheet->getColumnDimension('A')->setWidth(10);
		$sheet->getColumnDimension('B')->setWidth(14);
		$sheet->getColumnDimension('C')->setWidth(12);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(7);
        $sheet->getColumnDimension('H')->setWidth(5);
        $sheet->getColumnDimension('I')->setWidth(5);
        $sheet->getColumnDimension('J')->setWidth(5);
        $sheet->getColumnDimension('K')->setWidth(5);
		$sheet->getColumnDimension('L')->setWidth(5);
		$sheet->getColumnDimension('M')->setWidth(5);
        $sheet->getColumnDimension('N')->setWidth(5);
        $sheet->getColumnDimension('O')->setWidth(5);
        $sheet->getColumnDimension('P')->setWidth(5);
        $sheet->getColumnDimension('Q')->setWidth(5);
        $sheet->getColumnDimension('R')->setWidth(5);
        $sheet->getColumnDimension('S')->setWidth(5);
        $sheet->getColumnDimension('T')->setWidth(5);
        $sheet->getColumnDimension('U')->setWidth(5);
        $sheet->getColumnDimension('V')->setWidth(5);
        $sheet->getColumnDimension('W')->setWidth(5);
        $sheet->getColumnDimension('X')->setWidth(5);
        $sheet->getColumnDimension('Y')->setWidth(5);
        $sheet->getColumnDimension('Z')->setWidth(5);
        $sheet->getColumnDimension('AA')->setWidth(5);
        $sheet->getColumnDimension('AB')->setWidth(5);
        $sheet->getColumnDimension('AC')->setWidth(5);
        $sheet->getColumnDimension('AD')->setWidth(5);
        $sheet->getColumnDimension('AE')->setWidth(5);
        //final part
		$curdate = date('d-m-Y');
		$writer = new Xlsx($spreadsheet);
		$filename = 'Mercaderia_'.$usuario."_".$semana."_".$anio;
		ob_end_clean();
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
    }
}
