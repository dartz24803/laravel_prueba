<form id="formulario_editar_estadocivil" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Estado Civil: <b><?php echo $get_id[0]['nom_estado_civil']; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Código: </label>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" id="cod_estado_civil_e" name="cod_estado_civil_e" value="<?php echo $get_id[0]['cod_estado_civil']; ?>" placeholder="Código">
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-3 control-label text-bold">Descripción: </label>
            </div>            
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id="nom_estado_civil_e" name="nom_estado_civil_e" value="<?php echo $get_id[0]['nom_estado_civil']; ?>" placeholder="Ingresar Tipo de Documento" autofocus>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <input name="id_estado_civil" type="hidden" class="form-control" id="id_estado_civil" value="<?php echo $get_id[0]['id_estado_civil']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Edit_Estado_Civil();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
  
<script>
    function Edit_Estado_Civil() {
        var csrfToken = $('input[name="_token"]').val();
        var dataString = new FormData(document.getElementById('formulario_editar_estadocivil'));
        var url = "{{ url('ColaboradorConfController/Update_Estado_Civil') }}";

            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
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
                        TablaEstadoCivil();
                        $("#ModalUpdate .close").click()
                    });
                }
            });
    }
</script>

