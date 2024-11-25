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
                            <label class="control-label text-bold">Transporte:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <select class="form-control" disabled>
                                <option value="1" @if ($get_transporte->transporte=="1") selected @endif>Agencia - Terrestre</option>
                                <option value="2" @if ($get_transporte->transporte=="2") selected @endif>Agencia - Aérea</option>
                                <option value="3" @if ($get_transporte->transporte=="3") selected @endif>Propio</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Tiempo llegada:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Tiempo llegada" 
                            value="{{ $get_transporte->tiempo_llegada }}" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Recepción:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <select class="form-control" disabled>
                                <option value="0">Seleccione</option>
                                <option value="1" @if ($get_transporte->recepcion=="1") selected @endif>Agencia</option>
                                <option value="2" @if ($get_transporte->recepcion=="2") selected @endif>Domicilio</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Receptor:</label>
                        </div>
                        <div class="form-group col-lg-5">
                            <input type="text" class="form-control" placeholder="Receptor" 
                            value="{{ $get_transporte->receptor }}" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Tipo pago:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <select class="form-control" disabled>
                                <option value="1" @if ($get_transporte->tipo_pago=="1") selected @endif>Si pago</option>
                                <option value="2" @if ($get_transporte->tipo_pago=="2") selected @endif>Por pagar</option>
                            </select>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nombre de empresa:</label>
                        </div>
                        <div class="form-group col-lg-5">
                            <input type="text" class="form-control" placeholder="Nombre de empresa" 
                            value="{{ $get_transporte->nombre_transporte }}" disabled>
                        </div>

                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Nro. GR Transporte:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Nro. GR Transporte" 
                            value="{{ $get_transporte->guia_transporte }}" disabled>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Importe a pagar:</label>
                        </div>
                        <div class="form-group col-lg-2">
                            <input type="text" class="form-control" placeholder="Importe a pagar" 
                             value="{{ $get_transporte->importe_transporte }}" disabled>
                        </div>

                        <div class="form-group col-lg-1" @if ($get_transporte->tipo_pago=="2") style="display: none;" @endif>
                            <label class="control-label text-bold">N° Factura:</label>
                        </div>
                        <div class="form-group col-lg-2" @if ($get_transporte->tipo_pago=="2") style="display: none;" @endif>
                            <input type="text" class="form-control" placeholder="N° Factura" 
                            value="{{ $get_transporte->factura_transporte }}">
                        </div>

                        <div class="form-group col-lg-2" @if ($get_transporte->tipo_pago=="2") style="display: none;" @endif>
                            <label class="control-label text-bold">PDF de factura (pago adelantado):</label>
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
                        <div class="form-group col-lg-11">
                            <textarea class="form-control" placeholder="Comentario" rows="3" disabled
                            >@php if(isset($comentario_transporte->id)){ echo $comentario_transporte->comentario; } @endphp</textarea>
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
                        <div class="form-group col-lg-11">
                            <textarea class="form-control" placeholder="Observación" rows="3" disabled
                            >{{ $get_id->observacion_inspf }}</textarea>
                        </div>
                    </div>

                    <div class="row mr-1 ml-1">
                        <div class="form-group col-lg-1">
                            <label class="control-label text-bold">Comentario:</label>
                        </div>
                        <div class="form-group col-lg-11">
                            <textarea class="form-control" placeholder="Comentario" rows="3" disabled
                            >@php if(isset($comentario_fardo->id)){ echo $comentario_fardo->comentario; } @endphp</textarea>
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

        Lista_Mercaderia_Nueva();
        Traer_Tipo_Usuario();
        Traer_Tipo_Prenda();
    });

    function Lista_Mercaderia_Nueva() {
        Cargando();

        var cod_base = $('#cod_baseb').val();
        var tipo_usuario = $('#tipo_usuariob').val();
        var tipo_prenda = $('#tipo_prendab').val();
        var url = "{{ route('tracking.list_mercaderia_nueva') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {
                'cod_base': cod_base,
                'tipo_usuario': tipo_usuario,
                'tipo_prenda': tipo_prenda
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#lista_mercaderia_nueva').html(resp);
            }
        });
    }

    function Traer_Tipo_Usuario() {
        Cargando();

        var cod_base = $('#cod_baseb').val();
        var url = "{{ route('tracking.mercaderia_nueva_tusu', ':cod_base') }}".replace(':cod_base', cod_base);;

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#tipo_usuariob').html(resp);
            }
        });
    }

    function Traer_Tipo_Prenda() {
        Cargando();

        var cod_base = $('#cod_baseb').val();
        var url = "{{ route('tracking.mercaderia_nueva_tpre', ':cod_base') }}".replace(':cod_base', cod_base);;

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#tipo_prendab').html(resp);
            }
        });
    }
</script>
@endsection