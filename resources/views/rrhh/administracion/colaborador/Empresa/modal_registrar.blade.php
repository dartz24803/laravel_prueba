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
        left: 80%;
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

<form id="formulario_registrar_empresa" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nueva Empresa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Siglas:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="text" min="1" max="99" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "10" class="form-control" id="cod_empresa" name="cod_empresa" value="" placeholder="Siglas">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-5">
                <input type="text" class="form-control" id="nom_empresa" name="nom_empresa" value="" placeholder="Ingresar Nombre de Empresa" autofocus>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">RUC:</label>
            </div>
            <div class="form-group col-md-5">
                <input type="number" min="1" max="99" class="form-control" id="ruc_empresa" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "11"   name="ruc_empresa" value="" placeholder="Ingresar RUC de empresa">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Banco:</label>
            </div>
            <div class="form-group col-md-3">
                  <select class="form-control" name="id_banco" id="id_banco">
	                		<option value="0"  >Seleccione</option>
	                			<?php foreach($list_banco as $list){ ?>
	                    		<option value="<?php echo $list['id_banco'] ; ?>" >
	                        	<?php echo $list['nom_banco'];?></option>
	                			<?php } ?>
	                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Cuenta:</label>
            </div>
            <div class="form-group col-md-5">
                <input type="number" min="1" max="99" class="form-control" id="num_cuenta"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "20" name="num_cuenta" value="" placeholder="N° Cuenta">
            </div>

            <div class="form-group col-md-2">
                <label id="lbl2"class="control-label text-bold">Regimen:</label>
            </div>

            <div class="form-group col-md-3">
                <select required class="form-control" name="id_regimen" id="id_regimen">
                    <option  value="0">Seleccione</option>
                    <?php foreach($list_regimen as $list){ ?>
                        <option value="<?php echo $list['id_regimen']; ?>"><?php echo $list['nom_regimen'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label id="lbl"  class="control-label text-bold">Correo:</label>
            </div>
            <div class="form-group col-md-5">
                    <i class="fa fa-check" aria-hidden="true" id="success"></i>
                    <i class="fa fa-times" aria-hidden="true" id="error"></i>
                    <i class="fa fa-exclamation" aria-hidden="true" id="warning"></i>
                    <input type="email" class="form-control email_empresa" id="email_empresa" name="email_empresa" value="" placeholder="Correo de empresa" ><br />
                  <span id="span1">Ingresa un correo Valido</span>
                  <span id="span2">Debe llenar este campo</span>
            </div>

            <div class="form-group col-md-2">
                <label id="lbl2" class="control-label text-bold">Activo:</label>
            </div>
            <div class="form-group col-md-3">
                <input type="checkbox" class="minimal" id="activo"  name="activo" value="1" checked>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Teléfono:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                id="telefono_empresa" name="telefono_empresa" maxlength="9" placeholder="Teléfono de empresa">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Inicio Actividad:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="date" class="form-control" id="inicio_actividad" name="inicio_actividad">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Partida:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control"
                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "10" id="num_partida"  name="num_partida" value="" placeholder="Ingresar N° de partida">
            </div>

            <div class="form-group col-md-2">
                <label id="lbl2"class="control-label text-bold">Departamento:</label>
            </div>

            <div class="form-group col-md-4">
                <select required class="form-control" name="id_departamento" id="id_departamento" onchange="provincia()">
                    <option  value="0">Seleccione</option>
                    <?php foreach($list_departamento as $list){ ?>
                        <option value="<?php echo $list->id_departamento ?>"><?php echo $list->nombre_departamento?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Provincia:</label>
            </div>
            <div class="form-group col-md-4" id="mprovincia">
                <select class="form-control" name="id_provincia" id="id_provincia">
                <option  value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Distrito:</label>
            </div>
            <div class="form-group col-md-4" id="mdistrito">
                <select class="form-control" name="id_distrito" id="id_distrito">
                <option  value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Direccion:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="direccion"  name="direccion" value="" placeholder="Ingresar dirección">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Días Laborales:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="dias_laborales"  name="dias_laborales" placeholder="Días Laborales" min="1">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Horas/Día:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" id="hora_dia"  name="hora_dia" placeholder="Horas/Día" min="1">
            </div>


            <div class="form-group col-md-6">
                <label>Firma:</label>
                <div class="" >
                    <input id="firma" name="firma" type="file" class="form-control-file" size="100" required data-allowed-file-extensions='["jpeg|png|jpg"]'>
                </div>
            </div>
            <div class="form-group col-md-6">
                <label>Logo: (500x500px)</label>
                <div class="" >
                    <input type="file" class="form-control-file" id="logo" name="logo" onchange="validar_Archivo_Formato_Tamanio(this,'500','500')"/>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label>Pie de Pagina: (300x2000px)</label>
                <div class="">
                    <input type="file" class="form-control-file" id="pie" name="pie" onchange="validar_Archivo_Formato_Tamanio(this,'300','2000')"/>
                </div>
            </div>


            <div class="form-group col-md-6">
                <label class="control-label text-bold">Aporte Senati: </label>
                <div class="">
                    <input type="checkbox" id="aporte_senati" name="aporte_senati" value="1" checked>
                </div>
            </div>


            <div class="form-group col-md-2">
                <label id="lbl2" class="control-label text-bold">Representante:</label>
            </div>
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="representante_empresa"  name="representante_empresa" value="" placeholder="Ingresar Representante">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo Documento:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                    <option value="0" >Seleccione</option>
                    <?php foreach($list_tipo_documento as $list){ ?>
                    <option value="<?php echo $list->id_tipo_documento ; ?>"  >
                    <?php echo $list->nom_tipo_documento;?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">N° Documento:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="number" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                    maxlength = "8" id="num_documento"  name="num_documento" value="" placeholder="Ingresar N° documento">
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Empresa();">Guardar</button>
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
            $('.email_empresa').css('border','2px solid red');
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
            data: $("#formulario_registrar_empresa").serialize(),
            success: function(data){
                $('#mprovincia').html(data);
            }
        });
        distrito();
    }

    function distrito(){
        var url = "{{ url('ColaboradorConfController/Distrito') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            //data: frm,
            data: $("#formulario_registrar_empresa").serialize(),
            success: function(data){
                $('#mdistrito').html(data);
            }
        });
    }
    function Insert_Empresa() {
        var dataString = new FormData(document.getElementById('formulario_registrar_empresa'));
        var url = "{{ url('ColaboradorConfController/Insert_Empresa') }}";
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
