<form id="formulario_registro_nacionalidad" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nacionalidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Código País: </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" id="pais_nacionalidad" name="pais_nacionalidad" placeholder="País" autofocus>
            </div>
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Nacionalidad: </label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id="nom_nacionalidad" name="nom_nacionalidad" placeholder="Ingresar nacionalidad" autofocus>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Nacionalidad();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Nacionalidad() {
        var dataString = $("#formulario_registro_nacionalidad").serialize();
        var url = "{{ url('ColaboradorConfController/Insert_Nacionalidad') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        TablaNacionalidad();
                        $("#ModalRegistro .close").click()
                    });
                }
            },
            error:function(xhr) {
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
