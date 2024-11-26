@extends('layouts.plantilla')

@section('navbar')
    @include('logistica.navbar')
@endsection

@section('content')
<style>
    input[disabled],
    select[disabled],
    textarea[disabled] {
        background-color: white !important;
        color: black;
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title d-flex justify-content-between w-100">
                <h3>Detalle Nro. Req: {{ $get_id->n_requerimiento }}</h3>
                <a href="{{ route('tracking') }}" class="btn btn-primary">Regresar</a>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="row mr-1 ml-1 mt-3">
                        <div class="form-group col-lg-2">
                            <label class="control-label text-bold" style="color: black;">SEMANA: {{ $get_id->semana }}</label>
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label class="control-label text-bold" style="color: black;">Base: {{ $get_id->hacia }}</label>
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label class="control-label text-bold" style="color: black;">Distrito: {{ $get_id->nombre_distrito }}</label>
                        </div>
                    </div>

                    {{--PROCESO DESPACHO--}}
                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-12">
                            <label style="color: black; font-weight: bold;">PROCESO DESPACHO:</label>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Guía de remisión:</label>
                        </div>
                        <div class="form-group col-lg-1">
                            <a class="btn" style="background-color: #28a745 !important;" onclick="Excel_Guia_Remision_Despacho('{{ $get_id->id }}');">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>                                
                            </a>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Transporte:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <select class="form-control" disabled>
                                <option value="0">Seleccione</option>
                                <option value="1" @if ($get_transporte && $get_transporte->transporte=="1") selected @endif>Agencia - Terrestre</option>
                                <option value="2" @if ($get_transporte && $get_transporte->transporte=="2") selected @endif>Agencia - Aérea</option>
                                <option value="3" @if ($get_transporte && $get_transporte->transporte=="3") selected @endif>Propio</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Tiempo llegada:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Tiempo llegada" 
                            value="@php if($get_transporte){ echo $get_transporte->tiempo_llegada; } @endphp" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Recepción:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <select class="form-control" disabled>
                                <option value="0">Seleccione</option>
                                <option value="1" @if ($get_transporte && $get_transporte->recepcion=="1") selected @endif>Agencia</option>
                                <option value="2" @if ($get_transporte && $get_transporte->recepcion=="2") selected @endif>Domicilio</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Receptor:</label>
                        </div>
                        <div class="form-group col-lg-5">
                            <input type="text" class="form-control" placeholder="Receptor" 
                            value="@php if($get_transporte){ echo $get_transporte->receptor; } @endphp" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Tipo pago:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <select class="form-control" disabled>
                                <option value="0">Seleccione</option>
                                <option value="1" @if ($get_transporte && $get_transporte->tipo_pago=="1") selected @endif>Si pago</option>
                                <option value="2" @if ($get_transporte && $get_transporte->tipo_pago=="2") selected @endif>Por pagar</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nombre de empresa:</label>
                        </div>
                        <div class="form-group col-lg-5">
                            <input type="text" class="form-control" placeholder="Nombre de empresa" 
                            value="@php if($get_transporte){ echo $get_transporte->nombre_transporte; } @endphp" disabled>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nro. GR Transporte:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Nro. GR Transporte" 
                            value="@php if($get_transporte){ echo $get_transporte->guia_transporte; } @endphp" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Importe a pagar:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Importe a pagar" 
                             value="@php if($get_transporte){ echo $get_transporte->importe_transporte; } @endphp" disabled>
                        </div>

                        <div class="form-group col-lg-1" @php if($get_transporte){ if($get_transporte->tipo_pago=="2"){ echo "style='display: none;'"; } } @endphp>
                            <label class="control-label text-bold">N° Factura:</label>
                        </div>
                        <div class="form-group col-lg-2" @php if($get_transporte){ if($get_transporte->tipo_pago=="2"){ echo "style='display: none;'"; } } @endphp>
                            <input type="text" class="form-control" placeholder="N° Factura" 
                            value="@php if($get_transporte){ echo $get_transporte->factura_transporte; } @endphp" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1" @php if($get_transporte){ if($get_transporte->tipo_pago=="2"){ echo "style='display: none;'"; } } @endphp>
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">PDF de factura: (pago_adelantado)</label>
                        </div>
                        <div class="row mr-1 ml-1">
                            @foreach ($list_archivo_pago as $list)
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">{{ basename($list->archivo); }}</label>
                                    <a href="{{ $list->archivo }}" title="Evidencia" target="_blank">
                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Peso:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Peso" 
                            value="{{ $get_id->peso }}" disabled>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Paquetes:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Paquetes" 
                            value="{{ $get_id->paquetes }}" disabled>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Sobres:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Sobres" 
                            value="{{ $get_id->sobres }}" disabled>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Fardos:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Fardos" 
                            value="{{ $get_id->fardos }}" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Caja:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Caja" 
                            value="{{ $get_id->caja }}" disabled>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Merc. total:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Merc. total" 
                            value="{{ $get_id->mercaderia_total }}" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Comentario:</label>
                        </div>
                        <div class="row mr-1 ml-1">
                            @foreach ($list_comentario_despacho as $list)
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">{{ $list->nombre.": ".$list->comentario }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{--PROCESO INSPECCIÓN DE FARDO--}}
                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-12">
                            <label style="color: black; font-weight: bold;">PROCESO INSPECCIÓN DE FARDO:</label>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Observación:</label>
                        </div>
                        <div class="form-group col-lg-11">
                            <textarea class="form-control" placeholder="Observación" rows="3" disabled
                            >{{ $get_id->observacion_inspf }}</textarea>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Evidencia:</label>
                        </div>
                        <div class="row mr-1 ml-1">
                            @foreach ($list_archivo_fardo as $list)
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">{{ basename($list->archivo); }}</label>
                                    <a href="{{ $list->archivo }}" title="Evidencia" target="_blank">
                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Comentario:</label>
                        </div>
                        <div class="row mr-1 ml-1">
                            @foreach ($list_comentario_fardo as $list)
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">{{ $list->nombre.": ".$list->comentario }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{--PROCESO PAGO DE MERCADERÍA--}}
                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-12">
                            <label style="color: black; font-weight: bold;">PROCESO PAGO DE MERCADERÍA:</label>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Guía de Remisión: </label>
                        </div>
                        <div class="form-group col-lg-1">
                            @if ($get_transporte && $get_transporte->guia_remision!="")
                                <a href="{{ $get_transporte->guia_remision }}" title="Guía de remisión" target="_blank">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nombre de empresa: </label>
                        </div>
                        <div class="form-group col-lg-5">
                            <input type="text" class="form-control" placeholder="Nombre de empresa" 
                            value="@php if($get_transporte){ echo $get_transporte->nombre_transporte; } @endphp" disabled>
                        </div>
                    </div>
                    
                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nro. GR Transporte: </label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Nro. GR Transporte" 
                            value="@php if($get_transporte){ echo $get_transporte->guia_transporte; } @endphp" disabled>
                        </div>
                    
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Importe a pagar: </label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Importe a pagar" 
                            value="@php if($get_transporte){ echo $get_transporte->importe_transporte; } @endphp" disabled>
                        </div>
                    
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">N° Factura: </label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="N° Factura" 
                            value="@php if($get_transporte){ echo $get_transporte->factura_transporte; } @endphp" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">PDF de factura:</label>
                        </div>
                        <div class="row mr-1 ml-1">
                            @foreach ($list_archivo_pago as $list)
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">{{ basename($list->archivo); }}</label>
                                    <a href="{{ $list->archivo }}" title="Evidencia" target="_blank">
                                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                            <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399" />
                                            <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8" />
                                            <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z" />
                                            <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z" />
                                            <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z" />
                                        </svg>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{--PROCESO DE INSPECCIÓN - DIFERENCIA--}}
                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-12">
                            <label style="color: black; font-weight: bold;">PROCESO DE INSPECCIÓN - DIFERENCIA:</label>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-12">
                            <div class="table-responsive">
                                <table id="tabla_js_dif" class="table" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>SKU</th>
                                            <th>Estilo</th>
                                            <th>Col/Ta</th>
                                            <th>Enviado</th>
                                            <th>Recibido</th>
                                            <th>Diferencia</th>
                                            <th>Orden de regularización</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @foreach ($list_diferencia as $list)
                                            <tr class="text-center">
                                                <td>{{ $list->sku }}</td>
                                                <td>{{ $list->estilo }}</td>
                                                <td class="text-left">{{ $list->color_talla }}</td>
                                                <td>{{ $list->enviado }}</td>
                                                <td>{{ $list->recibido }}</td>
                                                <td>{{ $list->recibido-$list->enviado }}</td>
                                                <td class="text-left">{{ $list->observacion }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nro. GR (Sobrante): </label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Nro. GR" 
                            value="{{ $get_id->guia_sobrante }}" disabled>
                        </div>
                        
                        <div class="form-group col-lg-9">
                            <label class="control-label text-bold">GR (Sobrante): </label>
                            @if ($get_id->archivo_sobrante!="")
                                <a href="{{ $get_id->archivo_sobrante }}" title="GR (Sobrante)" target="_blank">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nro. GR (Faltante): </label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Nro. GR" 
                            value="{{ $get_id->guia_faltante }}" disabled>
                        </div>

                        <div class="form-group col-lg-9">
                            <label class="control-label text-bold">GR (Faltante): </label>
                            @if ($get_id->archivo_faltante!="")
                                <a href="{{ $get_id->archivo_faltante }}" title="GR (Faltante)" target="_blank">
                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Comentario:</label>
                        </div>
                        <div class="row mr-1 ml-1">
                            @foreach ($list_comentario_diferencia as $list)
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">{{ $list->nombre.": ".$list->comentario }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{--PROCESO DE INSPECCIÓN - DEVOLUCIÓN--}}
                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-12">
                            <label style="color: black; font-weight: bold;">PROCESO DE INSPECCIÓN - DEVOLUCIÓN:</label>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-12">
                            <div class="table-responsive">
                                <table id="tabla_js_dev" class="table" style="width:100%">
                                    <thead>
                                        <tr class="text-center">
                                            <th>SKU</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Devolución</th>
                                            <th>Motivo</th>
                                            <th>Forma de proceder</th>
                                            <th class="no-content"></th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @foreach ($list_devolucion as $list)
                                            <tr class="text-center">
                                                <td>{{ $list->sku }}</td>
                                                <td class="text-left">{{ $list->descripcion }}</td>
                                                <td>{{ $list->cantidad }}</td>
                                                <td>{{ $list->devolucion }}</td>
                                                <td class="text-left">{{ $list->sustento_respuesta }}</td>
                                                <td class="text-left">{{ $list->forma_proceder }}</td>
                                                <td>
                                                    <?php 
                                                        if($list->archivos!=""){
                                                            $array = explode("@@@",$list->archivos);
                                                            $i = 0;
                                                            while($i<count($array)){ ?>
                                                                <a href="{{ $array[$i] }}" title="Evidencia" target="_blank">
                                                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve">
                                                                        <rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/>
                                                                        <circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/>
                                                                        <path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/>
                                                                        <path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/>
                                                                        <path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/>
                                                                    </svg>
                                                                </a>
                                                                <?php $i++;
                                                            }
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1 mb-3">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Comentario:</label>
                        </div>
                        <div class="row mr-1 ml-1">
                            @foreach ($list_comentario_devolucion as $list)
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">{{ $list->nombre.": ".$list->comentario }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#logisticas").addClass('active');
        $("#hlogisticas").attr('aria-expanded', 'true');
        $("#trackings").addClass('active');

        $('#tabla_js_dif').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });

        $('#tabla_js_dev').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });
    });

    function Excel_Guia_Remision_Despacho(id) {
        window.location = "{{ route('tracking_det.excel_guia_despacho', ':id') }}".replace(':id', id);
    }
</script>
@endsection