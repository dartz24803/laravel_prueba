@extends('layouts.plantilla')

@section('navbar')
@include('finanzas.navbar')
@endsection

@section('content')
<style>

</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Informe Contabilidad</h3>
            </div>

        </div>
        <div class="form-group col-lg-1">
            <button type="button" class="btn btn-secondary w-100" title="Actualizar" id="btnActualizar">
                Actualizar
            </button>
        </div>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <div class="table-responsive" id="lista_maestra" style="padding: 10px">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#contabilidad").addClass('active');
        $("#hcontabilidad").attr('aria-expanded', 'true');
        $("#tabla_facturacion").addClass('active');
        Redirigir_Lista_Contabilidad();
    });

    function Redirigir_Lista_Contabilidad() {
        Cargando();
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();

        var ini = moment(fecha_inicio);
        var fin = moment(fecha_fin);
        var url = "{{ route('tabla_facturacion.list') }}";

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
                $('#lista_maestra').html(resp);
            }
        });
    }

    $('#btnActualizar').on('click', function() {
        $.ajax({
            url: "{{ route('tabla_facturacion.update') }}", // Ruta donde se procesarán los IDs
            type: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data == "error") {
                    Swal.fire({
                        title: '¡Error al Actualizar!',
                        text: "¡El registro ya existe o hay un problema con los datos!",
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Los registros han sido actualizados correctamente!',
                        'success'
                    ).then(function() {
                        table.ajax.reload();
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: '¡Error!',
                    text: "Ocurrió un error al procesar la actualización.",
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>
@endsection