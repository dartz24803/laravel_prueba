<table id="zero-config323" class="table " style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th class="no-content"></th>
            <th>Estado</th>
            <th>Colaborador</th>
            <th>Base/OFC</th>
            <th>Motivo</th>
            <th>Destino</th>
            <th>Especificación</th>
            <th>Trámite</th>
            <th>Especificación</th>
            <th>Fecha</th>
            <th>H. Salida</th>
            <th>H. Retorno</th>
            <th>H. Real Salida</th>
            <th>H. Real Retorno</th>
            <th>Fecha Registro</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_papeletas_salida as $list) {  ?>
        <tr>
            <td><?= $list['fec_solicitud'] ?></td>
            <td class="text-center">
                <?php if( $list['estado_solicitud']=='1' || $list['estado_solicitud']=='4' || $list['estado_solicitud']=='5'){ ?>
                    <?php if($acciones==1){ ?>
                    <a href="#" class="" title="Aprobar Papeleta" onclick="Aprobado_solicitud_papeletas_1('<?php echo $list['id_solicitudes_user']; ?>');" id="Eliminar" role="button">
                        <svg id="Layer_1" enable-background="new 0 0 512.063 512.063" height="24" viewBox="0 0 512.063 512.063" width="24" xmlns="http://www.w3.org/2000/svg"><g><g><ellipse cx="256.032" cy="256.032" fill="#00df76" rx="255.949" ry="256.032"/></g><path d="m256.032 0c-.116 0-.231.004-.347.004v512.055c.116 0 .231.004.347.004 141.357 0 255.949-114.629 255.949-256.032s-114.592-256.031-255.949-256.031z" fill="#00ab5e"/><path d="m111.326 261.118 103.524 103.524c4.515 4.515 11.836 4.515 16.351 0l169.957-169.957c4.515-4.515 4.515-11.836 0-16.351l-30.935-30.935c-4.515-4.515-11.836-4.515-16.351 0l-123.617 123.615c-4.515 4.515-11.836 4.515-16.351 0l-55.397-55.397c-4.426-4.426-11.571-4.526-16.119-.226l-30.83 29.149c-4.732 4.475-4.837 11.973-.232 16.578z" fill="#fff5f5"/><path d="m370.223 147.398c-4.515-4.515-11.836-4.515-16.351 0l-98.187 98.187v94.573l145.473-145.473c4.515-4.515 4.515-11.836 0-16.352z" fill="#dfebf1"/></g></svg>
                    </a>
                    <a href="#" class="" title="Desaprobar Papeleta" onclick="Anular_solicitud_papeletas_1('<?php echo $list['id_solicitudes_user']; ?>')" id="Eliminar" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </a>
                    <?php }elseif($acciones==2){ ?>
                        <a href="#" class="" title="Aprobar Papeleta" onclick="Aprobado_solicitud_papeletas_2('<?php echo $list['id_solicitudes_user']; ?>');" id="Eliminar" role="button">
                            <svg id="Layer_1" enable-background="new 0 0 512.063 512.063" height="24" viewBox="0 0 512.063 512.063" width="24" xmlns="http://www.w3.org/2000/svg"><g><g><ellipse cx="256.032" cy="256.032" fill="#00df76" rx="255.949" ry="256.032"/></g><path d="m256.032 0c-.116 0-.231.004-.347.004v512.055c.116 0 .231.004.347.004 141.357 0 255.949-114.629 255.949-256.032s-114.592-256.031-255.949-256.031z" fill="#00ab5e"/><path d="m111.326 261.118 103.524 103.524c4.515 4.515 11.836 4.515 16.351 0l169.957-169.957c4.515-4.515 4.515-11.836 0-16.351l-30.935-30.935c-4.515-4.515-11.836-4.515-16.351 0l-123.617 123.615c-4.515 4.515-11.836 4.515-16.351 0l-55.397-55.397c-4.426-4.426-11.571-4.526-16.119-.226l-30.83 29.149c-4.732 4.475-4.837 11.973-.232 16.578z" fill="#fff5f5"/><path d="m370.223 147.398c-4.515-4.515-11.836-4.515-16.351 0l-98.187 98.187v94.573l145.473-145.473c4.515-4.515 4.515-11.836 0-16.352z" fill="#dfebf1"/></g></svg>
                        </a>
                        <a href="#" class="" title="Desaprobar Papeleta" onclick="Anular_solicitud_papeletas_2('<?php echo $list['id_solicitudes_user']; ?>')" id="Eliminar" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </a>
                    <?php } ?>
                <?php }else{?>

                <?php } ?>
            </td>
            <td class='text-center'>
                <?php
                    if( $list['estado_solicitud']=='1'){
                        echo "<span class='shadow-none badge badge-warning'>En proceso</span>";
                    }else if ($list['estado_solicitud']=='2'){
                        echo "<span class='shadow-none badge badge-primary'>Aprobado</span>";
                    }else if ($list['estado_solicitud']=='3'){
                        echo " <span class='shadow-none badge badge-danger'>Denegado</span>";
                    }else if ($list['estado_solicitud']=='4'){
                        echo " <span class='shadow-none badge badge-warning'>En proceso - Aprobación Gerencia</span>";
                    }else if ($list['estado_solicitud']=='5'){
                        echo " <span class='shadow-none badge badge-warning'>En proceso - Aprobación RRHH</span>";
                    }else{
                        echo "<span class='shadow-none badge badge-primary'>Error</span>";
                    }
                ?>
            </td>
            <td><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
            <td><?php echo $list['cod_base']; ?></td>

            <td>
                <?php
                    if( $list['id_motivo']==1){
                        echo "Laboral";
                    }else if ($list['id_motivo']==2){
                        echo "Personal";
                    }else{
                        echo $list['motivo'];
                    }
                ?>
            </td>
            <td>
                <?php echo $list['destino']; ?>
            </td>
            <td>
                <?php echo $list['especificacion_destino']; ?>
            </td>
            <td>
                <?php echo $list['tramite']; ?>
            </td>
            <td>
                <?php echo $list['especificacion_tramite']; ?>
            </td>
            <td data-order="<?= $list['fec_solicitud'] ?>">
                <?php
                    echo date_format(date_create($list['fec_solicitud']), "d/m/Y");
                ?>
            </td>
            <td>
                <?php
                    if($list['sin_ingreso'] == 1 ){
                        echo "Sin Ingreso";
                    }else{
                        echo $list['hora_salida'];
                    }
                ?>
            </td>
            <td>
                <?php
                    if($list['sin_retorno'] == 1 ){
                        echo "Sin Retorno";
                    }else{
                        echo $list['hora_retorno'];
                    }
                ?>
            </td>
            <td>
                <?php if( $list['sin_ingreso']==1){
                        echo "Sin Ingreso";
                    }else{
                        if($list['horar_salida']!="00:00:00"){
                            echo $list['horar_salida'];
                        }
                    }
                    ?>
            </td>
            <td>
                    <?php if($list['sin_retorno'] == 1 ){
                            echo "Sin Retorno";
                        }else{
                            echo $list['hora_retorno'];
                        }
                ?>
            </td>
            <td><?php echo date_format(date_create($list['fec_reg']), "d/m/Y H:i:s"); ?></td>

        </tr>
    <?php } ?>
    </tbody>
</table>

<script>
    document.title = 'Papeletas Aprobacion';
    $('#zero-config323').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        order: [[1, "asc"]],
        responsive: true,
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
        "sLengthMenu": "Resultados :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10,
        "columnDefs": [
            {
                'targets': 0, // Índice de la columna que quieres ocultar
                'visible': false // Oculta la columna
            }
        ],
    });
</script>
