<?php
$id_nivel = session('usuario')->id_nivel;
$id_puesto = session('usuario')->id_puesto;
$id_usuario = session('usuario')->id_usuario;
?>
<form id="form_reclutamientoe"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Reclutamiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:600px; overflow:auto;">
        <div class="col-md-12 row">
            <input  type="hidden" required class="form-control" id="nivele" name="nivele" value="<?php echo $id_nivel ?>">
            <input  type="hidden" required class="form-control" id="puestoe" name="puestoe" value="<?php echo $id_puesto ?>">
            <div class="form-group col-md-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_areae" id="id_areae" class="form-control basiccc" onchange="Buscar_Puesto_Area('2')" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_area as $list){?>
                        <option value="<?php echo $list->id_area ?>" <?php if($get_id[0]['id_area']==$list->id_area){echo "selected";}?>><?php echo $list->nom_area ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-md-4" id="cmb_puestoe">
                <select name="id_puestoe" id="id_puestoe" class="form-control basiccc" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_puesto as $list){?>
                        <option value="<?php echo $list['id_puesto'] ?>" <?php if($get_id[0]['id_puesto']==$list['id_puesto']){echo "selected";}?>><?php echo $list['nom_puesto'] ?></option>
                    <?php }?>
                </select>
            </div>
            <?php if($id_nivel==1 || $id_nivel==2){?>
            <div class="form-group col-md-2">
                <label>Solicitante:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_solicitantee" id="id_solicitantee" class="form-control basiccc" disabled>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_colaborador as $list){?>
                        <option value="<?php echo $list['id_usuario'] ?>" <?php if($get_id[0]['id_solicitante']==$list['id_usuario']){echo "selected";}?>><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label>Evaluador:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_evaluadore" id="id_evaluadore" class="form-control basiccc">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_colaborador as $list){?>
                        <option value="<?php echo $list['id_usuario'] ?>" <?php if($get_id[0]['id_evaluador']==$list['id_usuario']){echo "selected";}?>><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                    <?php }?>
                </select>
            </div>
            <?php }else{?>
                <input type="hidden" name="id_solicitantee" id="id_solicitantee" value="<?php echo $get_id[0]['id_solicitante'] ?>">
                <input type="hidden" name="id_evaluadore" id="id_evaluadore" value="<?php echo $get_id[0]['id_evaluador'] ?>">
            <?php }?>
            <div class="form-group col-md-2">
                <label>Vancantes: </label>
            </div>
            <div class="form-group col-md-4">
                <input  type="text" required class="form-control" id="vacantese" name="vacantese" value="<?php echo $get_id[0]['vacantes'] ?>" onkeypress="return soloNumeros(event)">
            </div>

            <div class="form-group col-md-2" >
                <label>Centro Labores:</label>
            </div>
            <div class="form-group col-md-4">
                    <select class="form-control" name="id_ubicacione" id="id_ubicacione">
	                		<option value="0"  >Seleccione</option>
                            <?php foreach($list_ubicacion as $list) { ?>
                                <option value="<?php echo $list['id_ubicacion']; ?>" <?php if($list['id_ubicacion']==$get_id[0]['id_ubicacion']){ echo "selected"; }?>>
                                    <?php echo $list['cod_ubi']; ?>
                                </option>
                            <?php } ?>
	                </select>
            </div>
            <div class="form-group col-md-2" >
                <label>Modalidad:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_modalidad_laborale" id="id_modalidad_laborale" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_modalidad_laboral as $list){?>
                        <option value="<?php echo $list['id_modalidad_laboral'] ?>" <?php if($get_id[0]['id_modalidad_laboral']==$list['id_modalidad_laboral']){echo "selected";}?>><?php echo $list['nom_modalidad_laboral'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-md-2" >
                <label>Tipo Remuneación:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="tipo_sueldoe" id="tipo_sueldoe" class="form-control" onchange="Tipo_Sueldo('2')">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['tipo_sueldo']==1){echo "selected";}?>>Fijo</option>
                    <option value="2" <?php if($get_id[0]['tipo_sueldo']==2){echo "selected";}?>>Banda</option>
                </select>
            </div>
            <div class="form-group col-md-2" id="lbl_sueldoe" style="display:<?php if($get_id[0]['tipo_sueldo']==1 ){echo "block";}else{echo "none";}?>" >
                <label class="control-label text-bold">Sueldo: </label>
            </div>
            <div class="form-group col-md-4" id="inp_sueldoe" style="display:<?php if($get_id[0]['tipo_sueldo']==1 ){echo "block";}else{echo "none";}?>">
                <input type="text" class="form-control" name="sueldoe" id="sueldoe" value="<?php echo $get_id[0]['sueldo']; ?>"  onkeypress="return soloNumeros(event)">
            </div>
            <div class="form-group col-md-2" id="lbl_desdee" style="display:<?php if($get_id[0]['tipo_sueldo']==2 ){echo "block";}else{echo "none";}?>">
                <label class="control-label text-bold">Desde: </label>
            </div>
            <div class="form-group col-md-4" id="inp_desdee" style="display:<?php if($get_id[0]['tipo_sueldo']==2 ){echo "block";}else{echo "none";}?>">
                <input type="text" class="form-control" name="desdee" id="desdee" value="<?php echo $get_id[0]['desde'] ?>" onkeypress="return soloNumeros(event)">
            </div>
            <div class="form-group col-md-2" id="lbl_ae" style="display:<?php if($get_id[0]['tipo_sueldo']==2 ){echo "block";}else{echo "none";}?>">
                <label class="control-label text-bold">A: </label>
            </div>
            <div class="form-group col-md-4" id="inp_ae" style="display:<?php if($get_id[0]['tipo_sueldo']==2 ){echo "block";}else{echo "none";}?>">
                <input type="text" class="form-control" name="ae" id="ae" value="<?php echo $get_id[0]['a'] ?>" onkeypress="return soloNumeros(event)">
            </div>
            <?php if($id_nivel==1 || $id_nivel==2){?>
            <div class="form-group col-md-2" >
                <label>Asignado a: </label>
            </div>
            <div class="form-group col-md-4">
                <select name="id_asignadoe" id="id_asignadoe" class="form-control basiccc">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_rrhh as $list){?>
                        <option value="<?php echo $list['id_usuario'] ?>" <?php if($get_id[0]['id_asignado']==$list['id_usuario']){echo "selected";}?>><?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'] ?></option>
                    <?php }?>
                </select>
            </div>
            <div class="form-group col-md-2" >
                <label>Prioridad:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="prioridade" id="prioridade" class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['prioridad']==1){echo "selected";}?>>Baja</option>
                    <option value="2" <?php if($get_id[0]['prioridad']==2){echo "selected";}?>>Media</option>
                    <option value="3" <?php if($get_id[0]['prioridad']==3){echo "selected";}?>>Alta</option>
                </select>
            </div>
            <div class="form-group col-md-2" >
                <label>Fecha de Vencimiento:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" name="fec_cierree" id="fec_cierree" value="<?php echo $get_id[0]['fec_cierre'] ?>" class="form-control" disabled>
            </div>
            <?php }else{?>
            <input type="hidden" name="id_asignadoe" id="id_asignadoe" value="<?php echo $get_id[0]['id_asignado'] ?>">
            <?php }?>
            <div class="form-group col-md-2" >
                <label>Observaciones:</label>
            </div>
            <div class="form-group col-md-4">
                <textarea name="observacione" id="observacione" cols="30" rows="2" class="form-control"><?php echo $get_id[0]['observacion'] ?></textarea>
            </div>
            <?php if($id_nivel==1 || $id_nivel==2){?>
            <div class="form-group col-md-2" >
                <label>Estado:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="estado_reclutamientoe" id="estado_reclutamientoe" class="form-control" onchange="Estado_Reclutamiento()">
                    <option value="0">Seleccione</option>
                    <option value="1" <?php if($get_id[0]['estado_reclutamiento']==1){echo "selected";}?>>Por iniciar</option>
                    <option value="2" <?php if($get_id[0]['estado_reclutamiento']==2){echo "selected";}?>>En proceso</option>
                    <option value="3" <?php if($get_id[0]['estado_reclutamiento']==3){echo "selected";}?>>Completado</option>
                </select>
            </div>
            <?php }else{?>
            <input type="hidden" name="estado_reclutamientoe" id="estado_reclutamientoe" value="<?php echo $get_id[0]['estado_reclutamiento'] ?>">
            <?php }?>
            <div class="form-group col-md-2" id="div_fectermino1" style="display:<?php if($get_id[0]['estado_reclutamiento']==3){echo "block";}else{echo "none";} ?>">
                <label>Fecha de Termino:</label>
            </div>
            <div class="form-group col-md-4" id="div_fectermino2" style="display:<?php if($get_id[0]['estado_reclutamiento']==3){echo "block";}else{echo "none";} ?>">
                <input type="date" name="fec_terminoe" id="fec_terminoe" value="<?php echo $get_id[0]['fec_termino'] ?>" class="form-control">
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2" >
                <label><b>Reclutados</b></label>
            </div>
            <div class="form-group col-md-10">
                <?php if($id_nivel==1 || $id_nivel==2){?>
                <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Reclutamiento/Modal_Reclutamiento_Reclutado/'. $get_id[0]['id_reclutamiento']) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                    Agregar
                </button> <?php }?>
            </div>

            <div id="list_reclutado" class="form-group col-md-12">
                <table id="zero-config-reclutado" class="table table-hover" style="width:100%">
                    <thead class="text-center">
                        <tr>
                            <th align="center"><b>Nombre</b></th>
                            <th align="center"><b>Documento</b></th>
                            <th align="center"><b>Fecha de Inicio</b></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        <?php foreach($list_detalle_reclutamiento as $list) {  ?>
                            <tr>
                                <td align="center" ><?php echo $list['usuario_nombres']; ?></td>
                                <td align="center" ><?php echo $list['num_doc']; ?></td>
                                <td align="center" ><?php echo $list['fec_ingreso'] ?></td>
                                <td class="text-center">
                                    <?php if($id_nivel==1 || $id_nivel==2){?>
                                    <a href="javascript:void()" class="" title="Eliminar" onclick="Delete_Reclutado('<?php echo $list['id_reclutamiento'] ?>','<?php echo $list['id_detalle'] ?>')" id="delete" role="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </a>
                                    <?php }?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_reclutamiento" id="id_reclutamiento" value="<?php echo $get_id[0]['id_reclutamiento'] ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Reclutamiento();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".basiccc").select2({
        tags: true
    });

    $('.basiccc').select2({
        dropdownParent: $('#ModalUpdateSlide')
    });

</script>
<script>
$('#zero-config-reclutado').DataTable({
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
    },
    "stripeClasses": [],
    "lengthMenu": [10, 20, 50],
    "pageLength": 10
});

function Update_Reclutamiento() {
    Cargando();

    var dataString = new FormData(document.getElementById('form_reclutamientoe'));
    var url = "{{ url('Reclutamiento/Update_Reclutamiento') }}";
    var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: dataString,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    swal.fire(
                        'Actualización Denegada!',
                        'Existe un registro con los mismos datos',
                        'error'
                    ).then(function() {
                    });
                }else{
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga click en el botón',
                        'success'
                    ).then(function() {
                        $("#ModalUpdateSlide .close").click();
                        Buscador_Reclutamiento('1');
                    });
                }
            },
            error:function(xhr) {
                var errors = xhr.responseJSON.errors;
                var firstError = Object.values(errors)[0][0];
                Swal.fire(
                    '¡Ups!',
                    firstError,
                    'warning'
                );
            }
        });
}

function List_Reclutamiento_Reclutado(id_reclutamiento) {
    Cargando();
    var url = "{{ url('Reclutamiento/List_Reclutamiento_Reclutado') }}";
    var csrfToken = $('input[name="_token"]').val();

    $.ajax({
        type: "POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data: {'id_reclutamiento':id_reclutamiento},
        success: function(data) {
            $('#list_reclutado').html(data);
        }
    });
}

function Delete_Reclutado(id_reclutamiento,id_detalle) {
    var url = "{{ url('Reclutamiento/Delete_Reclutado') }}";
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
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'id_detalle': id_detalle
                },
                success: function() {
                    Swal(
                        'Eliminado!',
                        'El registro ha sido eliminado satisfactoriamente.',
                        'success'
                    ).then(function() {
                        List_Reclutamiento_Reclutado(id_reclutamiento);
                    });
                }
            });
        }
    })
}
</script>
