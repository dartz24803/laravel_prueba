<style>
    table.table td {
        white-space: normal !important;
    }
</style>

<?php
$id_puesto=session('usuario')->id_puesto;
$id_nivel=session('usuario')->id_nivel;
?>
@php
    use Carbon\Carbon;
@endphp
<?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==24 || $id_puesto==26 ){ ?>
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<script src="<?php echo base_url(); ?>template/table-responsive/datatables.responsive.min.js"></script> --}}
    <table id="zero-config" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Base</th>
                <th>Colaborador</th>
                <th>Ocurrencia</th>
                <th>Conclusión</th>
                <th>Gestión</th>
                <th>Cantidad</th>
                <th>Monto Total</th>
                <th>Descripción</th>
                <th>Revisado</th>
                <th class="no-content"></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($list_ocurrencia as $list) {  ?>
                <tr>
                    <td><?php echo $list['cod_ocurrencia']; ?></td>
                    <td data-order="{{ Carbon::createFromFormat('d-m-Y', $list['fecha_ocurrencia'])->format('Y-m-d'); }}"><?php echo $list['fecha_ocurrencia']; ?></td>
                    <td><?php echo $list['cod_base']; ?></td>
                    <td><?php echo $list['colaborador']; ?></td>
                    <td><?php echo $list['nom_tipo_ocurrencia']; ?></td>
                    <td><?php echo $list['nom_conclusion']; ?></td>
                    <td><?php echo $list['nom_gestion']; ?></td>
                    <td><?php echo $list['cantidad']; ?></td>
                    <td><?php echo "S/. ".$list['monto']; ?></td>
                    <td><?php echo $list['descripcion']; ?></td>
                    <td class="text-center"><?php echo $list['v_revisado']; ?></td>
                    <td nowrap>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('OcurrenciaTienda/Modal_Update_Ocurrencia_Tienda_Admin/'. $list['id_ocurrencia']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                        <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Ocurrencia_Tienda('<?php echo $list['id_ocurrencia']; ?>');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                        <?php if($list['v_revisado'] == 'No' && ($id_nivel==1 || $id_puesto==23 || $id_puesto==26)){ ?>
                            <a href="javascript:void(0);" title="Confirmar Revisión" onclick="Confirmar_Revision('<?php echo $list['id_ocurrencia']; ?>');">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php }else{ ?>
    <table id="zero-config" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Base</th>
                <th>Colaborador</th>
                <th>Ocurrencia</th>
                <th>Conclusión</th>
                <th>Gestión</th>
                <th>Cantidad</th>
                <th>Monto Total</th>
                <th>Descripción</th>
                <th class="no-content"></th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($list_ocurrencia as $list) {  ?>
                <tr>
                    <td><?php echo $list['cod_ocurrencia']; ?></td>
                    <td><?php echo $list['fecha_ocurrencia']; ?></td>
                    <td><?php echo $list['cod_base']; ?></td>
                    <td><?php echo $list['colaborador']; ?></td>
                    <td><?php echo $list['nom_tipo_ocurrencia']; ?></td>
                    <td><?php echo $list['nom_conclusion']; ?></td>
                    <td><?php echo $list['nom_gestion']; ?></td>
                    <td><?php echo $list['cantidad']; ?></td>
                    <td><?php echo "S/. " . $list['monto']; ?></td>
                    <td><?php echo $list['descripcion']; ?></td>
                    <td>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('OcurrenciaTienda/Modal_Update_Ocurrencia_Tienda_Admin/'.$list['id_ocurrencia']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                        <a title="Eliminar" onclick="Delete_Ocurrencia_Tienda('<?php echo $list['id_ocurrencia']; ?>');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                <line x1="14" y1="11" x2="14" y2="17"></line>
                            </svg>
                        </a>
                        <?php if($list['v_revisado'] == 'No'){ ?>
                            <a title="Confirmar Revisión" onclick="Confirmar_Revision('<?php echo $list['id_ocurrencia']; ?>');">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } ?>

<script>
    $('#zero-config').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
        "<'table-responsive'tr>" +
        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
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
        },
        "stripeClasses": [],
        "lengthMenu": [50, 70, 100],
        "pageLength": 50
    });
</script>
