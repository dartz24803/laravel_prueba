@extends('layouts.plantilla')

@section('navbar')
@include('caja.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Duración de transacción</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="toolbar d-md-flex align-items-md-center mt-3">
                        <div class="form-group col-lg-2">
                            <label>Fecha Inicio:</label>
                            <input type="date" class="form-control" name="fecha_iniciob"
                                id="fecha_iniciob" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="form-group col-lg-2">
                            <label>Fecha Fin:</label>
                            <input type="date" class="form-control" name="fecha_finb"
                                id="fecha_finb" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-lg-8">
                            <button type="button"
                                class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Buscar"
                                onclick="Lista_Duracion_Transacion();">
                                Buscar
                            </button>


                        </div>
                    </div>

                    <div class="table-responsive" id="lista_duracion_transaccion">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#cajas").addClass('active');
        $("#hcajas").attr('aria-expanded', 'true');
        $("#duraciones_transacciones").addClass('active');

        Lista_Duracion_Transacion();
    });

    function Lista_Duracion_Transacion() {
        Cargando();

        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();

        var ini = moment(fecha_inicio);
        var fin = moment(fecha_fin);
        if (ini.isAfter(fin) == true) {
            Swal({
                title: 'Búsqueda Denegada!',
                html: "Fecha inicio no debe ser mayor a fecha fin. <br> Por favor corrígelo.",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
        } else if (fin.diff(ini, 'days') > 31) {
            Swal({
                title: '¡Búsqueda Denegada!',
                text: "Solo se permite búsquedas de hasta 31 días",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
        } else {
            var url = "{{ route('duracion_transaccion.list') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {
                    'fecha_inicio': fecha_inicio,
                    'fecha_fin': fecha_fin
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(resp) {
                    $('#lista_duracion_transaccion').html(resp);
                }
            });
        }
    }

    function Excel_Duracion_Transaccion() {
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();
        window.location.replace("{{ route('duracion_transaccion.excel', [':fecha_inicio', ':fecha_fin']) }}".replace(':fecha_inicio', fecha_inicio).replace(':fecha_fin', fecha_fin));
    }
</script>
@endsection