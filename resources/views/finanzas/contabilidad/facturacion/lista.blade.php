<!-- Estilos CSS -->
<style>
    /* Ajustar el tamaño y el espacio alrededor del checkbox */
    .custom-checkbox {
        width: 20px;
        height: 20px;
        margin-top: 5px;
    }

    /* Ajustar la etiqueta */
    .control-label {
        font-size: 14px;
        /* Reducir el tamaño del texto */
        margin-bottom: 5px;
        display: block;
    }

    /* Mejorar la alineación y espaciado */
    .form-group {
        margin-bottom: 10px;
    }

    /* Fijar el encabezado de la tabla */
    #tabla_js thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        /* Asegura que el encabezado se quede encima de las filas */
        background-color: white;
        /* Fondo blanco para que se vea encima de las filas */
    }

    /* Fijar el pie de página (paginación) */
    .dataTables_wrapper .dataTables_paginate {
        position: sticky;
        bottom: 0;
        z-index: 2;
        background-color: white;
    }

    /* Asegurar que solo la tabla de datos se mueva horizontalmente */
    #tabla_js_wrapper {
        overflow-x: auto;
        /* Agregar scroll horizontal */
        max-width: 100%;
    }

    /* Para los filtros en cabecera (si tienes campos de búsqueda o algo similar) */
    .dataTables_filter {
        position: sticky;
        top: 0;
        z-index: 3;
        background-color: white;
    }

    /* Estilo para la fila seleccionada */

    .highlight-row {
        background-color: #d1ecf1 !important;
        /* Cambia el color según tu necesidad */
    }
</style>
<div class="toolbar d-md-flex align-items-md-center mt-3">
    <!-- Modal Previsualización por Facturar-->
    <div class="modal fade" id="modalFacturados" tabindex="-1" aria-labelledby="modalFacturadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFacturadosLabel">Previsualización por Facturar</h5>
                </div>
                <div class="modal-body" id="tablaFacturados">
                    <!-- Aquí se insertará la tabla con estructura personalizada -->
                    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table class="table table-striped" style="width: 100%; border-collapse: collapse; min-width: 800px;">
                            <thead>
                                <tr>
                                    <th>Estilo</th>
                                    <th>SKU</th>
                                    <th>Descripción</th>
                                    <th>Color</th>
                                    <th>Talla</th>
                                    <th>Costo Precio</th>
                                    <th>Alm DSC</th>
                                    <th>Empresa</th>
                                    <th>Guía de Remisión</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="tablaContenido">
                                <!-- Los registros de la tabla se insertarán aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Botón para cerrar el modal -->
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cerrar</button>
                    <!-- Botón para llamar a la función de facturación -->
                    <button type="button" class="btn btn-primary" onclick="exportar_por_facturar()">Exportar</button>
                </div>
            </div>
        </div>
    </div>




    <div class="row">


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
        <div class="form-group col-lg-2">
            <label>Estado:</label>
            <select class="form-control" id="estadoFiltro">
                <option value="">Todos</option>
                <option value="1">Con Stock</option>
                <option value="0">Sin Stock</option>
            </select>
        </div>
        <div class="form-group col-lg-2">
            <label for="mostrarSeleccionados" class="control-label">Mostrar Seleccionados:</label>
            <input type="checkbox" id="mostrarSeleccionados" class="custom-checkbox" />
        </div>
        <div class="form-group col-lg-1">
            <button type="button"
                class="btn btn-primary mx-1 mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Buscar"
                id="btnBuscar">
                Buscar
            </button>
        </div>
        <div class="form-group col-lg-2">
            <button type="button"
                class="btn btn-primary mb-2 mx-1 mb-sm-0 mb-md-2 mb-lg-0" title="Facturar"
                id="btnFacturar" disabled>
                Previsualizar
            </button>
        </div>
        <div class="form-group col-lg-1">
            <button type="button"
                class="btn btn-secondary mb-2 mx-1 mb-sm-0 mb-md-2 mb-lg-0" title="Facturar"
                id="btnActualizar">
                Actualizar
            </button>
        </div>
    </div>
</div>


<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <tr class="text-center">
            <th>ID</th>
            <th>Seleccionar</th>
            <th>Estilo</th>
            <th>Color</th>
            <th>SKU</th>
            <th>Talla</th>
            <th>Descripción</th>
            <th>Costo Precio</th>
            <th>Almacén LN1</th>
            <th>Almacén Descuento</th>
            <th>Almacén Discotela</th>
            <th>Almacén PB</th>
            <th>Almacén Fam</th>
            <th>Almacén Mad</th>
            <th>Fecha Documento</th>
            <th>Guía Remisión</th>
            <th>Empresa</th>
            <th>Enviado</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <!-- Los datos se llenarán mediante DataTables -->
    </tbody>
</table>

<script>
    var selectedIds = [];
    $(document).ready(function() {


        var table = $('#tabla_js').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true, // Guarda el estado de la tabla (incluido el filtro, paginación, etc.)
            "ajax": {
                "url": "{{ route('tabla_facturacion.datatable') }}", // La URL de la ruta
                "type": "POST", // Cambiar a POST
                "data": function(d) {
                    // Obtener los valores de las fechas y el estado de los filtros
                    var fechaInicio = $('#fecha_iniciob').val();
                    var fechaFin = $('#fecha_finb').val();
                    var estado = $('#estadoFiltro').val();
                    d.fecha_inicio = fechaInicio;
                    d.fecha_fin = fechaFin;
                    d.estado = estado;
                },
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            "pageLength": 50, // Número de registros por página
            "lengthMenu": [10, 25, 50, 100],
            "columns": [{
                    "data": "id", // Columna para el ID
                    "visible": false // Oculta la columna del ID
                },
                {
                    "data": null, // Columna para el checkbox
                    "render": function(data, type, row, meta) {
                        return `<input type="checkbox" class="row-selector" />`;
                    },
                    "orderable": false,
                    "searchable": false
                },
                {
                    "data": "estilo"
                },
                {
                    "data": "color"
                },
                {
                    "data": "sku"
                },
                {
                    "data": "talla"
                },
                {
                    "data": "descripcion"
                },
                {
                    "data": "costo_precio"
                },
                {
                    "data": "alm_ln1"
                },
                {
                    "data": "alm_dsc"
                },
                {
                    "data": "alm_discotela"
                },
                {
                    "data": "alm_pb"
                },
                {
                    "data": "alm_fam"
                },
                {
                    "data": "alm_mad"
                },
                {
                    "data": "fecha_documento"
                },
                {
                    "data": "guia_remision"
                },
                {
                    "data": "empresa"
                },
                {
                    "data": "enviado"
                },
                {
                    "data": "estado"
                }
            ],
            "scrollX": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            }
        });

        // Manejo de eventos para los checkboxes
        $('#tabla_js tbody').on('change', '.row-selector', function() {
            var $row = $(this).closest('tr');
            var data = table.row($row).data();
            var rowId = data.id; // Obtén el ID de la fila desde los datos
            if (this.checked) {
                // Agrega el ID al array si no existe
                if (!selectedIds.includes(rowId)) {
                    selectedIds.push(rowId);
                }
                $row.addClass('highlight-row');
            } else {
                // Elimina el ID del array si existe
                selectedIds = selectedIds.filter(id => id !== rowId);
                $row.removeClass('highlight-row');
            }

            // VALIDAR BUTTON DE FACTURAR
            var selectedRows = $('#tabla_js tbody .row-selector:checked').length; // Contar cuántas filas están seleccionadas
            // Habilitar o deshabilitar el botón según el número de filas seleccionadas
            if (selectedRows > 0) {
                $('#btnFacturar').prop('disabled', false); // Habilitar el botón
            } else {
                $('#btnFacturar').prop('disabled', true); // Deshabilitar el botón
            }
        });

        // Guardar las selecciones al cambiar de página
        table.on('draw', function() {
            // Vuelve a seleccionar las filas previamente seleccionadas
            $('#tabla_js tbody .row-selector').each(function() {
                var $row = $(this).closest('tr');
                var data = table.row($row).data();
                var rowId = data.id;
                if (selectedIds.includes(rowId)) {
                    $(this).prop('checked', true);
                    $row.addClass('highlight-row');
                } else {
                    $(this).prop('checked', false);
                    $row.removeClass('highlight-row');
                }
            });
        });

        // Función para manejar la búsqueda
        $('#btnBuscar').on('click', function() {
            table.ajax.reload();
        });

        $('#btnFacturar').on('click', function() {
            if (selectedIds.length > 0) {

                $.ajax({
                    url: "{{ route('tabla_facturacion.facturar_ver') }}", // Ruta donde se procesarán los IDs
                    type: "GET",
                    data: {
                        ids: selectedIds,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {
                        // Verificar si la respuesta contiene los registros actualizados
                        if (response.updated_records && response.updated_records.length > 0) {
                            console.log(response.updated_records.length);

                            // Generar la tabla con los registros
                            let tableContent = '';
                            response.updated_records.forEach(function(record) {
                                tableContent += `
                        <tr>
                                            
                            <td>${record.estilo}</td>
                            <td>${record.sku}</td>
                            <td>${record.descripcion}</td>
                            <td>${record.color}</td>
                            <td>${record.talla}</td>
                            <td>${record.costo_precio}</td>
                            <td>${record.alm_dsc}</td>
                            <td>${record.empresa}</td>
                            <td>${record.guia_remision}</td>
                            <td>${record.estado}</td>
                        </tr>
                    `;
                            });

                            // Insertar la tabla en el modal
                            $('#tablaContenido').html(tableContent);

                            // Destruir cualquier instancia previa de DataTable antes de crear una nueva
                            if ($.fn.dataTable.isDataTable('#modalFacturados table')) {
                                $('#modalFacturados table').DataTable().clear().destroy();
                            }

                            // Inicializar DataTables después de que el modal haya sido mostrado
                            $('#modalFacturados').on('shown.bs.modal', function() {
                                // Inicializa DataTables solo cuando el modal esté visible
                                $('#modalFacturados table').DataTable({
                                    "destroy": true, // Habilitar destrucción de la instancia anterior
                                    "responsive": true
                                });
                            });

                            // Abrir el modal
                            $('#modalFacturados').modal('show');
                        } else {
                            alert('No se encontraron registros para mostrar.');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Error al procesar la facturación.');
                    }
                });
            } else {
                alert('No has seleccionado ninguna fila para facturar');
            }
        });

        // Asegurarse de que el modal se cierra correctamente y se destruye la instancia de DataTable
        $('#modalFacturados').on('hidden.bs.modal', function() {
            // Limpiar el contenido de la tabla para evitar problemas con datos obsoletos
            $('#tablaContenido').html('');
            // Si la tabla ya ha sido destruida, evitar errores posteriores
            if ($.fn.dataTable.isDataTable('#modalFacturados table')) {
                $('#modalFacturados table').DataTable().clear().destroy();
            }
        });

        // Filtro para mostrar solo las filas seleccionadas
        $('#mostrarSeleccionados').on('change', function() {
            if (this.checked) {
                table.rows().every(function() {
                    var rowData = this.data();
                    var rowId = rowData.id;
                    if (!selectedIds.includes(rowId)) {
                        this.nodes().to$().hide();
                    }
                });

            } else {
                // Mostrar todas las filas
                table.rows().every(function() {
                    this.nodes().to$().show();
                });
            }

        });

        // Actualizar
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
    });
    // Función para cerrar el modal
    function cerrarModal() {
        $('#modalFacturados').modal('hide');
    }

    function exportar_por_facturar() {
        // Realizamos la solicitud AJAX
        $.ajax({
            url: "{{ route('tabla_facturacion.facturar_cerrar') }}",
            type: "GET", // Método GET
            data: {
                ids: selectedIds,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // console.log(response);
                // Aquí puedes manejar la respuesta del servidor
                // Si la exportación es exitosa, puedes mostrar un mensaje de éxito
                if (response.success) {
                    alert('Los datos se exportaron correctamente.');
                } else {
                    alert('Hubo un error al exportar los datos.');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Hubo un error en la solicitud.');
            }

        });
    }
</script>