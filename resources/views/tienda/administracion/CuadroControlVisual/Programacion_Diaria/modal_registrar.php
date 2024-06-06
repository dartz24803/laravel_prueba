<form id="formulario_horario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Programación Diaria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Base: </label>
                <div>
                    <select class="form-control" id="cod_base" name="cod_base" onchange="Traer_Puesto_Programacion_Diaria();">
                        <option value="0">Seleccione</option>
                        <?php foreach($list_base as $list){?>
                            <option value="<?php echo $list['cod_base']; ?>">
                                <?php echo $list['cod_base']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="form-group col-lg-4">
                <label class="control-label text-bold">Puesto: </label>
                <div>
                    <select class="form-control" id="id_puesto" name="id_puesto" onchange="Traer_Colaborador_Programacion_Diaria(); Traer_Horario_Programacion_Diaria('lu',1); Traer_Horario_Programacion_Diaria('ma',2); Traer_Horario_Programacion_Diaria('mi',3); Traer_Horario_Programacion_Diaria('ju',4); Traer_Horario_Programacion_Diaria('vi',5); Traer_Horario_Programacion_Diaria('sa',6); Traer_Horario_Programacion_Diaria('do',7);">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Colaborador: </label>
                <div>
                    <select class="form-control" id="id_usuario" name="id_usuario">
                        <option value="0">Seleccione</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Selecciona los días laborados: </label>
            </div>
        </div>

        <div class="col-lg-12 row">
            <div class="form-group col-lg-12">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_lu" name="ch_dia_laborado_lu" value="1" checked onclick="Mostrar_Dias_Laborados('lu')">
                    <span class="new-control-indicator"></span>&nbsp;Lunes
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_ma" name="ch_dia_laborado_ma" value="1" checked onclick="Mostrar_Dias_Laborados('ma')">
                    <span class="new-control-indicator"></span>&nbsp;Martes
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_mi" name="ch_dia_laborado_mi" value="1" checked onclick="Mostrar_Dias_Laborados('mi')">
                    <span class="new-control-indicator"></span>&nbsp;Miércoles
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_ju" name="ch_dia_laborado_ju" value="1" checked onclick="Mostrar_Dias_Laborados('ju')">
                    <span class="new-control-indicator"></span>&nbsp;Jueves
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_vi" name="ch_dia_laborado_vi" value="1" checked onclick="Mostrar_Dias_Laborados('vi')">
                    <span class="new-control-indicator"></span>&nbsp;Viernes
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_sa" name="ch_dia_laborado_sa" value="1" onclick="Mostrar_Dias_Laborados('sa')">
                    <span class="new-control-indicator"></span>&nbsp;Sábado
                </label>

                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_dia_laborado_do" name="ch_dia_laborado_do" value="1" onclick="Mostrar_Dias_Laborados('do')">
                    <span class="new-control-indicator"></span>&nbsp;Domingo
                </label>
            </div>
        </div>

        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
            <li class="nav-item"> 
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Conf. Básica</a>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent"> 
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="col-lg-12 row ">
                    <div class="form-group col-lg-2 conf_basica_lu">
                        <label class="control-label text-bold">Lunes: </label>
                    </div>
                    <div class="form-group col-lg-4 conf_basica_lu">
                        <select name="id_horario_lu" id="id_horario_lu" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                
                    <div class="form-group col-lg-2 conf_basica_ma">
                        <label class="control-label text-bold">Martes: </label>
                    </div>
                    <div class="form-group col-lg-4 conf_basica_ma">
                        <select name="id_horario_ma" id="id_horario_ma" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-2 conf_basica_mi">
                        <label class="control-label text-bold">Miércoles: </label>
                    </div>
                    <div class="form-group col-lg-4 conf_basica_mi">
                        <select name="id_horario_mi" id="id_horario_mi" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-2 conf_basica_ju">
                        <label class="control-label text-bold">Jueves: </label>
                    </div>
                    <div class="form-group col-lg-4 conf_basica_ju">
                        <select name="id_horario_ju" id="id_horario_ju" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-2 conf_basica_vi">
                        <label class="control-label text-bold">Viernes: </label>
                    </div>
                    <div class="form-group col-lg-4 conf_basica_vi">
                        <select name="id_horario_vi" id="id_horario_vi" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-2 conf_basica_sa">
                        <label class="control-label text-bold">Sábado: </label>
                    </div>
                    <div class="form-group col-lg-4 conf_basica_sa">
                        <select name="id_horario_sa" id="id_horario_sa" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>

                    <div class="form-group col-lg-2 conf_basica_do">
                        <label class="control-label text-bold">Domingo: </label>
                    </div>
                    <div class="form-group col-lg-4 conf_basica_do">
                        <select name="id_horario_do" id="id_horario_do" class="form-control">
                            <option value="0">Seleccione</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Programacion_Diaria();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $(".conf_basica_sa").hide();
        $(".conf_basica_do").hide();
    });

    function Traer_Puesto_Programacion_Diaria(){
        Cargando();

        var cod_base = $('#cod_base').val();
        var url = "<?= site_url() ?>Tienda/Traer_Puesto_Horario";

        $.ajax({
            type: "POST",
            url: url,
            data: {'cod_base':cod_base},
            success: function(data) {
                $('#id_puesto').html(data);
                $('#id_usuario').html('<option value="0">Seleccione</option>');
                $('#id_horario_lu').html('<option value="0">Seleccione</option>');
                $('#id_horario_ma').html('<option value="0">Seleccione</option>');
                $('#id_horario_mi').html('<option value="0">Seleccione</option>');
                $('#id_horario_ju').html('<option value="0">Seleccione</option>');
                $('#id_horario_vi').html('<option value="0">Seleccione</option>');
                $('#id_horario_sa').html('<option value="0">Seleccione</option>');
                $('#id_horario_do').html('<option value="0">Seleccione</option>');
            }
        });
    }

    function Traer_Colaborador_Programacion_Diaria(){
        Cargando();

        var cod_base = $('#cod_base').val();
        var id_puesto = $('#id_puesto').val();
        var url = "<?= site_url() ?>Tienda/Traer_Colaborador_Programacion_Diaria";

        $.ajax({
            type: "POST",
            url: url,
            data: {'cod_base':cod_base,'id_puesto':id_puesto},
            success: function(data) {
                $('#id_usuario').html(data);
            }
        });
    }

    function Traer_Horario_Programacion_Diaria(dia,num){
        Cargando();

        var cod_base = $('#cod_base').val();
        var id_puesto = $('#id_puesto').val();
        var url = "<?= site_url() ?>Tienda/Traer_Horario_Programacion_Diaria";

        $.ajax({
            type: "POST",
            url: url,
            data: {'cod_base':cod_base,'id_puesto':id_puesto,'dia':num},
            success: function(data) {
                $('#id_horario_'+dia).html(data);
            }
        });
    }

    function Mostrar_Dias_Laborados(dia){
        $('#id_horario_'+dia).val('0');
        if ($('#ch_dia_laborado_'+dia).is(":checked")){
            $(".conf_basica_"+dia).show();
        }else{
            $(".conf_basica_"+dia).hide();
        }
    }

    function Insert_Programacion_Diaria() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_horario'));
        var url = "<?php echo site_url(); ?>Tienda/Insert_Programacion_Diaria";

        if (Valida_Programacion_Diaria()) {
            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Programacion_Diaria();
                        $("#ModalRegistroSlide .close").click()
                    });
                }
            });
        }
    }

    function Valida_Programacion_Diaria() {
        if ($('#cod_base').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar base.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_puesto').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar puesto.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#id_usuario').val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar colaborador.',
                'warning'
            ).then(function() { });
            return false;
        }
        if(!$('#ch_dia_laborado_lu').is(":checked") && !$('#ch_dia_laborado_ma').is(":checked") && 
        !$('#ch_dia_laborado_mi').is(":checked") && !$('#ch_dia_laborado_ju').is(":checked") && 
        !$('#ch_dia_laborado_vi').is(":checked") && !$('#ch_dia_laborado_sa').is(":checked") && 
        !$('#ch_dia_laborado_do').is(":checked")){
            Swal(
                'Ups!',
                'Debe seleccionar al menos un día de la semana.',
                'warning'
            ).then(function() { });
            return false;
        }
        if($('#ch_dia_laborado_lu').is(":checked")){
            if($('#id_horario_lu').val()=="0"){
                Swal(
                    'Ups!',
                    'Debe seleccionar horario para Lunes.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ch_dia_laborado_ma').is(":checked")){
            if($('#id_horario_ma').val()=="0"){
                Swal(
                    'Ups!',
                    'Debe seleccionar horario para Martes.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ch_dia_laborado_mi').is(":checked")){
            if($('#id_horario_mi').val()=="0"){
                Swal(
                    'Ups!',
                    'Debe seleccionar horario para Miércoles.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ch_dia_laborado_ju').is(":checked")){
            if($('#id_horario_ju').val()=="0"){
                Swal(
                    'Ups!',
                    'Debe seleccionar horario para Jueves.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ch_dia_laborado_vi').is(":checked")){
            if($('#id_horario_vi').val()=="0"){
                Swal(
                    'Ups!',
                    'Debe seleccionar horario para Viernes.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ch_dia_laborado_sa').is(":checked")){
            if($('#id_horario_sa').val()=="0"){
                Swal(
                    'Ups!',
                    'Debe seleccionar horario para Sábado.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        if($('#ch_dia_laborado_do').is(":checked")){
            if($('#id_horario_do').val()=="0"){
                Swal(
                    'Ups!',
                    'Debe seleccionar horario para Domingo.',
                    'warning'
                ).then(function() { });
                return false;
            }
        }
        return true;
    }
</script>
