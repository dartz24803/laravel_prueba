@extends('layouts.plantilla')

@section('navbar')
@include('manufactura.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a id="a_pa" class="nav-link" onclick="Pago();" style="cursor: pointer;">Pago</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_tpa" class="nav-link" onclick="Tipo_Pago();" style="cursor: pointer;">Tipo de pago</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_ca" class="nav-link" onclick="Categoria();" style="cursor: pointer;">Categoría</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_sca" class="nav-link" onclick="Sub_Categoria();" style="cursor: pointer;">Sub-Categoría</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_tco" class="nav-link" onclick="Tipo_Comprobante();" style="cursor: pointer;">Tipo Comprobante</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_caja_chica_conf" class="widget-content widget-content-area p-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#conf_tesorerias").addClass('active');
        $("#hconf_tesorerias").attr('aria-expanded', 'true');
        $("#conf_cajas_chicas").addClass('active');

        Pago();
    });

    function Pago() {
        $("#a_pa").addClass('active');

        /*Cargando();

        var url="{{ route('administrador_conf_st') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#div_caja_chica_conf').html(resp);  
                $("#a_st").addClass('active');
                $("#a_sc").removeClass('active');
            }
        });*/
    }

    function Seguimiento_Coordinador() {
        Cargando();

        var url = "{{ route('administrador_conf_sc') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_caja_chica_conf').html(resp);
                $("#a_st").removeClass('active');
                $("#a_sc").addClass('active');
            }
        });
    }
</script>
@endsection