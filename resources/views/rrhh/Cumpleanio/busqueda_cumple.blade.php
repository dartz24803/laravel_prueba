<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th style="display:none">&nbsp;</th>
            <th>Cumpleaños</th>
            <th>Cumpleañero</th>
            <th>Centro Labores</th>
            <th>Puesto</th>
            <th>Cantidad</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_cumple as $list) {  ?>   
        <tr>
            <td style="display:none"><?php echo $list['cumpleanio']; ?></td>
            <td><?php echo date('d/m',strtotime($list['cumpleanio'])) ; ?></td>
            <td><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
            <td><?php echo $list['centro_labores'] ?></td>
            <td><?php echo $list['nom_puesto'] ?></td>
            <td><?php echo $list['cantidad']; ?></td>
            <td class="text-center">
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('RecursosHumanos/Modal_Lista_Saludo_Cumpleanio/' . $list["id_usuario"]) }}">Ver</a>
                        <a class="dropdown-item" href="javascript:void(0);" onclick="Excel_Saludo_Cumpleanio('<?php echo $list['id_usuario'] ?>');">Exportar Excel</a>
                        <a class="dropdown-item" target="_blank" href="{{ url('Corporacion/Imprimir_Saludo/' . $list["id_usuario"]) }}">Imprimir</a>
                    </div>
                </div>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script>
$(document).ready(function() {
    $('#zero-config').DataTable({
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
        "sEmptyTable": "No hay datos disponibles en la tabla",
    },
        "stripeClasses": [],
        "lengthMenu": [10, 20, 50],
        "pageLength": 10
    });
});
</script>