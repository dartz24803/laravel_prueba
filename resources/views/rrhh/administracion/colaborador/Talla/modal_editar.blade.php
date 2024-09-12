<form id="formulario_editar_talla" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Talla: <b><?php echo $get_id[0]['nom_talla']; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Accesorio:</label>
            </div>
            <div class="form-group col-sm-5">
            <select class="form-control" name="id_accesorio" id="id_accesorio">
                <option value="0"  <?php if (!(strcmp(0, $get_id[0]['id_accesorio']))) {echo "selected=\"selected\"";} ?>  >Seleccione</option>
                <?php foreach($list_accesorio as $list){ ?>
                    <option value="<?php echo $list['id_accesorio']; ?>" <?php if (!(strcmp($list['id_accesorio'], $get_id[0]['id_accesorio']))) {echo "selected=\"selected\"";} ?>  ><?php echo $list['nom_accesorio'];?></option>
                <?php } ?>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Talla:</label>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" id="cod_talla" name="cod_talla" value="<?php echo $get_id[0]['cod_talla']; ?>" placeholder="Talla">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id="nom_talla" name="nom_talla" value="<?php echo $get_id[0]['nom_talla']; ?>" placeholder="Ingresar descripción" autofocus>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_talla" type="hidden" class="form-control" id="id_talla" value="<?php echo $get_id[0]['id_talla']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Edit_Talla();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
  
<script>
    function Edit_Talla() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_editar_talla'));
        var url = "{{ url('ColaboradorConfController/Update_Talla') }}";
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
                        $("#ModalUpdate .close").click();
                        TablaTalla();
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
