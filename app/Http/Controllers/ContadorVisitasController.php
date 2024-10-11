<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Models\ContadorVisitas;
use App\Models\Model_Infosap;
use App\Models\Model_Perfil;
use App\Models\Notificacion;
use App\Models\SubGerencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContadorVisitasController extends Controller
{
    protected $input;
    protected $Model_Infosap;
    protected $Model_Perfil;
    protected $ContadorVisitas;

    public function __construct(Request $request){
        $this->middleware('verificar.sesion.usuario');
        $this->input = $request;
        $this->Model_Infosap = new Model_Infosap();
        $this->Model_Perfil = new Model_Perfil();
        $this->ContadorVisitas = new ContadorVisitas();
    }
    public function index(){
        //NOTIFICACIONES
        $dato["list_notificacion"] = Notificacion::get_list_notificacion();
        $dato['list_subgerencia'] = SubGerencia::list_subgerencia(3);
            $dato['list_requerimiento'] = $this->Model_Infosap->get_list_requerimiento();
            $dato['list_semanas'] = $this->Model_Infosap->get_list_semanas();
            $dato['list_anio'] = $this->Model_Perfil->get_list_anio();
            $list_base = Base::leftJoin('asociacion_base as a', 'base.id_base', '=', 'a.id_base')
                        ->select('a.*', 'base.cod_base')
                        ->where('a.estado', 1)
                        ->get();
            $dato['list_base'] = json_decode(json_encode($list_base), true);

            return view('comercial.Contador_Visitas.index', $dato);
    }

    public function Visualizar_Insert_Contador_Visitas(){
        set_time_limit(300);
            $dato['inicio'] = $this->input->post("inicio");
            $dato['fin'] = $this->input->post("fin");
            $dato['tipo'] = $this->input->post("tipo");
            $dato['id_base'] = $this->input->post("cod_base");
            $dato['get_asociacion'] = DB::table('asociacion_base')
                                    ->where('id_base', $dato['id_base'])
                                    ->where('estado', 1)
                                    ->get();

            $list_base = Base::leftJoin('asociacion_base as a', 'base.id_base', '=', 'a.id_base')
                            ->select('a.*', 'base.cod_base')
                            ->where('a.estado', 1)
                            ->get();

            $dato['list_base'] = json_decode(json_encode($list_base), true);

            if ($dato['tipo'] == 1) {
                $dato['list_contador'] = $this->ContadorVisitas->get_list_contador_vistas($dato);
                return view('comercial.Contador_Visitas.lista', $dato);
            } else {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://auth.tbretail.com/oauth2/token',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => 'grant_type=refresh_token&client_id=63h4jubc7qvrg9f65c36vjp3bq&redirect_uri=https%3A%2F%2Flogin.tbretail.com%2Fmytoken%2Findex.html&refresh_token=eyJjdHkiOiJKV1QiLCJlbmMiOiJBMjU2R0NNIiwiYWxnIjoiUlNBLU9BRVAifQ.VzhGEc74HrDmCgMYZIc8WN47jxfsLI4dIqtEyc6fT5PFjqs7jjPebVR_56ZqKDWzbLcHXPW5Ee3GNo9FKSjdVWRmhr06YvDDhJjIPVJQySjNQPDX8DvCbkIhwUCukz1KgnW2goRPPOSYCv3a5WpeP5T9x-8keXIl6geA0i7OvnsdRDuHDLRAbWnlN6xMWXz5GDvVSvl3BvjnBBes2tUbn5h2zyedb9b49qAz5hQusz5vhoO-UOX_x0vgZ5dmiBkVz3jH3pp_OnUJPd_xeD4YU4C-yEJF1YHfcusk901mZcWvOubheOXiG_xToT4CA4akJXxzbH6SHr9Beh2zy37CDA.wMCCC2thv_g9Wkf5.-skUcd6TxiVhDDKWrMOnaGTi562F8bobkTjQToFuYfeyFyH72ZKrKJKLkmwqni0AS9eTIQU4N01pnp08h6dmM48UZB8n8eI5awAQ-JG6Zr2NsyY2z5Tk259GfMEpcuwb7vcN994hUnIo3DungMOH-TlzlwyfEzq05y-8W0lsgvV681x5Vt6JC2OeXPcgZNG_b9gtLH7eHRAA7RA54UZ82w9CMtAW8HAf5mqcZozl05RVxi2tATKaAmcwEtzu-CF9A0oeCrVp6SsLYeoN-_JfMa0hqNTfU9QPaHR-6Wcbjdy9-1hAhQC8PEc1E5XnEaA8C2Zv-B-RfFIcNko2QWLjih2vzlzPeRiiOahPTm298pQnAbWF1PAvSw6xBtSzesUHG0HxR8Cw-x9R3LGuhXfHaTiuS-K41PPwIPA7-iYTKaxYeOIwIVo4btkMoVYZaOPCy6DkjO5xJtcEjVx5hF3BD7xyjlGiAP_miSswmc645Gbw6Nl-P7Lc6u1x5Hsy4wHKVuqN7WLL3cH2dcXLSIqSaNuWvbcSfeRQgRXCyr_tkFcnv6SIXyRfm6Aa9VmiAQoAXrWK6T8mMtz1oSPGo3IO78d_Vto7U7cJxhYxYUzoynAVupv4nn1aJKjLI4BaVu0UxjnA4PrVIZTkQBglkjTJ-6xSgQtXKxmWUkM5f8_Duyc_qYI7_rxkfZrXkknA6JTYIxTQzNABc6mFu4zAYWhiZNmO7TH68K57MGmB12GZ8W-Nk71iiq1M87c98belERMMuBd4_h3NeO4allcUa3avSN7O-_tS3tB4usTcapnhISwTHOLqi5LJ_mRck-HRszv4GberaEewD7ZXWJJYhMfsoMh7cno0SmPzmlTPC4nVqVjXXjRUO4fXXtok08GsxEnHRwvshwCJ9fclMB23Ezspnm_YKFguOOghTG_GEnja4x0KERRbOBYKNsPRIjGe1uA0iiiSwJahbVNHfRPSUlpxvDPemd1TrNwYKxOwdXAzNHGmju19LvEQt9_5nkh3ONnYg9LRvQ25DJqTaTUyuRIHFHaq4TmHvyMDm4d1JDDS0RH2EWt9ydy7fyc-WgQJP6RWNnpDO9-s-3FrDAYtO2fuURDV2Qj9oHj75nQjXWJz3gz_gfUdQa0vKk_li-hbZBTEZxcnoWzcDgffL8laJLFnIdEbFuCzXyZ_27T77q6V7JGRKd2BInxizVmmOY3MUUal4Kau-lEIR1jmEovugm0rh6NMqSJv1rRHkl9WII5Mb_6DxnLRLrahCdg85vc1VU92xTXlu5RNb4gCWRqOd4YPLr-BsE3BtXkyku1FM6D5412zuARytwPM3Soq0M22S1IQUoZD8-xzH5P_V8hu.WFr8OV1Vpw9IMAaQ8dNkFQ',
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/x-www-form-urlencoded',
                        'Cookie: XSRF-TOKEN=3b6775a9-e7aa-4190-95b6-91c9673ad89d'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
                $valida = json_decode($response, true);
                if (isset($valida['access_token']) && $valida['access_token'] != "") {

                    $access_token = $valida['access_token'];
                    $companie = 68;
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://api.tbretail.com',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => '{"query":"query {\\r\\n            getData(\\r\\n                companies: [' . $companie . ']\\r\\n                brands: []\\r\\n                locations: []\\r\\n                zones: []\\r\\n                start_date: \\"' . $dato['inicio'] . '\\"\\r\\n                end_date: \\"' . $dato['fin'] . '\\"\\r\\n                metrics: [{name: ENTERS, operation: SUM}]\\r\\n                category: {dimension: MINUTE interval: 15}\\r\\n                group: {dimension: LOCATION}\\r\\n            ) {\\r\\n                series {\\r\\n                    group\\r\\n                    metric\\r\\n                    data\\r\\n                } \\r\\n                categories\\r\\n            }\\r\\n        }","variables":{}}',
                        CURLOPT_HTTPHEADER => array(
                            'Authorization: Bearer ' . $access_token,
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);
                    $dato['detalle'] = json_decode($response, true);
                    DB::connection('sqlsrv_dbmsrt')->table('contador_visitas')
                            ->whereBetween('fecha', [$dato['inicio'], $dato['fin']])
                            ->where('estado', 1)
                            ->delete();

                    foreach ($dato['detalle']['data']['getData']['series'] as $list) {
                        $i = 0;
                        foreach ($list['data'] as $data) {
                            $i++;
                            $dato['hora'] = "";
                            $t = 0;
                            foreach ($dato['detalle']['data']['getData']['categories'] as $milliseconds) {
                                $t++;
                                if ($i == $t) {

                                    $timestamp = $milliseconds / 1000; // Convert milliseconds to seconds
                                    $date = date('Y-m-d H:i:s', $timestamp);
                                    $dato['hora'] = date('H:i', strtotime($date . '+5 hours'));
                                    $dato['fecha'] = date('Y-m-d', strtotime($date . '+5 hours'));
                                    $dato['anio'] = date('Y', strtotime($date . '+5 hours'));
                                    $dato['mes'] = date('m', strtotime($date . '+5 hours'));
                                    $dato['dia'] = date('d', strtotime($date . '+5 hours'));
                                }
                            }

                            $dato['cod_tienda'] = $list['group'];
                            $dato['entradas'] = $data;
                            $dato['salidas'] = 0;

                            DB::connection('sqlsrv_dbmsrt')->table('contador_visitas')->insert([
                                'cod_tienda' => $dato['cod_tienda'],
                                'fecha' => $dato['fecha'],
                                'hora' => $dato['hora'],
                                'entradas' => $dato['entradas'],
                                'salidas' => $dato['salidas'],
                                'anio' => $dato['anio'],
                                'mes' => $dato['mes'],
                                'dia' => $dato['dia'],
                                'estado' => 1,
                                'user_reg' => session('usuario')->id_usuario,
                                'fec_reg' => now(),
                            ]);
                        }
                    }
                } else {
                    echo "no se generó token";
                }
            }

    }
}
