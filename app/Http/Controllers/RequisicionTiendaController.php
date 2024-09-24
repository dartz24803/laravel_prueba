<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\Notificacion;
use App\Models\ProductoCaja;
use App\Models\RequisicionTda;
use App\Models\RequisicionTdaDetalle;
use App\Models\RequisicionTdaTemporal;
use App\Models\SubGerencia;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequisicionTiendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('verificar.sesion.usuario');
    }

    public function index()
    {
        //NOTIFICACIONES
        $list_notificacion = Notificacion::get_list_notificacion();
        $list_subgerencia = SubGerencia::list_subgerencia(13);
        $list_base = Base::get_list_todas_bases_agrupadas();
        return view('caja.requisicion_tienda.index',compact('list_notificacion','list_base','list_subgerencia'));
    }

    public function list(Request $request)
    {
        $list_requisicion_tienda = RequisicionTda::get_list_requisicion_tienda(['base'=>$request->cod_base]);
        return view('caja.requisicion_tienda.lista', compact('list_requisicion_tienda'));
    }

    public function create()
    {
        $list_archivo = RequisicionTdaTemporal::where('id_usuario',session('usuario')->id_usuario)
                        ->where('archivo','!=','')->get();
        if(count($list_archivo)>0){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                foreach($list_archivo as $list){
                    $file_to_delete = "CAJA/REQUISICION/".basename($list->archivo);
                    if (ftp_delete($con_id, $file_to_delete)) {
                        RequisicionTdaTemporal::where('id_temporal', $list->id_temporal)->delete();
                    }
                }
            }
        }
        RequisicionTdaTemporal::where('id_usuario',session('usuario')->id_usuario)->delete();
        $list_usuario = Usuario::select('id_usuario',
                        DB::raw('CONCAT(usuario_nombres," ",usuario_apater," ",usuario_amater,
                        " - Base: ",centro_labores) AS nom_usuario'))
                        ->whereIn('id_puesto',[9,27,30,41,66,68,73,82,83,314])->where('estado',1)->get();
        $list_producto = ProductoCaja::from('producto_caja AS pc')
                        ->select('pc.id_producto',DB::raw('CONCAT(pc.nom_producto," - UM: ",
                        un.cod_unidad," - Marca: ",ma.nom_marca," - Modelo: ",
                        (CASE WHEN pc.id_modelo>0 THEN mo.nom_modelo ELSE "" END)) AS nom_producto'))
                        ->join('unidad AS un','un.id_unidad','=','pc.id_unidad')
                        ->join('marca AS ma','ma.id_marca','=','pc.id_marca')
                        ->leftjoin('modelo AS mo','mo.id_modelo','=','pc.id_modelo')
                        ->where('pc.estado',1)->get();
        return view('caja.requisicion_tienda.modal_registrar',compact(
            'list_usuario',
            'list_producto'
        ));
    }
    
    public function list_tmp(Request $request)
    {
        $list_temporal = RequisicionTdaTemporal::from('requisicion_tda_temporal AS rt')
                        ->select('rt.id_temporal','rt.stock','un.cod_unidad',
                        DB::raw('CONCAT("Producto: ",pc.nom_producto," - Marca: ",ma.nom_marca,
                        " - Modelo: ",(CASE WHEN pc.id_modelo>0 THEN mo.nom_modelo 
                        ELSE "" END)) AS nom_producto'),'rt.cantidad',
                        DB::raw('CONCAT("S/ ",rt.precio) AS precio'),
                        DB::raw('CONCAT("S/ ",(rt.precio*rt.cantidad)) AS total'),'rt.archivo')
                        ->join('producto_caja AS pc','pc.id_producto','=','rt.id_producto')
                        ->join('unidad AS un','un.id_unidad','=','pc.id_unidad')
                        ->join('marca AS ma','ma.id_marca','=','pc.id_marca')
                        ->leftjoin('modelo AS mo','mo.id_modelo','=','pc.id_modelo')
                        ->where('rt.id_usuario',session('usuario')->id_usuario)->get();                      
        return view('caja.requisicion_tienda.lista_temporal', compact('list_temporal'));
    }

    public function store_tmp(Request $request)
    {
        $request->validate([
            'stock' => 'required',
            'cantidad' => 'required|gt:0',
            'id_producto' => 'gt:0',
            'precio' => 'required|gt:0'
        ],[
            'stock.required' => 'Debe ingresar stock.',
            'cantidad.required' => 'Debe ingresar cantidad.',
            'cantidad.gt' => 'Debe ingresar cantidad mayor a 0.',
            'id_producto.gt' => 'Debe seleccionar producto.',
            'precio.required' => 'Debe ingresar precio unitario.',
            'precio.gt' => 'Debe ingresar precio unitario mayor a 0.'
        ]);

        $valida = RequisicionTdaTemporal::where('id_usuario', session('usuario')->id_usuario)
                ->where('id_producto', $request->id_producto)->exists();
        if($valida){
            echo "error";
        }else{
            $archivo = "";
            if ($_FILES["archivo"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $path = $_FILES["archivo"]["name"];
                    $source_file = $_FILES['archivo']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Archivo_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "CAJA/REQUISICION/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/CAJA/REQUISICION/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
    
            RequisicionTdaTemporal::create([
                'id_usuario' => session('usuario')->id_usuario,
                'stock' => $request->stock,
                'cantidad' => $request->cantidad,
                'id_producto' => $request->id_producto,
                'precio' => $request->precio,
                'archivo' => $archivo
            ]);
        }
    }

    public function destroy_tmp($id)
    {
        $get_id = RequisicionTdaTemporal::findOrFail($id);
        if($get_id->archivo!=""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $file_to_delete = "CAJA/REQUISICION/".basename($get_id->archivo);
                ftp_delete($con_id, $file_to_delete);
            }
        }
        RequisicionTdaTemporal::destroy($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'gt:0',
            'fecha' => 'required'
        ],[
            'id_usuario.gt' => 'Debe seleccionar coordinador.',
            'fecha.required' => 'Debe ingresar fecha.'
        ]);

        $list_temporal = RequisicionTdaTemporal::where('id_usuario',session('usuario')->id_usuario)
                        ->count();
        $errors = [];
        if($list_temporal==0){
            if ($request->monto == "") {
                $errors['temporal'] = ['Debe adicionar al menos un producto.'];
            }
        }
        if (!empty($errors)) {
            return response()->json(['errors' => $errors], 422);
        }

        $get_usuario = Usuario::findOrFail($request->id_usuario);
        $valida = RequisicionTda::where('base', $get_usuario->centro_labores)
                ->where(DB::raw('MONTH(fecha)'),DB::raw('MONTH("'.$request->fecha.'")'))
                ->where('estado', 1)->exists();

        if($valida){
            echo "error";
        }else{
            $requisicion = RequisicionTda::create([
                'fecha' => $request->fecha,
                'base' => $get_usuario->centro_labores,
                'id_usuario' => $request->id_usuario,
                'estado_registro' => 1,
                'estado' => 1,
                'fec_reg' => now(),
                'user_reg' => session('usuario')->id_usuario,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);

            DB::statement('INSERT INTO requisicion_tda_detalle (id_requisicion,stock,cantidad,
            id_producto,precio,archivo)
            SELECT '.$requisicion->id_requisicion.',stock,cantidad,id_producto,precio,archivo
            FROM requisicion_tda_temporal
            WHERE id_usuario='.session('usuario')->id_usuario);

            RequisicionTdaTemporal::where('id_usuario',session('usuario')->id_usuario)->delete();
        }
    }

    public function edit($id)
    {
        $get_id = RequisicionTda::findOrFail($id);
        $list_usuario = Usuario::select('id_usuario',
                        DB::raw('CONCAT(usuario_nombres," ",usuario_apater," ",usuario_amater,
                        " - Base: ",centro_labores) AS nom_usuario'))
                        ->whereIn('id_puesto',[9,27,30,41,66,68,73,82,83,314])->where('estado',1)->get();
        return view('caja.requisicion_tienda.modal_editar',compact('get_id','list_usuario'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_usuarioe' => 'gt:0',
            'fechae' => 'required'
        ],[
            'id_usuarioe.gt' => 'Debe seleccionar coordinador.',
            'fechae.required' => 'Debe ingresar fecha.'
        ]);

        $get_usuario = Usuario::findOrFail($request->id_usuarioe);
        $valida = RequisicionTda::where('base', $get_usuario->centro_labores)
                ->where(DB::raw('MONTH(fecha)'),DB::raw('MONTH("'.$request->fechae.'")'))
                ->where('estado', 1)->where('id_requisicion', '!=', $id)->exists();

        if($valida){
            echo "error";
        }else{
            RequisicionTda::findOrFail($id)->update([
                'id_usuario' => $request->id_usuarioe,
                'fecha' => $request->fechae,
                'base' => $get_usuario->centro_labores,
                'fec_act' => now(),
                'user_act' => session('usuario')->id_usuario
            ]);
        }
    }

    public function show($id)
    {
        $get_id = RequisicionTda::findOrFail($id);     
        return view('caja.requisicion_tienda.modal_detalle',compact('get_id'));
    }

    public function list_detalle($id)
    {
        $list_detalle = RequisicionTdaDetalle::from('requisicion_tda_detalle AS rd')
                        ->select('rd.id_requisicion_detalle','rd.stock','un.cod_unidad',
                        DB::raw('CONCAT("Producto: ",pc.nom_producto," - Marca: ",ma.nom_marca,
                        " - Modelo: ",(CASE WHEN pc.id_modelo>0 THEN mo.nom_modelo 
                        ELSE "" END)) AS nom_producto'),'rd.cantidad',
                        DB::raw('CONCAT("S/ ",rd.precio) AS precio'),
                        DB::raw('CONCAT("S/ ",(rd.precio*rd.cantidad)) AS total'),'rd.archivo',
                        DB::raw('(SELECT rt.estado_registro FROM requisicion_tda rt
                        WHERE rt.id_requisicion=rd.id_requisicion
                        LIMIT 1) AS estado_registro'))
                        ->join('producto_caja AS pc','pc.id_producto','=','rd.id_producto')
                        ->join('unidad AS un','un.id_unidad','=','pc.id_unidad')
                        ->join('marca AS ma','ma.id_marca','=','pc.id_marca')
                        ->leftjoin('modelo AS mo','mo.id_modelo','=','pc.id_modelo')
                        ->where('rd.id_requisicion',$id)->get();                      
        return view('caja.requisicion_tienda.lista_detalle', compact('list_detalle'));
    }

    public function store_detalle(Request $request, $id)
    {
        $request->validate([
            'stockd' => 'required',
            'cantidadd' => 'required|gt:0',
            'id_productod' => 'gt:0',
            'preciod' => 'required|gt:0'
        ],[
            'stockd.required' => 'Debe ingresar stock.',
            'cantidadd.required' => 'Debe ingresar cantidad.',
            'cantidadd.gt' => 'Debe ingresar cantidad mayor a 0.',
            'id_productod.gt' => 'Debe seleccionar producto.',
            'preciod.required' => 'Debe ingresar precio unitario.',
            'preciod.gt' => 'Debe ingresar precio unitario mayor a 0.'
        ]);

        $valida = RequisicionTdaDetalle::where('id_requisicion', $id)
                ->where('id_producto', $request->id_productod)->exists();
        if($valida){
            echo "error";
        }else{
            $archivo = "";
            if ($_FILES["archivod"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    $path = $_FILES["archivod"]["name"];
                    $source_file = $_FILES['archivod']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Archivo_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "CAJA/REQUISICION/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/CAJA/REQUISICION/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }
    
            RequisicionTdaDetalle::create([
                'id_requisicion' => $id,
                'stock' => $request->stockd,
                'cantidad' => $request->cantidadd,
                'id_producto' => $request->id_productod,
                'precio' => $request->preciod,
                'archivo' => $archivo
            ]);
        }
    }

    public function edit_detalle($id)
    {
        $get_id = RequisicionTdaDetalle::findOrFail($id);
        $list_producto = ProductoCaja::from('producto_caja AS pc')
                        ->select('pc.id_producto',DB::raw('CONCAT(pc.nom_producto," - UM: ",
                        un.cod_unidad," - Marca: ",ma.nom_marca," - Modelo: ",
                        (CASE WHEN pc.id_modelo>0 THEN mo.nom_modelo ELSE "" END)) AS nom_producto'))
                        ->join('unidad AS un','un.id_unidad','=','pc.id_unidad')
                        ->join('marca AS ma','ma.id_marca','=','pc.id_marca')
                        ->leftjoin('modelo AS mo','mo.id_modelo','=','pc.id_modelo')
                        ->where('pc.estado',1)->get();
        return view('caja.requisicion_tienda.editar_detalle',compact('get_id','list_producto'));
    }

    public function cancelar_detalle()
    {
        $list_producto = ProductoCaja::from('producto_caja AS pc')
                        ->select('pc.id_producto',DB::raw('CONCAT(pc.nom_producto," - UM: ",
                        un.cod_unidad," - Marca: ",ma.nom_marca," - Modelo: ",
                        (CASE WHEN pc.id_modelo>0 THEN mo.nom_modelo ELSE "" END)) AS nom_producto'))
                        ->join('unidad AS un','un.id_unidad','=','pc.id_unidad')
                        ->join('marca AS ma','ma.id_marca','=','pc.id_marca')
                        ->leftjoin('modelo AS mo','mo.id_modelo','=','pc.id_modelo')
                        ->where('pc.estado',1)->get();
        return view('caja.requisicion_tienda.cancelar_detalle',compact('list_producto'));
    }

    public function update_detalle(Request $request, $id)
    {
        $request->validate([
            'stockde' => 'required',
            'cantidadde' => 'required|gt:0',
            'id_productode' => 'gt:0',
            'preciode' => 'required|gt:0'
        ],[
            'stockde.required' => 'Debe ingresar stock.',
            'cantidadde.required' => 'Debe ingresar cantidad.',
            'cantidadde.gt' => 'Debe ingresar cantidad mayor a 0.',
            'id_productode.gt' => 'Debe seleccionar producto.',
            'preciode.required' => 'Debe ingresar precio unitario.',
            'preciode.gt' => 'Debe ingresar precio unitario mayor a 0.'
        ]);

        $get_id = RequisicionTdaDetalle::findOrFail($id);

        $valida = RequisicionTdaDetalle::where('id_requisicion', $get_id->id_requisicion)
                ->where('id_producto', $request->id_productode)
                ->where('id_requisicion_detalle','!=',$id)->exists();
        if($valida){
            echo "error";
        }else{
            $archivo = "";
            if ($_FILES["archivode"]["name"] != "") {
                $ftp_server = "lanumerounocloud.com";
                $ftp_usuario = "intranet@lanumerounocloud.com";
                $ftp_pass = "Intranet2022@";
                $con_id = ftp_connect($ftp_server);
                $lr = ftp_login($con_id, $ftp_usuario, $ftp_pass);
                if ($con_id && $lr) {
                    if($get_id->archivo!=""){
                        ftp_delete($con_id, "CAJA/REQUISICION/".basename($get_id->archivo));
                    }

                    $path = $_FILES["archivode"]["name"];
                    $source_file = $_FILES['archivode']['tmp_name'];
    
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $nombre_soli = "Archivo_" . date('YmdHis');
                    $nombre = $nombre_soli . "." . strtolower($ext);
    
                    ftp_pasv($con_id, true);
                    $subio = ftp_put($con_id, "CAJA/REQUISICION/" . $nombre, $source_file, FTP_BINARY);
                    if ($subio) {
                        $archivo = "https://lanumerounocloud.com/intranet/CAJA/REQUISICION/" . $nombre;
                    } else {
                        echo "Archivo no subido correctamente";
                    }
                } else {
                    echo "No se conecto";
                }
            }

            RequisicionTdaDetalle::findOrFail($id)->update([
                'stock' => $request->stockde,
                'cantidad' => $request->cantidadde,
                'id_producto' => $request->id_productode,
                'precio' => $request->preciode,
                'archivo' => $archivo
            ]);
        }
    }

    public function destroy_detalle($id)
    {
        $get_id = RequisicionTdaDetalle::findOrFail($id);
        if($get_id->archivo!=""){
            $ftp_server = "lanumerounocloud.com";
            $ftp_usuario = "intranet@lanumerounocloud.com";
            $ftp_pass = "Intranet2022@";
            $con_id = ftp_connect($ftp_server);
            $lr = ftp_login($con_id,$ftp_usuario,$ftp_pass);
            if($con_id && $lr){
                $file_to_delete = "CAJA/REQUISICION/".basename($get_id->archivo);
                ftp_delete($con_id, $file_to_delete);
            }
        }
        RequisicionTdaDetalle::destroy($id);
    }

    public function aprobar($id)
    {
        RequisicionTda::findOrFail($id)->update([
            'estado_registro' => 2,
            'fec_aprob' => now(),
            'user_aprob' => session('usuario')->id_usuario
        ]);
    }

    public function destroy($id)
    {
        RequisicionTda::findOrFail($id)->update([
            'estado' => 2,
            'fec_eli' => now(),
            'user_eli' => session('usuario')->id_usuario
        ]);
    }

    /*public function download($id)
    {
        $get_id = Suceso::findOrFail($id);

        // URL del archivo
        $url = $get_id->archivo;

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
    }*/
}
