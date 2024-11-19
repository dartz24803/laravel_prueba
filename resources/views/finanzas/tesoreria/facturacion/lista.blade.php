<!-- Estilos CSS -->
<style>
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

    <div class="form-group col-lg-1">
        <button type="button"
            class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Buscar"
            id="btnBuscar">
            Buscar
        </button>
    </div>

    <div class="form-group col-lg-1">
        <button type="button"
            class="btn btn-primary mb-2 mx-2 mb-sm-0 mb-md-2 mb-lg-0" title="Facturar"
            id="btnFacturar" disabled>
            Facturar
        </button>
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
    $(document).ready(function() {
        var selectedIds = [];
        // Inicializa DataTable
        var table = $('#tabla_js').DataTable({
            "processing": true,
            "serverSide": true,
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

        $('#btnBuscar').on('click', function() {
            // Recarga la tabla con los datos filtrados por fecha
            table.ajax.reload();
        });

        $('#btnFacturar').on('click', function() {
            // Verifica si hay IDs seleccionados
            if (selectedIds.length > 0) {
                // Enviar los IDs seleccionados a través de una solicitud POST
                $.ajax({
                    url: "{{ route('tabla_facturacion.facturar') }}", // Ruta donde se procesarán los IDs
                    type: "POST",
                    data: {
                        ids: selectedIds, // Envía el array de IDs
                        _token: $('meta[name="csrf-token"]').attr('content') // Agrega el token CSRF para seguridad
                    },
                    success: function(data) {
                        if (data == "error") {
                            Swal.fire({
                                title: '¡Error al Facturar!',
                                text: "¡El registro ya existe o hay un problema con los datos!",
                                icon: 'error',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire(
                                '¡Facturación Exitosa!',
                                '¡Las facturas han sido generadas correctamente!',
                                'success'
                            ).then(function() {

                                table.ajax.reload();

                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Maneja los errores
                        Swal.fire({
                            title: '¡Error!',
                            text: "Ocurrió un error al procesar la facturación.",
                            icon: 'error',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            } else {
                alert('No has seleccionado ninguna fila para facturar');
            }
        });
    });
</script>