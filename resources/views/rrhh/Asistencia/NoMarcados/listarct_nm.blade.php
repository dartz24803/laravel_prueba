<?php
use Carbon\Carbon;
$sesion =  Session('usuario');
$id_nivel = Session('usuario')->id_nivel;
$id_puesto = Session('usuario')->id_puesto;
?>
<table id="table-z" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Centro de Labores</th>
            <th>DNI</th>
            <th>Colaborador</th>
            <th>Fecha</th>
            <th>Ingreso</th>
            <th>Inicio Descanso</th>
            <th>Fin Descanso</th>
            <th>Salida</th>
            <th>Día Laborado</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($list_asistencia as $num_doc=>$registros){
                foreach($registros as $list) {
                    $cadenaConvert = str_replace(" ", "-", $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']);
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $list['orden']; ?></td>
                        <td class="text-center"> <?php echo $list['centro_labores']; ?> </td>
                        <td class="text-center"> <?php echo $list['num_doc']; ?> </td>
                        <td class="text-center"> <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
                        <td class="text-center" data-order="{{ $list['orden'] }}"> <?php echo $list['fecha'];?> </td>
                        <td class="text-center">
                            <?php $ingreso = 0; ?>
                            <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Asistencia/Modal_Registro_Dia/'. $cadenaConvert . "/" .$list['num_doc'] ."/". $list['orden'] . "/". $ingreso) }}" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>
                        </td>
                        <td class="text-center">
                        </td>
                        <td class="text-center">
                        </td>
                        <td class="text-center">
                        </td>
                        <td class="text-center">0</td>
                    </tr>
                <?php }
            }
        ?>
    </tbody>
</table>

<script>
$('#table-z').DataTable({
    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
    "<'table-responsive'tr>" +
    "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
    responsive: true,
    "order": [[0, "desc"]],
    "oLanguage": {
        "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
        "sInfo": "Mostrando página _PAGE_ de _PAGES_",
        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
        "sSearchPlaceholder": "Buscar...",
    "sLengthMenu": "Resultados :  _MENU_",
    "sEmptyTable": "No hay datos disponibles en la tabla",

    },
    "stripeClasses": [],
    "lengthMenu": [50, 70, 100],
    "pageLength": 50,
    "columnDefs": [
        {
            "targets": 0,
            "visible": false,
            "searchable": false
        }
    ]
});
</script>
