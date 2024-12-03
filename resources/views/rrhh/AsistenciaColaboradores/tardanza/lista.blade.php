<table id="tabla_js_tardanza" class="table table-hover non-hover" style="width:100%">
    <thead>
        <tr>
            <th>Colaborador</th>
            <th>Base</th>
            <th>Puesto</th>
            <th>DNI</th>
            <th>Fecha</th>
            <th>Hora de inicio de turno</th>
            <th>Hora de llegada</th>
            <th>Minutos de atraso</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_tardanza as $list) { ?>
            <tr class="text-center">
                <td class="text-left"><?php echo ucwords($list->colaborador); ?></td>
                <td><?php echo $list->base; ?></td>
                <td class="text-left"><?php echo ucwords($list->puesto); ?></td>
                <td><?php echo $list->dni; ?></td>
                <td><?php echo $list->fecha; ?></td>
                <td><?php echo $list->hora_inicio_turno; ?></td>
                <td><?php echo $list->hora_llegada; ?></td>
                <td><?php echo $list->minutos_atraso; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla_js_tardanza').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
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
            "pageLength": 50
        });
    });
</script>