<?php

namespace App\Http\Controllers;

use App\Models\CajaChica;
use App\Models\CajaChicaPago;
use App\Models\CajaChicaPagoTemporal;
use App\Models\CajaChicaProducto;
use App\Models\CajaChicaProductoTmp;
use App\Models\CajaChicaRuta;
use App\Models\CajaChicaRutaTmp;
use App\Models\Categoria;
use App\Models\Empresas;
use App\Models\Notificacion;
use App\Models\Pago;
use App\Models\SubCategoria;
use App\Models\TipoMoneda;
use App\Models\Ubicacion;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SubGerencia;
use App\Models\TipoComprobante;
use App\Models\TipoPago;
use App\Models\UnidadCC;
use App\Models\Usuario;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use function PHPSTORM_META\map;

class CajaChicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(8);
        $list_tipo_moneda = TipoMoneda::select('id_moneda','nom_moneda')->where('estado',1)->get();
        return view('finanzas.tesoreria.caja_chica.index',compact(
            'list_notificacion',
            'list_subgerencia',
            'list_tipo_moneda'
        ));
    }

    public function list(Request $request)
    {
        $list_caja_chica = CajaChica::get_list_caja_chica([
            'fec_inicio'=>$request->fec_inicio,
            'fec_fin'=>$request->fec_fin
        ]);
        return view('finanzas.tesoreria.caja_chica.lista', compact('list_caja_chica'));
    }

    public function create_mo()
    {
        CajaChicaRutaTmp::where('id_usuario',session('usuario')->id_usuario)->delete();
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)
                        ->orderBy('cod_ubi','ASC')->get();
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('activo',1)
                        ->where('estado',1)->orderBy('nom_empresa','ASC')->get();
        $list_usuario = Usuario::select('id_usuario',
                        DB::raw("CONCAT(num_doc,' - ',usuario_apater,' ',usuario_amater,', ',
                        usuario_nombres) AS nom_usuario"))->where('estado',1)->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        return view('finanzas.tesoreria.caja_chica.modal_registrar_mo', compact(
            'list_ubicacion',
            'list_empresa',
            'list_usuario',
            'list_tipo_moneda'
        ));
    }

    public function traer_sub_categoria_mo(Request $request)
    {
        $get_id = Categoria::where('id_categoria_mae',3)
                ->where('id_ubicacion',$request->id_ubicacion)
                ->where('nom_categoria','MOVILIDAD')->where('estado',1)->first();

        if(isset($get_id->id_categoria)){
            $list_sub_categoria = SubCategoria::where('id_categoria',$get_id->id_categoria)
                                ->where('estado',1)->orderBy('nombre','ASC')->get();
        }else{
            $list_sub_categoria = [];
        }
        return view('finanzas.tesoreria.caja_chica.sub_categoria', compact('list_sub_categoria'));
    }

    public function list_tmp_mo(Request $request)
    {
        $list_temporal = CajaChicaRutaTmp::select('id','personas','punto_salida','punto_llegada',
                        DB::raw("CASE WHEN transporte=1 THEN 'A PIE' WHEN transporte=2 THEN 'BUS'
                        WHEN transporte=3 THEN 'COLECTIVO' WHEN transporte=4 THEN 'METRO'
                        WHEN transporte=5 THEN 'TAXI' WHEN transporte=6 THEN 'TREN'
                        ELSE '' END AS transporte"),'motivo','costo')
                        ->where('id_usuario',session('usuario')->id_usuario)->get();
        return view('finanzas.tesoreria.caja_chica.lista_temporal_mo', compact('list_temporal'));
    }

    public function store_tmp_mo(Request $request)
    {
        $request->validate([
            'personas' => 'required|gt:0',
            'punto_salida' => 'required',
            'punto_llegada' => 'required',
            'transporte' => 'gt:0',
            'motivo' => 'required',
            'costo' => 'required'
        ],[
            'personas.required' => 'Debe ingresar n° personas.',
            'personas.gt' => 'Debe ingresar n° personas mayor a 0.',
            'punto_salida.required' => 'Debe ingresar punto salida.',
            'punto_llegada.required' => 'Debe ingresar punto llegada.',
            'transporte.gt' => 'Debe seleccionar transporte.',
            'motivo.required' => 'Debe ingresar motivo.',
            'costo.required' => 'Debe ingresar costo.'
        ]);

        CajaChicaRutaTmp::create([
            'id_usuario' => session('usuario')->id_usuario,
            'personas' => $request->personas,
            'punto_salida' => $request->punto_salida,
            'punto_llegada' => $request->punto_llegada,
            'transporte' => $request->transporte,
            'motivo' => $request->motivo,
            'costo' => $request->costo
        ]);
    }

    public function destroy_tmp_mo($id)
    {
        CajaChicaRutaTmp::destroy($id);
    }

    public function total_tmp_mo()
    {
        $suma = CajaChicaRutaTmp::where('id_usuario',session('usuario')->id_usuario)->sum('costo');
        echo $suma;
    }

    public function store_mo(Request $request)
    {
        $request->validate([
            'id_ubicacion' => 'gt:0',
            'id_empresa' => 'gt:0',
            'id_sub_categoria' => 'gt:0',
            'id_usuario' => 'gt:0',
            'fecha' => 'required',
            'descripcion' => 'required'
        ], [
            'id_ubicacion.gt' => 'Debe seleccionar ubicación.',
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'id_sub_categoria.gt' => 'Debe seleccionar sub-categoría.',
            'id_usuario.gt' => 'Debe seleccionar solicitante.',
            'fecha.required' => 'Debe ingresar fecha solicitud.',
            'descripcion.required' => 'Debe ingresar descripción.'
        ]);

        $errors = [];
        $list_temporal = CajaChicaRutaTmp::where('id_usuario',session('usuario')->id_usuario)
                        ->count();
        if($list_temporal=="0"){
            $errors['temporal'] = ['Debe adicionar al menos una ruta.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $cantidad = CajaChica::where('tipo','MO')->count();
        if(($cantidad+1)<=9){
            $n_comprobante = "000000".($cantidad+1);
        }
        if(($cantidad+1)>9 && ($cantidad+1)<=99){
            $n_comprobante = "00000".($cantidad+1);
        }
        if(($cantidad+1)>99 && ($cantidad+1)<=999){
            $n_comprobante = "0000".($cantidad+1);
        }
        if(($cantidad+1)>999 && ($cantidad+1)<=9999){
            $n_comprobante = "000".($cantidad+1);
        }
        if(($cantidad+1)>9999 && ($cantidad+1)<=99999){
            $n_comprobante = "00".($cantidad+1);
        }
        if(($cantidad+1)>99999 && ($cantidad+1)<=999999){
            $n_comprobante = "0".($cantidad+1);
        }
        if(($cantidad+1)>999999 && ($cantidad+1)<=9999999){
            $n_comprobante = ($cantidad+1);
        }

        $get_id = SubCategoria::findOrFail($request->id_sub_categoria);

        $caja_chica = CajaChica::create([
            'tipo' => 'MO',
            'id_ubicacion' => $request->id_ubicacion,
            'id_categoria' => $get_id->id_categoria,
            'id_empresa' => $request->id_empresa,
            'id_sub_categoria' => $request->id_sub_categoria,
            'id_usuario' => $request->id_usuario,
            'tipo_movimiento' => $request->tipo_movimiento,
            'fecha' => $request->fecha,
            'descripcion' => $request->descripcion,
            'id_tipo_moneda' => $request->id_tipo_moneda,
            'id_tipo_comprobante' => 6,
            'n_comprobante' => $n_comprobante,
            'id_pago' => 1,
            'id_tipo_pago' => 1,
            'estado_c' => 1,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        DB::statement('INSERT INTO caja_chica_ruta (id_caja_chica,personas,punto_salida,
        punto_llegada,transporte,motivo,costo)
        SELECT '.$caja_chica->id.',personas,punto_salida,punto_llegada,transporte,motivo,costo
        FROM caja_chica_ruta_tmp
        WHERE id_usuario='.session('usuario')->id_usuario);

        CajaChicaRutaTmp::where('id_usuario',session('usuario')->id_usuario)->delete();
    }

    public function create_pv()
    {
        CajaChicaProductoTmp::where('id_usuario',session('usuario')->id_usuario)->delete();
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)
                        ->orderBy('cod_ubi','ASC')->get();
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('activo',1)
                        ->where('estado',1)->orderBy('nom_empresa','ASC')->get();
        $list_usuario = Usuario::select('id_usuario',
                        DB::raw("CONCAT(num_doc,' - ',usuario_apater,' ',usuario_amater,', ',
                        usuario_nombres) AS nom_usuario"))->where('estado',1)->get();
        $list_tipo_comprobante = TipoComprobante::whereIn('id',[1,2,3,6])->get();
        $list_pago = Pago::all();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        $list_unidad = UnidadCC::all();
        return view('finanzas.tesoreria.caja_chica.modal_registrar_pv', compact(
            'list_ubicacion',
            'list_empresa',
            'list_usuario',
            'list_tipo_comprobante',
            'list_pago',
            'list_tipo_moneda',
            'list_unidad'
        ));
    }

    public function traer_categoria_pv(Request $request)
    {
        $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',3)
                        ->where('id_ubicacion',$request->id_ubicacion)->where('nom_categoria','!=','MOVILIDAD')
                        ->where('estado',1)->get();
        return view('finanzas.tesoreria.caja_chica.categoria', compact('list_categoria'));
    }

    public function traer_sub_categoria_pv(Request $request)
    {
        $list_sub_categoria = SubCategoria::select('id','nombre')->where('id_categoria',$request->id_categoria)
                            ->where('estado',1)->get();
        return view('finanzas.tesoreria.caja_chica.sub_categoria', compact('list_sub_categoria'));
    }
    
    public function traer_tipo_pago(Request $request)
    {
        if($request->id_pago=="1"){
            $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)
                            ->where('estado',1)->whereIn('id',[1,2])
                            ->orderBy('nombre','ASC')->get();
        }elseif($request->id_pago=="2"){
            $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)
                            ->where('estado',1)->whereIn('id',[2])
                            ->orderBy('nombre','ASC')->get();
        }else{
            $list_tipo_pago = [];
        }
        return view('finanzas.tesoreria.caja_chica.tipo_pago',compact('list_tipo_pago'));
    }

    public function consultar_ruc(Request $request)
    {
        $request->validate([
            'ruc' => 'required|size:11'
        ], [
            'ruc.required' => 'Debe ingresar RUC.',
            'ruc.size' => 'Debe ingresar RUC válido (11 dígitos).'
        ]);

        $client = new Client();
        $body = '';
        $request = new Psr7Request('GET', 'https://dniruc.apisperu.com/api/v1/ruc/'.$request->ruc.'?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6InNpc3RlbWFzbGFudW1lcm91bm9AZ21haWwuY29tIn0.FP8eTZr1p_oKvGXN3Wcc8mZd4fBuyAYvSYy28Qkgg0E', [], $body);
        $res = $client->sendAsync($request)->wait();
        $responseData = json_decode($res->getBody(), true);

        if(isset($responseData['success'])){
            echo "error@@@".$responseData['message'];
        }else{
            echo $responseData['razonSocial']."@@@".$responseData['direccion'];
        }
    }

    public function list_tmp_pv(Request $request)
    {
        $list_temporal = CajaChicaProductoTmp::from('caja_chica_producto_tmp AS cp')
                        ->select('cp.id','cp.cantidad','un.nom_unidad','cp.producto','cp.precio',
                        DB::raw('cp.cantidad*cp.precio AS total'))
                        ->join('vw_unidad_caja_chica AS un','un.id_unidad','=','cp.id_unidad')
                        ->where('cp.id_usuario',session('usuario')->id_usuario)->get();
        return view('finanzas.tesoreria.caja_chica.lista_temporal_pv', compact('list_temporal'));
    }

    public function store_tmp_pv(Request $request)
    {
        $request->validate([
            'cantidad' => 'required|gt:0',
            'id_unidad' => 'gt:0',
            'producto' => 'required',
            'precio' => 'required|gt:0'
        ],[
            'cantidad.required' => 'Debe ingresar cantidad.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
            'id_unidad.gt' => 'Debe seleccionar unidad.',
            'producto.required' => 'Debe ingresar producto.',
            'precio.required' => 'Debe ingresar precio unitario.',
            'precio.gt' => 'Debe ingresar precio unitario mayor a 0.'
        ]);

        CajaChicaProductoTmp::create([
            'id_usuario' => session('usuario')->id_usuario,
            'cantidad' => $request->cantidad,
            'id_unidad' => $request->id_unidad,
            'producto' => $request->producto,
            'precio' => $request->precio
        ]);
    }

    public function destroy_tmp_pv($id)
    {
        CajaChicaProductoTmp::destroy($id);
    }

    public function total_tmp_pv()
    {
        $suma = CajaChicaProductoTmp::where('id_usuario',session('usuario')->id_usuario)
                ->sum(DB::raw('cantidad*precio'));
        echo $suma;
    }

    public function store_pv(Request $request)
    {
        $request->validate([
            'id_ubicacion' => 'gt:0',
            'id_categoria' => 'gt:0',
            'id_empresa' => 'gt:0',
            'id_sub_categoria' => 'gt:0',
            'id_usuario' => 'gt:0',
            'tipo_movimiento' => 'required',
            'id_tipo_comprobante' => 'gt:0',
            'n_comprobante' => 'required',
            'id_pago' => 'gt:0',
            'id_tipo_pago' => 'gt:0',
            'fecha' => 'required',
            'comprobante' => 'required',
            'ruc' => 'nullable|size:11',
            'razon_social' => 'required',
            'descripcion' => 'required'
        ], [
            'id_ubicacion.gt' => 'Debe seleccionar ubicación.',
            'id_categoria.gt' => 'Debe seleccionar categoría.',
            'id_empresa.gt' => 'Debe seleccionar empresa.',
            'id_sub_categoria.gt' => 'Debe seleccionar sub-categoría.',
            'id_usuario.gt' => 'Debe seleccionar solicitante.',
            'tipo_movimiento.required' => 'Debe seleccionar tipo de movimiento.',
            'id_tipo_comprobante.gt' => 'Debe seleccionar tipo comprobante.',
            'n_comprobante.required' => 'Debe ingresar n° comprobante.',
            'id_pago.gt' => 'Debe seleccionar pago.',
            'id_tipo_pago.gt' => 'Debe seleccionar tipo pago.',
            'fecha.required' => 'Debe ingresar fecha solicitud.',
            'comprobante.required' => 'Debe cargar comprobante.',
            'ruc.size' => 'Debe ingresar RUC válido (11 dígitos).',
            'razon_social.required' => 'Debe ingresar razón social.',
            'descripcion.required' => 'Debe ingresar descripción.'
        ]);

        $errors = [];
        $list_temporal = CajaChicaProductoTmp::where('id_usuario',session('usuario')->id_usuario)
                        ->count();
        if($list_temporal=="0"){
            $errors['temporal'] = ['Debe adicionar al menos un producto.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $comprobante = "";
        if ($_FILES["comprobante"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                $path = $_FILES["comprobante"]["name"];
                $source_file = $_FILES['comprobante']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CAJA_CHICA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante = "https://lanumerounocloud.com/intranet/CAJA_CHICA/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        $caja_chica = CajaChica::create([
            'tipo' => 'PV',
            'id_ubicacion' => $request->id_ubicacion,
            'id_categoria' => $request->id_categoria,
            'id_empresa' => $request->id_empresa,
            'id_sub_categoria' => $request->id_sub_categoria,
            'id_usuario' => $request->id_usuario,
            'tipo_movimiento' => $request->tipo_movimiento,
            'id_tipo_comprobante' => $request->id_tipo_comprobante,
            'n_comprobante' => $request->n_comprobante,
            'id_pago' => $request->id_pago,
            'id_tipo_pago' => $request->id_tipo_pago,
            'fecha' => $request->fecha,
            'comprobante' => $comprobante,
            'ruc' => $request->ruc,
            'razon_social' => $request->razon_social,
            'direccion' => $request->direccion,
            'descripcion' => $request->descripcion,
            'id_tipo_moneda' => $request->id_tipo_moneda,
            'estado_c' => 1,
            'estado' => 1,
            'fec_reg' => now(),
            'user_reg' => session('usuario')->id_usuario,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        DB::statement('INSERT INTO caja_chica_producto (id_caja_chica,cantidad,id_unidad,producto,precio)
        SELECT '.$caja_chica->id.',cantidad,id_unidad,producto,precio
        FROM caja_chica_producto_tmp
        WHERE id_usuario='.session('usuario')->id_usuario);

        CajaChicaProductoTmp::where('id_usuario',session('usuario')->id_usuario)->delete();
    }

    public function show($id)
    {
        $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();                   
        if($get_id->tipo=="MO"){
            $list_ruta = CajaChicaRuta::select('id','personas','punto_salida','punto_llegada',
                        DB::raw("CASE WHEN transporte=1 THEN 'A PIE' WHEN transporte=2 THEN 'BUS'
                        WHEN transporte=3 THEN 'COLECTIVO' WHEN transporte=4 THEN 'METRO'
                        WHEN transporte=5 THEN 'TAXI' WHEN transporte=6 THEN 'TREN'
                        ELSE '' END AS transporte"),'motivo','costo')->where('id_caja_chica',$id)
                        ->get();
            return view('finanzas.tesoreria.caja_chica.modal_detalle_mo', compact(
                'get_id',
                'list_tipo_moneda',
                'list_ruta'
            ));
        }else{
            $list_producto = CajaChicaProducto::from('caja_chica_producto AS cp')
                            ->select('cp.id','cp.cantidad','un.nom_unidad','cp.producto','cp.precio',
                            DB::raw('cp.cantidad*cp.precio AS total'))
                            ->join('vw_unidad_caja_chica AS un','un.id_unidad','=','cp.id_unidad')
                            ->where('cp.id_caja_chica',$id)->get();                            
            return view('finanzas.tesoreria.caja_chica.modal_detalle_pv', compact(
                'get_id',
                'list_tipo_moneda',
                'list_producto'
            ));
        }
    }

    public function edit($id)
    {
        $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
        $list_ubicacion = Ubicacion::select('id_ubicacion','cod_ubi')->where('estado',1)
                        ->orderBy('cod_ubi','ASC')->get();
        $list_empresa = Empresas::select('id_empresa','nom_empresa')->where('activo',1)
                        ->where('estado',1)->orderBy('nom_empresa','ASC')->get();
        $list_sub_categoria = SubCategoria::where('id_categoria',$get_id->id_categoria)
                            ->where('estado',1)->orderBy('nombre','ASC')->get();
        $list_usuario = Usuario::select('id_usuario',
                        DB::raw("CONCAT(num_doc,' - ',usuario_apater,' ',usuario_amater,', ',
                        usuario_nombres) AS nom_usuario"))->where('estado',1)->get();
        $list_tipo_moneda = TipoMoneda::select('id_moneda','cod_moneda')->get();
        if($get_id->tipo=="MO"){
            $list_ruta = CajaChicaRuta::select('id','personas','punto_salida','punto_llegada',
                            DB::raw("CASE WHEN transporte=1 THEN 'BUS' WHEN transporte=2 THEN 'TAXI'
                            ELSE '' END AS transporte"),'motivo','costo')->where('id_caja_chica',$id)
                            ->get();
            return view('finanzas.tesoreria.caja_chica.modal_editar_mo', compact(
                'get_id',
                'list_ubicacion',
                'list_empresa',
                'list_sub_categoria',
                'list_usuario',
                'list_tipo_moneda',
                'list_ruta'
            ));
        }else{
            $list_categoria = Categoria::select('id_categoria','nom_categoria')->where('id_categoria_mae',3)
                            ->where('id_ubicacion',$get_id->id_ubicacion)->where('nom_categoria','!=','MOVILIDAD')
                            ->where('estado',1)->get();
            $list_pago = Pago::all();
            $list_tipo_comprobante = TipoComprobante::whereIn('id',[1,2,3,6])->get();
            if($get_id->id_pago=="1"){
                $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)
                                ->where('estado',1)->whereIn('id',[1,2])
                                ->orderBy('nombre','ASC')->get();
            }elseif($get_id->id_pago=="2"){
                $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)
                                ->where('estado',1)->whereIn('id',[2])
                                ->orderBy('nombre','ASC')->get();
            }else{
                $list_tipo_pago = [];
            }
            $list_unidad = UnidadCC::all();
            return view('finanzas.tesoreria.caja_chica.modal_editar_pv', compact(
                'get_id',
                'list_ubicacion',
                'list_categoria',
                'list_empresa',
                'list_sub_categoria',
                'list_usuario',
                'list_tipo_comprobante',
                'list_pago',
                'list_tipo_pago',
                'list_tipo_moneda',
                'list_unidad'
            ));
        }
    }

    public function list_ruta_mo($id)
    {
        $list_ruta = CajaChicaRuta::select('id','personas','punto_salida','punto_llegada',
                    DB::raw("CASE WHEN transporte=1 THEN 'A PIE' WHEN transporte=2 THEN 'BUS'
                    WHEN transporte=3 THEN 'COLECTIVO' WHEN transporte=4 THEN 'METRO'
                    WHEN transporte=5 THEN 'TAXI' WHEN transporte=6 THEN 'TREN'
                    ELSE '' END AS transporte"),'motivo','costo')->where('id_caja_chica',$id)
                    ->get();
        return view('finanzas.tesoreria.caja_chica.lista_ruta_mo', compact('list_ruta'));
    }

    public function store_ruta_mo(Request $request, $id)
    {
        $request->validate([
            'personase' => 'required|gt:0',
            'punto_salidae' => 'required',
            'punto_llegadae' => 'required',
            'transportee' => 'gt:0',
            'motivoe' => 'required',
            'costoe' => 'required'
        ],[
            'personase.required' => 'Debe ingresar n° personas.',
            'personase.gt' => 'Debe ingresar n° personas mayor a 0.',
            'punto_salidae.required' => 'Debe ingresar punto salida.',
            'punto_llegadae.required' => 'Debe ingresar punto llegada.',
            'transportee.gt' => 'Debe seleccionar transporte.',
            'motivoe.required' => 'Debe ingresar motivo.',
            'costoe.required' => 'Debe ingresar costo.'
        ]);

        CajaChicaRuta::create([
            'id_caja_chica' => $id,
            'personas' => $request->personase,
            'punto_salida' => $request->punto_salidae,
            'punto_llegada' => $request->punto_llegadae,
            'transporte' => $request->transportee,
            'motivo' => $request->motivoe,
            'costo' => $request->costoe
        ]);
    }

    public function destroy_ruta_mo($id)
    {
        $valida = CajaChicaRuta::where('id_caja_chica', $id)->count();
        if ($valida<=1) {
            echo "error";
        }else{
            CajaChicaRuta::destroy($id);
        }
    }

    public function total_ruta_mo($id)
    {
        $suma = CajaChicaRuta::where('id_caja_chica',$id)->sum('costo');
        echo $suma;
    }

    public function update_mo(Request $request, $id)
    {
        $request->validate([
            'id_ubicacione' => 'gt:0',
            'id_empresae' => 'gt:0',
            'id_sub_categoriae' => 'gt:0',
            'id_usuarioe' => 'gt:0',
            'fechae' => 'required',
            'descripcione' => 'required'
        ], [
            'id_ubicacione.gt' => 'Debe seleccionar ubicación.',
            'id_empresae.gt' => 'Debe seleccionar empresa.',
            'id_sub_categoriae.gt' => 'Debe seleccionar sub-categoría.',
            'id_usuarioe.gt' => 'Debe seleccionar solicitante.',
            'fechae.required' => 'Debe ingresar fecha de solicitud.',
            'descripcione.required' => 'Debe ingresar descripción.'
        ]);

        $errors = [];
        $list_temporal = CajaChicaRuta::where('id_caja_chica',$id)->count();
        if($list_temporal=="0"){
            $errors['temporal'] = ['Debe adicionar al menos una ruta.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $get_id = SubCategoria::findOrFail($request->id_sub_categoriae);

        CajaChica::findOrFail($id)->update([
            'id_ubicacion' => $request->id_ubicacione,
            'id_categoria' => $get_id->id_categoria,
            'id_empresa' => $request->id_empresae,
            'id_sub_categoria' => $request->id_sub_categoriae,
            'id_usuario' => $request->id_usuarioe,
            'tipo_movimiento' => $request->tipo_movimientoe,
            'fecha' => $request->fechae,
            'descripcion' => $request->descripcione,
            'id_tipo_moneda' => $request->id_tipo_monedae,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function list_producto_pv($id)
    {
        $list_producto = CajaChicaProducto::from('caja_chica_producto AS cp')
                        ->select('cp.id','cp.cantidad','un.nom_unidad','cp.producto','cp.precio',
                        DB::raw('cp.cantidad*cp.precio AS total'))
                        ->join('vw_unidad_caja_chica AS un','un.id_unidad','=','cp.id_unidad')
                        ->where('cp.id_caja_chica',$id)->get();
        return view('finanzas.tesoreria.caja_chica.lista_producto_pv', compact('list_producto'));
    }

    public function store_producto_pv(Request $request, $id)
    {
        $request->validate([
            'cantidade' => 'required|gt:0',
            'id_unidade' => 'gt:0',
            'productoe' => 'required',
            'precioe' => 'required|gt:0'
        ],[
            'cantidade.required' => 'Debe ingresar cantidad.',
            'cantidade.gt' => 'Debe ingresar cantidad mayor a 0.',
            'id_unidade.gt' => 'Debe seleccionar unidad.',
            'productoe.required' => 'Debe ingresar producto.',
            'precioe.required' => 'Debe ingresar precio unitario.',
            'precioe.gt' => 'Debe ingresar precio unitario mayor a 0.'
        ]);

        CajaChicaProducto::create([
            'id_caja_chica' => $id,
            'cantidad' => $request->cantidade,
            'id_unidad' => $request->id_unidade,
            'producto' => $request->productoe,
            'precio' => $request->precioe
        ]);
    }

    public function destroy_producto_pv($id)
    {
        $valida = CajaChicaProducto::where('id_caja_chica', $id)->count();
        if ($valida<=1) {
            echo "error";
        }else{
            CajaChicaProducto::destroy($id);
        }
    }

    public function total_producto_pv($id)
    {
        $suma = CajaChicaProducto::where('id_caja_chica',$id)->sum(DB::raw('cantidad*precio'));
        echo $suma;
    }

    public function download($id)
    {
        $get_id = CajaChica::findOrFail($id);

        // URL del archivo
        $url = $get_id->comprobante;

        // Crear un cliente Guzzle
        $client = new Client();

        // Realizar la solicitud GET para obtener el archivo
        $response = $client->get($url);

        // Obtener el contenido del archivo
        $content = $response->getBody()->getContents();

        // Obtener el nombre del archivo desde la URL
        $filename = basename($url);

        // Devolver el contenido del archivo en la respuesta
        return response($content, 200)
                    ->header('Content-Type', $response->getHeaderLine('Content-Type'))
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function update_pv(Request $request, $id)
    {
        $request->validate([
            'id_ubicacione' => 'gt:0',
            'id_categoriae' => 'gt:0',
            'id_empresae' => 'gt:0',
            'id_sub_categoriae' => 'gt:0',
            'id_usuarioe' => 'gt:0',
            'tipo_movimientoe' => 'required',
            'id_tipo_comprobantee' => 'gt:0',
            'n_comprobantee' => 'required',
            'id_pagoe' => 'gt:0',
            'id_tipo_pagoe' => 'gt:0',
            'fechae' => 'required',
            'ruce' => 'nullable|size:11',
            'razon_sociale' => 'required',
            'descripcione' => 'required'
        ], [
            'id_ubicacione.gt' => 'Debe seleccionar ubicación.',
            'id_categoriae.gt' => 'Debe seleccionar categoría.',
            'id_empresae.gt' => 'Debe seleccionar empresa.',
            'id_sub_categoriae.gt' => 'Debe seleccionar sub-categoría.',
            'id_usuarioe.gt' => 'Debe seleccionar solicitante.',
            'tipo_movimientoe.required' => 'Debe seleccionar tipo de movimiento.',
            'id_tipo_comprobantee.gt' => 'Debe seleccionar tipo comprobante.',
            'n_comprobantee.required' => 'Debe ingresar n° comprobante.',
            'id_pagoe.gt' => 'Debe seleccionar pago.',
            'id_tipo_pagoe.gt' => 'Debe seleccionar tipo pago.',
            'fechae.required' => 'Debe ingresar fecha solicitud.',
            'ruce.size' => 'Debe ingresar RUC válido (11 dígitos).',
            'razon_sociale.required' => 'Debe ingresar razón social.',
            'descripcione.required' => 'Debe ingresar descripción.'
        ]);

        $get_id = CajaChica::findOrFail($id);

        $errors = [];
        if($get_id->comprobante==""){
            $errors['comprobante'] = ['Debe cargar comprobante.'];
        }
        $list_temporal = CajaChicaProducto::where('id_caja_chica',$id)->count();
        if($list_temporal=="0"){
            $errors['temporal'] = ['Debe adicionar al menos un producto.'];
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $comprobante = $get_id->comprobante;
        if ($_FILES["comprobantee"]["name"] != "") {
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
            if ($con_id && $lr) {
                if($get_id->comprobante!=""){
                    ftp_delete($con_id, "CAJA_CHICA/".basename($get_id->comprobante));
                }

                $path = $_FILES["comprobantee"]["name"];
                $source_file = $_FILES['comprobantee']['tmp_name'];

                $ext = pathinfo($path, PATHINFO_EXTENSION);
                $nombre_soli = "Comprobante_" . date('YmdHis');
                $nombre = $nombre_soli . "." . strtolower($ext);

                ftp_pasv($con_id, true);
                $subio = ftp_put($con_id, "CAJA_CHICA/" . $nombre, $source_file, FTP_BINARY);
                if ($subio) {
                    $comprobante = "https://lanumerounocloud.com/intranet/CAJA_CHICA/" . $nombre;
                } else {
                    echo "Archivo no subido correctamente";
                }
            } else {
                echo "No se conecto";
            }
        }

        CajaChica::findOrFail($id)->update([
            'id_ubicacion' => $request->id_ubicacione,
            'id_categoria' => $request->id_categoriae,
            'id_empresa' => $request->id_empresae,
            'id_sub_categoria' => $request->id_sub_categoriae,
            'id_usuario' => $request->id_usuarioe,
            'tipo_movimiento' => $request->tipo_movimientoe,
            'id_tipo_comprobante' => $request->id_tipo_comprobantee,
            'n_comprobante' => $request->n_comprobantee,
            'id_pago' => $request->id_pagoe,
            'id_tipo_pago' => $request->id_tipo_pagoe,
            'fecha' => $request->fechae,
            'comprobante' => $comprobante,
            'ruc' => $request->ruce,
            'razon_social' => $request->razon_sociale,
            'direccion' => $request->direccione,
            'descripcion' => $request->descripcione,
            'id_tipo_moneda' => $request->id_tipo_monedae,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function validar($id)
    {
        $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
        $list_pago = Pago::all();
        if($get_id->tipo=="MO"){
            $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)
                            ->where('estado',1)->whereIn('id',[1,2])
                            ->orderBy('nombre','ASC')->get();
            return view('finanzas.tesoreria.caja_chica.modal_validar_mo', compact(
                'get_id',
                'list_pago',
                'list_tipo_pago'
            ));
        }else{
            if($get_id->id_pago=="1"){
                $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)
                                ->where('estado',1)->whereIn('id',[1,2])
                                ->orderBy('nombre','ASC')->get();
            }elseif($get_id->id_pago=="2"){
                $list_tipo_pago = TipoPago::select('id','nombre')->where('id_mae',1)
                                ->where('estado',1)->whereIn('id',[2])
                                ->orderBy('nombre','ASC')->get();
            }else{
                $list_tipo_pago = [];
            }
            CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->delete();
            return view('finanzas.tesoreria.caja_chica.modal_validar_pv', compact(
                'get_id',
                'list_pago',
                'list_tipo_pago'
            ));
        }
    }

    public function validar_mo(Request $request, $id)
    {
        $request->validate([
            'id_tipo_pagov' => 'gt:0',
            'fecha_pagov' => 'required'
        ], [
            'id_tipo_pagov.gt' => 'Debe seleccionar tipo pago.',
            'fecha_pagov.required' => 'Debe ingresar fecha de pago.'
        ]);

        CajaChica::findOrFail($id)->update([
            'id_pago' => 1,
            'id_tipo_pago' => $request->id_tipo_pagov,
            'cuenta_1' => $request->cuenta_1v,
            'cuenta_2' => $request->cuenta_2v,
            'estado_c' => 2,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
        CajaChicaPago::create([
            'id_caja_chica' => $id,
            'fecha' => $request->fecha_pagov,
            'monto' => $get_id->total
        ]);
    }

    public function validar_pv(Request $request, $id)
    {
        if($request->id_pagov=="1"){
            $request->validate([
                'id_pagov' => 'gt:0',
                'id_tipo_pagov' => 'gt:0',
                'fecha_pagov' => 'required'
            ], [
                'id_pagov.gt' => 'Debe seleccionar pago.',
                'id_tipo_pagov.gt' => 'Debe seleccionar tipo pago.',
                'fecha_pagov.required' => 'Debe ingresar fecha de pago.'
            ]);
        }
        if($request->id_pagov=="2"){
            $request->validate([
                'id_pagov' => 'gt:0',
                'id_tipo_pagov' => 'gt:0'
            ], [
                'id_pagov.gt' => 'Debe seleccionar pago.',
                'id_tipo_pagov.gt' => 'Debe seleccionar tipo pago.'
            ]);
        }

        $errors = [];
        if($request->id_pagov=="2"){
            $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
            $suma = CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->sum('monto');
            if ($get_id->total != $suma) {
                $errors['suma'] = ['Debe ingresar más montos para completar el total.'];
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }
        
        CajaChica::findOrFail($id)->update([
            'id_pago' => $request->id_pagov,
            'id_tipo_pago' => $request->id_tipo_pagov,
            'cuenta_1' => $request->cuenta_1v,
            'cuenta_2' => $request->cuenta_2v,
            'estado_c' => 2,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);

        if($request->id_pagov=="1"){
            $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
            CajaChicaPago::create([
                'id_caja_chica' => $id,
                'fecha' => $request->fecha_pagov,
                'monto' => $get_id->total
            ]);
        }
        if($request->id_pagov=="2"){
            DB::statement('INSERT INTO caja_chica_pago (id_caja_chica,fecha,monto)
            SELECT '.$id.',fecha,monto
            FROM caja_chica_pago_temporal
            WHERE id_usuario='.session('usuario')->id_usuario);

            CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->delete();
        }
    }

    public function credito($id)
    {
        return view('finanzas.tesoreria.caja_chica.modal_credito',compact('id'));
    }

    public function list_credito()
    {
        $list_temporal = CajaChicaPagoTemporal::select('id',
                        DB::raw('DATE_FORMAT(fecha,"%d-%m-%Y") AS fecha'),'monto')
                        ->where('id_usuario',session('usuario')->id_usuario)->get();
        return view('finanzas.tesoreria.caja_chica.lista_credito', compact(
            'list_temporal'
        ));
    }

    public function saldo($id)
    {
        $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
        $suma = CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->sum('monto');
        echo $get_id->total-$suma;
    }

    public function store_cr(Request $request, $id)
    {
        $request->validate([
            'fechac' => 'required',
            'montoc' => 'required|gt:0'
        ], [
            'fechac.required' => 'Debe ingresar fecha.',
            'montoc.required' => 'Debe ingresar monto.',
            'montoc.gt' => 'Debe ingresar monto mayor a 0.'
        ]);

        $get_id = CajaChica::get_list_caja_chica(['id'=>$id]);
        $suma = CajaChicaPagoTemporal::where('id_usuario',session('usuario')->id_usuario)->sum('monto');

        if(($suma+$request->montoc)>$get_id->total){
            echo "error";
        }else{
            CajaChicaPagoTemporal::create([
                'id_usuario' => session('usuario')->id_usuario,
                'fecha' => $request->fechac,
                'monto' => $request->montoc
            ]);
        }
    }

    public function destroy_cr($id)
    {
        CajaChicaPagoTemporal::destroy($id);
    }

    public function anular($id)
    {
        CajaChica::findOrFail($id)->update([
            'estado_c' => 3,
            'fec_act' => now(),
            'user_act' => session('usuario')->id_usuario
        ]);
    }

    public function destroy($id)
    {
        CajaChica::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    public function excel($fec_inicio, $fec_fin)
    {
        $list_caja_chica = CajaChica::get_list_caja_chica([
            'fec_inicio'=>$fec_inicio,
            'fec_fin'=>$fec_fin
        ]);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getStyle("A1:L1")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A1:L1")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $spreadsheet->getActiveSheet()->setTitle('Caja chica');

        $sheet->setAutoFilter('A1:L1');

        $sheet->getColumnDimension('A')->setWidth(18);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(40);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(22);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(15);

        $sheet->getStyle('A1:L1')->getFont()->setBold(true);

        $spreadsheet->getActiveSheet()->getStyle("A1:L1")->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('C8C8C8');

        $styleThinBlackBorderOutline = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle("A1:L1")->applyFromArray($styleThinBlackBorderOutline);

        $sheet->setCellValue("A1", 'Fecha solicitud');
        $sheet->setCellValue("B1", 'Ubicación');
        $sheet->setCellValue("C1", 'Categoría');
        $sheet->setCellValue("D1", 'Sub-Categoría');
        $sheet->setCellValue("E1", 'Empresa');
        $sheet->setCellValue("F1", 'Descripción');
        $sheet->setCellValue("G1", 'RUC');
        $sheet->setCellValue("H1", 'Razón social');
        $sheet->setCellValue("I1", 'Tipo comprobante');
        $sheet->setCellValue("J1", 'N° comprobante');
        $sheet->setCellValue("K1", 'Monto');
        $sheet->setCellValue("L1", 'Estado');

        $contador = 1;

        foreach ($list_caja_chica as $list) {
            $contador++;

            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle("C{$contador}:F{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("H{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("K{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle("L{$contador}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle("A{$contador}:L{$contador}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $sheet->getStyle("A{$contador}:L{$contador}")->applyFromArray($styleThinBlackBorderOutline);
            if($list->id_tipo_moneda=="1"){
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_SOL_SIMPLE);
            }else{
                $sheet->getStyle("K{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_CURRENCY_USD);
            }

            $sheet->setCellValue("A{$contador}", Date::PHPToExcel($list->fecha));
            $sheet->getStyle("A{$contador}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_DDMMYYYY);
            $sheet->setCellValue("B{$contador}", $list->cod_ubi); 
            $sheet->setCellValue("C{$contador}", $list->nom_categoria);
            $sheet->setCellValue("D{$contador}", $list->nombre);
            $sheet->setCellValue("E{$contador}", $list->nom_empresa);
            $sheet->setCellValue("F{$contador}", $list->descripcion);
            $sheet->setCellValue("G{$contador}", $list->ruc);
            $sheet->setCellValue("H{$contador}", $list->razon_social); 
            $sheet->setCellValue("I{$contador}", $list->nom_tipo_comprobante);
            $sheet->setCellValue("J{$contador}", $list->n_comprobante);
            $sheet->setCellValue("K{$contador}", $list->total);
            $sheet->setCellValue("L{$contador}", $list->nom_estado);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Caja chica';
        if (ob_get_contents()) ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
