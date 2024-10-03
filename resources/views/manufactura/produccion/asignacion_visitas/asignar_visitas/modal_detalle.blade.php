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


    #selected-data-detalle-table td {
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
<form id="formulariodeta" method="POST" enctype="multipart/form-data" class="needs-validation">

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
                    <input type="checkbox" id="almuerzo" name="almuerzo"
                        onclick="toggleAlmuerzo()"
                        value="{{ isset($get_id->ch_alm) ? $get_id->ch_alm : 0 }}"
                        {{ isset($get_id->ch_alm) && $get_id->ch_alm == 1 ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div id="horas_almuerzo" class="row col-lg-12" style="{{ isset($get_id->ch_alm) && $get_id->ch_alm == 1 ? 'display: flex;' : 'display: none;' }}">
                <div class="form-group col-lg-6">
                    <label class="control-label text-bold">Hora Inicio: </label>
                    <input type="time" class="form-control" id="hora_inicio_almuerzo" name="hora_inicio_almuerzo" value="{{ isset($get_id->ini_alm) ? $get_id->ini_alm : '' }}">
                </div>
                <div class="form-group col-lg-6">
                    <label class="control-label text-bold">Hora Fin: </label>
                    <input type="time" class="form-control" id="hora_fin_almuerzo" name="hora_fin_almuerzo" value="{{ isset($get_id->fin_alm) ? $get_id->fin_alm : '' }}">
                </div>
            </div>

            <div class="row col-lg-12">
                <div class="form-group col-lg-6">
                    <label class="control-label text-bold">Tipo de Transporte: </label>
                    <select class="form-control" name="id_tipotransporte_principal[]" id="id_tipotransporte_principal">
                        @foreach ($list_tipo_transporte as $item)
                        <option value="{{ $item->id_tipo_transporte }}">{{ $item->nom_tipo_transporte }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Costo: </label>
                    <input type="number" class="form-control" id="ncosto" name="ncosto">
                </div>
                <div class="form-group col-md-12">
                    <label class="text-bold">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" cols="1" rows="2" class="form-control">PUNTO DE PARTIDA: 
PUNTO DE LLEGADA:</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label class="text-bold">Observación:</label>
                    <textarea name="observacion" id="observacion" cols="1" rows="1" class="form-control">{{ isset($get_id->observacion) ? $get_id->observacion : '' }}</textarea>
                </div>

            </div>

            <div class="row m-4">
                <div class="form-group col-lg-12 mt-2">
                    <button class="btn btn-success" type="button" id="btn-add-row-detalle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </button>
                </div>
                <table id="selected-data-detalle-table" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>Borrar</th>
                            <th>Tipo de Transporte</th>
                            <th style="width: 100px;">Costo (S/)</th>
                            <th style="width: 300px;">Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list_visita_transporte as $item)
                        <tr>
                            <td class="px-1">
                                <button type="button" class="btn btn-danger btn-delete-row">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                    </svg>
                                </button>
                            </td>
                            <td class="px-1">
                                <select class="form-control" name="id_tipotransporte[]">
                                    @foreach ($list_tipo_transporte as $option)
                                    <option value="{{ $option->id_tipo_transporte }}" {{ $option->id_tipo_transporte == $item->id_tipo_transporte ? 'selected' : '' }}>
                                        {{ $option->nom_tipo_transporte }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-1">
                                <input type="number" class="form-control" value="{{ $item->costo }}" name="ncosto[]">
                            </td>
                            <td class="px-1">
                                <textarea class="form-control" rows="2" name="descripcion[]">{{ $item->descripcion }}</textarea>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


        </div>

    </div>
    </div>

    <div class="modal-footer">
        @csrf
        <!-- @method('PUT') -->
        <input type="hidden" id="capturae" name="capturae">
        <button id="boton_disablede" class="btn btn-primary" type="button" onclick="Update_Detalle_Asignacion();">Guardar</button>
        <button class=" btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>


<script>
    $('.multivalue2').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Detalle_Asignacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulariodeta'));

        var url = "{{ route('produccion_detalle_av.update', $get_id->id_asignacion_visita) }}";

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
                        Lista_Asig_Visitas();
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


    $('#toggle').change(function() {
        var visible = this.checked;
        tabla.column(6).visible(visible);
        tabla.column(10).visible(visible);
        tabla.column(14).visible(visible);
        tabla.column(18).visible(visible);
    });

    function toggleAlmuerzo() {
        const almuerzoVisible = document.getElementById("almuerzo").checked;
        const horasAlmuerzo = document.getElementById("horas_almuerzo");

        if (almuerzoVisible) {
            horasAlmuerzo.style.display = 'flex'; // Mostrar cuando el switch está activado
        } else {
            horasAlmuerzo.style.display = 'none'; // Ocultar cuando el switch está desactivado
        }
    }

    // Para asegurarte que se oculte al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
        toggleAlmuerzo(); // Esto ocultará la sección al iniciar
    });


    $('#btn-add-row-detalle').on('click', function() {
        // Obtener los datos del select principal renombrado
        let tipoTransporteId = $('#id_tipotransporte_principal').val();
        let costo = $('#ncosto').val();
        let descripcion = $('#descripcion').val();

        // Validar que todos los campos estén completados
        if (tipoTransporteId && costo) {
            // Obtener el cuerpo de la tabla
            var tableBody = document.querySelector('#selected-data-detalle-table tbody');
            // Crear una nueva fila
            var newRow = document.createElement('tr');
            newRow.classList.add('text-center');

            // Contenido HTML de la nueva fila
            newRow.innerHTML = `
        <td>
            <button type="button" class="btn btn-danger btn-delete-row">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    <line x1="10" y1="11" x2="10" y2="17"></line>
                    <line x1="14" y1="11" x2="14" y2="17"></line>
                </svg>
            </button>
        </td>
        <td class="px-1">
            <select class="form-control" name="id_tipotransporte[]">
                ${$('#id_tipotransporte_principal').html()}
            </select>
        </td>
        <td class="px-1">
            <input type="number" class="form-control" value="${costo}" name="ncosto[]">
        </td>
        <td class="px-1">
            <textarea class="form-control" rows="2" name="descripcion[]">${descripcion}</textarea>
        </td>
        `;

            // Agregar la nueva fila al cuerpo de la tabla
            tableBody.appendChild(newRow);
            // Seleccionar la opción correspondiente en el nuevo select
            newRow.querySelector('select[name="id_tipotransporte[]"]').value = tipoTransporteId;

        } else {
            alert('Por favor, completa todos los campos.');
        }
    });


    $(document).on('click', '.btn-delete-row', function() {
        $(this).closest('tr').remove(); // Eliminar la fila correspondiente
    });
</script>