<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Horario:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="basese" id="basese" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_base as $list) { ?>
                        <option value="<?php echo $list['cod_base']; ?>" 
                        <?php if ($list['cod_base'] == $get_id[0]['cod_base']){ echo "selected"; } ?>>
                            <?php echo $list['cod_base']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            
            <div class="form-group col-lg-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" name="puesto" id="puesto" class="form-control" value="<?php echo $get_id[0]['puesto']; ?>" disabled>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-lg-2">
                <label>Día:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control basic" name="dia_n" id="dia_n" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_dia as $list){ ?>
                        <option value="<?= $list['id']; ?>"
                        <?php if($list['id']==$get_id[0]['dia']){ echo "selected"; } ?>>
                            <?= $list['nombre']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Tipo de Refrigerio:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="t_refrigerio_he" id="t_refrigerio_he" class="form-control" onchange="Tipo_Refrigerio_Horarioe()">
                    <option value="1" <?php if($get_id[0]['t_refrigerio_h']==1){ echo "selected"; } ?>>Con almuerzo</option>
                    <option value="2" <?php if($get_id[0]['t_refrigerio_h']==2){ echo "selected"; } ?>>Sin Refrigerio</option>
                    <option value="3" <?php if($get_id[0]['t_refrigerio_h']==3){ echo "selected"; } ?>>Con almuerzo y break</option>
                </select>
            </div>
            
            <div class="form-group col-md-2">
                <label>Entrada:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="hora_entradae" id="hora_entradae" class="form-control" value="<?php echo $get_id[0]['hora_entrada']?>">
            </div>

            <div class="form-group col-md-2">
                <label>Salida:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="hora_salidae" id="hora_salidae" class="form-control" value="<?php echo $get_id[0]['hora_salida']?>">
            </div>
        </div>

        <div class="col-md-12 row" id="break1e">
            <div class="form-group col-md-2">
                <label>Inicio Almuerzo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="ini_refrie" id="ini_refrie" class="form-control" value="<?php echo $get_id[0]['ini_refri']?>">
            </div>

            <div class="form-group col-md-2">
                <label>Fin Almuerzo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="fin_refrie" id="fin_refrie" class="form-control" value="<?php echo $get_id[0]['fin_refri']?>">
            </div>
        </div>

        <div class="col-md-12 row" id="break2e">
            <div class="form-group col-md-2">
                <label>Inicio Break:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="ini_refri2e" id="ini_refri2e" class="form-control" value="<?php echo $get_id[0]['ini_refri2']?>">
            </div>

            <div class="form-group col-md-2">
                <label>Fin Break:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="fin_refri2e" id="fin_refri2e" class="form-control" value="<?php echo $get_id[0]['fin_refri2']?>">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id" value="<?php echo $get_id[0]['id_horarios_cuadro_control']; ?>">
        <button class="btn btn-primary" type="button" onclick="Update_Horarios_Cuadro_Control();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        if(<?= $get_id[0]['t_refrigerio_h'] ?>==1){
            $('#break1e').show();
            $('#break2e').hide();
        }else if(<?= $get_id[0]['t_refrigerio_h'] ?>==3){
            $('#break1e').show();
            $('#break2e').show();
        }else{
            $('#break1e').hide();
            $('#break2e').hide();
        }
    });
    
    function Update_Horarios_Cuadro_Control() {
        Cargando();

        var dataString = $("#formulario_update").serialize();
        var url = "<?php echo site_url(); ?>Tienda/Update_Horarios_Cuadro_Control";
        
        if (Valida_Horarios_Cuadro_Control('e')) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Horarios_Cuadro_Control();
                        $("#ModalUpdate .close").click();
                    });
                }
            });
        }
    }

    function Valida_Horarios_Cuadro_Control(v) {
        return true;
    }

    function Tipo_Refrigerio_Horarioe(){
        var break1 = $("#break1e");
        var break2 = $("#break2e");
        $('#ini_refrie').val(null);
        $('#fin_refrie').val(null);
        $('#ini_refri2e').val(null);
        $('#fin_refri2e').val(null);
        if($('#t_refrigerio_he').val()=="1"){
            break1.show();
            break2.hide();
        }else if($('#t_refrigerio_he').val()=="3"){
            break1.show();
            break2.show();
        }else{
            break1.hide();
            break2.hide();
        }
    }
</script>