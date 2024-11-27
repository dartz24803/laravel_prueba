@csrf
<div class="form-group row">
    <div class="col-lg-2">
        <button type="button" class="btn btn-secondary w-100" title="Actualizar" id="btnActualizar">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg> Actualizar
        </button>
    </div>
    <div class="col-lg-4">
        Última Fecha de actualización: <span id="ultimaActualizacion">{{ $fecha_actualizacion }}</span><br>
        Cantidad total de Registros: <span id="totalRegistros">{{ $cantidad_registros }}</span>
    </div>

</div>

<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">

            <div class="table-responsive" id="lista_maestra" style="padding: 10px">
            </div>
        </div>
    </div>
</div>
<div class="table-responsive" id="lista_maestra" style="padding: 10px">
</div>

<script>
    Redirigir_Lista_Contabilidad();

    function Redirigir_Lista_Contabilidad() {
        Cargando();
        var url = "{{ route('tabla_facturacion.list') }}";

        $.ajax({
            url: url,
            type: "POST",
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
            type: "GET",

            success: function(data) {
                console.log("Respuesta del servidor:", data); // Para ver los datos completos
                if (data.success) {

                    Swal.fire(
                        '¡Actualización Exitosa!',
                        '¡' + data.cantidad_insertados + ' registros han sido actualizados correctamente!',
                        'success'
                    ).then(function() {
                        table.ajax.reload();
                    });

                } else {
                    Swal.fire({
                        title: 'Actualizado',
                        text: data.message || 'No hay Datos para Actualizar',
                        icon: 'info',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.log(error)
                console.log("########2")

                Swal.fire({
                    title: '¡Error al Actualizar!',
                    text: error,
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
</script>