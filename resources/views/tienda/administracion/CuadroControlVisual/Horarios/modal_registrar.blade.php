<form id="formulario_insert"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo horario:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control basic" name="cod_base" id="cod_base" onchange="Traer_Puesto_Horario();">
                    <option value="0">Seleccione</option>
                    <?php foreach ($list_base as $list) { ?>
                        <option value="<?php echo $list['cod_base']; ?>">
                            <?php echo $list['cod_base']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control basic" name="puesto" id="puesto"><!-- onchange="ActualizarSegunPuesto()"-->
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-lg-2">
                <label>Día:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="dia" id="dia">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_dia as $list){ ?>
                        <option value="<?= $list['id']; ?>"><?= $list['nombre']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Tipo de Refrigerio:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="t_refrigerio_h" id="t_refrigerio_h" class="form-control" onchange="Tipo_Refrigerio_Horario()">
                    <option value="1">Con almuerzo</option>
                    <option value="2" selected>Sin Refrigerio</option>
                    <option value="3">Con almuerzo y break</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label>Entrada:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="hora_entrada" id="hora_entrada" class="form-control">
            </div>

            <div class="form-group col-md-2">
                <label>Salida:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="hora_salida" id="hora_salida" class="form-control">
            </div>
        </div>

        <div class="col-md-12 row" id="break1" style="display: none;"> 
            <div class="form-group col-md-2">
                <label>Inicio Almuerzo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="ini_refri" id="ini_refri" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>Fin Almuerzo:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="fin_refri" id="fin_refri" class="form-control">
            </div>
        </div>

        <div class="col-md-12 row" id="break2" style="display: none;"> 
            <div class="form-group col-md-2">
                <label>Inicio Break:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="ini_refri2" id="ini_refri2" class="form-control">
            </div>

            <div class="form-group col-md-2">
                <label>Fin Break:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="fin_refri2" id="fin_refri2" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" type="button" onclick="Insert_Horarios_Cuadro_Control();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Traer_Puesto_Horario(){
        Cargando();

        var cod_base = $('#cod_base').val();
        var url = "<?= site_url() ?>Tienda/Traer_Puesto_Horario";

        $.ajax({
            type: "POST",
            url: url,
            data: {'cod_base':cod_base},
            success: function(data) {
                $('#puesto').html(data);
            }
        });
    }

    function Insert_Horarios_Cuadro_Control() {
        Cargando();

        var dataString = $("#formulario_insert").serialize();
        var url = "<?php echo site_url(); ?>Tienda/Insert_Horarios_Cuadro_Control";

        if (Valida_Horarios_Cuadro_Control('')) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                success: function(data) {
                    swal.fire(
                        'Registro Exitoso!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        <?php if($validador!=1){ ?>
                            Lista_Horarios_Cuadro_Control();
                        <?php } ?>
                        $("#ModalRegistro .close").click();
                    });
                }
            });
        }
    }

    function Valida_Horarios_Cuadro_Control(v) {
        if ($('#cod_base' + v).val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar base.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#puesto' + v).val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar puesto.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#dia' + v).val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar dia.',
                'warning'
            ).then(function() {});
            return false;
        }
        if ($('#t_refrigerio_h' + v).val() == '1') {
            if ($('#hora_entrada' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de entrada.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#hora_salida' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de salida.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#ini_refri' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de inicio de almuerzo.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#fin_refri' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de fin de almuerzo.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#t_refrigerio_h' + v).val() == '2') {
            if ($('#hora_entrada' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de entrada.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#hora_salida' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de salida.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        if ($('#t_refrigerio_h' + v).val() == '3') {
            if ($('#hora_entrada' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de entrada.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#hora_salida' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de salida.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#ini_refri' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de inicio de almuerzo.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#fin_refri' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de fin de almuerzo.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#ini_refri2' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de inicio de break.',
                    'warning'
                ).then(function() {});
                return false;
            }
            if ($('#fin_refri2' + v).val() === '') {
                Swal(
                    'Ups!',
                    'Debe ingresar hora de fin de break.',
                    'warning'
                ).then(function() {});
                return false;
            }
        }
        return true;
    }

    function Tipo_Refrigerio_Horario(){
        var break1 = $("#break1");
        var break2 = $("#break2");
        $('#ini_refri').val(null);
        $('#fin_refri').val(null);
        $('#ini_refri2').val(null);
        $('#fin_refri2').val(null);
        if($('#t_refrigerio_h').val()=="1"){
            break1.show();
            break2.hide();
        }else if($('#t_refrigerio_h').val()=="3"){
            break1.show();
            break2.show();
        }else{
            break1.hide();
            break2.hide();
        }
    }

    /*function ActualizarSegunPuesto() {
        var cargoSeleccionado = document.getElementById("puesto").value;

        // Dependiendo del valor seleccionado, actualiza el segundo select
        switch (cargoSeleccionado) {
            case "CAJERO PRINCIPAL":
                $("#t_refrigerio_h").val("3");
                Tipo_Refrigerio_Horario();
                break;
            case "COORDINADOR JR. DE TIENDA":
                $("#t_refrigerio_h").val("3");
                Tipo_Refrigerio_Horario();
                break;
            case "COORDINADOR SR. DE TIENDA":
                $("#t_refrigerio_h").val("3");
                Tipo_Refrigerio_Horario();
                break;
            default:
                $("#t_refrigerio_h").val("0");
                Tipo_Refrigerio_Horario();
                break;
        }
    }*/
</script>
