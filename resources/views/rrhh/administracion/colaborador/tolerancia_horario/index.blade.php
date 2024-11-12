<div class="d-flex justify-content-end align-items-center">
    <div class="col-lg-12 d-flex justify-content-end mb-4">
        <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('ToleranciaHorario/Modal_ToleranciaHorario') }}">
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
    <div class="table-responsive mb-4 mt-4">
        <table id="zero-configtallaa" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Tolerancia</th>
                    <th>Estado</th>
                    <th class="no-content"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list_tolerancia as $list) {  ?>
                    <tr>
                        <td><?php echo $list['tolerancia'] . " " . $list['desc_tipo']; ?></td>
                        <td><?php echo $list['desc_estado_registro']; ?></td>
                        <td class="text-center">
                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ToleranciaHorario/Modal_Update_ToleranciaHorario/'. $list['id_tolerancia']) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                            </a>
                            <?php if ($list['estado_registro'] == 2) { ?>
                                <a href="javascript:void(0)" title="Activar" onclick="Actualizar_ToleranciaHorario('<?php echo $list['id_tolerancia'] ?>','1')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                    </svg>
                                </a>
                            <?php }
                            if ($list['estado_registro'] == 1) { ?>
                                <a href="javascript:void(0)" title="Desactivar" onclick="Actualizar_ToleranciaHorario('<?php echo $list['id_tolerancia'] ?>','2')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle text-danger">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="15" y1="9" x2="9" y2="15"></line>
                                        <line x1="9" y1="9" x2="15" y2="15"></line>
                                    </svg>
                                </a>
                            <?php } ?>

                            <a href="#" class="" title="Eliminar" onclick="Delete_ToleranciaHorario('<?php echo $list['id_tolerancia']; ?>')" id="delete" role="button">
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
        document.title = 'Tolerancia de Horario';
        $('#zero-configtallaa').DataTable({
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
            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });
    });

    function Actualizar_ToleranciaHorario(id, t) {
        texto1 = "activar";
        texto2 = "Activado!";
        if (t == 2) {
            texto1 = "desactivar";
            texto2 = "Desactivado!";
        }
        var url = "{{ url('ToleranciaHorario/Actualizar_ToleranciaHorario') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
            title: '¿Realmente desea ' + texto1 + ' el registro?',
            //text: "El registro será actualizado permanentemente",
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
                        'id_tolerancia': id,
                        'estado_registro': t
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            texto2,
                            'El registro ha sido actualizado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            ToleranciaHorario();
                        });
                    }
                });
            }
        })
    }

    function Delete_ToleranciaHorario(id) {
        var id = id;
        var url = "{{ url('ToleranciaHorario/Delete_ToleranciaHorario') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
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
                        'id_tolerancia': id
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
                            ToleranciaHorario();
                        });
                    }
                });
            }
        })
    }

    function Valida_ToleranciaHorario(t) {
        v = "";
        if (t == 2) {
            v = "e";
        }
        if ($('#tipo' + v).val() == '0') {
            msgDate = 'Debe seleccionar tipo.';
            inputFocus = '#tipo' + v;
            return false;
        }
        if ($('#tolerancia' + v).val().trim() == '') {
            msgDate = 'Debe seleccionar tolerancia.';
            inputFocus = '#tolerancia' + v;
            return false;
        }
        return true;
    }
</script>