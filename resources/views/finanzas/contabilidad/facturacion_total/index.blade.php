@csrf
<div class="table-responsive" id="lista_maestra" style="padding: 10px">
</div>

<script>
    Redirigir_Lista_Contabilidad();

    function Redirigir_Lista_Contabilidad() {
        Cargando();
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();

        var ini = moment(fecha_inicio);
        var fin = moment(fecha_fin);
        var url = "{{ route('tabla_facturacion_parcial.list') }}";

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