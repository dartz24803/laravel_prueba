<form id="formulario_registrar_planilla" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Dato Planilla</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Situación Laboral: </label>
            </div>            
            <div class="form-group col-md-4">
                <select class="form-control basic" name="id_situacion_laboral" id="id_situacion_laboral" onchange="Cambio_Situacion()">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_situacion_laboral as $list){ 
                        if($list['ficha']==1){ ?>
                            <option  value="<?php echo $list['id_situacion_laboral']; ?>"><?php echo $list['nom_situacion_laboral']; ?></option>
                        <?php } ?>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2" id="lbl_tipo_contrato" style="display:none">
                <label class="control-label text-bold">Tipo Contrato: </label>
            </div>            
            <div class="form-group col-md-4" id="input_tipo_contrato" style="display:none">
                <select class="form-control basic" name="id_tipo_contrato" id="id_tipo_contrato" onchange="Cambio_Tipo_Contrato_I();">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_tipo_contrato as $list){ ?>
                        <option  value="<?php echo $list['id_tipo_contrato']; ?>"><?php echo $list['nom_tipo_contrato'];?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-12 row">
            <div class="form-group col-md-2" id="lbl_empresa" style="display:none">
                <label class="control-label text-bold">Empresa: </label>
            </div>            
            <div class="form-group col-md-4" id="input_empresa" style="display:none">
                <select class="form-control basic" name="id_empresa" id="id_empresa" >
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_empresa as $list){ ?>
                        <option  value="<?php echo $list['id_empresa']; ?>"><?php echo $list['nom_empresa'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2" id="lbl_regimen" style="display:none">
                <label class="control-label text-bold">Régimen: </label>
            </div>            
            <div class="form-group col-md-4" id="input_regimen" style="display:none">
                <select class="form-control basic" name="id_regimen" id="id_regimen" >
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_regimen as $list){ ?>
                        <option  value="<?php echo $list['id_regimen']; ?>"><?php echo $list['nom_regimen'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Sueldo: </label> 
            </div>            
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="sueldo" name="sueldo" placeholder="Ingresar Sueldo">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Bono: </label>
            </div>            
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="bono" name="bono" placeholder="Ingresar Bono" onkeypress="return soloNumeros(event)" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Fecha Inicio: </label>
            </div>            
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="fec_inicio" name="fec_inicio">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold ocultar_fec_ven">Fecha Vencimiento: </label>
            </div>            
            <div class="form-group col-md-4">
                <input type="date" class="form-control ocultar_fec_ven" id="fec_vencimiento" name="fec_vencimiento">
            </div>

            <?php if($cantidad>0){?> 
                <div class="form-group col-md-2">
                    <label class="control-label text-bold">Tipo: </label>
                </div>            
                <div class="form-group col-md-4">
                    <label class="control-label text-bold">
                    <?php if(count($get_ultimo)>0){ 
                        if($get_ultimo[0]['motivo_fin']==1){
                            echo "Renovación";
                        }
                        if($get_ultimo[0]['motivo_fin']==2){
                            echo "Reingreso";
                        } 
                    } ?>   
                    </label>
                    <input type="hidden" id="id_tipo" name="id_tipo" value="<?php if(count($get_ultimo)>0){ 
                        if($get_ultimo[0]['motivo_fin']==1){echo "4";}
                        if($get_ultimo[0]['motivo_fin']==2){echo "5";} 
                    } ?>">
                </div>   
            <?php }else{?> 
                <input type="hidden" id="id_tipo" name="id_tipo" value="6">
            <?php }?>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo $cantidad ?>">
        <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id_usuario?>">
        <input type="hidden" name="ultima_fecha_fin" id="ultima_fecha_fin" value="<?php if(count($get_ultimo)>0){ echo $get_ultimo[0]['fec_fin']; } ?>">
        <input type="hidden" name="fecha_fin_historico_estado" id="fecha_fin_historico_estado" value="<?php if(count($get_historico_estado)>0){ echo $get_historico_estado[0]['fec_fin']; } ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Datos_Planilla();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        Cambio_Tipo_Contrato_I();
    });

    $('#sueldo').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9.]/g, '');
    });

    function Cambio_Situacion(){
        var div1 = document.getElementById("lbl_empresa");
        var div2 = document.getElementById("input_empresa");
        var div3 = document.getElementById("lbl_regimen");
        var div4 = document.getElementById("input_regimen");
        var div5 = document.getElementById("lbl_tipo_contrato");
        var div6 = document.getElementById("input_tipo_contrato");

        if($('#id_situacion_laboral').val()==1 || $('#id_situacion_laboral').val()==0){
            div1.style.display = "none";
            div2.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "none";
            div5.style.display = "none";
            div6.style.display = "none";
            document.getElementById("id_empresa").value = "0";
            document.getElementById("id_regimen").value = "0";
            document.getElementById("id_tipo_contrato").value = "0";
        }else{
            div1.style.display = "block";
            div2.style.display = "block";
            div3.style.display = "block";
            div4.style.display = "block";
            div5.style.display = "block";
            div6.style.display = "block";
        }
    }

    function Cambio_Tipo_Contrato_I(){
        var id_tipo_contrato = $('#id_tipo_contrato').val();

        if(id_tipo_contrato==1){
            $('.ocultar_fec_ven').hide();
            $('#fec_vencimiento').val('');
        }else{
            $('.ocultar_fec_ven').show();
        }
    }
    function Insert_Datos_Planilla() {
        var dataString = new FormData(document.getElementById('formulario_registrar_planilla'));
        var url = "{{ url('ColaboradorController/Insert_Dato_Planilla') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡Existe un registro con la misma fecha de inicio o empresa!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else if (data == "incompleto") {
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡Existe un registro en estado activo!",
                        type: 'warning',
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
                        var dataString1 = new FormData(document.getElementById('formulario_registrar_planilla'));
                        var url1 = "{{ url('ColaboradorController/List_datosgenerales_planilla') }}";
                        var csrfToken = $('input[name="_token"]').val();

                        $.ajax({
                            type: "POST",
                            data: dataString1,
                            url: url1,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            processData: false,
                            contentType: false,
                            success: function(resp) {
                                $('#datosplanilla').html(resp);
                                $("#ModalRegistro .close").click();
                            }
                        });

                        var dataString2 = new FormData(document.getElementById('formulario_registrar_planilla'));
                        var url2 = "{{ url('ColaboradorController/List_datos_planilla') }}";
                        var csrfToken = $('input[name="_token"]').val();

                        $.ajax({
                            type: "POST",
                            data: dataString2,
                            url: url2,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            processData: false,
                            contentType: false,

                            success: function(resp) {
                                $('#mddatoplanilla').html(resp);
                                
                            }
                        });

                        var url3 = "{{ url('ColaboradorController/Btn_Planilla_Perfil') }}";
                        var dataString3 = new FormData(document.getElementById('formulario_registrar_planilla'));
                        var csrfToken = $('input[name="_token"]').val();

                        $.ajax({
                            type: "POST",
                            url: url3,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: dataString3,
                            processData: false,
                            contentType: false,

                            success: function(resp) {
                                $('#btn_planilla').html(resp);
                            }
                        });
                    });
                    $('#btn_enviar_correo1').prop('disabled', false).removeClass('btn-gray').addClass('btn-primary');
                    $('#btn_enviar_correo2').prop('disabled', false).removeClass('btn-gray').addClass('btn-danger');
                }
            }
        });
    }
</script>