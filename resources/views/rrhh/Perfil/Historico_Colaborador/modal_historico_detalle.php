
<div class="modal-header">
    <h5 class="modal-title"><b>Historial de <?php if($tipo==1){?> Puestos<?php }
    if($tipo==2){?> Ubicaciones <?php }if($tipo==3){?> Modalidad de Trabajo<?php }
    if($tipo==4){?> Horarios<?php }if($tipo==5){ echo "Horas Semanales"; } ?></b></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>

<div class="modal-body" style="max-height:500px; overflow:auto;" >
    <div class="col-md-12 row">
        <?php if($tipo==1){?>
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th><b>Gerencia</b></th>
                        <th><b>Área</b></th>
                        <th><b>Puesto</b></th>
                        <th><b>F.&nbsp;Inicio</b></th>
                        <th><b>F.&nbsp;Fin</b></th>
                        <th><b>Tipo</b></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($list_historico_puesto as $list) {  ?>
                        <tr >
                            <td ><?php echo $list['nom_gerencia']; ?></td>
                            <td ><?php echo $list['nom_area']; ?></td>
                            <td ><?php echo $list['nom_puesto']; ?></td>
                            <td align="center" ><?php if($list['fec_inicio']!="" && $list['fec_inicio']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_inicio']));} ?></td>
                            <td align="center" ><?php if($list['fec_fin']!="" && $list['fec_fin']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_fin']));} ?></td>
                            <td align="center" ><?php echo $list['nom_tipo_cambio']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php }if($tipo==2){?>
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th><b>Ubicaciones</b></th>
                        <th><b>F.&nbsp;Inicio</b></th>
                        <th><b>F.&nbsp;Fin</b></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($list_historico_base as $list) {  ?>
                        <tr >
                            <td align="center"><?php echo $list['centro_labores']; ?></td>
                            <td align="center" ><?php if($list['fec_inicio']!="" && $list['fec_inicio']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_inicio']));} ?></td>
                            <td align="center" ><?php if($list['fec_fin']!="" && $list['fec_fin']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_fin']));} ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php }if($tipo==3){?>
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th><b>Modalidad Laboral</b></th>
                        <th><b>F.&nbsp;Inicio</b></th>
                        <th><b>F.&nbsp;Fin</b></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($list_historico_modalidad as $list) {  ?>
                        <tr >
                            <td align="center"><?php echo $list['nom_modalidad_laboral']; ?></td>
                            <td align="center" ><?php if($list['fec_inicio']!="" && $list['fec_inicio']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_inicio']));} ?></td>
                            <td align="center" ><?php if($list['fec_fin']!="" && $list['fec_fin']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_fin']));} ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php }if($tipo==4){?>
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th><b>Horario</b></th>
                        <th><b>F.&nbsp;Inicio</b></th>
                        <th><b>F.&nbsp;Fin</b></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($list_historico_horario as $list) {  ?>
                        <tr >
                            <td align="center"><?php echo $list['nombre']; ?></td>
                            <td align="center" ><?php if($list['fec_inicio']!="" && $list['fec_inicio']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_inicio']));} ?></td>
                            <td align="center" ><?php if($list['fec_fin']!="" && $list['fec_fin']!="0000-00-00"){echo date('d/m/Y',strtotime($list['fec_fin']));} ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php }?>
        <?php if($tipo==5){ ?>
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr class="text-center">
                        <th><b>Horas Semanales</b></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($list_historico_horas_semanales as $list) {  ?>
                        <tr class="text-center">
                            <td><?php echo $list['horas_semanales']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php }?>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-primary mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>
</div>
<script>
    $(document).ready(function() {
        $('#zero-configprovedor').DataTable({
            "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
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
    });
</script>
