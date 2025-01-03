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
        <div class="form-group col-lg-5">
            <label>
                <input type="checkbox" name="almacenFP" value="1" id="alm_dscFP"> Alm DSC
            </label>
            <label>
                <input type="checkbox" name="almacenFP" value="2" id="alm_discotelaFP"> Alm Discotela
            </label>
            <label>
                <input type="checkbox" name="almacenFP" value="3" id="alm_pbFP"> Alm PB
            </label>
            <label>
                <input type="checkbox" name="almacenFP" value="4" id="alm_madFP"> Alm Mad
            </label>
            <label>
                <input type="checkbox" name="almacenFP" value="5" id="alm_famFT"> Alm Fam
            </label>
        </div>
        <input type="hidden" id="almacenSeleccionadoInputFP" name="almacenSeleccionadoFP">

        <div class="modal-footer">
            <a class="btn mb-1 mb-sm-0" title="Exportar excel"
                style="background-color: #28a745 !important;"
                onclick="Excel_Facturacion_Informe_Parcial();">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;">
                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                        <path d="M0,172v-172h172v172z" fill="none"></path>
                        <g fill="#ffffff">
                            <path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path>
                        </g>
                    </g>
                </svg>
            </a>
        </div>
    </div>
</div>

<div class="form-group col-lg-4 offset-lg-8">
    <input type="text" id="customSearchParcial" class="form-control" placeholder="Buscar en la tabla...">
</div>

<table id="tabla_js_fp" class="table" style="width:100%">
    <div id="facturadosTotalContainer" class="alert alert-info" style="text-align: center; font-weight: bold;">
        <div>Total Facturado: <span id="facturadosTotalValueFP">0</span></div>
        <div>Total Pendiente: <span id="facturadosPendienteValueFP">0</span></div>
    </div>

    <thead>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <tr class="text-center">
            <th>ID</th>
            <th>Fecha Fact.Parcial</th>
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
            <th>Facturado</th>
            <th>Pendiente</th>
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
            "stateSave": true,
            "searching": false,

            "ajax": {
                "url": "{{ route('tabla_facturacion_fp.datatable_fp') }}", // La URL de la ruta
                "type": "POST", // Cambiar a POST
                "data": function(d) {
                    // Obtener los valores de las fechas y el estado de los filtros
                    var fechaInicio = $('#fecha_iniciob').val();
                    var fechaFin = $('#fecha_finb').val();
                    var estado = $('#estadoFiltro').val();
                    var filtroSku = $('#skuFiltro').val();
                    var filtroEmpresa = $('#empresaFiltro').val();

                    var almacenSeleccionadoInput = $('#almacenSeleccionadoInputFP').val();


                    d.fecha_inicio = fechaInicio;
                    d.fecha_fin = fechaFin;
                    d.estado = estado;
                    d.filtroSku = filtroSku;
                    d.filtroEmpresa = filtroEmpresa;
                    d.almacenSeleccionadoInput = almacenSeleccionadoInput;
                    d.customSearch = $('#customSearchParcial').val();

                },
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "dataSrc": function(json) {
                    // Asignar directamente el texto al span
                    $('#facturadosTotalValueFP').text(json.facturadosParcial);
                    $('#facturadosPendienteValueFP').text(json.facturadosPendiente);


                    return json.data;
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
                    "data": "fecha_cerrado_parcial",
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
                    "data": "pendiente",
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
        $('#customSearchParcial').on('keypress', function(e) {
            if (e.which === 13) { // Detectar tecla Enter
                var searchTerm = $(this).val();
                console.log(searchTerm)
                table.search(searchTerm).draw();
            }
        });
        const checkboxes = document.querySelectorAll('input[type="checkbox"][name="almacenFP"]');

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                // Restablecer todos los checkboxes, y marcar sólo el seleccionado
                checkboxes.forEach((otherCheckbox) => {
                    if (otherCheckbox !== checkbox) {
                        otherCheckbox.checked = false; // Desmarcar otros checkboxes
                    }
                });
                // Enviar los datos del checkbox seleccionado
                enviarDatosSeleccionado();
            });
        });

        function enviarDatosSeleccionado() {
            let selectedAlmacenId = null;
            // Buscar el checkbox seleccionado
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedAlmacenId = checkbox.value; // Captura el valor del checkbox seleccionado
                }
            });

            // Si hay un checkbox seleccionado, enviar su valor, sino enviar 0
            if (selectedAlmacenId) {
                $('#almacenSeleccionadoInputFP').val(selectedAlmacenId);
            } else {
                $('#almacenSeleccionadoInputFP').val(0); // Si no hay ninguno seleccionado, poner 0
            }

            // Mostrar el valor del input donde se está enviando el valor
            var almacenSeleccionadoInput = $('#almacenSeleccionadoInputFP').val();
        }

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


    function Excel_Facturacion_Informe_Parcial() {
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();
        window.location.replace("{{ route('tabla_facturacion_parcial.excel', [':fecha_inicio', ':fecha_fin']) }}".replace(':fecha_inicio', fecha_inicio).replace(':fecha_fin', fecha_fin));
    }
</script>