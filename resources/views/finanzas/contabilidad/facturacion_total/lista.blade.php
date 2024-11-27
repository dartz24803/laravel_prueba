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

    tfoot {
        font-weight: bold;
        font-size: small;
        /* Letras en negrita */
        margin: 0 10px;
        /* Margen horizontal */
    }

    table.dataTable td,
    table.dataTable th {
        padding: 10px 21px 10px 21px;
    }

    tfoot td {
        text-align: start;
        /* Alinear el contenido */
    }

    table.dataTable.fixedColumns {
        table-layout: fixed;
    }


    /* Fijar el encabezado de la tabla en caso de scroll horizontal */
    .dataTables_wrapper .dataTables_scrollHeadInner {
        margin-left: 0 !important;
    }

    /* Ajusta la primera columna */



    /* Reducir tamaño de fuente en filas y encabezados */
    #tabla_js_fp thead th,
    #tabla_js_fp tbody td {
        /* font-size: 10px; */
        /* Ajusta el tamaño de letra */
        padding-top: 2px;
        padding-bottom: 2px;

        /* Padding vertical (10px) y horizontal por defecto (auto) */
    }

    #tabla_jsver tbody td {
        /* font-size: 10px; */
        /* Ajusta el tamaño de letra */
        padding-top: 1px;
        padding-bottom: 1px;

        /* Padding vertical (10px) y horizontal por defecto (auto) */
    }

    /* Reducir tamaño del checkbox */



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
    #tabla_js_fp thead th {
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


<div class="toolbar m-4">

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
            <br>
            <button type="button" class="btn btn-primary w-100 d-flex align-items-center justify-content-center" title="Buscar" id="btnBuscar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                Buscar
            </button>
        </div>

    </div>
</div>


<table id="tabla_js_fp" class="table" style="width:100%">
    <thead>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <tr class="text-center">
            <th>ID</th>
            <th>Fecha Fact.Total</th>
            <th>Estilo</th>
            <th>Color</th>
            <th>SKU</th>
            <th>Talla</th>
            <th>Descripción</th>
            <th>Costo Prom</th>
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





    var selectedIds = [];
    $(document).ready(function() {

        var table = $('#tabla_js_fp').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true, // Guarda el estado de la tabla (incluido el filtro, paginación, etc.)
            "ajax": {
                "url": "{{ route('tabla_facturacion_ft.datatable_ft') }}", // La URL de la ruta
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
            "order": [
                [0, "asc"]
            ], // Define la columna 0 como orden por defecto

            "columns": [{
                    "data": "id",
                    "visible": false, // Oculta la columna del ID
                    "orderable": true // Asegura que sea ordenable (aunque esté oculta)
                },
                {
                    "data": "fecha_cerrado_total",
                    "orderable": true
                },
                {
                    "data": "estilo",
                    "orderable": true
                },
                {
                    "data": "color",
                    "orderable": true
                },
                {
                    "data": "sku",
                    "orderable": true
                },
                {
                    "data": "talla",
                    "orderable": true
                },
                {
                    "data": "descripcion",
                    "orderable": true
                },
                {
                    "data": "costo_precio",
                    "orderable": true
                },
                {
                    "data": "alm_ln1",
                    "orderable": true
                },
                {
                    "data": "alm_dsc",
                    "orderable": true
                },
                {
                    "data": "alm_discotela",
                    "orderable": true
                },
                {
                    "data": "alm_pb",
                    "orderable": true
                },
                {
                    "data": "alm_fam",
                    "orderable": true
                },
                {
                    "data": "alm_mad",
                    "orderable": true
                },
                {
                    "data": "fecha_documento",
                    "orderable": true
                },
                {
                    "data": "guia_remision",
                    "orderable": true
                },
                {
                    "data": "empresa",
                    "orderable": true
                },
                {
                    "data": "enviado",
                    "orderable": true
                },
                {
                    "data": "estado",
                    "orderable": true
                }
            ],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
            },
            "scrollCollapse": true,
            "scrollX": true,
            "scrollY": 400,
        });



        // Manejo de eventos para los checkboxes
        $('#tabla_js_fp tbody').on('change', '.row-selector', function() {
            var $row = $(this).closest('tr');
            var data = table.row($row).data();
            var rowId = data.id;

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
            var selectedRows = $('#tabla_js_fp tbody .row-selector:checked').length; // Contar cuántas filas están seleccionadas
            // Habilitar o deshabilitar el botón según el número de filas seleccionadas

        });

        // Evento para el checkbox global en el encabezado





        $('#btnFacturar').on('click', function() {
            let filas = []; // Arreglo para almacenar los datos de todas las filas

            // Recorremos cada campo de entrada en la columna "Enviado"
            $('#tablaContenido .enviado-input').each(function() {
                let enviadoActual = $(this).val(); // Valor actual del campo input
                let enviadoOriginal = $(this).attr('data-original'); // Valor original

                // Determinar si hay cambios en la fila
                let parcial = enviadoActual != enviadoOriginal ? 1 : 0;

                // Capturar los datos de la fila
                let fila = $(this).closest('tr'); // Obtiene la fila actual
                let datosFila = {
                    id: $(this).data('id'), // ID del input
                    enviado: enviadoActual, // Valor actual de enviado
                    parcial: parcial // Indicador de cambio
                };

                // Agregar la fila al arreglo
                filas.push(datosFila);
            });

            // Mostrar el arreglo en consola
            console.log("Filas procesadas:", filas);
            $.ajax({
                url: "{{ route('tabla_facturacion.facturar_cerrar') }}",
                type: "GET", // Método GET
                data: {
                    filas: filas,
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


        // Función para manejar la búsqueda
        $('#btnBuscar').on('click', function() {
            table.ajax.reload();
        });

        $('#btnVer').on('click', function() {
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

                            // Generar la tabla con los registros
                            let tableContent = '';
                            response.updated_records.forEach(function(record) {
                                tableContent += `
                        <tr>
                                            
                            <td>${record.estilo}</td>
                            <td>${record.sku}</td>
                            <td>${record.alm_ln1}</td>
                            <td>${record.alm_dsc}</td>
                            <td>${record.alm_discotela}</td>
                            <td>${record.alm_pb}</td>
                            <td>${record.alm_fam}</td>
                            <td>${record.alm_mad}</td>
                            <td>
                            <input type="number" value="${record.enviado}" 
                                class="form-control enviado-input" 
                                data-id="${record.id}" 
                                data-original="${record.enviado}" 
                                style="width: 100px; height:24px" />

                            </td>
                            <td>${record.costo_precio}</td>
                            <td>${record.color}</td>
                            <td>${record.talla}</td>
                            <td>${record.empresa}</td>
                            <td>${record.guia_remision}</td>
                            <td>${record.descripcion}</td>
                            <td>${record.estado}</td>
                        </tr>
                    `;
                            });

                            // Insertar la tabla en el modal
                            $('#tablaContenido').html(tableContent);
                            // Calcular totales
                            calcularTotales();
                            // Destruir cualquier instancia previa de DataTable antes de crear una nueva
                            if ($.fn.dataTable.isDataTable('#modalFacturados table')) {
                                $('#modalFacturados table').DataTable().clear().destroy();
                            }

                            // Inicializar DataTables después de que el modal haya sido mostrado
                            $('#modalFacturados').on('shown.bs.modal', function() {
                                // Inicializa DataTables solo cuando el modal esté visible
                                $('#modalFacturados table').DataTable({
                                    "destroy": true,
                                    "scrollX": true,
                                    "scrollY": 300,
                                    // "responsive": true,
                                    "columnDefs": [{
                                            "width": "80px",
                                            "targets": 0
                                        },
                                        {
                                            "width": "80px",
                                            "targets": 1
                                        },
                                        {
                                            "width": "80px",
                                            "targets": 2
                                        },
                                        {
                                            "width": "80px",
                                            "targets": 3
                                        },
                                        {
                                            "width": "80px",
                                            "targets": 4
                                        },
                                        {
                                            "width": "80px",
                                            "targets": 5
                                        },
                                        {
                                            "width": "80px",
                                            "targets": 6
                                        }
                                    ],
                                    "oLanguage": {
                                        "oPaginate": {
                                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                                        },
                                        "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                                        "sSearchPlaceholder": "Buscar...",
                                        "sLengthMenu": "Resultados :  _MENU_",
                                    },
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
                var cantidadSeleccionados = selectedIds.length + 1;
                $('#cantidadSeleccionados').text(cantidadSeleccionados);
                table.rows().every(function() {
                    var rowData = this.data();
                    var rowId = rowData.id;
                    if (!selectedIds.includes(rowId)) {
                        this.nodes().to$().hide();
                    }
                });
                var cantidadSeleccionados = selectedIds.length;
                $('#cantidadSeleccionados').text(cantidadSeleccionados);

            } else {
                var cantidadSeleccionados = 0;
                $('#cantidadSeleccionados').text(cantidadSeleccionados);
                // Mostrar todas las filas
                table.rows().every(function() {
                    this.nodes().to$().show();
                });
            }

        });

        // Actualizar

    });
    // Función para cerrar el modal
    function cerrarModal() {
        $('#modalFacturados').modal('hide');
    }



    // Función para calcular y actualizar los totales
    function calcularTotales() {
        let totalAlmLN1 = 0;
        let totalAlmDSC = 0;
        let totalAlmDISCOTELA = 0;
        let totalAlmPB = 0;
        let totalAlmFAM = 0;
        let totalAlmMAD = 0;
        let totalEnviado = 0;

        // Recorre cada fila de la tabla
        $('#tablaContenido tr').each(function() {
            // Obtén los valores de las celdas y convierte a número
            totalAlmLN1 += Number($(this).find('td:nth-child(3)').text()) || 0;
            totalAlmDSC += Number($(this).find('td:nth-child(4)').text()) || 0;
            totalAlmDISCOTELA += Number($(this).find('td:nth-child(5)').text()) || 0;
            totalAlmPB += Number($(this).find('td:nth-child(6)').text()) || 0;
            totalAlmFAM += Number($(this).find('td:nth-child(7)').text()) || 0;
            totalAlmMAD += Number($(this).find('td:nth-child(8)').text()) || 0;
            totalEnviado += Number($(this).find('.enviado-input').val()) || 0;
        });

        // Actualiza los totales en el pie de la tabla
        $('#totalAlmLN1').text(totalAlmLN1);
        $('#totalAlmDSC').text(totalAlmDSC);
        $('#totalAlmDISCOTELA').text(totalAlmDISCOTELA);
        $('#totalAlmPB').text(totalAlmPB);
        $('#totalAlmFAM').text(totalAlmFAM);
        $('#totalAlmMAD').text(totalAlmMAD);
        $('#totalEnviado').text(totalEnviado);
    }

    // Escuchar los cambios en los inputs dentro de la tabla
    $(document).on('input', '.enviado-input', function() {
        actualizarTotalEnviado(); // Solo actualiza el total de la columna "Enviado"
    });

    // Función para actualizar solo el total de la columna "Enviado" en el <tfoot>
    function actualizarTotalEnviado() {
        let totalEnviado = 0;
        // Recorre cada input .enviado-input y suma los valores
        $('.enviado-input').each(function() {
            totalEnviado += Number($(this).val()) || 0; // Asegúrate de usar el valor actual del input
        });
        // Solo actualiza la celda de "Enviado" en el <tfoot> sin modificar la tabla completa
        $('#tablaTotales #totalEnviado').text(totalEnviado);
    }
</script>