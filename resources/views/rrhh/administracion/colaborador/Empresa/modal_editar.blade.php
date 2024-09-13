<style>
    .containermail {
        left: 50%;
        top: 50%;
        position: absolute;
        transform: translate(-50%,-50%);
        border: 1px solid black;
        width: 500px;
        height: 150px;
    }
    .contentsemail {
        margin-top: 25px;
    }

    #lbl {
        margin-top: 5px;
    }

    #email {
        margin-left: 30px;
        margin-top: 15px;
        width: 80%;
        height: 30px;
        text-indent: 15px;
    }

    ::-webkit-input-placeholder {
        font-size: 15px;
    }

    i.fa {
        font-size: 25px;
        position: absolute;
        left: 100%;
        top: 13%;
    }

    #success {
        color: green;
        display: none;
    }

    #error {
        color: red;
        display: none;
    }

    #warning {
        color: red;
        display: none;
    }

    span#span1 {
        color: red;
        font-weight: bold;
        display: none;
    }

    span#span2 {
        padding-top: 5px;
        left: 0px;
        color: red;
        font-weight: bold;
        display: none;
    }

    #lbl2 {
        font-size: 13px;
        margin-top: 5px;
    }
</style>

<form id="formulario_editar_empresa" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Empresa <b><?php echo $get_id[0]['nom_empresa']; ?></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Siglas:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="text" min="1" max="99" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "10" class="form-control" id="cod_empresa" name="cod_empresa" value="<?php echo $get_id[0]['cod_empresa']; ?>" placeholder="Siglas">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>            
            <div class="form-group col-md-5">
                <input type="text" class="form-control" id="nom_empresa" name="nom_empresa" value="<?php echo $get_id[0]['nom_empresa']; ?>" placeholder="Ingresar Nombre de Empresa" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">RUC:</label>
            </div>
            <div class="form-group col-md-5">
                <input type="number" min="1" max="99" class="form-control" id="ruc_empresa" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "11"   name="ruc_empresa" value="<?php echo $get_id[0]['ruc_empresa']; ?>" placeholder="RUC">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Banco:</label>
            </div>           
            <div class="form-group col-md-3">
                <select class="form-control" name="id_banco" id="id_banco">
                <option value="0"  <?php if (!(strcmp(0, $get_id[0]['id_banco']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                <?php foreach($list_banco as $list){ ?>
                <option value="<?php echo $list['id_banco'] ; ?>" <?php if (!(strcmp($list['id_banco'], $get_id[0]['id_banco']))) {echo "selected=\"selected\"";} ?> >
                <?php echo $list['nom_banco'];?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Cuenta:</label>
            </div>
            <div class="form-group col-md-5">
                <input type="number" min="1" max="99" class="form-control" id="num_cuenta"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "20" name="num_cuenta" value="<?php echo $get_id[0]['num_cuenta']; ?>" placeholder="N° Cuenta">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Regimen:</label>
            </div>
    
            <div class="form-group col-md-3">
                <select class="form-control" name="id_regimen" id="id_regimen">
                <option  value="0"  selected>Seleccione</option>
                <?php foreach($list_regimen as $list){
                if($get_id[0]['id_regimen'] == $list['id_regimen']){ ?> 
                <option selected value="<?php echo $list['id_regimen']; ?>"><?php echo $list['nom_regimen'];?></option>
                <?php }else{?>
                <option value="<?php echo $list['id_regimen']; ?>"><?php echo $list['nom_regimen'];?></option>
                <?php } } ?>
                </select>  
            </div>  

            <div class="form-group col-md-2">
                <label  id="lbl" class="control-label text-bold">Correo:</label>
            </div>
            <div class="form-group col-md-5">
                    <i class="fa fa-check" aria-hidden="true" id="success"></i>
                    <i class="fa fa-times" aria-hidden="true" id="error"></i>
                    <i class="fa fa-exclamation" aria-hidden="true" id="warning"></i>
                    <input type="email" class="form-control email_empresa" id="email_empresa" name="email_empresa" value="<?php echo $get_id[0]['email_empresa']; ?>" placeholder="Correo de empresa" ><br />
                    <span id="span1">Ingresa un correo Valido</span>
                    <span id="span2">Debe llenar este campo</span>
            </div>

            <div class="form-group col-md-2">
                <label id="lbl2" class="control-label text-bold">Activo:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="checkbox" class="minimal" id="activo" <?php if($get_id[0]['activo']==1){echo "checked"; }?> name="activo" value="1">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Teléfono:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" 
                id="telefono_empresa" name="telefono_empresa" maxlength="9" placeholder="Teléfono de empresa" value="<?php echo $get_id[0]['telefono_empresa']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio Actividad:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_actividad" name="inicio_actividad" value="<?php echo $get_id[0]['inicio_actividad']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Partida:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" min="1" max="99" class="form-control" id="num_partida"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "10" name="num_partida" value="<?php echo $get_id[0]['num_partida']; ?>" placeholder="Ingresar N° partida">
            </div>

            <div class="form-group col-md-2">
                <label id="lbl2" class="control-label text-bold">Departamento:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_departamento" id="id_departamento" onchange="provincia()">
                <option value="0">Seleccione</option>
                <?php foreach($list_departamento as $list){
                    if($get_id[0]['id_departamento'] == $list->id_departamento){ ?>
                    <option selected value="<?php echo $list->id_departamento; ?>"><?php echo $list->nombre_departamento;?></option> 
                <?php }else{?>
                <option value="<?php echo $list->id_departamento; ?>"><?php echo $list->nombre_departamento;?></option>
                <?php } } ?>
                </select>         
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Provincia:</label>
            </div>
            <div class="form-group col-md-4" id="mprovincia">
                <select class="form-control" name="id_provincia" id="id_provincia"  onchange="distrito()">
                <option  value="0"  selected>Seleccione</option>
                <?php foreach($list_provincia as $list){
                if($get_id[0]['id_provincia'] == $list->id_provincia){ ?> 
                <option selected value="<?php echo $list->id_provincia; ?>"><?php echo $list->nombre_provincia;?></option>
                <?php }else{?>
                <option value="<?php echo $list->id_provincia; ?>"><?php echo $list->nombre_provincia;?></option>
                <?php } } ?>
                 </select>  
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Distrito:</label>
            </div>
            <div class="form-group col-md-4" id="mdistrito">
                 <select class="form-control" name="id_distrito" id="id_distrito">
                <option  value="0"  selected>Seleccione</option>
                <?php foreach($list_distrito as $list){
                if($get_id[0]['id_distrito'] == $list->id_distrito){ ?> 
                <option selected value="<?php echo $list->id_distrito; ?>"><?php echo $list->nombre_distrito;?></option>
                <?php }else{?>
                <option value="<?php echo $list->id_distrito; ?>"><?php echo $list->nombre_distrito;?></option>
                <?php } } ?>
                 </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Direccion:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="direccion"  name="direccion" value="<?php echo $get_id[0]['direccion']; ?>" placeholder="Ingresar dirección">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Días Laborales:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="dias_laborales"  name="dias_laborales" placeholder="Días Laborales" min="1" value="<?php echo $get_id[0]['dias_laborales']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Horas/Día:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="hora_dia"  name="hora_dia" placeholder="Horas/Día" min="1" value="<?php echo $get_id[0]['hora_dia']; ?>">
            </div>

            <div class="form-group col-md-6">
                <label>Firma: <?php if($get_id[0]['firma']!=""){?> 
                    <a href="javascript:void(0);" title="Documento" data-toggle="modal" data-target="#Modal_IMG_Link_Normal" data-imagen="<?php echo $url[0]['url_config'].$get_id[0]["firma"]?>" data-title="Firma">
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg>
                    </a>
                    <?php }?>
                </label>
                <div class="" >
                    <input id="firmae" name="firmae" type="file" class="form-control-file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg"]'>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Logo: (500x500px) <?php if($get_id[0]['logo']!=""){?> 
                    <a href="javascript:void(0);" title="Documento" data-toggle="modal" data-target="#Modal_IMG_Link_Normal" data-imagen="<?php echo $url[0]['url_config'].$get_id[0]["logo"]?>" data-title="Logo">
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg>
                    </a>
                    <?php }?></label>
                <div class="" >
                    <input type="file" class="form-control-file" id="logoe" name="logoe" onchange="validar_Archivo_Formato_Tamanio(this,'500','500')"/>   
                </div>
            </div>
            
            <div class="form-group col-md-6">
                <label>Pie de Pagina: (300x2000px)<?php if($get_id[0]['pie']!=""){?> 
                    <a href="javascript:void(0);" title="Documento" data-toggle="modal" data-target="#Modal_IMG_Link_Normal" data-imagen="<?php echo $url[0]['url_config'].$get_id[0]["pie"]?>" data-title="Pie de Página">
                        <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg>
                    </a>
                    <?php }?></label>
                <div class="">
                    <input type="file" class="form-control-file" id="piee" name="piee" onchange="validar_Archivo_Formato_Tamanio(this,'300','2000')"/>   
                </div>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Aporte Senati: </label>
            </div>
            <div class="form-group col-md-4">
                <input type="checkbox" id="aporte_senati" name="aporte_senati" value="1" <?php if($get_id[0]['aporte_senati']==1){ echo "checked"; } ?>>
            </div>

            <div class="form-group col-md-2">
                <label id="lbl2" class="control-label text-bold">Representante:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="representante_empresa"  name="representante_empresa" value="<?php echo $get_id[0]['representante_empresa']; ?>" placeholder="Ingresar Representante">
            </div>

            <div class="form-group col-md-2">
                <label id="lbl2" class="control-label text-bold">Tipo Documento:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                <option value="0"  <?php if (!(strcmp(0, $get_id[0]['id_tipo_documento']))) {echo "selected=\"selected\"";} ?> >Seleccione</option>
                <?php foreach($list_tipo_documento as $list){ ?>
                <option value="<?php echo $list['id_tipo_documento'] ; ?>" <?php if (!(strcmp($list['id_tipo_documento'], $get_id[0]['id_tipo_documento']))) {echo "selected=\"selected\"";} ?> >
                <?php echo $list['nom_tipo_documento'];?></option>
                <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Documento:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" min="1" max="99" class="form-control" id="num_documento" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "8"   name="num_documento" value="<?php echo $get_id[0]['num_documento']; ?>" placeholder="N° documento">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input name="firma_actual" type="hidden" class="form-control" id="firma_actual" value="<?php echo $get_id[0]['firma']; ?>">
        <input name="id_empresa" type="hidden" class="form-control" id="id_empresa" value="<?php echo $get_id[0]['id_empresa']; ?>">
        <button class="btn btn-primary mt-3" id="createProductBtn" onclick="Edit_Empresa();" type="button">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function(){
        $('.email_empresa').focusout(function(){
            email_validate();
        });

        function email_validate() {

            var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var email = $('.email_empresa').val();

            if(email !== '') {
                if(pattern.test(email)) {
                $('#lbl').css('color','#008000ab');
                $('.email_empresa').css('border','2px solid green'); 
                $('#success').css('display','block');
                $('#error').css('display','none');
                $('#span1').css('display','none');
                $('#span2').css('display','none');
                $('#warning').css('display','none');
                }
                else {
                $('#lbl').css('color','#ff0000b0');
                $('.email_empresa').css('border','2px solid red'); 
                $('#error').css('display','block');
                $('#success').css('display','none');
                $('#span1').css('display','block');
                $('#span2').css('display','none');
                $('#warning').css('display','none');
                }
            }
            else {
            $('#span2').css('display','block');
            $('#lbl').css('color','red');
            $('#email_empresa').css('border','2px solid red'); 
            $('#error').css('display','none');
            $('#success').css('display','none');
            $('#warning').css('display','block');
            $('#span1').css('display','none');
            }
        }
    });
</script>

<script>
function provincia(){
    var url = "{{ url('ColaboradorConfController/Provincia') }}";
    var csrfToken = $('input[name="_token"]').val();

    $.ajax({
        url: url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        //data: frm,
        data: $("#formulario_editar_empresa").serialize(),
        success: function(data)             
        {
            $('#mprovincia').html(data);
        }
    });
    distrito();
}

function distrito(){
    var url = "{{ url('ColaboradorConfController/Distrito') }}";
    $.ajax({
        url: url, 
        type: 'POST',
        //data: frm,
        data: $("#formulario_editar_empresa").serialize(),
        success: function(data)             
        {
            $('#mdistrito').html(data);               
        }
    });
}

function Edit_Empresa(){
    var dataString = new FormData(document.getElementById('formulario_editar_empresa'));
    var url="{{ url('ColaboradorConfController/Update_Empresa') }}";
    var csrfToken = $('input[name="_token"]').val();

    $.ajax({
        type:"POST",
        url: url,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        data:dataString,
        processData: false,
        contentType: false,
        success:function (data) {
            if (data == "error") {
                Swal({
                    title: 'Actualizacion Denegada',
                    text: "¡El registro ya existe!",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
            } else {
                swal.fire(
                    'Actualización Exitosa!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    $("#ModalUpdate .close").click()
                    TablaEmpresa();
                });
            }
        },
        error: function(xhr) {
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
</script>
  