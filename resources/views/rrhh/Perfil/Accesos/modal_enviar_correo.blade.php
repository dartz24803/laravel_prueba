<form id="formulario_editar" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">CORREO INGRESO DE NUEVO PERSONAL: <b></b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;">
        <?php $nombre=explode(" ",$get_id[0]['usuario_nombres']); ?>
        <h9 class="card-title"><strong>ASUNTO: </strong>SOLICITUD DE ACCESOS Y PREPARACIÓN DE EQUIPOS - <?php echo $nombre[0].' '.$get_id[0]['usuario_apater'] ?></h9>
        <hr>
        <h9 class="card-title">PARA: <?php echo $usuario_mail_soporte[0]['emailp']; ?>, <?php echo $usuario_mail_soporte2[0]['emailp']; ?>  </h9><br>
        <h9 class="card-title">
            CC: 
            <?php
            foreach ($get_jefe_area as $item) {
                echo $item['emailp'] . ', ';
            }
            echo $usuario_mail_2[0]['emailp'];
            ?>, rrhh@lanumero1.com.pe
        </h9>
        <hr>
        <div class="card-text">Estimado equipo de Soporte TI,</div><br>
        <div class="card-text">Su apoyo para crearle usuario de PC y correo al siguiente ingreso:</div><br>
        <div class="table-responsive">
            <table class="table mt-2">
                <thead>
                    <tr class="tableheader">
                        <th class="text-center">Fecha inicio</th>
                        <th class="text-center">DNI</th>
                        <th class="text-center">Apellido paterno</th>
                        <th class="text-center">Apellido materno</th>
                        <th class="text-center">Nombres</th>
                        <th class="text-center">Puesto</th>
                        <th class="text-center">Área</th>
                        <th class="text-center">Gerencia</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">
                            <?php foreach($list_fec_inicio as $list){
                                echo $list['fec_inicio'];
                            } ?>
                        </td>
                        <td class="text-center"><?php echo $get_id[0]['num_doc']; ?></td>
                        <td class="text-center"><?php echo $get_id['0']['usuario_apater'];?></td>
                        <td class="text-center"><?php echo $get_id['0']['usuario_amater'];?></td>
                        <td class="text-center"><?php echo $get_id['0']['usuario_nombres'];?></td>
                        <td class="text-center"><?php echo $get_id[0]['nom_puesto']; ?></td>
                        <td class="text-center"><?php echo $get_id[0]['nom_area']; ?></td>
                        <td class="text-center"><?php echo $get_id[0]['nom_gerencia']; ?></td>
                    </tr>
                </tbody>
            </table>
            <div class="card-text">Además de los siguientes requerimientos para la PC:</div>
            <table class="table mt-4">
                <thead>
                    <tr class="tableheader">
                        <th>CARPETA DE ACCESO (DATACORP)</th>
                        <th>PÁGINAS WEB</th>
                        <th>PROGRAMAS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php
                                $accesos = array_column($list_accesos_datacorp, 'carpeta_acceso');
                                echo implode(', ', $accesos);
                            ?>
                        </td>
                        <td>
                            <?php
                                $accesos = array_column($list_accesos_paginas_web, 'pagina_acceso');
                                echo implode(', ', $accesos);
                            ?>
                        </td>
                        <td>
                            OFFICE, 
                            <?php
                                $accesos = array_column($list_accesos_programas, 'programa');
                                echo implode(', ', $accesos);
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="form-group col-md-12">
            <label for="my-input">Observaciones </label>
            <div class="card-text"> - Todos deben tener acceso a Intranet, Amauta Educa, Zimbra, La Número 1 y Apps de Google.</div><br>
            <div class="card-text"> 
                - Ingresar este correo a los grupos de 
                <?php echo mb_strtolower($get_id[0]['nom_area']) ?>, 
                <?php echo mb_strtolower($get_id[0]['nom_gerencia'])?>, 
                <?php if($get_id[0]['centro_labores']=='OFC'){
                    echo 'oficina';
                }else if($get_id[0]['centro_labores']=='AMT'){
                    echo 'amauta';
                }else{
                    echo $get_id[0]['centro_labores'];
                }
                ?>.
            </div>
            <textarea name="observaciones" id="observaciones" cols="150" rows="5"></textarea>
        </div>
        <div class="card-text">Gracias. </div><br>
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_user" name="id_user" value="<?php echo $get_id[0]['id_usuario']?>">
        <button class="btn btn-primary mt-3" onclick="Enviar_Correo_Colaborador();" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg> Enviar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Enviar_Correo_Colaborador() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_editar'));
        var url = "{{ url('ColaboradorController/Enviar_Correo_Colaborador') }}";
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
                var divEnviarCorreo = $('#div_enviar_correo');
                divEnviarCorreo.html('<a title="Correo enviado" id="btn_enviar_correo" class="btn btn-gray" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" disabled> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg> </a>');
                swal.fire(
                    'Envío de correo Exitoso!',
                    'Haga clic en el botón!',
                    'success'
                ).then(function() {
                    $("#ModalRegistro .close").click()
                });
            }
        });
    }
</script>