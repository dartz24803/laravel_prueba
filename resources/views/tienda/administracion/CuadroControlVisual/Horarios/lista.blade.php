<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Base</th>
            <th>Puesto</th>
            <th>Dia</th>
            <th>Horario</th>
            <th class="no-content"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list_horarios as $list) {  ?>
            <tr class="text-center">
                <td><?php echo $list['cod_base']; ?></td>
                <td>
                    <?php echo $list['puesto']; ?>
                    <a href="javascript:void(0);" title="Agregar horario al puesto" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Modal_Agregar_Horarios_Cuadro_Control/' . $list['id_horarios_cuadro_control']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </a>
                </td>
                <td>
                    <?php
                    if ($list['dia'] == 1) {
                        echo 'Lunes';
                    } else if($list['dia'] == 2) {
                        echo 'Martes';
                    } else if($list['dia'] == 3) {
                        echo 'Miercoles';
                    } else if($list['dia'] == 4) {
                        echo 'Jueves';
                    } else if($list['dia'] == 5) {
                        echo 'Viernes';
                    } else if($list['dia'] == 6) {
                        echo 'Sabado';
                    } else if($list['dia'] == 7) {
                        echo 'Domingo';
                    }else{
                        echo '- -';
                    }
                    ?>
                </td>
                <td>
                    <?php if ($list['ini_refri'] == '00:00:00' && $list['fin_refri'] && $list['ini_refri2'] == '00:00:00' && $list['fin_refri2'] == '00:00:00') {
                        $horario = $list['hora_entrada'] . ' ' . $list['hora_salida'];
                    } else if ($list['ini_refri2'] == '00:00:00' && $list['fin_refri2'] == '00:00:00') {
                        $horario = $list['hora_entrada'] . ' ' . $list['ini_refri'] . ' ' . $list['fin_refri'] . ' ' . $list['hora_salida'];
                    } else {
                        $horario = $list['hora_entrada'] . ' ' . $list['ini_refri'] . ' ' . $list['fin_refri'] . ' ' . $list['ini_refri2'] . ' ' . $list['fin_refri2'] . ' ' . $list['hora_salida'] . ' ';
                    }
                    echo $horario;
                    ?>
                </td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Modal_Update_Horarios_Cuadro_Control/' . $list['id_horarios_cuadro_control']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>

                    <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Horarios_Cuadro_Control('<?php echo $list['id_horarios_cuadro_control']; ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#zero-config').DataTable({
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
