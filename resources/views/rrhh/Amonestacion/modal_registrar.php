<style>
    .flatpickr-current-month .numInputWrapper {
        width: 7ch;
        width: 7ch\0;
        display: inline-block;
    }

    .dia_no_hoy {
        display: none;
    }
</style>

<form id="formulario_amonestacion" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registro Amonestación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
    <div class="modal-body" style="max-height:500px; overflow:auto;">
        <div class="col-md-12 row">
            <input type="hidden" id="nivel" name="nivel" value="<?php echo $_SESSION['usuario'][0]['id_nivel'] ?>">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Fecha: </label>
                <div class="col">
                    <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d') ?>">
                </div>
            </div>
            
            <?php if($_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_nivel']==1 || $_SESSION['usuario'][0]['id_puesto']==133){?> 
                <div class="form-group col-md-8">
                    <label class="col-sm-12 control-label text-bold">Solicitante: </label>
                    <div class="col-md">
                        <!--<select class="form-control basic" name="id_solicitante" id="id_solicitante" onchange="Busca_Colaborador_Area('1')">-->
                        <select class="form-control basic" name="id_solicitante" id="id_solicitante" >
                            <option value="0">Seleccione</option>
                            <?php foreach($list_responsables as $list){ ?> 
                                <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'];?></option>
                            <?php }  ?>
                        </select>
                    </div>
                </div>  
            <?php if($_SESSION['usuario'][0]['id_nivel']==2 || $_SESSION['usuario'][0]['id_puesto']==133){?> 
                <input type="hidden" name="estado_amonestacion" id="estado_amonestacion" value="2">     
            <?php }else{?>
                <input type="hidden" name="estado_amonestacion" id="estado_amonestacion" value="1">    
            <?php }}else{?> 
            <input type="hidden" name="id_solicitante" id="id_solicitante" value="<?php echo $_SESSION['usuario'][0]['id_usuario'] ?>">    
            <input type="hidden" name="estado_amonestacion" id="estado_amonestacion" value="1">    
            <?php }?>
            <div class="form-group col-md-8">
                <label class="col-sm-12 control-label text-bold">Colaborador: </label>
                <div class="col-md" id="cmb_colaborador">
                    <select class="form-control multivalue_pps" name="id_usuario[]" id="id_usuario" multiple="multiple">
                        <?php foreach($list_colaborador as $list){ ?> 
                            <option value="<?php echo $list['id_usuario']; ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'];?></option>
                        <?php }  ?>
                    </select>
                </div>
            </div> 
            
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Tipo: </label>
                <div class="col">
                    <select name="tipo" id="tipo" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_tipo_amonestacion as $list){ ?> 
                            <option value="<?php echo $list['id_tipo_amonestacion'] ?>"><?php echo $list['nom_tipo_amonestacion'] ?></option>     
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Gravedad: </label>
                <div class="col">
                    <select name="id_gravedad_amonestacion" id="id_gravedad_amonestacion" class="form-control"><!-- onchange="Cambio_Motivo_Gravedad('1')"-->
                        <option value="0">Seleccione</option>
                        <?php foreach($list_gravedad_amonestacion as$list){ ?> 
                        <option value="<?php echo $list['id_gravedad_amonestacion'] ?>"><?php echo $list['nom_gravedad_amonestacion'] ?></option>    
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Motivo: </label>
                <div class="col" id="cmb_motivo">
                    <select name="motivo" id="motivo" class="form-control">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_motivo_amonestacion as $list){ ?> 
                            <option value="<?php echo $list['id_motivo_amonestacion'] ?>"><?php echo $list['nom_motivo_amonestacion'] ?></option>    
                        <?php }?>
                    </select>
                </div>
            </div>

            <div class="form-group col-md-12">
                <label class="col-sm-12 control-label text-bold">Detalle del suceso: </label>
                <div class="col">
                    <textarea class="form-control" name="detalle" id="detalle" rows="3" placeholder="Ingresar Detalle del suceso"></textarea>
                </div>
            </div> 
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Insert_Amonestacion();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".basic").select2({
        tags: true
    });
    $('.basic').select2({
        dropdownParent: $('#ModalRegistroSlide')
    });
    var ss = $(".multivalue_pps").select2({
        tags: true
    });
    
    $('.multivalue_pps').select2({
        dropdownParent: $('#ModalRegistroSlide')
    });

</script>
