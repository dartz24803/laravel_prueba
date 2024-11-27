<?php //print_r($get_id[0]);?>
<div class="modal-header bg-primary">
    <h5 class="modal-title"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>
<div class="modal-body text-center" style="max-height:450px; overflow:auto;">
    <div id="foto_normal" class="mb-4 mt-4">
        <img id="foto_<?= $get_id[0]['id'] ?>" loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" src="" alt="Evidencia" style="width: 22rem;">
    </div>
    <div class="col-sm-12 row p-4 d-flex align-items-center">
        <div class="col-sm-4">
            <!--<span class="badge badge-dark" style="font-size: 3rem;"><?//= $get_id[0]['base'] ?></span>-->
            <span class="badge badge-dark" style="font-size: 2rem; padding: 0.8rem"><?= $get_id[0]['base'] ?></span>
        </div>
        <div class="col-sm-4">
            <span><?= $get_id[0]['descripcion'] ?></span><br>
            <span><?= $get_id[0]['fec_reg'] ?></span>
        </div>
        <div class="col-sm-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="form-check">
                    <button class="btn btn-warning" value="90" name="orientation" id="rotateButton" onclick="Rotar_Imagen_RF()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-ccw"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="form-group d-flex justify-content-center">
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" id="prev-button" class="btn btn-secondary" data-prev-id="{{ $prev }}">⬅ Anterior</button>
    <button type="button" id="next-button" class="btn btn-secondary" data-next-id="{{ $next }}">Siguiente ➡</button>
    <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>
<script>
    $(document).ready(function() {
        AbrirImagen();
        EzPlus();
        const prevId = parseInt($('#prev-button').data('prev-id'));
        const nextId = parseInt($('#next-button').data('next-id'));// Deshabilitar botones si prevId o nextId son 0
        if (prevId === 0) {
            $('#prev-button').attr('disabled', true);
        }

        if (nextId === 0) {
            $('#next-button').attr('disabled', true);
        }
    });

    function AbrirImagen(){
        const timestamp = new Date().getTime();
        const imgUrl = `https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/<?= $get_id[0]['foto'] ?>?${timestamp}`; // Agrega el parámetro único a la URL
        document.getElementById("foto_<?= $get_id[0]['id'] ?>").src = imgUrl;
    }
    
    function EzPlus(){
        $(".img_post").ezPlus({
            scrollZoom: true,
            zoomLevel: 0.5, // Aumenta este valor para más zoom
            zIndex: 1000,
            zoomWindowWidth: 600, // Ancho del cuadro de zoom
            zoomWindowHeight: 600, // Altura del cuadro de zoom
            zoomWindowOffetx: 10, // Desplazamiento horizontal del cuadro
            zoomWindowPosition: 1 // Posición del cuadro (1: derecha de la imagen)
        });
    }

    var rotationAngle_<?= $get_id[0]['id'] ?> = 0;
    var popupWindow = null;

    $(document).on("click", ".img_post", function () {
        var imgSrc = $(this).attr("src");
        var imgElement = $(this)[0];
        var rotationAngle = imgElement.dataset.rotation || 0;

        if (popupWindow && !popupWindow.closed) {
            popupWindow.focus();
            return;
        }

        popupWindow = window.open("", 'popUpWindow', "height=" + imgElement.naturalHeight + ",width=" + imgElement.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no");
        popupWindow.document.write('<html><head><title>Image Zoom</title></head><body style="margin:0;display:flex;justify-content:center;align-items:center;"><img src="' + imgSrc + '" style="transform:rotate(' + rotationAngle + 'deg); max-width:100%; height:auto;"></body></html>');
        popupWindow.focus();
    });

    function Rotar_Imagen_RF(){
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var id = <?= $get_id[0]['id'] ?>;
        var url = "{{ url('ReporteFotografico/Rotar_Imagen_RF' ) }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'id': id,
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                AbrirImagen();
                EzPlus();
            }
        });
    }

    $('#prev-button').on('click', function() {
        var prevId = {{ $prev }};
        if (prevId) {
            $("#ModalUpdate .close").click()
            $("#detalle_"+prevId).click()
        } else {
            Swal.fire(
                '¡Ups!',
                'No hay reporte previo',
                'error'
            );
        }
    });

    $('#next-button').on('click', function() {
        var nextId = {{ $next }}
        if (nextId) {
            $("#ModalUpdate .close").click()
            $("#detalle_"+nextId).click()
        } else {
            Swal.fire(
                '¡Ups!',
                'No hay reporte siguiente',
                'error'
            );
        }
    });
</script>
<style>
    .zoomContainer{
        z-index: 9999 !important;
    }
    .select2-container--default .select2-results > .select2-results__options {
        height: 5rem;
    }
    .select2-results__option {
        color: red;
    }
    .modal-content{
        height: 50rem;
    }

    .modal-body{
        max-height: none !important;
        height: 40rem;
    }
    .select2-hidden-accessible {
        position: static !important;
    }
</style>