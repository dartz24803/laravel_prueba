<!-- CSS -->
<style>
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field:disabled {
        background-color: transparent !important;

    }

    .select2-container {
        margin-bottom: 0rem !important;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }


    #tabla_js2 td {
        max-width: 180px;
        /* Controla el ancho máximo */
        white-space: nowrap;
        /* Evita que el texto se divida en varias líneas */
        overflow: hidden;
        /* Oculta el contenido que se desborda */
        text-overflow: ellipsis;
        /* Añade puntos suspensivos (...) */
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 20px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: #4f46e5;
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }
</style>
<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">

    <div class="modal-header">
        <h5 class="modal-title">Detalle de Visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height: 450px; overflow: auto;">
        <div class="row my-4">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Almuerzo: </label>
                <label class="switch">
                    <input type="checkbox" id="acceso_todo" name="acceso_todo" onclick="toggleAlmuerzo()" checked>
                    <span class="slider"></span>
                </label>
            </div>

            <!-- Div para las horas que será mostrado u ocultado -->
            <div id="horas_almuerzo" class="row col-lg-12"> <!-- Asegúrate de que ocupa toda la fila -->
                <div class="form-group col-lg-6">
                    <label class="control-label text-bold">Hora Inicio: </label>
                    <input type="time" class="form-control" id="hora_inicio_almuerzo" name="hora_inicio_almuerzo">
                </div>
                <div class="form-group col-lg-6">
                    <label class="control-label text-bold">Hora Fin: </label>
                    <input type="time" class="form-control" id="hora_fin_almuerzo" name="hora_fin_almuerzo">
                </div>
            </div>

            <div class="row col-lg-12">
                <div class="form-group col-lg-6">
                    <label class="control-label text-bold">Tipo de Transporte: </label>
                    <select class="form-control" name="id_inspector" id="id_inspector">
                        @foreach ($list_tipo_transporte as $list)
                        <option value="{{ $list->id_tipo_transporte }}">{{ $list->nom_tipo_transporte }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Costo: </label>
                    <input type="text" class="form-control" id="ncosto" name="ncosto">
                </div>
                <div class="form-group col-md-12">
                    <label class="text-bold">Descripción:</label>
                    <div class="">
                        <textarea name="descripcion" id="descripcion" cols="1" rows="2" class="form-control">PUNTO DE PARTIDA:
PUNTO DE LLEGADA:
            </textarea>
                    </div>
                </div>
            </div>

            <div class="row m-4">
                <div class="form-group col-lg-12 mt-2">
                    <button class="btn btn-success" type="button" id="btn-add-row">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </button>
                </div>
                <table class="table table-bordered table-responsive" id="selected-data-table" style="margin-top:20px; display:none;">
                    <thead>
                        <tr>
                            <th>Borrar</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Tipo de Transporte</th>
                            <th>Costo</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" id="capturae" name="capturae">
        <button id="boton_disablede" class="btn btn-primary" type="button" onclick="Update_Asignacion();">Guardar</button>
        <button class=" btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>


<script>
    // $(document).ready(function() {
    //     $('#id_ptpartidae').select2({
    //         placeholder: "Selecciona un Punto de Partida",
    //         allowClear: true // Esto permite limpiar la selección
    //     });
    //     $('#id_ptpartidae').select2({
    //         placeholder: "Selecciona un Punto de Partida",
    //         allowClear: true // Esto permite limpiar la selección
    //     });
    // });
    $('.multivalue2').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Asignacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));

        var url = "{{ route('produccion_av.update', $get_id->id_asignacion_visita) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        ListaAsignacionVisitas();
                        $("#ModalUpdate .close").click();
                    });
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var firstError = Object.values(errors)[0][0];
                Swal.fire(
                    '¡Ups!',
                    firstError,
                    'warning'
                );
            }
        });
    }






    var tabla = $('#tabla_js2').DataTable({
        "columnDefs": [{
                "width": "180px",
                "targets": 3
            } // Aplica a la columna de Área (índice 3)
        ],
        "autoWidth": false, // Desactiva el auto ajuste de ancho de DataTables
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        responsive: true,
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });

    $('#toggle').change(function() {
        var visible = this.checked;
        tabla.column(6).visible(visible);
        tabla.column(10).visible(visible);
        tabla.column(14).visible(visible);
        tabla.column(18).visible(visible);
    });

    function toggleAlmuerzo() {
        var checkbox = document.getElementById("acceso_todo");
        var horasAlmuerzo = document.getElementById("horas_almuerzo");

        if (checkbox.checked) {
            horasAlmuerzo.classList.remove("d-none"); // Mostrar horas
        } else {
            horasAlmuerzo.classList.add("d-none"); // Ocultar horas
        }
    }

    $('#btn-add-row').on('click', function() {
        // Obtener los valores de los campos
        let horaInicio = $('#hora_inicio_almuerzo').val();
        let horaFin = $('#hora_fin_almuerzo').val();
        let tipoTransporte = $('#id_inspector').val();
        let costo = $('#ncosto').val();
        let descripcion = $('#descripcion').val();

        // Validar que todos los campos estén llenos
        if (horaInicio && horaFin && tipoTransporte && costo && descripcion) {
            // Mostrar la tabla si está oculta
            $('#selected-data-table').show();

            // Crear una nueva fila para la tabla con los valores
            let newRow = `
            <tr>
                <td><button class="btn btn-danger btn-delete-row" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button></td>
                <td>${horaInicio}</td>
                <td>${horaFin}</td>
                <td>${$('#id_inspector option:selected').text()}</td>
                <td>${costo}</td>
                <td>${descripcion}</td>
            </tr>
        `;
            $('#selected-data-table tbody').append(newRow);
        } else {
            alert('Por favor, completa todos los campos.');
        }
    });
</script>