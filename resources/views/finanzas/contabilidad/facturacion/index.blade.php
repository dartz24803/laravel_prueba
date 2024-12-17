@csrf
<div class="form-group row">
    <!-- Sección Izquierda: Actualizar -->
    <div class="col-lg-6">
        <div class="card p-3">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Botón Actualizar -->
                    <button type="button" class="btn btn-secondary w-100" title="Actualizar" id="btnActualizar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                            <polyline points="23 4 23 10 17 10"></polyline>
                            <polyline points="1 20 1 14 7 14"></polyline>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                        </svg>
                        Actualizar
                    </button>
                    <span id="ultimaActualizacion">{{ $fecha_actualizacion }}</span>
                </div>
                <div class="col-lg-4">
                    <label for="fecha_iniciob_act">Del</label>
                    <input type="date" class="form-control" name="fecha_iniciob_act" id="fecha_iniciob_act" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-lg-4">
                    <label for="fecha_finb_act">Al</label>
                    <input type="date" class="form-control" name="fecha_finb_act" id="fecha_finb_act" value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>
    </div>

    <!-- Sección Derecha: Almacenes -->
    <div class="col-lg-6">
        <div class="card p-3">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Botón Almacenes -->
                    <button type="button" class="btn btn-primary w-100" title="Actualizar" id="btnActualizarEnviados">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                            <polyline points="23 4 23 10 17 10"></polyline>
                            <polyline points="1 20 1 14 7 14"></polyline>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                        </svg>
                        Almacenes
                    </button>
                    <span id="ultimaActualizacionEnviados">{{ $fecha_actualizacion_enviados }}</span>
                </div>
                <div class="col-lg-4">
                    <label for="fecha_iniciob_alm">Del</label>
                    <input type="date" class="form-control" name="fecha_iniciob_alm" id="fecha_iniciob_alm" value="{{ date('Y-m-d') }}">
                </div>
                <div class="col-lg-4">
                    <label for="fecha_finb_alm">Al</label>
                    <input type="date" class="form-control" name="fecha_finb_alm" id="fecha_finb_alm" value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>
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
        const fecha_inicioact = document.getElementById('fecha_iniciob_act').value;
        const fecha_finact = document.getElementById('fecha_finb_act').value;

        const fechaInicioFormateada = formatDate(fecha_inicioact);
        const fechaFinFormateada = formatDate(fecha_finact);

        Swal({
            title: '¿Estás seguro?',
            text: `Se procederá a actualizar la tabla de datos desde ${fechaInicioFormateada}  hasta  ${fechaFinFormateada}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Actualizar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ route('tabla_facturacion.update') }}",
                    type: "POST",
                    data: {
                        initialDate: fechaInicioFormateada,
                        endDate: fechaFinFormateada,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status) {
                            Swal.fire(
                                '¡Actualización Exitosa!',
                                data.data,
                                'success'
                            ).then(function() {
                                $('#ultimaActualizacion').text(data.message);
                                table.ajax.reload();
                                limpiarSeleccionados();
                            });
                        } else {
                            Swal.fire({
                                title: '¡Error al Actualizar!',
                                text: data.message || "Ocurrió un error inesperado.",
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
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

            }
        });
    });

    function formatDate(date) {
        const [year, month, day] = date.split('-');
        return `${day}/${month}/${year}`;
    }


    $('#btnActualizarEnviados').on('click', function() {
        const fecha_iniciob = document.getElementById('fecha_iniciob_alm').value;
        const fecha_finb = document.getElementById('fecha_finb_alm').value;

        const fechaInicioFormateada = formatDate(fecha_iniciob);
        const fechaFinFormateada = formatDate(fecha_finb);

        Swal({
            title: '¿Estás seguro?',
            text: `Se procederá a actualizar la cantidad de "stock", en todos los almacenes desde ${fechaInicioFormateada} hasta ${fechaFinFormateada}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, Actualizar',
            cancelButtonText: 'Cancelar',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "{{ route('tabla_facturacion.updateEnviadosEndpoint') }}",
                    type: "POST",
                    data: {
                        initialDate: fechaInicioFormateada,
                        endDate: fechaFinFormateada,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.status) {
                            Swal.fire(
                                '¡Actualización Exitosa!',
                                data.data,
                                'success'
                            ).then(function() {
                                $('#ultimaActualizacionEnviados').text(data.message);
                                limpiarSeleccionados();
                            });
                        } else {
                            Swal.fire({
                                title: '¡Error al Actualizar!',
                                text: data.message || "Ocurrió un error inesperado.",
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
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

            }
        });
    });
</script>