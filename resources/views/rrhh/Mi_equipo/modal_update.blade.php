<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Actualizar Datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Usuario: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="usuario_codigo" name="usuario_codigo" placeholder="Código de Usuario" value="<?php echo $get_id['0']['usuario_codigo'];?>" autofocus readonly>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Contraseña: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="password" class="form-control" id="usuario_password" name="usuario_password" placeholder="Contraseña" autofocus>
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $get_id['0']['id_usuario'];?>" placeholder="Contraseña" autofocus>
    <button class="btn btn-primary mt-3" type="button" onclick="Update_Miequipo();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Miequipo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ url('MiEquipo/Update_Miequipo') }}";
        var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $("#ModalUpdate .close").click();
                    });
                }
            });
    }
</script>
