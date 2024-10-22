<table id="tabla_js" class="table" style="width:100%">
    <thead class="text-center">
        <tr>
            <th>Orden</th>
            <th>F. de Creación</th>
            <th>Área</th>
            <th>Puesto</th>
            <th>Nombres</th>
            <th>Documento</th>
            <th>Celular</th>
            <th>Creado Por</th>
            <th>Estado</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_postulante as $list)
            <tr>
                <td>{{ $list->orden }}</td>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->nom_area }}</td>
                <td>{{ $list->nom_puesto }}</td>
                <td>{{ $list->nom_postulante }}</td>
                <td>{{ $list->num_doc }}</td>
                <td>{{ $list->num_celp }}</td>
                <td>{{ $list->creado_por }}</td>
                <td>{{ $list->nom_estado }}</td>
                <td class="text-center">
                    <div class="btn-group dropleft" role="group"> 
                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                            <a href="javascript:void(0);" class="dropdown-item">
                                Ver perfil
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" 
                            data-target="#ModalUpdate" 
                            app_elim="{{ route('postulante_reg.edit', $list->id_postulante) }}">
                                Editar
                            </a>
                            <a href="javascript:void(0);" class="dropdown-item" 
                            onclick="Delete_Postulante('{{ $list->id_postulante }}');">
                                Eliminar
                            </a>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
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
</script>