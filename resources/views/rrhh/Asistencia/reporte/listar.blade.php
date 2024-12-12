<?php
use Carbon\Carbon;
$sesion =  Session('usuario');
$id_nivel = Session('usuario')->id_nivel;
$id_puesto = Session('usuario')->id_puesto;
?>
<table id="multi-column-orderingg" class="table table-hover" style="width:100%">
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
            // print_r($list_asistencia);
            //foreach($list_asistencia as $num_doc=>$registros){
                foreach($list_asistencia as $list) {
                    $cadenaConvert = str_replace(" ", "-", $list['Usuario_Nombres']." ".$list['Usuario_Apater']." ".$list['Usuario_Amater']);
                    ?>
                    <tr>
                        <td class="text-center"><?php echo $list['Orden']; ?></td>
                        <td class="text-center"> <?php echo $list['Centro_Labores']; ?> </td>
                        <td class="text-center"> <?php echo $list['Num_Doc']; ?> </td>
                        <td class="text-center"> <?php echo $list['Usuario_Nombres']." ".$list['Usuario_Apater']." ".$list['Usuario_Amater']; ?></td>
                        <td class="text-center" data-order="{{ $list['Orden'] }}"> <?php echo $list['Fecha'];?> </td>
                        <td class="text-center">
                            <?php if($list['Ingreso']!==null){ ?>
                                <?php echo Carbon::parse($list['Ingreso'])->format('H:i A'); ?>
                                <?php $ingreso = Carbon::parse($list['Ingreso'])->format('H:i:s'); ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $ingreso) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php }else{
                                $ingreso = 0; ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Asistencia/Modal_Registro_Dia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $ingreso) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if($list['Inicio_Refrigerio']!==null){ ?>
                                <?php echo Carbon::parse($list['Inicio_Refrigerio'])->format('H:i A'); ?>
                                <?php $inicio_refrigerio = Carbon::parse($list['Inicio_Refrigerio'])->format('H:i:s'); ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $inicio_refrigerio) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php }else{
                                $inicio_refrigerio = 0; ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Asistencia/Modal_Registro_Dia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $inicio_refrigerio) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if($list['Fin_Refrigerio']!==null){ ?>
                                <?php echo Carbon::parse($list['Fin_Refrigerio'])->format('H:i A'); ?>
                                <?php $fin_refrigerio = Carbon::parse($list['Fin_Refrigerio'])->format('H:i:s'); ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $fin_refrigerio) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php }else{
                                $fin_refrigerio = 0; ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Asistencia/Modal_Registro_Dia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $fin_refrigerio) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if($list['Salida']!==null){ ?>
                                <?php echo Carbon::parse($list['Salida'])->format('H:i A'); ?>
                                <?php $salida = Carbon::parse($list['Salida'])->format('H:i:s'); ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Asistencia/Modal_Update_Asistencia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $salida) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php }else{
                                $salida = 0; ?>
                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Asistencia/Modal_Registro_Dia/'. $cadenaConvert . "/" .$list['Num_Doc'] ."/". $list['Orden'] . "/". $salida) }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if($list['Salida']!=""){
                                echo "1";
                            }else{
                                echo "0";
                            } ?>
                        </td>
                    </tr>
                <?php }
            //}
        ?>
    </tbody>
</table>

<script>
$('#multi-column-orderingg').DataTable({
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
            'targets': 0, // Índice de la columna que quieres ocultar
            'visible': false // Oculta la columna
        }
    ],
});

</script>
