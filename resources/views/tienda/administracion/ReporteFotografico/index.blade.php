@extends('layouts.plantilla_new')

@section('navbar')
    @include('tienda.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte fotografico Adm</h3>
            </div>
        </div>

        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a id="tabla_rf1" class="nav-link active" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="home" aria-selected="true" onclick="Tabla_RF1()">Categorías</a>
                            </li>
                            <li class="nav-item">
                                <a id="tabla_rf2" class="nav-link" data-toggle="tab" href="#aprobacion" role="tab" aria-controls="home" aria-selected="true" onclick="Tabla_RF2()">Codigos</a>
                            </li>
                        </ul>
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_rf" class="widget-content widget-content-area">
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
        $("#ccvtabla").addClass('active');
        $("#hccvtabla").attr('aria-expanded', 'true');
        $("#rfa").addClass('active');
        Tabla_RF1();
    });

    function Tabla_RF1(){
        Cargando();

        var url="{{ url('ReporteFotograficoAdm')}}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_rf').html(resp);
                $("#tabla_rf1").addClass('active');
                $("#tabla_rf2").removeClass('active');
            }
        });
    }

    function Tabla_RF2(){
        Cargando();

        var url="{{ url('Codigos_Reporte_Fotografico')}}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_rf').html(resp);
                $("#tabla_rf1").removeClass('active');
                $("#tabla_rf2").addClass('active');
            }
        });
    }

</script>
@endsection