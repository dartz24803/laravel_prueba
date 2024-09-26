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
        <h9 class="card-title">
            <strong>ASUNTO: </strong>
            <?php
                echo $usuario_mail[0]['id_genero'] == 1 ? "BIENVENIDO " : "BIENVENIDA ";

                $nombre=explode(" ",$usuario_mail[0]['usuario_nombres']);
                echo $nombre[0].' '.$usuario_mail[0]['usuario_apater'];
            ?>
        </h9>
        <hr>
        <h9 class="card-title">
            PARA: coordinadores@lanumero1.com.pe; tiendas@lanumero1.com.pe; oficina@lanumero1.com.pe; amauta@lanumero1.com.pe; cd@lanumero1.com.pe; logisticat@lanumero1.com.pe
        </h9><br>
        <h9 class="card-title">
            CC: gerencia@lanumero1.com.pe; 
            <?php
            echo $usuario_mail[0]['emailp'];
            ?>
        </h9>
        <hr>
        <div class="text-center">
            <img class="w-100" src="{{ asset('Bienvenido_Temporales/imagen' . $usuario_mail[0]['id_usuario'] . '.jpg') }}" alt="Imagen de Bienvenida">
        </div>
        <hr>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id" id="id" value="<?php echo $usuario_mail[0]['id_usuario'];?>">
        <button class="btn btn-primary mt-3" onclick="Enviar_Correo_Bienvenida();" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send">
                <line x1="22" y1="2" x2="11" y2="13"></line>
                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
            </svg> Enviar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Enviar_Correo_Bienvenida() {
        Cargando();
        var id_user = $('#id_usuariodp').val();
        var url = "{{ url('ColaboradorController/Enviar_Correo_Bienvenida')}}/" + id_user;
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea enviar el correo?',
            text: "El envío solo se realiza una vez!",
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
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        var divEnviarCorreo = $('#div_enviar_correo_bienvenida');
                        divEnviarCorreo.html('<button class="btn btn-gray mt-3" type="button" disabled><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg></button>');
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
        })
    }
</script>