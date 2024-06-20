<style>
    .flatpickr-current-month .numInputWrapper {
        width: 7ch;
        width: 7ch\0;
        display: inline-block;
    }
</style>
<link href="<?=base_url() ?>template/fileinput/css/fileinput.min.css" rel="stylesheet">

<form id="formulario_documento" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Actualizar Documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="col-md-12 row">
            <div class="form-group col-md-6">
                <label class="col-sm-12 control-label text-bold">Adjuntar Nuevo: </label>
                <div class="col">
                    <input name="documentoe" id="documentoe" type="file" class="file" data-allowed-file-extensions='["png|jpg|pdf"]'  size="100" required >
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="col-sm-12 control-label text-bold">Documento: </label>
                <input type="hidden" id="documento_bd" name="documento_bd" value="<?php echo $get_id[0]['documento'] ?>">
                <div class="col-md">
                    <?php if ($get_id[0]['documento']!="") { ?>
                    <a href="<?php echo $url[0]['url_config'].$get_id[0]['documento']; ?> "size="100" target="_blank" ></a>
                    <div id="d_pdf" >
                        <iframe id="pdf" src="<?php echo $url[0]['url_config'].$get_id[0]['documento']; ?>" > </iframe>
                    </div>
                    <div id="pdf-main-container">
                        <div id="pdf-contents">
                            <canvas id="pdf-canvas"  height=10 0 width=195></canvas>
                            <div id="pdf-meta">
                                <div id="pdf-buttons">
                                </div>
                            </div> 
                        </div>
                    </div>
                    <?php } else { echo "No ha adjuntado ningún documento"; } ?> 
                </div>
            </div> 
        </div>
    </div>

    <div class="modal-footer">
        <input name="cod_amonestacion" type="hidden" class="form-control" id="cod_amonestacion" value="<?php echo $get_id[0]['cod_amonestacion']; ?>">
        <input name="id_amonestacion" type="hidden" class="form-control" id="id_amonestacion" value="<?php echo $get_id[0]['id_amonestacion']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Update_Documento_Amonestacion();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script src="<?= base_url() ?>template/fileinput/js/fileinput.min.js"></script>
<script>
    var ss = $(".basic").select2({
        tags: true
    });
    $('.basic').select2({
        dropdownParent: $('#ModalUpdate')
    });
</script>
