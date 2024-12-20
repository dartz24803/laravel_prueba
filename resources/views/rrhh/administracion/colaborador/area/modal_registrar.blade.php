<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva área:</h5>
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
                <select class="form-control" name="id_direccion" id="id_direccion" onchange="Traer_Gerencia('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_direccion as $list)
                    <option value="{{ $list->id_direccion }}">{{ $list->direccion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Gerencia:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_gerencia" id="id_gerencia" onchange="Traer_Sub_Gerencia(''); Traer_Puesto('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Departamento:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_sub_gerencia" id="id_sub_gerencia">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="nom_area" name="nom_area" placeholder="Ingresar Descripción">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Código:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="cod_area" name="cod_area" placeholder="Ingresar Código">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Puestos:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="puestos[]" id="puestos" multiple="multiple">
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Sedes:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="sedelaboral[]" id="sedelaboral" multiple>
                    @foreach ($list_sedes as $sede)
                    <option value="{{ $sede->id }}">{{ $sede->descripcion }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row" id="additionalSelectContainer2" style="display: none;">
            <div class="form-group col-lg-2">
                <label>Ubicaciones:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control multivalue" name="ubicaciones[]" id="ubicaciones" multiple>
                    @foreach ($list_ubicaciones as $ubicacion)
                    <option value="{{ $ubicacion->id_ubicacion }}"> {{ $ubicacion->cod_ubi }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-lg-2">
                <label>Orden:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="orden" name="orden" placeholder="Ingresar Orden" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Area();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Area() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('colaborador_conf_ar.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Area();
                        $("#ModalRegistro .close").click();
                    })
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
            var selectedValues = $('#sedelaboral').val();
            if (selectedValues.includes('6')) {
                $('#additionalSelectContainer2').show();
            } else {
                $('#additionalSelectContainer2').hide();
            }
        }

        // Llama a la función al cargar la página para manejar los valores seleccionados por defecto
        toggleAdditionalSelect();

        // Agrega un evento para manejar cambios en el primer select
        $('#sedelaboral').on('change', function() {
            toggleAdditionalSelect();
        });
    });
</script>