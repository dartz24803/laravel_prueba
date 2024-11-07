<?php 
$id_nivel = session('usuario')->id_nivel;
$id_puesto = session('usuario')->id_puesto;
$id_usuario = session('usuario')->id_usuario;
?>
<form id="form_reclutamiento"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Reclutamiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">    
            <input  type="hidden" required class="form-control" id="nivel" name="nivel" value="<?php echo $id_nivel ?>">
            <input  type="hidden" required class="form-control" id="puesto" name="puesto" value="<?php echo $id_puesto ?>">
            <div class="form-group col-md-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-md-4">
                <?php if($id_puesto!=314){ ?>
                <select name="id_area" id="id_area" class="form-control basic" onchange="Buscar_Puesto_Area('1')">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_area as $list){?>
                        <option value="<?php echo $list->id_area ?>"><?php echo $list->nom_area ?></option>
                    <?php }?>
                </select>
                <?php }else{ ?>
                <input type="hidden" id="id_area" name="id_area" value="<?= session('usuario')->id_area ?>">
                <select name="id_area_s" id="id_area_s" class="form-control basic" onchange="Buscar_Puesto_Area('1')" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_area as $list){ ?>
                        <option value="<?php echo $list->id_area ?>" <?php if(session('usuario')->id_area==$list->id_area){ echo "selected"; }?>><?php echo $list->nom_area ?></option>
                    <?php }?>
                </select>
                <?php } ?>
            </div>
            <div class="form-group col-md-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-md-4" id="cmb_puesto">
                <select name="id_puesto" id="id_puesto" class="form-control basic">
                    <option value="0">Seleccione</option>
                </select>
            </div>
            <?php if($id_nivel==1 || $id_nivel==2 || $id_puesto==21){?> 
            <div class="form-group col-md-2">
                <label>Solicitante:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_solicitante" id="id_solicitante" class="form-control basic">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_colaborador as $list){?>
                        <option value="<?php echo $list['id_usuario'] ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                    <?php }?>
                </select>
            </div> 
            <div class="form-group col-md-2">
                <label>Evaluador:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_evaluador" id="id_evaluador" class="form-control basic">
                    <option value="0">Seleccione</option>
                    <?php //foreach($list_rrhh as $list){?>
                    <?php foreach($list_colaborador as $list){?>
                        <option value="<?php echo $list['id_usuario'] ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                    <?php }?>
                </select>
            </div>    
            <?php }else{?> 
                <input type="hidden" name="id_solicitante" id="id_solicitante" value="<?php echo $id_usuario ?>">
                <input type="hidden" name="id_evaluador" id="id_evaluador" value="<?php echo $_SESSION['usuario'][0]['id_usuario'] ?>">
            <?php }?>
            <div class="form-group col-md-2">
                <label>Vacantes: </label>
            </div>
            <div class="form-group col-md-4">
                <input  type="text" required class="form-control" id="vacantes" name="vacantes" onkeypress="return soloNumeros(event)">
            </div>

            <div class="form-group col-md-2" >
                <label>Centro Labores:</label>
            </div>
            <div class="form-group col-md-4">
                <?php if($id_puesto!=314){ ?>
                <select name="cod_base" id="cod_base" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_base as $list){?>
                        <option value="<?php echo $list->cod_base ?>" ><?php echo $list->cod_base ?></option>
                    <?php }?>
                </select>
                <?php }else{ ?>
                    <input type="hidden" id="cod_base" name="cod_base" value="<?= $_SESSION['usuario'][0]['centro_labores'] ?>">
                    <input type="text" class="form-control" id="centro_labores" name="centro_labores" value="<?= $_SESSION['usuario'][0]['centro_labores'] ?>" disabled>
                <?php } ?>
            </div>
            <div class="form-group col-md-2" >
                <label>Modalidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_modalidad_laboral" id="id_modalidad_laboral" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_modalidad_laboral as $list){?>
                        <option value="<?php echo $list['id_modalidad_laboral'] ?>" ><?php echo $list['nom_modalidad_laboral'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-md-2" >
                <label>Tipo Remuneración:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="tipo_sueldo" id="tipo_sueldo" class="form-control" onchange="Tipo_Sueldo('1')">
                    <option value="0">Seleccione</option>
                    <option value="1">Fijo</option>
                    <option value="2">Banda</option>
                </select>
            </div>
            <div class="form-group col-md-2" id="lbl_sueldo" style="display:none">
                <label class="control-label text-bold">Sueldo: </label>
            </div>
            <div class="form-group col-md-4" id="inp_sueldo" style="display:none">
                <input type="text" class="form-control" name="sueldo" id="sueldo" placeholder="" onkeypress="return soloNumeros(event)">
            </div>
            <div class="form-group col-md-2" id="lbl_desde" style="display:none">
                <label class="control-label text-bold">Desde: </label>
            </div>
            <div class="form-group col-md-4" id="inp_desde" style="display:none">
                <input type="text" class="form-control" name="desde" id="desde" placeholder="" onkeypress="return soloNumeros(event)">
            </div>
            <div class="form-group col-md-2" id="lbl_a" style="display:none">
                <label class="control-label text-bold">A: </label>
            </div>
            <div class="form-group col-md-4" id="inp_a" style="display:none">
                <input type="text" class="form-control" name="a" id="a" placeholder="" onkeypress="return soloNumeros(event)">
            </div>
            <?php if($id_nivel==1 || $id_nivel==2 || $id_puesto==21){?> 
            <div class="form-group col-md-2" >
                <label>Asignado a:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_asignado" id="id_asignado" class="form-control basic">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_rrhh as $list){?>
                        <option value="<?php echo $list['id_usuario'] ?>"><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                    <?php }?>
                </select>
            </div>
            <?php }?>
            <div class="form-group col-md-2" >
                <label>Prioridad:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="prioridad" id="   " class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="1">Baja</option>
                    <option value="2">Media</option>
                    <option value="3">Alta</option>
                </select>
            </div>
            <div class="form-group col-md-2" >
                <label>Fecha de Vencimiento:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" name="fec_cierre" id="fec_cierre" class="form-control">
            </div>
            
            <div class="form-group col-md-2" >
                <label>Observaciones:</label>
            </div>
            <div class="form-group col-md-4">
                <textarea name="observacion" id="observacion" cols="30" rows="3" class="form-control"></textarea>
            </div>
        </div>

        <div class="modal-footer">
            <button class="btn btn-primary mt-3" type="button" onclick="Insert_Reclutamiento();">Guardar</button>
            <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
        </div>
    </div>
</form> 

<script>
    var ss = $(".basic").select2({
        tags: true
    });

    $('.basic').select2({
        dropdownParent: $('#ModalRegistroGrande')
    });
    <?php if(session('usuario')->id_puesto==314){ ?>
        Buscar_Puesto_Area('1');
    <?php } ?>
    
    function Buscar_Puesto_Area(t){
        Cargando();
        v="";
        if(t==2){
            v="e";
        }
        var id_area=$('#id_area'+v).val();
        var url = "{{ url('Reclutamiento/Buscar_Puesto_Area') }}/" + id_area + "/" + t;
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#cmb_puesto'+v).html(resp);
            }
        });
    }
    
    function Insert_Reclutamiento() {
        Cargando();

        var dataString = new FormData(document.getElementById('form_reclutamiento'));
        var url = "{{ url('Reclutamiento/Insert_Reclutamiento') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: dataString,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    swal.fire(
                        'Registro Denegado!',
                        'Existe un registro con los mismos datos',
                        'error'
                    ).then(function() {
                    });
                }else{
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga click en el botón',
                        'success'
                    ).then(function() {
                        $("#ModalRegistroGrande .close").click()
                        Buscador_Reclutamiento('1');
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

    function soloNumeros(e) {
        var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        //letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
        letras = "0123456789",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }

    function Tipo_Sueldo(t) {
        Cargando();
        v="";
        if(t==2){
            v="e";
        }
        var lbl_sueldo = document.getElementById("lbl_sueldo"+v);
        var inp_sueldo = document.getElementById("inp_sueldo"+v);
        var lbl_desde = document.getElementById("lbl_desde"+v);
        var inp_desde = document.getElementById("inp_desde"+v);
        var lbl_a = document.getElementById("lbl_a"+v);
        var inp_a = document.getElementById("inp_a"+v);
        
        $('#sueldo'+v).val('');
        $('#desde'+v).val('');
        $('#a'+v).val('');
        if ($('#tipo_sueldo'+v).val()==1){
            lbl_sueldo.style.display = "block";
            inp_sueldo.style.display = "block";
            lbl_desde.style.display = "none";
            inp_desde.style.display = "none";
            lbl_a.style.display = "none";
            inp_a.style.display = "none";
        }if($('#tipo_sueldo'+v).val()==2){
            lbl_sueldo.style.display = "none";
            inp_sueldo.style.display = "none";
            lbl_desde.style.display = "block";
            inp_desde.style.display = "block";
            lbl_a.style.display = "block";
            inp_a.style.display = "block";
        }if($('#tipo_sueldo'+v).val()==0){
            lbl_sueldo.style.display = "none";
            inp_sueldo.style.display = "none";
            lbl_desde.style.display = "none";
            inp_desde.style.display = "none";
            lbl_a.style.display = "none";
            inp_a.style.display = "none";
        }
    }
</script>
