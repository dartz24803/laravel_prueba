<form id="formulario_perchae"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Percha: <b><?php echo $get_id[0]['nom_percha']; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row"> 
            <div class="form-group col-md-2">
                <label>Nombre:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="nom_perchae" name="nom_perchae" maxlength="2" placeholder="Ingresar Nombre" value="<?php echo $get_id[0]['nom_percha']; ?>" autofocus>
            </div>
        </div>  	 	           	                	        
    </div>
    <div class="modal-footer">
        <input name="id_percha" type="hidden" class="form-control" id="id_percha" value="<?php echo $get_id[0]['id_percha']; ?>">
        <button class="btn btn-primary btn-sm mt-3" type="button" onclick="Update_Percha();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>
    
    function Update_Percha() {
        Cargando();

        var dataString = $("#formulario_perchae").serialize();
        var url = "{{ url('MercaderiaConf/Update_Percha') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: dataString,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: 'Actualización Denegada',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        TablaPercha();
                        $("#ModalUpdate .close").click();
                        
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