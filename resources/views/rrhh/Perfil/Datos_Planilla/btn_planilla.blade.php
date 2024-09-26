
<a title="Agregar Dato Planilla" class="btn btn-danger" title="Registrar" onclick="Valida_Planilla_Activa('<?php echo $get_id[0]['id_usuario']; ?>')" >
    Agregar
</a>
<!-- Boton modal nuevo dato planilla-->
<a style="display:none" id="btn_registrar_planilla" class="btn btn-danger" title="Registrar" data-toggle="modal" data-target="#ModalRegistro"
    app_reg="{{ url('ColaboradorController/Modal_Dato_Planilla/' . $get_id[0]['id_usuario'] . '/' . count($list_datos_planilla)) }}">
</a>