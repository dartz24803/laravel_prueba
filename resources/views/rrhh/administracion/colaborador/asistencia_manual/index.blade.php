<div class="d-flex justify-content-end align-items-center">
    <div class="col-lg-12 d-flex justify-content-end mb-4">
        <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('AsistenciaManual/Modal_AsistenciaManual') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </button>
    </div>
</div>
@csrf
<div class="widget-content widget-content-area br-6">
    <div class="table-responsive mb-4 mt-4" id="busqueda">
        <table id="tabla_asis_manual" class="table table-hover" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Colaborador</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Inicio Refrigerio</th>
                    <th>Fin Refrigerio</th>
                    <th class="no-content"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($list_asistencia_manual as $list) {  ?>
                    <tr class="text-center">
                        <td class="text-left"><?php echo ucwords($list['nom_usuario']); ?></td>
                        <td><?php echo $list['entrada']; ?></td>
                        <td><?php echo $list['salida']; ?></td>
                        <td><?php echo $list['inicio_refrigerio']; ?></td>
                        <td><?php echo $list['fin_refrigerio']; ?></td>
                        <td>
                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>

                            <a href="javascript:void(0)" title="Eliminar" onclick="Delete_Asistencia_Manual('<?php echo $list['id']; ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                    <line x1="14" y1="11" x2="14" y2="17"></line>
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
        document.title = 'Asistencia Manual';

        $('#tabla_asis_manual').DataTable({
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

    function Delete_Asistencia_Manual(id) {
        Cargando();

        var url = "{{ url('AsistenciaManual/Delete_Asistencia_Manual') }}";
        var csrfToken = $('input[name="_token"]').val();
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
                    data: {
                        'id': id
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {

                        });
                    }
                });
            }
        })
    }
</script>