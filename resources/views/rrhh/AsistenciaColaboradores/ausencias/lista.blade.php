<table id="zero-configggea" class="table table-hover non-hover" style="width:100%">
    <thead>
        <tr>
            <th>Colaborador</th>
            <th>DNI</th>
            <th>Base</th>
            <th>Fecha</th>
            <th>Turno</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($list_ausenciai as $list) { ?>
            <tr>
                <td><?php echo $list->colaborador; ?></td>
                <td><?php echo $list->num_doc; ?></td>
                <td><?php echo $list->centro_labores; ?></td>
                <td><?php echo $list->fecha; ?></td>
                <td><?php echo $list->turno; ?></td>
                <td>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate"
                        <?php echo $list->id_asistencia_inconsistencia; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<script>
    $(document).ready(function() {
        $('#zero-configggea').DataTable({
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
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [50, 70, 100],
            "pageLength": 50
        });
    });
</script>