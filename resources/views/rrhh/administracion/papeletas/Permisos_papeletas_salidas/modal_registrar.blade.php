<form id="formulario_registrar_permiso_papeletas_salida"  method="POST" enctype="multipart/form-data" class="needs-validation" novalidate action="javascript:void(0);">
    <div class="modal-header">
        <h5 class="modal-title">Gestión de Papeletas de Salida</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Puesto Aprueba:</label>
            </div>
            <div id="select_menu" class="form-group col-md-8">
                <select name="id_puesto" id="id_puesto" class="placeholderpermisos js-states custom-select form-control" required>
                    <option value="0">Seleccione</option>
                    <?php foreach($list_puesto as $list){ ?>
                    <option value="<?php echo $list['id_puesto'] ; ?>" >
                    <?php echo $list['nom_puesto'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Puesto(s) Aprobado(s):</label>
            </div> 

            <div class="form-group col-sm-8">
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input"  id="todos" name="todos" value="99">
                        <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Seleccionar todos
                    </label>
                </div>
                <select class="form-control multivalue_pps"  name="id_puesto_permitido[]" id="id_puesto_permitido" multiple="multiple">
                    <?php foreach($list_puesto as $list){ ?> 
                        <option  value="<?php echo $list['id_puesto']; ?>"><?php echo "GERENCIA: ".$list['nom_gerencia']." ÁREA: ".$list['nom_area']." Puesto: ".$list['nom_puesto'];?></option>
                    <?php }  ?>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Papeleta Masiva:</label>
            </div>

            <div class="form-group col-md-1">
                <input type="checkbox" id="checkmasivo" name="checkmasivo" value="1" />                                        
            </div>
        
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Permisos_Papeletas_Salida();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form> 
<script>
    $(".placeholderpermisos").select2({
            placeholder: "Haz una selección",
            allowClear: true,
            dropdownParent: $('#ModalRegistro')
    });

    var update_registro = function () {
        if ($("#todos").is(":checked")) {
            $('#id_puesto_permitido').prop('disabled', 'disabled');
    
        }
        else {
            $('#id_puesto_permitido').prop('disabled', false);
        }
    };

    $(update_registro);
    $("#todos").change(update_registro);
        var ss = $(".multivalue_pps").select2({
            tags: true
        });
        
        $('.multivalue_pps').select2({
            dropdownParent: $('#ModalRegistro')
        });

    
        function Insert_Permisos_Papeletas_Salida() {
        Cargando();
        
        var dataString = $("#formulario_registrar_permiso_papeletas_salida").serialize();
        var url = "{{ url('PapeletasConf/Insert_Permisos_Papeletas_Salidas') }}";
        var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: dataString,
                success: function(data) {
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $("#ModalRegistro .close").click()
                            TablaPermisosPepeletas_salidas();
                        });
                    }
                }
            });
    }
</script>