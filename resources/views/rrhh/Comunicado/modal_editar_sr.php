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
        <h5 class="modal-title">Editar Slider RRRHH</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label for="tipoe" class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-lg-2">
                <select name="tipoe" id="tipoe" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="2" <?= ($get_id[0]['base']==2) ? "selected" : ""; ?>>Tienda</option>
                    <?php foreach($list_base as $list){?> 
                        <option value="<?= $list['cod_base']; ?>" 
                        <?= ($get_id[0]['base']==$list['cod_base']) ? "selected" : ""; ?>>
                            <?= $list['cod_base']; ?>
                        </option>  
                    <?php }?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label for="ordene" class="control-label text-bold">Orden</label>
            </div>            
            <div class="form-group col-lg-2">
                <input type="text" name="ordene" id="ordene" class="form-control" value="<?= $get_id[0]['orden'] ?>" placeholder="Ingresar orden" onkeypress="return solo_Numeros(event);" maxlength="6">
            </div>

            <div class="form-group col-lg-2">
                <label for="entrada_slidee" class="control-label text-bold">Tiempo de Entrada:<a href="#" title="La aparicion del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped"><div class="divdea">?</div><span class="title-tooltip">La aparicion del slide va de 0.1s hasta 2.0</span></a></label>
            </div>            
            <div class="form-group col-lg-2">
                <input type="text" name="entrada_slidee" id="entrada_slidee" value="<?= $get_id[0]['entrada_slide'] ?>" placeholder="Ingresar tiempo de entrada" class="form-control" maxlength="3" onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label for="salida_slide" class="control-label text-bold">Tiempo de salida:<a href="#" title="La desaparción del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped"><div class="divdea">?</div><span class="title-tooltip">La desaparción del slide va de 0.1s hasta 2.0</span></a></label>
            </div>            
            <div class="form-group col-lg-2">
                <input type="text" name="salida_slidee" id="salida_slidee" value="<?= $get_id[0]['salida_slide'] ?>" placeholder="Ingresar tiempo de salida" class="form-control" maxlength="3" onkeypress="return solo_Numeros_Punto(event);">
            </div>

            <div class="form-group col-lg-2">
                <label for="duracion" class="control-label text-bold">Tiempo de duracion:<a href="#" title="Especificado en segundos y solo perimite nùmeros enteros" class="anchor-tooltip tooltiped"><div class="divdea">?</div><span class="title-tooltip">Especificado en segundos y solo perimite nùmeros enteros</span></a></label>
            </div>
            <div class="form-group col-lg-2">
                <input type="text" name="duracione" id="duracione" value="<?= $get_id[0]['duracion'] ?>" placeholder="Ingresar tiempo de duración" class="form-control" maxlength="3" onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label for="tipo_slide" class="control-label text-bold">Tipo&nbsp;de Slide:</label>
            </div> 
            <div class="form-group col-lg-2">
                <select name="tipo_slidee" class="form-control" id="tipo_slidee">
                    <option value="0">Seleccione
                    </option>
                    <option value="1" <?= ($get_id[0]['tipo_slide']==1) ? "selected" : ""; ?>>Imagen</option>
                    <option value="2" <?= ($get_id[0]['tipo_slide']==2) ? "selected" : ""; ?>>Video</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label for="tituloe" class="control-label text-bold">Título:</label>
            </div>            
            <div class="form-group col-lg-10">
                <input type="text" name="tituloe" value="<?= $get_id[0]['titulo'] ?>" id="tituloe" placeholder="Ingresar título" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label for="descripcion" class="control-label text-bold">Descripción de Slide:</label>
            </div>            
            <div class="form-group col-lg-10">
                <textarea name="descripcione" cols="40" rows="2" id="descripcione" placeholder="Ingresar descripción" class="form-control"><?= $get_id[0]['descripcion'] ?></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Archivo Actual:</label>
            </div>     
            <div class="form-group col-lg-4">
                <?php if(substr($get_id[0]['archivoslide'],-3) === "mp4"){ ?>
                    <video loading="lazy" class="img-thumbnail img-presentation-small-actualizar" controls>
                        <source class="img_post img-thumbnail img-presentation-small-actualizar" src="<?= $get_id[0]['archivoslide']; ?>" type="video/mp4">
                    </video>
                <?php } else {?>
                    <img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar" src="<?= $get_id[0]['archivoslide']; ?>">
                <?php } ?>                     
            </div>

            <div class="form-group col-lg-2">
                <label for="videoslide" class="control-label text-bold">Nuevo Archivo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="file" name="archivoslidee" id="archivoslidee" class="form-control-file" onchange="return Validar_Archivo('e')">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="id_slide" type="hidden" id="id_slide" value="<?= $get_id[0]['id_slide']; ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Slider_Rrhh();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".img_post").click(function () {
        window.open($(this).attr("src"), 'popUpWindow', 
        "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no')");
    });

    function Update_Slider_Rrhh() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "<?php echo site_url(); ?>Recursos_Humanos/Update_Slider_Rrhh";

        if (Valida_Slider_Rrhh('e')) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Slider_Rrhh();
                        $("#ModalUpdateSlide .close").click();
                    });
                }
            });
        }
    }
</script>