<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th>Cod Tienda</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Entradas</th>
            <th>Salidas</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_contador as $list) {
        $busqueda = in_array($list['cod_tienda'], array_column($list_base, 'cod_tienda'));
        $posicion = array_search($list['cod_tienda'], array_column($list_base, 'cod_tienda'));
        ?>
        <tr>
            <td><?php if ($busqueda == true) {echo $list_base[$posicion]['cod_base'];}else{echo $list['cod_tienda'];} ?></td>
            <td><?php echo $list['fecha'] ?></td>
            <td><?php echo $list['hora'] ?></td>
            <td><?php echo $list['entradas'] ?></td>
            <td><?php echo $list['salidas'] ?></td>
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
        "lengthMenu": [20, 50, 100],
        "pageLength": 20
    });
</script>
