<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Consumible

        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Área:</label>
                <select class="form-control" id="areacon" name="areacon">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Colaborador:</label>
                <select class="form-control" id="colaborador" name="colaborador">
                    <option value="0">Seleccione</option>
                    @foreach ($list_colaborador as $list)
                    <option value="{{ $list->id_usuario }}">{{ $list->usuario_nombres }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Artículo:</label>
                <select class="form-control multivalue" id="articulo" name="articulo">
                    <option value="0">Seleccione</option>
                    @foreach ($list_articulos as $list)
                    <option value="{{ $list->id_articulo }}">{{ $list->nom_articulo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-4">
                <label class="control-label text-bold">Unidad:</label>
                <select class="form-control" id="unidad" name="unidad">
                    <option value="0">Seleccione</option>
                    @foreach ($list_unidades as $list)
                    <option value="{{ $list->id_unidad }}">{{ $list->nom_unidad }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad:</label>
                <input type="number" class="form-control" name="cantidad" id="cantidad"></input>
            </div>
        </div>
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
                    <th class="col-tipo">Artículo</th>
                    <th class="col-tipo">Unidad</th>
                    <th class="col-tipo">Cantidad</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>


        <div class="modal-footer">
            @csrf
            <button class="btn btn-primary" type="button" onclick="Insert_Consumible();">Guardar</button>
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
        </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Consumible() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));

        // Recolectar los datos de la tabla (IDs)
        let tableData = [];
        $('#selected-data-table tbody tr').each(function() {
            let row = {
                articulo: $(this).find('td').eq(1).data('id'),
                unidad: $(this).find('td').eq(2).data('id'),
                cantidad: parseFloat($(this).find('td').eq(3).text().trim()) // Convertir cantidad a número
            };
            tableData.push(row);
        });

        // Añadir los datos de la tabla al FormData
        dataString.append('tableData', JSON.stringify(tableData));

        var url = "{{ route('consumible.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Registro Exitoso!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_ErroresPicking();
                    $("#ModalRegistro .close").click();
                });
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

    $('#areacon').on('change', function() {
        const selectedArea = $(this).val();
        var url = "{{ route('usuarios_por_area') }}";
        console.log(selectedArea)
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                area_id: selectedArea
            },
            success: function(response) {
                // Vaciar el segundo select antes de agregar las nuevas opciones
                $('#colaborador').empty();
                // Agregar las nuevas opciones
                $.each(response, function(index, area) {
                    $('#colaborador').append(
                        `<option value="${area.id_usuario}">${area.nombre_completo}</option>`
                    );
                });
            },
            error: function(xhr) {
                console.error('Error al obtener usuarios:', xhr);
            }
        });
    });


    $(document).ready(function() {
        // Evento click del botón "+"
        $('#btn-add-row').on('click', function() {
            // Obtener los valores seleccionados (IDs)
            let articulo = $('#articulo').val() || [];
            let unidad = $('#unidad').val() || [];
            let cantidad = $('#cantidad').val();

            // Convertir a arrays si no lo son
            articulo = Array.isArray(articulo) ? articulo : [articulo];
            unidad = Array.isArray(unidad) ? unidad : [unidad];

            // Obtener los textos seleccionados (nombres en lugar de IDs)
            let articuloText = articulo.map(id => $('#articulo option[value="' + id + '"]').text()).join(', ');
            let unidadText = unidad.map(id => $('#unidad option[value="' + id + '"]').text()).join(', ');


            // Validar que todos los selects estén seleccionados
            if (articulo.length > 0 && unidad.length > 0) {
                // Mostrar la tabla si está oculta
                $('#selected-data-table').show();

                // Crear una nueva fila para la tabla con los nombres y los IDs en data-attributes
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
                    <td data-id="${articulo.join(',')}">${articuloText}</td>
                    <td data-id="${unidad.join(',')}">${unidadText}</td>
                    <td>${cantidad}</td>


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
            // Ocultar la tabla si no hay filas
            if ($('#selected-data-table tbody tr').length === 0) {
                $('#selected-data-table').hide();
            }
        });

    });
</script>