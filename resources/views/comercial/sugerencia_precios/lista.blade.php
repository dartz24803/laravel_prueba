<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Base</th>
            <th>Categoría</th>
            <th>Estilo</th>
            <th>Precio Vigente</th>
            <th title="Precio sugerido">Precio Sug.</th>
            <th title="Precio sugerido 2x (opcional)">P.S. 2X (Opc)</th>
            <th title="Precio sugerido 3x (opcional)">P.S. 3X (Opc)</th>
            <th>Motivo</th>
            <th>Comentario</th>
            <th>Evidencia</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_sugerencia_precios as $list) {  ?>
            <tr class="text-center">
                <td><?php echo $list['cod_base']; ?></td>
                <td><?php echo $list['categoria']; ?></td>
                <td class="text-left"><?php echo $list['estilo']; ?></td>
                <td class="text-right"><?php echo $list['precio_vigente']; ?></td>
                <td class="text-right"><?php echo $list['precio_sug']; ?></td>
                <td class="text-right"><?php echo $list['precio_sug_2x']; ?></td>
                <td class="text-right"><?php echo $list['precio_sug_3x']; ?></td>
                <td class="text-left"><?php echo $list['motivo']; ?></td>
                <td class="text-left"><?php echo $list['comentario']; ?></td>
                <td></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    var tabla = $('#zero-config').DataTable({
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
        },
        "stripeClasses": [],
        "lengthMenu": [50, 70, 100],
        "pageLength": 50
    });

    $('#toggle-coment').change(function() {
        var columnIndex = 8;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
    $('#toggle-eviden').change(function() {
        var columnIndex = 9;
        var visible = this.checked;
        tabla.column(columnIndex).visible(visible);
    });
</script>