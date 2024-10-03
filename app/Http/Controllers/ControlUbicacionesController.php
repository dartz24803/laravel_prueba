<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlUbicacion;
use App\Models\Mercaderia;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Support\Facades\DB;

class ControlUbicacionesController extends Controller
{
    protected $input;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
    }

    public function index() {
        //REPORTE BI CON ID
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(7);
        //NOTIFICACIONES
        $dato['list_notificacion'] = Notificacion::get_list_notificacion();
            return view('logistica.Control_Ubicaciones.index', $dato);
    }

    public function Cargar_Control_Ubicacion() {       
            $sql = "SELECT 
                b.art_estiloprd,sum(e.stk_stkfmes) as stock
                
                from mvm_stock_x_fecha e
                inner join tge_articulos b on e.stk_empresa=b.cia_codigo and e.art_codigo=b.art_codigo   
                Where exists (select 1 from seg_tbl_opci_conf where cnf_codi_secc like 'ALMACENES_CENTRALES_WEB%' and cnf_llav_secc like 'ALM%' and    
                    left(cnf_Valo_llav,5)=e.stk_empresa and    
                    right(rtrim(cnf_Valo_llav),2)=e.stk_sucursal    
                ) and    
                e.stk_ano=Year(Getdate()) and    
                e.stk_mes=Month(Getdate()) and    
                e.stk_stkfmes!=0
                group by b.art_estiloprd";
            $dato['list_estilo'] = DB::connection('sqlsrv')->select($sql);
            ControlUbicacion::select('control_ubicacion.*', 'nicho.numero', 'percha.nom_percha', 
                                        DB::raw("DATE_FORMAT(control_ubicacion.fecha, '%d/%m/%Y') as fecha"))
                ->leftJoin('nicho', 'control_ubicacion.id_nicho', '=', 'nicho.id_nicho')
                ->leftJoin('percha', 'nicho.id_percha', '=', 'percha.id_percha')
                ->where('control_ubicacion.estado', 1)
                ->orderBy('nicho.nom_nicho')
                ->get();
            
            $dato['list_control'] = Mercaderia::get_list_control_ubicaciones();
            $dato['list_nicho'] = Mercaderia::get_list_nicho();
            return view('logistica.Control_Ubicaciones.lista', $dato);
    }
}
