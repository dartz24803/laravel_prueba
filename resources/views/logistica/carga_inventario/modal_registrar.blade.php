<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Inventario

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
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha: </label>
                <div class="">
                    <input type="date" id="fecha" name="fecha" value="<?php echo date('Y-m-d') ?>" class="form-control">
                </div>
            </div>

            <!-- Pertenece -->
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Base:</label>
                <select class="form-control" id="base" name="base">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                    <option value="BEC">BEC</option>
                </select>

            </div>


            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Responsable:</label>

                <select class="form-control" id="responsable" name="responsable">
                    <option value="0">Seleccione</option>
                    @foreach ($list_usuario as $list)
                    <option value="{{ $list->id_usuario }}">{{ $list->usuario_nombres }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="modal-footer">
            @csrf
            <button class="btn btn-primary" type="button" onclick="Insert_Carga_Inventario();">Guardar</button>
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
        </div>
</form>

<script>
    function Insert_Carga_Inventario() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ route('cargainventario.store') }}";

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