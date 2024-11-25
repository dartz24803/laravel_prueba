<!-- Estilos CSS -->
<style>
    /* Asegurar que la primera columna no se mueva */
    /* Asegura que la columna fija tenga un fondo blanco y no se mezcle visualmente con las demás */
    /* Fondo blanco para la primera columna fija */
    .dataTables_wrapper .DTFC_LeftWrapper {
        background-color: white;
        /* Fondo blanco para la columna fija */
        z-index: 3;
        /* Asegura que esté sobre el contenido desplazable */
        border-right: 1px solid #ddd;
        /* Línea divisoria clara */
    }

    table.dataTable.fixedColumns {
        table-layout: fixed;
    }

    /* Asegura que el encabezado de la tabla sea fijo */
    #tabla_js thead th {
        position: sticky;
        top: 0;
        z-index: 2;
        background-color: white;
        /* Fondo blanco */
        width: 100%;
        overflow-x: auto;
    }

    /* Fijar el encabezado de la tabla en caso de scroll horizontal */
    .dataTables_wrapper .dataTables_scrollHeadInner {
        margin-left: 0 !important;
    }

    /* Ajusta la primera columna */
    .DTFC_LeftWrapper .row-selector {
        transform: scale(0.8);
        /* Reducir el tamaño del checkbox */
    }



    /* Reducir tamaño de fuente en filas y encabezados */
    #tabla_js thead th,
    #tabla_js tbody td {
        /* font-size: 10px; */
        /* Ajusta el tamaño de letra */
        padding-top: 2px;
        padding-bottom: 2px;

        /* Padding vertical (10px) y horizontal por defecto (auto) */
    }


    /* Reducir tamaño del checkbox */
    #tabla_js .row-selector {
        transform: scale(0.8);
        /* Escala el tamaño del checkbox */
    }


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
                <button type="button" class="btn btn-primary">Exportar</button>
            </div>
        </div>
    </div>
</div>

<div class="toolbar m-4">
    <!-- Primera fila -->
    <div class="row">
        <div class="form-group col-lg-2">
            <label>Fecha Inicio:</label>
            <input type="date" class="form-control" name="fecha_iniciob" id="fecha_iniciob" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group col-lg-2">
            <label>Fecha Fin:</label>
            <input type="date" class="form-control" name="fecha_finb" id="fecha_finb" value="{{ date('Y-m-d') }}">
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
            <label>SKU:</label>
            <select name="skuFiltro" id="skuFiltro" class="form-control">
                <option value="">Seleccione un SKU</option>
                @foreach($skus as $sku)
                <option value="{{ $sku->sku }}">{{ $sku->sku }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-lg-3">
            <label>Empresa:</label>
            <select class="form-control" name="empresaFiltro" id="empresaFiltro">
                <option value="">Seleccione una empresa</option>
                @foreach($empresas as $empresa)
                <option value="{{ $empresa->nom_empresa }}">{{ $empresa->nom_empresa }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-1">
            <label for="mostrarSeleccionados">Seleccionados:</label>
            <div class="d-block">
                <input type="checkbox" id="mostrarSeleccionados" class="custom-checkbox mb-2" />
            </div>
        </div>

        <div class="form-group col-lg-1">
            <button type="button" class="btn btn-primary w-100" title="Buscar" id="btnBuscar">
                Buscar
            </button>
        </div>
        <div class="form-group col-lg-1">
            <button type="button" class="btn btn-primary w-100" title="Facturar" id="btnFacturar" disabled>
                Ver
            </button>
        </div>
        <div class="form-group col-lg-1">
            <button type="button" class="btn btn-secondary w-100" title="Actualizar" id="btnActualizar">
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
            <th>
                Todos <input type="checkbox" id="selectAll" />
            </th>
            <th>Estilo</th>
            <th>Color</th>
            <th>SKU</th>
            <th>Talla</th>
            <th>Descripción</th>
            <th>Costo Precio</th>
            <th>Almacén LN1</th>
            <th>Almacén Dsc</th>
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
    $('#empresaFiltro').select2({
        placeholder: 'Seleccione una Empresa',
        allowClear: true
    });
    $('#skuFiltro').select2({
        placeholder: 'Seleccione un SKU',
        allowClear: true,
        ajax: {
            url: "{{ route('tabla_facturacion.obtenersku') }}", // Nuevo endpoint para cargar SKUs
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    search: params.term // Término de búsqueda ingresado
                };
            },
            processResults: function(data) {
                return {
                    results: data.results // Formato esperado
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });

    // $('#skuFiltro').select2({
    //     placeholder: 'Seleccione un SKU',
    //     allowClear: true
    // });
    var selectedIds = [];
    $(document).ready(function() {


        var table = $('#tabla_js').addClass('small-text').DataTable({
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
                    var filtroSku = $('#skuFiltro').val();
                    var filtroEmpresa = $('#empresaFiltro').val();
                    d.fecha_inicio = fechaInicio;
                    d.fecha_fin = fechaFin;
                    d.estado = estado;
                    d.filtroSku = filtroSku;
                    d.filtroEmpresa = filtroEmpresa;
                },
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            // "pageLength": 50, // Número de registros por página
            "lengthMenu": [10, 25, 50, 100],
            "columns": [{
                    "data": "id", // Columna para el ID
                    "visible": false // Oculta la columna del ID
                },
                {
                    "data": null, // Columna para los checkboxes de filas
                    "render": function(data, type, row, meta) {
                        return `<input type="checkbox" class="row-selector" />`;
                    },
                    "orderable": true,
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
            "scrollCollapse": true,
            "scrollX": true, // Habilita el desplazamiento horizontal
            "scrollY": 400, // Altura de la tabla para el desplazamiento vertical (ajústalo según sea necesario)
            "fixedColumns": {
                "leftColumns": 3 // Fija la primera columna (con el checkbox)
            },
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

        // Evento para el checkbox global en el encabezado
        $('#selectAll').on('change', function() {
            const isChecked = $(this).is(':checked');
            $('.row-selector').prop('checked', isChecked); // Marcar/desmarcar todos los checkboxes visibles

            // Manejar el array de seleccionados
            if (isChecked) {
                table.rows().every(function() {
                    const rowData = this.data();
                    const rowId = rowData.id;
                    if (!selectedIds.includes(rowId)) {
                        selectedIds.push(rowId);
                    }
                });
            } else {
                // Limpiar array al desmarcar
                table.rows().every(function() {
                    const rowData = this.data();
                    const rowId = rowData.id;
                    selectedIds = selectedIds.filter(id => id !== rowId);
                });
            }

            // Actualizar visualización de filas seleccionadas
            $('#tabla_js tbody tr').toggleClass('highlight-row', isChecked);

            // Actualizar estado del botón de facturar
            $('#btnFacturar').prop('disabled', !isChecked);
        });

        // Evento para desactivar el checkbox al paginar
        table.on('page.dt', function() {
            $('#mostrarSeleccionados').prop('checked', false); // Restablecer el estado del checkbox
            table.rows().every(function() {
                this.nodes().to$().show(); // Asegurarse de mostrar todas las filas
            });
        });
        $('#tabla_js tbody').on('click', 'tr', function() {
            var $checkbox = $(this).find('.row-selector'); // Obtén el checkbox en la fila
            var $row = $(this); // Obtén la fila
            var rowId = table.row($row).data().id; // Obtén el id de la fila

            // Alterna la selección del checkbox
            if ($checkbox.prop('checked')) {
                $checkbox.prop('checked', false); // Desmarca el checkbox si estaba marcado
                $row.removeClass('highlight-row'); // Elimina el resaltado de la fila
                selectedIds = selectedIds.filter(id => id !== rowId); // Elimina el id de la fila de selectedIds
            } else {
                $checkbox.prop('checked', true); // Marca el checkbox si estaba desmarcado
                $row.addClass('highlight-row'); // Resalta la fila
                selectedIds.push(rowId); // Agrega el id de la fila a selectedIds
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