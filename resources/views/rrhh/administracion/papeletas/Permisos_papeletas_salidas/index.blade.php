<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('PapeletasConf/Modal_Permisos_Papeletas_Salidas') }}" >
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>
<div class="widget-content widget-content-area br-6">
    @csrf
    <div class="table-responsive mb-4 mt-4">
        <table id="zero-configpermiso" class="table table-hover" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>Puesto que Aprueba</th>
                    <th>Puesto Aprobado</th>
                    <th>Papeleta Masiva</th>
                    <th class="no-content"></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($list_permisops as $list) {  ?>                                           
                    <tr>
                        <td align="center"><?php echo $list['puesto_jefe']; ?></td>
                        <td align="center"><?php echo "<b>GERENCIA: </b>".$list['nom_gerencia']."<br><b>ÁREA: </b>".$list['nom_area']."<br><b>PUESTO: </b>".$list['nom_puesto']; ?></td>
                        <td align="center"><?php if($list['registro_masivo']>0){echo "SÍ";}else{echo "NO";}; ?></td>
                        <td class="text-center"  width="80">
                            <a href="#" class="" title="Eliminar" onclick="Delete_Permisos_Papeletas_Salidas('<?php echo $list['id_permiso_papeletas_salida']; ?>')" id="delete" role="button">
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
	document.title = 'Permisos';
            $('#zero-configpermiso').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
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

    function Delete_Permisos_Papeletas_Salidas(id) {
        var id = id;
        var url = "{{ url('PapeletasConf/Delete_Permisos_Papeletas_Salidas') }}";
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
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id_permiso_papeletas_salida': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            TablaPermisosPepeletas_salidas();
                        });
                    }
                });
            }
        })
    }
</script>
