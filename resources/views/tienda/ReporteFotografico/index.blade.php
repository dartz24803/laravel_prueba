@extends('layouts.plantilla')

@section('content')

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte fotografico</h3>
            </div>
        </div>

        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a id="tabla_rf" class="nav-link active" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="home" aria-selected="true" onclick="Tabla_RF()">Tabla</a>
                            </li>
                            <li class="nav-item">
                                <a id="imagenes_rf" class="nav-link" data-toggle="tab" href="#aprobacion" role="tab" aria-controls="home" aria-selected="true" onclick="Imagenes_RF()">Imagenes</a>
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
        $("#tienda").addClass('active');
        $("#htienda").attr('aria-expanded', 'true');
        $("#reporte_foto").addClass('active');
        Tabla_RF();
    });

    function Tabla_RF(){
        Cargando();

        var url="{{ url('Reporte_Fotografico')}}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_rf').html(resp);
                $("#tabla_rf").addClass('active');
                $("#imagenes_rf").removeClass('active');
            }
        });
    }

    function Imagenes_RF(){
        Cargando();

        var url="{{ url('Imagenes_Reporte_Fotografico')}}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_rf').html(resp);
                $("#tabla_rf").removeClass('active');
                $("#imagenes_rf").addClass('active');
            }
        });
    }

</script>
@endsection
