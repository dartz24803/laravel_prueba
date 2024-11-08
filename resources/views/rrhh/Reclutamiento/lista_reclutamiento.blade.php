<?php
$id_nivel = session('usuario')->id_nivel;
?>
<table id="zero-config<?php echo $pestania ?>" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha de Registro</th>
            <th>Puesto</th>
            <th>Sede</th>
            <th>Vacantes</th>
            <th>Pendientes</th>
            <th>Asignado a</th>
            <?php  if($id_nivel==1 || $id_nivel==2){?>
            <th>Prioridad</th>
            <?php }?>
            <th>Estado</th>
            <th>Vencimiento</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php $t_vacantes=0;$t_pendientes=0; foreach($list_reclutamiento as $list){
            $t_vacantes=$t_vacantes+$list['vacantes'];
            $t_pendientes=$t_pendientes+($list['vacantes']-$list['reclutados']);
            ?>
        <tr>
            <td><?php echo $list['id_reclutamiento'] ?></td>
            <td><?php echo $list['fecha_registro']; ?></td>
            <td><?php echo $list['nom_puesto']; ?></td>
            <td><?php echo $list['cod_ubi']; ?></td>
            <td><?php echo $list['vacantes']; ?></td>
            <td><?php echo ($list['vacantes']-$list['reclutados']); ?></td>
            <td><?php echo $list['asignado_a']; ?></td>
            <?php  if($id_nivel==1 || $id_nivel==2){?>
                <td><?php echo $list['nom_prioridad']; ?></td>
            <?php } ?>
            <td><?php echo $list['nom_estado_reclutamiento']; ?></td>

            <td><?php if($list['fecha_cierre']!="00-00-0000"){echo $list['fecha_cierre'];} ?></td>
            <td>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                        <?php if($id_nivel==1 || $id_nivel==2){?>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('Reclutamiento/Modal_Update_Reclutamiento/' . $list['id_reclutamiento']) }}">Editar</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="Delete_Reclutamiento_Detalle('<?php echo $list['id_reclutamiento']; ?>')">Eliminar</a>
                        <?php }else{
                            if($list['estado_reclutamiento']==1){?>
                            <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('Reclutamiento/Modal_Update_Reclutamiento/' . $list['id_reclutamiento']) }}">Editar</a>
                            <a class="dropdown-item" href="javascript:void(0);" onclick="Delete_Reclutamiento_Detalle('<?php echo $list['id_reclutamiento']; ?>')">Eliminar</a>
                        <?php }}?>
                    </div>
                </div>
            </td>
        </tr>
        <?php }?>

    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>TOTALES</td>
            <td><?php echo $t_vacantes ?></td>
            <td><?php echo $t_pendientes ?></td>
            <td></td>
            <?php  if($id_nivel==1 || $id_nivel==2){?>
            <td></td>
            <?php }?>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </tfoot>
</table>

<script>
$('#zero-config<?php echo $pestania ?>').DataTable({
    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
    "<'table-responsive'tr>" +
    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
    responsive: true,
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Mostrando página _PAGE_ de _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
    "sLengthMenu": "Resultados :  _MENU_",
    },
    "stripeClasses": [],
    "lengthMenu": [25, 40, 50],
    "pageLength": 25,
    columnDefs: [
            {
                targets: 0,
                visible: false,
                searchable: false,
            }
    ],
    order: [[0, 'desc']],
});

function Delete_Reclutamiento_Detalle(id) {
        var id = id;
        var url = "{{ url('Reclutamiento/Delete_Reclutamiento_Detalle') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_reclutamiento': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Buscador_Reclutamiento('1');
                        });
                    }
                });
            }
        })
    }
</script>
