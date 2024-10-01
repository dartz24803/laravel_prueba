<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Tipo:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">

            <div class="form-group col-lg-6">
                <label for="cod_conclusion">Código:</label>
                <input type="text" class="form-control" id="cod_tipo_ocurrencia" name="cod_tipo_ocurrencia" placeholder="Ingresar código">
            </div>

            <div class="form-group col-lg-6">
                <label for="nom_conclusion">Nombre:</label>
                <input type="text" class="form-control" id="nom_tipo_ocurrencia" name="nom_tipo_ocurrencia" placeholder="Ingresar nombre">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6">
                <label>Base:</label>

                <select class="form-control multivalue" name="cod_base[]" id="cod_base" multiple="multiple">
                    @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label>Conclusión:</label>
                <select class="form-control" name="id_conclusion" id="id_conclusion">
                    <option value="0">Seleccione</option>
                    @foreach ($list_conclusion as $list)
                    <option value="{{ $list->id_conclusion }}">{{ $list->nom_conclusion }}</option>
                    @endforeach
                </select>
            </div>

        </div>


        <div class="modal-footer">
            @csrf
            <button class="btn btn-primary" type="button" onclick="Insert_Servicio();">Guardar</button>
            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
        </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Insert_Servicio() {

        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('ocurrencia_conf_to.store') }}";

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
                        Lista_Servicio();
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
</script>