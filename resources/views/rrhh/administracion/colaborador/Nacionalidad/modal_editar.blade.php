<form id="formulario_editar_nacionalidad" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Nacionalidad: <b><?php echo $get_id[0]['nom_nacionalidad']; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Código País: </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" id="pais_nacionalidad_e" name="pais_nacionalidad_e" value="<?php echo $get_id[0]['pais_nacionalidad']; ?>" placeholder="país">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Nacionalidad: </label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id="nom_nacionalidad_e" name="nom_nacionalidad_e" value="<?php echo $get_id[0]['nom_nacionalidad']; ?>" placeholder="Ingresar nacionalidad" autofocus>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_nacionalidad" type="hidden" class="form-control" id="id_nacionalidad" value="<?php echo $get_id[0]['id_nacionalidad']; ?>">
        @csrf
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Edit_Nacionalidad();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>


<script>

    function Edit_Nacionalidad() {
        var dataString = new FormData(document.getElementById('formulario_editar_nacionalidad'));
        var url = "{{ url('ColaboradorConfController/Update_Nacionalidad') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: dataString,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: 'Actualización Denegada',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        TablaNacionalidad();
                        $("#ModalUpdate .close").click()
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
