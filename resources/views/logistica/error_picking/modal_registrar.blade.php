<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo error de picking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <!-- Semana -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Semana:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="semana" id="semana" placeholder="Semana" onkeypress="return solo_Numeros(event);">
            </div>

            <!-- Pertenece -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Pertenece:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="pertenece" name="pertenece">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                    <option value="BEC">BEC</option>
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Encontrado -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Encontrado:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="encontrado" name="encontrado">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Área -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Área:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="id_area" name="id_area">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Estilo -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Estilo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="estilo" id="estilo" placeholder="Estilo">
            </div>

            <!-- Color -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Color:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="color" id="color" placeholder="Color">
            </div>
        </div>

        <div class="row">
            <!-- Talla -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Talla:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="id_talla" name="id_talla">
                    <option value="0">Seleccione</option>
                    @foreach ($list_talla as $list)
                        <option value="{{ $list->id_talla }}">{{ $list->nom_talla }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Prendas devueltas -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Prendas devueltas:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="prendas_devueltas" id="prendas_devueltas" placeholder="Prendas devueltas" onkeypress="return solo_Numeros(event)">
            </div>
        </div>

        <div class="row">
            <!-- Tipo de error -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo de error:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_error" id="id_tipo_error">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_error as $list)
                        <option value="{{ $list->id_tipo_error }}">{{ $list->nom_tipo_error }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Responsable -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Responsable:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_responsable" id="id_responsable">
                    <option value="0">Seleccione</option>
                    @foreach ($list_responsable as $list)
                        <option value="{{ $list->id_responsable }}">{{ $list->nom_responsable }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="row">
            <!-- Solución -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Solución:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="solucion" name="solucion">
                    <option value="0">Seleccione</option>
                    <option value="1">SI</option>
                    <option value="2">NO</option>
                </select>
            </div>
        </div>

        <div class="row">
            <!-- Observación -->
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Observación:</label>
            </div>
            <div class="form-group col-lg-10">
                <textarea class="form-control" name="observacion" id="observacion" rows="5" placeholder="Observación"></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Error_Picking();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Error_Picking() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('errorespicking.store') }}";

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
</script>