<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr>
            <th>Orden</th>
            <th>Base</th>
            <th>Colaborador</th>
            <th>Puesto asignado</th>
            <th>Tipo</th>
            <th>Actividad</th>
            <th>Fecha</th>
            <th>Horario</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_funcion_temporal as $list)
            <tr style="background-color:{{ $list->color_fondo }}">
                <td>{{ $list->orden }}</td>
                <td>{{ $list->base }}</td>
                <td>{{ ucwords($list->nom_usuario) }}</td> 
                <td>{{ $list->puesto_asignado }}</td>
                <td>{{ $list->nom_tipo }}</td>
                <td>{{ ucfirst($list->actividad) }}</td>
                <td>{{ $list->fecha_tabla }}</td>
                <td>{{ $list->horario }}</td>
                <td class="text-center">
                    <div class="btn-group dropleft" role="group"> 
                        <a id="btnDropLeft" type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="btnDropLeft" style="padding:0;">
                            <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" 
                            data-target="#ModalUpdate" 
                            app_elim="<?= site_url('Tienda/Modal_Ver_Funcion_Temporal') ?>/<?php echo $list['id_funcion']; ?>">
                                Ver
                            </a>
                            <?php if($_SESSION['usuario'][0]['id_puesto']!=311){ ?>
                                <a href="javascript:void(0);" class="dropdown-item" data-toggle="modal" 
                                data-target="#ModalUpdate" 
                                app_elim="<?= site_url('Tienda/Modal_Update_Funcion_Temporal') ?>/<?php echo $list['id_funcion']; ?>">
                                    Editar
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item" 
                                onclick="Delete_Funcion_Temporal('<?php echo $list['id_funcion']; ?>')">
                                    Eliminar
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>    

<script>
    $(document).ready(function() {
        $('#tabla_js').DataTable({
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
    });
</script>