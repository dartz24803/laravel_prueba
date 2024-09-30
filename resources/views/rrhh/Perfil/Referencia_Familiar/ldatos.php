<?php if(count($list_referenciafu)>0) { ?>
<table class="table" id="tableMain3">
    <thead>
        <tr class="tableheader">
            <th>Nombre de Familiar</th>
            <th>Parentesco</th>
            <th>Fecha de Nacimiento</th>
            <th>Celular</th>
            <th>Celular 2</th>
            <th>Teléfono fijo</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($list_referenciafu as $list){ ?>
        <tr>
            <td><?php echo $list['nom_familiar'] ; ?></td>
            <td><?php echo $list['nom_parentesco'] ; ?></td>
            <td><?php echo $list['dia_nac']."/".$list['mes_nac']."/".$list['anio_nac'] ; ?></td>
            <td><?php echo $list['celular1'] ; ?></td>
            <td><?php echo $list['celular2'] ; ?></td>
            <td><?php echo $list['fijo'] ; ?></td>
            <td>
                <?php if($editable==0){?>
                <a href="javascript:void(0);" title="Editar" onclick="Detalle_Referencia_Familiar('<?php echo $list['id_referencia_familiar']; ?>')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                </svg>
                </a>
                <?php }?>
            </td>
            <td>
                <?php if($editable==0){?>
                <a title="Eliminar" onclick="Delete_Referencia_Familiar('<?php echo $list['id_referencia_familiar']; ?>','<?php echo $list['id_usuario']; ?>')" id="delete" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                </a>
                <?php }?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<?php } ?>
