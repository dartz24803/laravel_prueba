<?php if(count($list_experiencial)>0) { ?>
    <table class="table" id="tableMain3">
        <thead>
            <tr class="tableheader">
            <th>Empresa</th>
            <th>Cargo</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Fin</th>
            <th>Motivo de Salida</th>
            <th>Remuneración</th>
            <th>Referencia Laboral</th>
            <th>Número de Contacto</th>
            <th></th>
            <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($list_experiencial as $list){ ?>
            <tr>
                <td><?php echo $list['empresa'] ; ?></td>
                <td><?php echo $list['cargo'] ; ?></td>
                <td><?php echo $list['dia_ini']."/".$list['mes_ini']."/".$list['anio_ini'] ; ?></td>
                <td><?php echo $list['dia_fin']."/".$list['mes_fin']."/".$list['anio_fin'] ; ?></td>
                <td><?php echo $list['motivo_salida'] ; ?></td>
                <td><?php echo $list['remuneracion'] ; ?></td>
                <td><?php echo $list['nom_referencia_labores'] ; ?></td>
                <td><?php echo $list['num_contacto'] ; ?></td>
                <td>
                    <a href="javascript:void(0);" title="Editar" onclick="Detalle_ExperenciaL('<?php echo $list['id_experiencia_laboral']; ?>')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                    </svg>
                    </a>
                </td>
                <td>
                    <a class="" title="Eliminar" onclick="Delete_ExperenciaL('<?php echo $list['id_experiencia_laboral']; ?>')" id="delete" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>