<!-- Formulario Mantenimiento -->
<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="form-group col-md-12">
            <label for="my-input">Codigo : <span class="text-danger">*</span></label>
            <div class="form-group col-lg-12">
                <select class="form-control basic_i" name="codigo" id="codigo">
                    <option value="0">Seleccionar</option>
                    <?php //foreach($list_codigos as $list){ ?>
                        <option value="<?php //echo $list['descripcion']; ?>"><?php //echo $list['descripcion'];?></option>
                    <?php //} ?>
                </select>
            </div>
        </div>
        
        <div class="row d-flex justify-content-center mb-2 mt-2">
            <button type="button" class="btn btn-secondary" id="boton_camara" onclick="Activar_Camara();">Activar cámara</button>
        </div>
        <div class="row d-flex justify-content-center mb-2" id="div_camara" style="display:none !important;">
            <video id="video" autoplay style="max-width: 95%;"></video>
        </div>
        <div class="row d-flex justify-content-center mb-2 mt-2" id="div_tomar_foto" style="display:none !important;">
            <button type="button" class="btn btn-info" onclick="Tomar_Foto();">Tomar foto</button>
        </div>
        <div class="row d-flex justify-content-center text-center" id="div_canvas" style="display:none !important;">
            <canvas id="canvas" width="640" height="480" style="max-width:95%;"></canvas>
        </div>
        
        <div id="imagen-container" class="d-flex justify-content-center ml-4">
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary mt-3" onclick="Registrar_Reporte_Fotografico();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<style>
    .select2-container--default .select2-results > .select2-results__options {
        height: 3rem;
    }
    .select2-results__option {
        color: red;
    }
</style>