<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Cargo</th>
            <th width="15%">Cap aprobado</th>
            <th width="15%">Asistencia</th>
            <th width="15%">Libre</th>
            <th width="15%">Falta</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($list_puesto as $list)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td class="text-left">{{ $list->nom_puesto }}</td>
                <td>{{ $list->aprobado }}</td> 
                <td>
                    <input type="text" class="form-control" id="asistencia_{{ $list->id_puesto }}" 
                    name="asistencia_{{ $list->id_puesto }}" value="{{ $list->asistencia }}" 
                    onkeypress="return solo_Numeros_Punto(event);">
                </td>
                <td>
                    <input type="text" class="form-control" id="libre_{{ $list->id_puesto }}" 
                    name="libre_{{ $list->id_puesto }}" value="{{ $list->libre }}" 
                    onkeypress="return solo_Numeros_Punto(event);">
                </td>
                <td>
                    <input type="text" class="form-control" id="falta_{{ $list->id_puesto }}" 
                    name="falta_{{ $list->id_puesto }}" value="{{ $list->falta }}" 
                    onkeypress="return solo_Numeros_Punto(event);">
                </td>
            </tr>  
        @php $i++; @endphp
        @endforeach
    </tbody>
</table>   


<script>
    $('#tabla_js').DataTable({
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
        "lengthMenu": [50, 75, 100],
        "pageLength": 50
    });
</script>