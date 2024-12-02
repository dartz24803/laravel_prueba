<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Orden</th>
            <th></th>
            <th>SKU</th>
            <th>Estado</th>
            <th>Estilo</th>
            <th>Tipo usuario</th>
            <th>Tipo prenda</th>
            <th>Color</th>
            <th>Talla</th>
            <th>Descripción</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_mercaderia_nueva as $list)
            <tr class="text-center">
                <td>{{ $list->orden }}</td>
                <td>
                    @if ($list->estado=="0")
                        <a href="javascript:void(0);" title="Actualizar" onclick="Update_Mercaderia_Nueva('{{ $list->id }}')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                        </a>
                    @endif
                </td>
                <td>{{ $list->sku }}</td>
                <td>{{ $list->nom_estado }}</td>
                <td>{{ $list->estilo }}</td>
                <td>{{ $list->tipo_usuario }}</td>
                <td class="text-left">{{ $list->tipo_prenda }}</td>
                <td class="text-left">{{ $list->color }}</td>
                <td>{{ $list->talla }}</td>
                <td class="text-left">{{ $list->descripcion }}</td>
                <td>{{ $list->cantidad }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        var tabla = $('#tabla_js').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
            order: [[0, "desc"]],
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
            "columnDefs": [
                {
                    'targets': [0,9],
                    'visible': false
                }
            ],
        });
        $('#toggle').change(function() {
            var columnIndex = 9;
            var visible = this.checked;
            tabla.column(columnIndex).visible(visible);
        });
    });
</script>