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
        <span id="ultimaActualizacion">{{ $fecha_actualizacion }}</span><br>
        Registros Totales: <span id="totalRegistros">{{ $cantidad_registros }}</span>
    </div>
    <div class="col-lg-2">
        <button type="button" class="btn btn-primary w-100" title="Actualizar" id="btnActualizarEnviados">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
            Almacenes
        </button>
    </div>
    <div class="col-lg-4">
        <span id="ultimaActualizacionEnviados">{{ $fecha_actualizacion_enviados }}</span><br>
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
    Redirigir_Lista_Contabilidad_f();

    function Redirigir_Lista_Contabilidad_f() {
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
        const fechaInicio = `Julio 01 del ${new Date().getFullYear()}`;
        const fechaActual = new Date();
        const meses = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        const dia = fechaActual.getDate().toString().padStart(2, "0");
        const mes = meses[fechaActual.getMonth()];
        const anio = fechaActual.getFullYear();
        const fechaActualM = `${mes} ${dia} del ${anio}`;

        Swal({
            title: '¿Estás seguro?',
            text: `Se procederá a actualizar la tabla de datos desde ${fechaInicio}  hasta  ${fechaActualM}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Actualizar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ route('tabla_facturacion.update') }}",
                    type: "GET",
                    success: function(data) {
                        console.log("Respuesta del servidor:", data);

                        if (data.success) {
                            // Actualizar los valores en el DOM
                            $('#ultimaActualizacion').text(data.fecha_actualizacion);
                            $('#totalRegistros').text(data.cantidad_registros);

                            Swal.fire(
                                '¡Actualización Exitosa!',
                                '¡' + data.cantidad_insertados + ' registros han sido actualizados correctamente!',
                                'success'
                            ).then(function() {
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire(
                                'Sin cambios',
                                'No hay datos nuevos para actualizar',
                                'info'
                            ).then(function() {
                                table.ajax.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: '¡Error al Actualizar!',
                            text: 'Ha ocurrido un error: ' + error,
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });



    $('#btnActualizarEnviados').on('click', function() {
        const fechaInicio = `Julio 01 del ${new Date().getFullYear()}`;
        const fechaActual = new Date();
        const meses = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        const dia = fechaActual.getDate().toString().padStart(2, "0");
        const mes = meses[fechaActual.getMonth()];
        const anio = fechaActual.getFullYear();
        const fechaActualM = `${mes} ${dia} del ${anio}`;

        Swal({
            title: '¿Estás seguro?',
            text: `Se procederá a actualizar la cantidad de "stock", en todos los almacenes desde ${fechaInicio} hasta  ${fechaActualM}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Actualizar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ route('tabla_facturacion.updateEnviados') }}",
                    type: "GET",
                    success: function(data) {
                        console.log("Respuesta del servidor:", data);
                        if (data.success) {
                            // Actualizar los valores en el DOM
                            $('#ultimaActualizacionEnviados').text(data.fecha_actualizacion_enviados);

                            Swal.fire(
                                '¡Actualización Exitosa!',
                                '¡' + data.cantidad_insertados_enviados + ' registros han sido actualizados correctamente!',
                                'success'
                            ).then(function() {
                                table.ajax.reload();
                            });
                        } else {
                            Swal.fire(
                                'Sin cambios',
                                'No hay datos nuevos para actualizar',
                                'info'
                            ).then(function() {
                                table.ajax.reload();
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: '¡Error al Actualizar!',
                            text: 'Ha ocurrido un error: ' + error,
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });

    });
</script>