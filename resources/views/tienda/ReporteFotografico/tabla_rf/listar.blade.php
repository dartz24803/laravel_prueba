<table id="tabla-rf" class="table table-hover" style="width:100%">
    <thead>
        <tr>
            <th> Orden</th>
            <th class="text-center">base</th>
            <th class="text-center">codigo</th>
            <th class="text-center">categoría</th>
            <th class="text-center">area</th>
            <th class="text-center">fecha</th>
            <th class="text-center no-content">foto</th>
            <th class="no-content"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list as $row) {  ?>
            <tr>
                <td class="text-center">
                    <?= $row['id'];?>
                </td>
                <td class="text-center"><?php echo $row['base']; ?></td>
                <td class="text-center"><?php echo $row['codigo']; ?></td>
                <td class="text-center">
                    <?php
                    if($row['base'] == 'B12' && $row['codigo'] == '1IA'){
                        echo 'HOMBRE';
                    }else if($row['base'] == 'B07' && $row['codigo'] == '1HA'){
                        echo 'MUJER';
                    }else {
                        echo $row['tipo'];
                    }
                    ?>
                </td>
                <td class="text-center"><?php echo $row['areas']; ?></td>
                <td class="text-center"><?php echo $row['fec_reg']; ?></td>
                <td class="text-center">
                    <a title="Ver evidencia" href="https://lanumerounocloud.com/intranet/REPORTE_FOTOGRAFICO/<?= $row['foto']; ?>" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye text-success"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </a>
                </td>
                <td class="text-center">
                <?php if (session('usuario')->id_puesto != 311 &&
                (session('usuario')->id_puesto == 15 || session('usuario')->id_puesto == 131 ||
                session('usuario')->id_puesto == 158 || session('usuario')->id_puesto == 161 ||
                session('usuario')->id_puesto == 12 ||
                session('usuario')->centro_labores == "OFC" ||
                session('usuario')->id_puesto == 128 || session('usuario')->id_usuario == 139)){ ?>
                    <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Modal_Update_Registro_Fotografico/' . $row['id']) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                        </svg>
                    </a>
                    <a href="javascript:void(0);" class="" title="Eliminar" onclick="Delete_Reporte_Fotografico('<?php echo $row['id']; ?>')" id="delete" role="button">
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
    var tabla = $('#tabla-rf').DataTable({
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

    function Delete_Reporte_Fotografico(id) {
        Cargando();

        var id = id;
        var url = "{{ url('Delete_Reporte_Fotografico') }}";
        swal.fire({
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
                    data: {
                        'id': id
                    },
                    success: function() {
                        swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Reporte_Fotografico_Listar()
                        });
                    }
                });
            }
        })
    }
</script>
