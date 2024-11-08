<div class="modal-header">
    <h5 class="modal-title"><b>Crear Marca</b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<div class="modal-body" style="max-height:500px; overflow:auto;">
    <div class="col-md-12 row">
        <div class="form-group col-md-12">
            <label class="control-label text-bold" style="color:black">La marca debe establecerse entre: <?php
                                                                                                            if ($tipo_marcacion == 1) {
                                                                                                                echo $get_marca[0]->hora_entrada . " y " . $get_marca[0]->hora_entrada_hasta;
                                                                                                            } elseif ($tipo_marcacion == 2) {
                                                                                                                echo $get_marca[0]->hora_descanso_e . " y " . $get_marca[0]->hora_descanso_e_hasta;
                                                                                                            } elseif ($tipo_marcacion == 3) {
                                                                                                                echo $get_marca[0]->hora_descanso_s . " y " . $get_marca[0]->hora_descanso_s_hasta;
                                                                                                            } elseif ($tipo_marcacion == 4) {
                                                                                                                echo $get_marca[0]->hora_salida . " y " . $get_marca[0]->hora_salida_hasta;
                                                                                                            } ?>
            </label>
            <input type="hidden" name="hora_min" id="hora_min" value="<?php
                                                                        if ($tipo_marcacion == 1) {
                                                                            echo $get_marca[0]->hora_entrada;
                                                                        } elseif ($tipo_marcacion == 2) {
                                                                            echo $get_marca[0]->hora_descanso_e;
                                                                        } elseif ($tipo_marcacion == 3) {
                                                                            echo $get_marca[0]->hora_descanso_s;
                                                                        } elseif ($tipo_marcacion == 4) {
                                                                            echo $get_marca[0]->hora_salida;
                                                                        } ?>">
            <input type="hidden" name="hora_max" id="hora_max" value="<?php
                                                                        if ($tipo_marcacion == 1) {
                                                                            echo $get_marca[0]->hora_entrada_hasta;
                                                                        } elseif ($tipo_marcacion == 2) {
                                                                            echo $get_marca[0]->hora_descanso_e_hasta;
                                                                        } elseif ($tipo_marcacion == 3) {
                                                                            echo $get_marca[0]->hora_descanso_s_hasta;
                                                                        } elseif ($tipo_marcacion == 4) {
                                                                            echo $get_marca[0]->hora_salida_hasta;
                                                                        } ?>">
        </div>
    </div>
    <div class="col-md-12 row">
        <div class="form-group col-md-3">
            <label class="control-label text-bold">Hora de marca: </label>
        </div>
        <div class="form-group col-md-4">
            <input type="time" name="hora_marcacion_nr" id="hora_marcacion_nr" class="form-control" value="<?php
                                                                                                            if ($tipo_marcacion == 1) {
                                                                                                                echo $get_marca[0]->hora_entrada;
                                                                                                            } elseif ($tipo_marcacion == 2) {
                                                                                                                echo $get_marca[0]->hora_descanso_e;
                                                                                                            } elseif ($tipo_marcacion == 3) {
                                                                                                                echo $get_marca[0]->hora_descanso_s;
                                                                                                            } elseif ($tipo_marcacion == 4) {
                                                                                                                echo $get_marca[0]->hora_salida;
                                                                                                            } ?>">
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="hidden" name="tipo_marcacion_nr" id="tipo_marcacion_nr" value="<?php echo $tipo_marcacion ?>">
    <input type="hidden" name="id_asistencia_inconsistencia_nr" id="id_asistencia_inconsistencia_nr" value="<?php echo $id_asistencia_inconsistencia ?>">
    <button class="btn btn-primary mt-3" onclick="Insert_Reg_Marcacion_Inconsistencia()">Crear</button>
    <button class="btn btn-default mt-3" data-dismiss="modal">Cancelar</button>
</div>

<script>
    $('.basice').select2({
        dropdownParent: $('#ModalUpdate')
    });

    $('#zero-configgmm').DataTable({
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
            "sEmptyTable": "No hay datos disponibles en la tabla",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });
</script>