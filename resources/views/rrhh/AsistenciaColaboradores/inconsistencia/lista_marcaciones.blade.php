<table id="" class="table table-hover non-hover" style="width:100%">
    <thead>
        <tr>
            <th class="text-center td_marcacion" width="5%">Visible</th>
            <th class="text-center td_marcacion" width="10%">Hora</th>
            <th class="text-center td_marcacion" width="80%">Tipo</th>
            <th class="no-content td_marcacion" width="5%"></th>
            <!--<th class="text-center">Observación</th>
            <th class="no-content"></th> -->
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_marcacionesh as $list) {
            $id_asistencia_detalle = $list['id_asistencia_detalle']; ?>
            <tr>
                <td class="text-center td_marcacion"><input type="checkbox" name="visible_id<?php echo $id_asistencia_detalle ?>" id="visible_id<?php echo $id_asistencia_detalle ?>" value="1" <?php if ($list['visible'] == 1) {
                                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                                } ?>></td>
                <td class="text-center td_marcacion">
                    <input type="time" name="hora_marcacion<?php echo $id_asistencia_detalle ?>" id="hora_marcacion<?php echo $id_asistencia_detalle ?>" value="<?php echo $list['marcacion'] ?>" class="form-control">
                </td>
                <td class="text-center td_marcacion">
                    <select name="tipo_marcacion<?php echo $id_asistencia_detalle ?>" id="tipo_marcacion<?php echo $id_asistencia_detalle ?>" class="form-control" style="padding:0px">
                        <option value="0">Seleccione</option>
                        <option value="1" <?php if ($list['tipo_marcacion'] == 1) {
                                                echo "selected";
                                            } ?>>Entrada</option>
                        <option value="2" <?php if ($list['tipo_marcacion'] == 2) {
                                                echo "selected";
                                            } ?>>Salida a refrigerio</option>
                        <option value="3" <?php if ($list['tipo_marcacion'] == 3) {
                                                echo "selected";
                                            } ?>>Entrada de refrigerio</option>
                        <option value="4" <?php if ($list['tipo_marcacion'] == 4) {
                                                echo "selected";
                                            } ?>>Salida</option>
                    </select>
                    <input type="hidden" name="obs_marcacion<?php echo $id_asistencia_detalle ?>" id="obs_marcacion<?php echo $id_asistencia_detalle ?>" value="<?php echo $list['obs_marcacion'] ?>">
                </td>
                <td class="td_marcacion">
                    <button class="btn btn-primary" onclick="Update_Marcacion_Inconsistencia('<?php echo $id_asistencia_detalle ?>')">Guardar</button>
                </td>
                <!--<td>
                    <?php echo $list['obs_marcacion']; ?>
                    <input type="hidden" name="obs_marcacion<?php echo $list['id_asistencia_detalle'] ?>" id="obs_marcacion<?php echo $list['id_asistencia_detalle'] ?>" value="<?php echo $list['obs_marcacion'] ?>">
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Editar" onclick="Div_Upd_Asistencia_Inconsistencia('<?php echo $list['id_asistencia_detalle'] ?>','<?php echo $list['marcacion'] ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                    </a>
                    <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Marcacion_Inconsistencia('<?php echo $list['id_asistencia_detalle'] ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                    </a>
                </td>-->
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#zero-configgmee').DataTable({
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
        var btn = document.getElementById("btn_asignacion_marc");
        <?php if (count($list_marcacionesh) == 0) { ?>
            btn.style.display = "block";
        <?php } else { ?>
            btn.style.display = "none";
        <?php } ?>
    });
</script>