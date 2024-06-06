<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Base</th>
            <th>Puesto</th>
            <th>Dia</th>
            <th>Horario</th>
            <th>Colaborador</th>
        </tr>
    </thead>

    <tbody>
        
        <?php foreach ($list_programacion_diaria as $list) {  ?>
            <tr class="text-left">
                <td><?php echo $list['centro_labores']; ?></td>
                <td><?php echo $list['puesto']; ?></td>
                <td class="text-center"><?php echo $list['nom_dia']; ?></td>
                <td><?php echo $list['horario']; ?></td>
                <td><?php echo $list['colaborador']; ?></td>
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