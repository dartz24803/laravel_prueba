<style>
    .img-presentation-small-actualizar {
        width: 100%;
        height: 184px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }
</style>

<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Anuncio Intranet</h5>
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
                <select class="form-control" name="cod_basee" id="cod_basee">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_base as $list){ ?>
                        <option value="<?= $list['cod_base']; ?>"
                        <?= ($get_id[0]['cod_base']==$list['cod_base']) ? "selected" : ""; ?>>
                            <?= $list['cod_base']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Orden: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="ordene" name="ordene" placeholder="Orden" value="<?= $get_id[0]['orden']; ?>" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Url: </label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="urle" name="urle" placeholder="Url" value="<?= $get_id[0]['url']; ?>">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Imagen Actual:</label>
            </div>
            <div class="form-group col-lg-4">
                <?php if ($get_id[0]['imagen']!="") { ?>
                    <img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" src="<?= $get_id[0]['imagen']; ?>">
                <?php } ?>
            </div>

            <div class="form-group col-lg-2">
                <label>Nueva Imagen: </label>
            </div>
            <div id="div_input_file" class="form-group col-lg-4">
                <input name="imagene" id="imagene" type="file" class="form-control-file" onchange="return Validar_Archivo('e');">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="publicadoe">Publicado: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="checkbox" id="publicadoe" name="publicadoe" value="1" <?= ($get_id[0]['publicado']=="1") ? "checked" : ""; ?>>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_bolsa_trabajo" name="id_bolsa_trabajo" value="<?= $get_id[0]['id_bolsa_trabajo']; ?>">
        <button class="btn btn-primary" type="button" onclick="Update_Anuncio_Intranet();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow',
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    function Update_Anuncio_Intranet() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ url('Update_Anuncio_Intranet') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Anuncio_Intranet('e')) {
            $.ajax({
                url: url,
                data:dataString,
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: 'Actualización Denegada',
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
                            Lista_Anuncio_Intranet();
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
    }
</script>
