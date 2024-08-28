<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo reproceso</h5> 
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
                <input type="date" class="form-control" name="fecha_documento" id="fecha_documento" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Documento: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="documento" id="documento" placeholder="Documento">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Usuario: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="usuario" id="usuario">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_usuario as $list){ ?> 
                        <option value="<?php echo $list['id']; ?>"><?php echo $list['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Descripción: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="cantidad" id="cantidad" placeholder="Cantidad" onkeypress="return soloNumeros(event);">
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Proveedor: </label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" name="proveedor" id="proveedor" placeholder="Proveedor">
            </div>  
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Status: </label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="estado_r" id="estado_r">
                    <option value="0">Seleccione</option>
                    <option value="1" selected>PENDIENTE</option>
                    <option value="2">EN PROCESO</option>
                    <option value="3">REPORTADO</option>
                </select>
            </div>  
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" type="button" onclick="Insert_Reproceso();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    
    function Insert_Reproceso(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_insert'));
        var url = "{{ url('Reproceso/Insert_Reproceso') }}";
        var csrfToken = $('input[name="_token"]').val();

        //if (Valida_Insert_Reproceso()) {
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
                            text: "¡El reproceso ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Reproceso();
                            $("#ModalRegistro .close").click(); 
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
  