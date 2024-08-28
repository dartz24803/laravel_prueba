<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation"> 
    <div class="modal-header">
        <h5 class="modal-title">Editar reproceso:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha documento: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" name="fecha_documentoe" id="fecha_documentoe" value="<?php echo $get_id[0]['fecha_documento']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="documentoe" id="documentoe" placeholder="Documento" value="<?php echo $get_id[0]['documento']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Usuario: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="usuarioe" id="usuarioe">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_usuario as $list){ ?> 
                        <option value="<?php echo $list['id']; ?>"
                        <?php if($list['id']==$get_id[0]['usuario']){ echo "selected"; } ?>>
                            <?php echo $list['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" name="descripcione" id="descripcione" placeholder="Descripción" value="<?php echo $get_id[0]['descripcion']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="cantidade" id="cantidade" placeholder="Cantidad" onkeypress="return soloNumeros(event);" value="<?php echo $get_id[0]['cantidad']; ?>">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Proveedor: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" name="proveedore" id="proveedore" placeholder="Proveedor" value="<?php echo $get_id[0]['proveedor']; ?>">
            </div>  
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Status: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_re" id="estado_re">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['estado_r']==1){ echo "selected"; } ?>>PENDIENTE</option>
                    <option value="2" <?php if($get_id[0]['estado_r']==2){ echo "selected"; } ?>>EN PROCESO</option>
                    <option value="3" <?php if($get_id[0]['estado_r']==3){ echo "selected"; } ?>>REPORTADO</option>
                </select>
            </div>  
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id" name="id" value="<?php echo $get_id[0]['id']; ?>">
        <button class="btn btn-primary" onclick="Update_Reproceso();" type="button">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Reproceso(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_update'));
        var url = "{{ url('Reproceso/Update_Reproceso') }}";
        var csrfToken = $('input[name="_token"]').val();

        //if (Valida_Update_Reproceso()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El orden ya existe!",
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
                            Lista_Reproceso();
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
        //}
    }
</script>
  

