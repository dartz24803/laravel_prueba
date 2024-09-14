<!-- CSS -->
<style>
    /* Asegúrate de que el dropdown de Select2 tenga un z-index más bajo */
    .select2-container--default .select2-dropdown {
        z-index: 1090;
        /* Debe ser menor que el z-index del modal */
    }

    /* Estilo para el campo de búsqueda dentro del select2 */
    /* Estilo para el campo de búsqueda dentro del select2 cuando está deshabilitado */
    .select2-container--default .select2-selection--multiple .select2-search--inline .select2-search__field:disabled {
        background-color: transparent !important;
    }


    /* Añadir un contenedor para manejar el overflow de la tabla */
    .table-responsive {
        overflow-x: auto;
        /* Habilita el scroll horizontal si es necesario */
        max-width: 100%;
        /* Asegura que la tabla no se desborde más allá de su contenedor */
    }

    .table {
        width: 100%;
        /* Asegura que la tabla use el 100% del espacio disponible */
    }


    .form-group {
        margin: 0px;
        /* Ajusta este valor según tus necesidades */
    }

    .small-text {
        color: black;
        font-size: 12px;
        /* Ajusta el tamaño según tus necesidades */
    }

    .centered-label {
        text-align: center;
        margin-bottom: 1rem;
        /* Espacio inferior */
        background-color: #f8f9fa;
        /* Color de fondo distinto para el label */
        padding: 10px;
        /* Espaciado interno */
        border-radius: 5px;
        /* Bordes redondeados */
        border: 1px solid #dee2e6;
        /* Borde */
    }

    .divider {
        border-bottom: 1px solid #dee2e6;
        /* Color y estilo del divisor */
        margin-bottom: 1rem;
        /* Espacio debajo del divisor */
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
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
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">

    <div class=" modal-header">
        <h5 class="modal-title">Registrar Asignación Visita</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="asignacion-tab" data-toggle="tab" href="#asignacion" role="tab" aria-controls="asignacion" aria-selected="true">Asignación</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="proceso-tab" data-toggle="tab" href="#proceso" role="tab" aria-controls="proceso" aria-selected="false">Proceso</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">

            <div class="tab-pane fade show active" id="asignacion" role="tabpanel" aria-labelledby="asignacion-tab">
                <div class="row my-4">

                    <div class="form-group col-lg-6">
                        <label class="control-label text-bold">Inspector: </label>
                        <select class="form-control" name="id_inspector" id="id_inspector">
                            @foreach ($list_inspector as $list)
                            <option value="{{ $list->id_usuario }}">{{ $list->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label text-bold">Inspectores Acompañantes: </label>
                        <select class="form-control multivalue" name="id_inspector_acop[]" id="id_inspector_acop" multiple="multiple">
                            @foreach ($list_inspector as $list)
                            <option value="{{ $list->id_usuario }}">{{ $list->nombre_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label text-bold">Fecha: </label>
                        <input class="form-control" type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="proceso" role="tabpanel" aria-labelledby="proceso-tab">
                <div class="row my-4">

                    <div class="form-group col-lg-6">
                        <label class="control-label text-bold">Punto de Partida: </label>
                        <select class="form-control multivalue" name="id_ptpartida" id="id_ptpartida">
                            <option value="0">Domicilio</option>
                            @foreach ($list_proveedor as $list)
                            <option value="{{ $list->id_proveedor }}">{{ $list->nombre_proveedor_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label text-bold">Punto de Llegada: </label>
                        <select class="form-control multivalue" name="id_ptllegada" id="id_ptllegada">
                            @foreach ($list_proveedor as $list)
                            <option value="{{ $list->id_proveedor }}">{{ $list->nombre_proveedor_completo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label text-bold">Modelo: </label>
                        <select class="form-control multivalue" name="id_modelo[]" id="id_modelo">
                            @foreach ($list_ficha_tecnica as $list)
                            <option value="{{ $list->id_ft_produccion }}">{{ $list->modelo }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-6">
                        <label class="control-label text-bold">Proceso: </label>
                        <select class="form-control" name="id_proceso[]" id="id_proceso">
                            @foreach ($list_proceso_visita as $list)
                            <option value="{{ $list->id_procesov }}">{{ $list->nom_proceso }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
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
                                <th class="col-tipo">Punto de Partida</th>
                                <th class="col-tipo">Punta de Llegada</th>
                                <th>Modelo</th>
                                <th>Proceso</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button">Guardar</button>
        <button class=" btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>

</form>

<script>
    $('.multivalue').select2({
        tags: true, // Permite crear nuevas etiquetas
        tokenSeparators: [',', ' '], // Separa las etiquetas con comas y espacios
        dropdownParent: $('#ModalRegistro')
    });

    $(document).ready(function() {
        // Evento click del botón "+"
        $('#btn-add-row').on('click', function() {
            // Obtener los valores seleccionados
            let partida = $('#id_ptpartida').val();
            let llegada = $('#id_ptllegada').val();
            let modelo = $('#id_modelo').val();
            let proceso = $('#id_proceso').val();

            // Validar que todos los selects estén seleccionados
            if (partida.length > 0 && llegada.length > 0 && modelo.length > 0 && proceso.length > 0) {
                // Mostrar la tabla si está oculta
                $('#selected-data-table').show();

                // Agregar una nueva fila a la tabla
                let newRow = `
                <tr>
                    <td><button class="btn btn-danger btn-delete-row" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button></td>
                    <td>${$('#id_ptpartida option:selected').map(function() { return $(this).text(); }).get().join(', ')}</td>
                    <td>${$('#id_ptllegada option:selected').map(function() { return $(this).text(); }).get().join(', ')}</td>
                    <td>${$('#id_modelo option:selected').map(function() { return $(this).text(); }).get().join(', ')}</td>
                    <td>${$('#id_proceso option:selected').map(function() { return $(this).text(); }).get().join(', ')}</td>
                </tr>
            `;
                $('#selected-data-table tbody').append(newRow);
            } else {
                alert('Por favor, selecciona todos los campos.');
            }
        });

        // Evento para eliminar una fila
        $(document).on('click', '.btn-delete-row', function() {
            $(this).closest('tr').remove();
            if ($('#selected-data-table tbody tr').length === 0) {
                $('#selected-data-table').hide();
            }
        });
    });
</script>