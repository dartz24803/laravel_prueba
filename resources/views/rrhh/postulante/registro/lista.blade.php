<table id="tabla_js" class="table" style="width:100%">
    <thead class="text-center">
        <tr>
            <th>Orden</th>
            <th id="ordenar-fechas" onclick="OrdenarFechas()" style="cursor: pointer;">
                <div class="row p-0" style="width: 155%;">
                    <div class="offset-1 col-md-6">
                        F. de Creación
                    </div>
                    <div class="offset-1 col-md-2">
                        <div class="d-flex flex-column orden-icono">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </div>
                    </div>
                </div>
            </th>
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
                    @if (session('usuario')->id_nivel=="1" || 
                    session('usuario')->id_puesto=="21" || 
                    session('usuario')->id_puesto=="22" || 
                    session('usuario')->id_puesto=="161" ||
                    session('usuario')->id_puesto=="277" ||
                    session('usuario')->id_puesto=="278" ||
                    session('usuario')->id_puesto=="314")
                        <div class="btn-group dropleft" role="group"> 
                            <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                                @if ($list->estado_postulacion=="1")
                                    <a href="{{ route('postulante_reg.datos_iniciales', $list->id_postulante) }}" 
                                    class="dropdown-item">
                                        Datos personales
                                    </a>
                                @else
                                    <a href="{{ route('postulante_reg.perfil', $list->id_postulante) }}" 
                                    class="dropdown-item">
                                        Ver perfil
                                    </a>
                                @endif
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
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $('#tabla_js').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive p-3'tr>" +
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
                'targets': 1,
                'orderable': false
            },
            {
                'targets': 0, // Índice de la columna que quieres ocultar
                'visible': false // Oculta la columna
            }
        ]
    });
    
    $('#tabla_js thead').on('click', 'th', function() {
        if ($(this).attr('id') !== 'ordenar-fechas') {
            $('#tabla_js thead th .orden-icono').html(`
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
            `);
        }
    });

    function OrdenarFechas() {
        var tabla = $('#tabla_js').DataTable();
        var currentOrder = tabla.order(); // Obtiene el orden actual

        var header = $('#ordenar-fechas'); // Selecciona el encabezado
        var icono = header.find('.orden-icono'); // Selecciona el ícono de la flecha

        // Alterna entre ascendente y descendente
        if (currentOrder[0][0] === 0) { // Si la columna 0 está ordenada
            var newOrder = (currentOrder[0][1] === 'asc') ? 'desc' : 'asc';
            tabla.order([0, newOrder]).draw();

            // Cambia la clase del ícono según el nuevo orden
            if (newOrder === 'asc') {
                icono.removeClass('desc').addClass('asc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
            } else {
                icono.removeClass('asc').addClass('desc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
            }
        } else {
            // Si no está ordenada, establece como ascendente por defecto
            tabla.order([0, 'asc']).draw();
            icono.removeClass('desc').addClass('asc').html(`
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-up"><polyline points="18 15 12 9 6 15"></polyline></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="12" viewBox="0 0 24 24" fill="none" stroke="#231b2e4b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        `);
        }
    }
</script>