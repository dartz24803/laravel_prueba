<div class="widget-content widget-content-area br-6">
    <div class="table-responsive mb-4 mt-4">
        <table id="zero-configidioma" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th class="no-content"></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($list_idioma as $list) {  ?>   
                <tr>
                    <td><?php echo $list['nom_idioma']; ?></td>
                    <td class="text-center">
                        <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ColaboradorConfController/Modal_Update_Idioma/' .$list["id_idioma"]) }}" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                        <a href="#" class="" title="Eliminar" onclick="Delete_Idioma('<?php echo $list['id_idioma']; ?>')" id="delete" role="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
       
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {

        document.title = 'Idioma Tabla';
                $('#zero-configidioma').DataTable({
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
                "pageLength": 10
            });
    });
</script>