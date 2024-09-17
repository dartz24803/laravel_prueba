<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar departamento:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Dirección:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_direccione" id="id_direccione" onchange="Traer_Gerencia('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_direccion as $list)
                    <option value="{{ $list->id_direccion }}" @if ($list->id_direccion==$get_id->id_direccion) selected @endif>{{ $list->direccion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Gerencia:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_gerenciae" id="id_gerenciae" onchange="Traer_Sub_Gerencia('e'); Traer_Puesto('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_gerencia as $list)
                    <option value="{{ $list->id_gerencia }}" @if ($list->id_gerencia==$get_id->id_gerencia) selected @endif>{{ $list->nom_gerencia }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Departamento:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_sub_gerenciae" id="id_sub_gerenciae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sub_gerencia as $list)
                    <option value="{{ $list->id_sub_gerencia }}" @if ($list->id_sub_gerencia==$get_id->id_departamento) selected @endif>{{ $list->nom_sub_gerencia }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="nom_areae" name="nom_areae" placeholder="Ingresar Descripción" value="{{ $get_id->nom_area }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Código:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="cod_areae" name="cod_areae" placeholder="Ingresar Código" value="{{ $get_id->cod_area }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Puestos:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="puestose[]" id="puestose" multiple="multiple">
                    @php $base_array = explode(",",$get_id->puestos) @endphp
                    @foreach ($list_puesto as $list)
                    <option value="{{ $list->id_puesto }}"
                        @php if(in_array($list->id_puesto,$base_array)){ echo "selected"; } @endphp>
                        {{ $list->nom_puesto }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Sedes:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="sedelaborale[]" id="sedelaborale" multiple>
                    @foreach ($list_sedes as $sede)
                    <option value="{{ $sede->id }}"
                        {{ in_array($sede->id, $sedes->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $sede->descripcion }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Segundo select, inicialmente oculto -->
        <div class="row" id="additionalSelectContainer" style="display: none;">
            <div class="form-group col-lg-2">
                <label>Ubicaciones:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="ubicacionesed[]" id="ubicacionesed" multiple>
                    @foreach ($list_ubicaciones as $ubicacion)
                    <option value="{{ $ubicacion->id_ubicacion }}"
                        {{ in_array($ubicacion->id_ubicacion, $id_ubicaciones) ? 'selected' : '' }}>
                        {{ $ubicacion->cod_ubi }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Orden:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="ordene" name="ordene" placeholder="Ingresar Orden" value="{{ $get_id->orden }}" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Area();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Area() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('colaborador_conf_ar.update', $get_id->id_area) }}";

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
                        Lista_Area();
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

    $(document).ready(function() {
        // Función para mostrar u ocultar el segundo select
        function toggleAdditionalSelect() {
            var selectedValues = $('#sedelaborale').val();
            if (selectedValues.includes('6')) {
                $('#additionalSelectContainer').show();
            } else {
                $('#additionalSelectContainer').hide();
            }
        }

        // Llama a la función al cargar la página para manejar los valores seleccionados por defecto
        toggleAdditionalSelect();

        // Agrega un evento para manejar cambios en el primer select
        $('#sedelaborale').on('change', function() {
            toggleAdditionalSelect();
        });
    });
</script>