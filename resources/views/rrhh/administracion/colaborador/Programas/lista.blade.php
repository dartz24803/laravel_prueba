<table id="tabla-datacorp" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th> Orden</th>
            <th class="text-center">Area</th>
            <th class="text-center">Puesto</th>
            <th class="text-center">Acceso</th>
            <th class="no-content"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list as $row) {  ?>
            <tr>
                <td class="text-center"><?php echo $row['id']; ?></td>
                <td class="text-center"><?php echo $row['nom_area']; ?></td>
                <td class="text-center"><?php echo $row['nom_puesto']; ?></td>
                <td class="text-center"><?php echo $row['programa']; ?></td>
                <td class="text-center">
                <?php if (session('usuario')->centro_labores == "OFC" || session('usuario')->id_puesto == 131 || session('usuario')->id_usuario == 139) { ?>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Modal_Update_Programa/' . $row['id']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <a href="javascript:void(0);" class="" title="Eliminar" onclick="Delete_Programa('<?php echo $row['id']; ?>')" id="delete" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    var tabla = $('#tabla-datacorp').DataTable({
        "order": [
            [0, "desc"]
        ],
        "oLanguage": {
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
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
        // Ordenar por la primera columna de forma descendente
        "columnDefs": [{
            "targets": 0, // La primera columna
            "visible": false, // Ocultar la primera columna
            "searchable": false // No permitir buscar en la primera columna
        }],
    });
    function Delete_Programa(id) {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var id = id;
        var url = "{{ url('Delete_Programa') }}";
        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Listar_Accesos_Programas()
                        });
                    }
                });
            }
        })
    }
</script>