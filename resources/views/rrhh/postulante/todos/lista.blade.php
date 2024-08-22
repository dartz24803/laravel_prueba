<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Orden</th>
            <th>F. de Creación</th>
            <th>Área</th>
            <th>Puesto</th>
            <th>Nombres</th>
            <th>Documento</th>
            <th>Celular</th>
            <th>Creado por</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_todos as $list)
            <tr class="text-center">
                <td>{{ $list->orden }}</td>
                <td>{{ $list->fecha_tabla }}</td>
                <td class="text-left">{{ $list->nom_area }}</td>
                <td class="text-left">{{ $list->nom_puesto }}</td>
                <td class="text-left">{{ $list->nombres }}</td>
                <td>{{ $list->num_doc }}</td>
                <td>{{ $list->num_celp }}</td>
                <td class="text-left">{{ $list->creado_por }}</td>
                <td class="text-left">{{ $list->nom_estados_postulante }}</td>
                <td class="text-center"> 
                    <div class="btn-group dropleft" role="group">
                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                            <a class="dropdown-item" onclick="Retomar_Proceso('{{ $list->id_postulante }}')" style="cursor:pointer;">Retomar Proceso</a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>    

<script>
    //$(document).ready(function() {
        @if(session('usuario')->id_nivel==1 || 
        session('usuario')->id_nivel==2 || 
        session('usuario')->id_puesto==133 || 
        session('usuario')->id_puesto==22 || 
        session('usuario')->id_puesto==21 || 
        session('usuario')->id_puesto==29 || 
        session('usuario')->id_puesto==98 || 
        session('usuario')->id_puesto==26 || 
        session('usuario')->id_puesto==16 || 
        session('usuario')->id_puesto==161 || 
        session('usuario')->id_puesto==197)
            $('#tabla_js').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                responsive: true,
                order: [[0,"desc"]],
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
                "aoColumnDefs" : [ 
                    {
                        'targets' : [ 0 ],
                        'visible' : false
                    } 
                ]
            });
        @else
            $('#tabla_js').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                responsive: true,
                order: [[0,"desc"]],
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
                "aoColumnDefs" : [ 
                    {
                        'targets' : [ 0,9 ],
                        'visible' : false
                    } 
                ]
            });
        @endif
    //});
</script>