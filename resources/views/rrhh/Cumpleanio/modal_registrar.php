<form id="formulario_saludo<?php if($modal==2){echo "2";}?>"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><?php if($m==1){?>Enviar <?php }?> Saludo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">     
            <div class="form-group col-md-12">
                <label>Mensaje:</label>
                <div class="">
                    <textarea <?php if($m==2){?>disabled <?php }?> name="mensaje" id="mensaje" cols="30" rows="10" class="form-control"><?php if(count($get_id)>0){echo $get_id[0]['mensaje'];} ?></textarea>
                </div>
            </div>
        </div>   	                	        
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_cumpleaniero" name="id_cumpleaniero" value="<?php echo $id_cumpleaniero ?>" class="form-control">
        <input type="hidden" id="id_historial" name="id_historial" value="<?php if(count($get_id)>0){echo $get_id[0]['id_historial'];} ?>" class="form-control">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Saludo_Cumpleanio('<?php echo $modal ?>');">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>    
        <!--<button class="btn btn-primary mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cerrar</button>   -->
        
    </div>
</form> 

<script>
    


    function Insert_Saludo_Cumpleanio(modal){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        if(modal==1){
            var dataString = new FormData(document.getElementById('formulario_saludo'));
        }else{
            var dataString = new FormData(document.getElementById('formulario_saludo2'));
        }
        
        var url="<?php echo site_url(); ?>Corporacion/Insert_Saludo_Cumpleanio";
        if (Valida_Saludo_Cumpleanio()) {
            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                processData: false,
                contentType: false,
                success:function (data) {
                    swal.fire(
                        'Registro Exitoso!',
                        '',
                        'success'
                    ).then(function() {
                        List_Proximo_Cumpleanio(modal);
                        if(modal==1){
                            $("#ModalRegistro .close").click();
                        }else{
                            $("#ModalUpdate .close").click();
                        }
                        
                    });
                }
            });
        }    
        else{
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function () {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Valida_Saludo_Cumpleanio(){
        if($('#mensaje').val().trim() === '') {
            msgDate = 'Debe ingresar mensaje.';
            inputFocus = '#mensaje';
            return false;
        }
        return true;
    }

    function List_Proximo_Cumpleanio(modal){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });
        var url="<?php echo site_url(); ?>Corporacion/List_Proximo_Cumpleanio/"+modal;
        $.ajax({
            type:"POST",
            url:url,
            success:function (data) {
                if(modal==2){
                    $('#busqueda2').html(data);
                }else{
                    $('#busqueda').html(data);
                }
            }
        });
    }
</script>
