@extends('layouts.plantilla')

@section('navbar')
    @include('interna.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Actualizaciones</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6 p-3">
                    <div class="col-md-12 row">
                        <div class="form-group col-md-3">
                            <label class="col-md-12 control-label text-bold">Actualización de Cobertura: </label>
                        </div>
                        @csrf
                        <div class="form-group col-md-2">
                            <div class="col-md-6 text-left mb-5" id="btnAlergia">
                                <a onclick="ActCobertura();" title="Ejecutar" class="btn btn-primary">
                                Ejecutar
                                </a>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="col-md-12 control-label text-bold">Actualización de Reporte de Estilo: </label>
                        </div>
                        @csrf
                        <div class="form-group col-md-2">
                            <div class="col-md-6 text-left mb-5" id="btnAlergia">
                                <a onclick="ActReporte();" title="Ejecutar" class="btn btn-primary">
                                Ejecutar
                                </a>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label class="col-md-12 control-label text-bold">Actualización de Stock de CD: </label>
                        </div>
                        @csrf
                        <div class="form-group col-md-2">
                            <div class="col-md-6 text-left mb-5" id="btnAlergia">
                                <a onclick="ActLocal();" title="Ejecutar" class="btn btn-primary">
                                Ejecutar
                                </a>
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
        $("#bi").addClass('active');
        $("#rbi").attr('aria-expanded','true');
        $("#sprocedure").addClass('active');
    });

    function ActCobertura(){
        Cargando();

        var url="{{ url('ActualizacionProcedimientos/Act_Cobertura') }}";
        var csrfToken = $('input[name="_token"]').val();

        var combo="dato";

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'semana':combo},
            success:function (data) {
                Swal(
                    'Ejecutado',
                    'El procedimiento de <b>Actualización de Cobertura</b> se ejecutó correctamente.',
                    'success'
                ).then(function() {
                    // window.location = "{{ url('ActualizacionProcedimientos/index') }}";
                });
            }
        });
    }

    function ActReporte(){
        Cargando();

        var url="{{ url('ActualizacionProcedimientos/Act_Reporte') }}";
        var csrfToken = $('input[name="_token"]').val();

        var combo="dato";

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'semana':combo},
            success:function (data) {
                Swal(
                    'Ejecutado',
                    'El procedimiento de <b>Actualización de Reporte Est</b> se ejecutó correctamente.',
                    'success'
                ).then(function() {
                    // window.location = "{{ url('ActualizacionProcedimientos/index') }}";
                });
            }
        });
    }

    function ActLocal(){
        Cargando();

        var url="{{ url('ActualizacionProcedimientos/Act_Local') }}";
        var csrfToken = $('input[name="_token"]').val();

        var combo="dato";

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'semana':combo},
            success:function (data) {
                Swal(
                    'Ejecutado',
                    'El procedimiento de <b>Actualización de Stock de CD</b> se ejecutó correctamente.',
                    'success'
                ).then(function() {
                    // window.location = "{{ url('ActualizacionProcedimientos/index') }}";
                });
            }
        });
    }
</script>

@endsection
