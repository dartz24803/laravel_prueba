<input type="hidden" id="observacion_validacion" name="observacion_validacion">
<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <?php if($mod==2){
                if($estadoi==0 || $estadoi==1){?>
                    <th><div align="center"><input type="checkbox" id="total" name="total" onclick="seleccionart();" value="1"></div></th>
                <?php }else{?> 
                
                <?php }
                ?> 
                
            <?php }else{?> <?php } ?>
            <th>Código</th>
            <th>Usuario</th>
            <th>Estilo</th>
            <th>Descripción</th>
            <th>Color</th>
            <th>Talla</th>
            <?php if($mod==2){?> 
                <th>Cantidad</th> 
            <?php }else{?> 
                <th>Cantidad Solicitado</th>
                <th>Cantidad Empaquetado</th>
                <th>Saldo</th>
            <?php }?>
            <th>Observación</th>
            <th>Estado</th>
            <?php if($mod==1){?> 
                <th class="no-content">Acciones</th>
            <?php }?>
           
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_requerimiento as $list) {  ?>   
        <tr style="background-color:<?php if($list['estado_requerimiento']==1){ echo "#e2a03f75";}else{
            if($list['estado_requerimiento']==4){echo "#11dd5e87";}else{
                if($list['estado_requerimiento']==2){
                    if($list['nuevo']=="1"){echo "#1b55e22e";}else{
                        if($list['saldo']>0){echo "#d1e21b36";}
                        if($list['saldo']<0){echo "#e7515a4d";}
                    }
                }else{
                    if($list['nuevo']=="1"){
                        echo "#1b55e22e";
                    }else{
                            if($list['saldo']>0){echo "#d1e21b36";}
                            if($list['saldo']<0){echo "#e7515a4d";}
                        }}}}?>">
            <?php if($mod==2){
                if($list['estado_requerimiento']==3){?>
                <td  class="text-center">
                    <input required type="checkbox" id="codigo[]" name="codigo[]" value="<?php echo $list['codigo']; ?>">
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Logistica/Modal_Validacion_Mercaderia') ?>/<?php echo $list["codigo"]; ?>/<?php echo $anio ?>/<?php echo $mes ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </a>
                </td>
                
                <?php }else{
                    if($estadoi==0){?>
                    <td></td>
                    <?php }
                }?> 
            <?php }?>
            <td><?php echo $list['codigo']; ?></td>
            <td><?php echo $list['tipo_usuario']; ?></td>
            <td><?php echo $list['estilo']; ?></td>
            <td><?php echo $list['descripcion']; ?></td>
            <td><?php echo $list['color']; ?></td>
            <td><?php echo $list['talla']; ?></td>
            <?php if($mod==2){?> 
                <td><?php echo $list['empaquetado']; ?></td>
            <?php }else{?> 
                <td><?php echo $list['cant_solicitado']; ?></td>
                <td><?php echo $list['empaquetado']; ?></td>
                <td><?php echo $list['saldo']; ?></td>    
            <?php }?>
            <?php if($mod==2){?> 
                <td><?php echo $list['observacion_validaf']; ?></td>
            <?php }else{?>
                <td><?php echo $list['obs_logistica']; ?></td>    
            <?php }?>
            
            <td><?php echo $list['desc_estado_requerimiento']; ?></td>
            <?php if($mod==1){?> 
                <td class="text-center">
                    <?php if($list['estado_requerimiento']==2){?>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Logistica/Modal_Update_Mercaderia_Fotografia') ?>/<?php echo $list["codigo"]; ?>/<?php echo $anio ?>/<?php echo $mes ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Mercaderia_Fotografia('<?php echo $list['codigo']; ?>','<?php echo $anio ?>','<?php echo $mes ?>')" id="delete" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>   
                    <?php }?>
                </td>   
            <?php }?>
            
        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    $('#zero-config').DataTable({
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [50, 70, 100],
        "pageLength": 50
    });

    function seleccionart(){
        if (document.getElementById('total').checked)
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='codigo')
                    inp[i].checked=1;
            }
        }else
        {
            var inp=document.getElementsByTagName('input');
            for(var i=0, l=inp.length;i<l;i++){
                if(inp[i].type=='checkbox' && inp[i].name.split('[]')[0]=='codigo')
                    inp[i].checked=0;
            }
        }
    }
</script>