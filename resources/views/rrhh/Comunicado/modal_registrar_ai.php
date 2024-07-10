<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Anuncio Intranet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Base: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" name="cod_base" id="cod_base">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_base as $list){ ?>
                        <option value="<?= $list['cod_base']; ?>"><?= $list['cod_base'];?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Orden: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="orden" name="orden" placeholder="Orden" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Url: </label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="url" name="url" placeholder="Url">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Imagen: </label>
            </div>
            <div id="div_input_file" class="form-group col-lg-6">
                <input name="imagen" id="imagen" type="file"  class="form-control-file" onchange="return Validar_Archivo('')">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="publicado">Publicado: </label>
            </div>
            <div class="form-group col-lg-2">
                <input type="checkbox" id="publicado" name="publicado" value="1">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" type="button" onclick="Insert_Anuncio_Intranet();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Anuncio_Intranet() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "<?= site_url(); ?>Recursos_Humanos/Insert_Anuncio_Intranet";

        if (Valida_Anuncio_Intranet('')) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                processData: false,
                contentType: false,
                success: function(data) {
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
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Anuncio_Intranet();
                            $("#ModalRegistro .close").click();
                        });
                    }
                }
            });
        }
    }
</script>