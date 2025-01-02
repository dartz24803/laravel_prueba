<span>Total cumpleaños desde el mes de {{ ucfirst($mesActual) }}: {{ $conteo }}</span>
<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th></th>
            <th>Cumpleaños</th>
            <th>Cumpleañero</th>
            <th>Centro Labores</th>
            <th>Puesto</th>
            <th>Tomatodo</th>
            <th>Caja</th>
            <th>Globos</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($list_cumple as $list) {  ?>   
        <tr>
            <td><?php echo $list['cumpleanio']; ?></td>
            <td><?php echo date('d/m',strtotime($list['cumpleanio'])) ; ?></td>
            <td><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater']; ?></td>
            <td><?php echo $list['centro_labores'] ?></td>
            <td><?php echo $list['nom_puesto'] ?></td>
            <td>1</td>
            <td>1</td>
            <td>3</td>
        </tr>
    <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Cumpleaños en el mes: {{ $conteo_mes }}</th>
            <th>Σ = {{ $conteoA }}</th>
            <th>Σ = {{ $conteoB }}</th>
            <th>Σ = {{ $conteoC }}</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Restante: </th>
            <th>Tomatodo {{ $restanteA }}</th>
            <th>Caja {{ $restanteB }}</th>
            <th>Globos {{ $restanteC }}</th>
        </tr>
        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>Total en inventario:</th>
            <th>Tomatodo {{ $inventario[2]->cantidad }}</th>
            <th>Caja {{ $inventario[1]->cantidad }}</th>
            <th>Globos {{ $inventario[0]->cantidad }}</th>
        </tr>
    </tfoot>
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
        "pageLength": 10,
        columnDefs: [
                {
                    targets: 0,
                    visible: false,
                    searchable: false,
                }
        ],
        order: [[0, 'asc']],
    });
});
</script>