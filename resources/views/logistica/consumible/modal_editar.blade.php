<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Consumible</h5>
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
                    <option value="{{ $list->id_area }}" {{ $list->id_area == $get_id->id_area ? 'selected' : '' }}>
                        {{ $list->nom_area }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Colaborador:</label>
                <select class="form-control" id="colaborador" name="colaborador">
                    <option value="0">Seleccione</option>
                    @foreach ($list_colaborador as $list)
                    <option value="{{ $list->id_usuario }}" {{ $list->id_usuario == $get_id->id_usuario ? 'selected' : '' }}>
                        {{ $list->usuario_nombres }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Artículo:</label>
                <select class="form-control multivalue" id="articuloe" name="articuloe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_articulos as $list)
                    <option value="{{ $list->id_articulo }}" title="{{ $list->nom_articulo }}">
                        {{ \Illuminate\Support\Str::limit($list->nom_articulo, 20, '...') }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Unidad:</label>
                <select class="form-control" id="unidade" name="unidade">
                    <option value="0">Seleccione</option>
                    @foreach ($list_unidades as $list)
                    <option value="{{ $list->id_unidad }}">{{ $list->nom_unidad }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Estado:</label>
                <select class="form-control" id="unidade" name="unidade">
                    <option value="0">TODOS</option>
                    <option value="1">Requerido</option>
                    <option value="2">En Procedo de Atención</option>
                    <option value="3">Observado</option>
                    <option value="4">Subsanado</option>
                    <option value="5">Atendido</option>
                </select>
            </div>


            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Cantidad:</label>
                <input type="number" class="form-control" name="cantidade" id="cantidade"></input>
            </div>

            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Observación:</label>
                <textarea class="form-control" name="obserbacione rows=" 2" id="obserbacione"></textarea>
            </div>
        </div>
        <div class="form-group col-lg-12 mt-2">
            <button class="btn btn-success" type="button" id="btn-add-row-detalle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </button>
        </div>

        <table class="table table-bordered table-responsive" id="selected-data-detalle-table" style="margin-top:20px;">
            <thead>
                <tr>
                    <th>Borrar</th>
                    <th class="col-tipo">Artículo</th>
                    <th class="col-tipo">Unidad</th>
                    <th class="col-tipo">Cantidad</th>
                </tr>
            </thead>
            <tbody> @foreach ($list_consumibles_detalle as $item)
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
                        <select class="form-control" name="id_articulo[]">
                            @foreach ($list_articulos as $list)
                            <option value="{{ $list->id_articulo }}" {{ $list->id_articulo == $item->articulo ? 'selected' : '' }}>
                                {{ $list->nom_articulo }}
                            </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="px-1">
                        <select class="form-control" name="id_unidad[]">
                            @foreach ($list_unidades as $list)
                            <option value="{{ $list->id_unidad }}" {{ $list->id_unidad == $item->unidad ? 'selected' : '' }}>
                                {{ $list->nom_unidad }}
                            </option>
                            @endforeach
                        </select>

                    </td>
                    <td class="px-1">
                        <input type="number" class="form-control" value="{{ $item->cantidad }}" name="cantidad[]">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" onclick="Update_Consumible();" type="button">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Consumible() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ route('consumible.update', $get_id->id_consumible) }}";

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
                        Lista_ErroresPicking();
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

    $('#btn-add-row-detalle').on('click', function() {
        // Obtener los datos del select principal
        let articulo = $('#articuloe').val();
        let unidad = $('#unidade').val();
        let cantidad = $('#cantidade').val();

        // Validar que todos los campos estén completados
        if (articulo != "0" && unidad != "0" && cantidad) {
            // Obtener los textos seleccionados
            let articuloText = $('#articuloe option:selected').text();
            let unidadText = $('#unidade option:selected').text();

            // Crear nueva fila
            var tableBody = document.querySelector('#selected-data-detalle-table tbody');
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
                <select class="form-control" name="id_articulo[]">
                    <option value="${articulo}">${articuloText}</option>
                </select>
            </td>
            
            <td class="px-1">
                <select class="form-control" name="id_unidad[]">
                    <option value="${unidad}">${unidadText}</option>
                </select>
            </td>
            <td class="px-1">
                <input type="number" class="form-control" value="${cantidad}" name="cantidad[]">
            </td>
            `;

            // Agregar la nueva fila al cuerpo de la tabla
            tableBody.appendChild(newRow);
        } else {
            alert('Por favor, completa todos los campos.');
        }
    });

    // Función para eliminar la fila
    $(document).on('click', '.btn-delete-row', function() {
        $(this).closest('tr').remove();
    });
</script>