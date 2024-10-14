<form id="formulario_editar_tramite" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Trámite</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>                
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Motivo:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_motivo" name="id_motivo" onchange="Traer_Destino();">
                    <option value="0" <?php if($get_id[0]['id_motivo']==0){ echo "selected"; } ?>>Seleccione</option>
                    <option value="1" <?php if($get_id[0]['id_motivo']==1){ echo "selected"; } ?>>Laboral</option>
                    <option value="2" <?php if($get_id[0]['id_motivo']==2){ echo "selected"; } ?>>Personal</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Destino:</label>
            </div>
            <div class="form-group col-md-4">
                <select class="form-control" id="id_destino" name="id_destino">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_destino as $list){ ?>
                        <option value="<?php echo $list['id_destino']; ?>" <?php if($list['id_destino']==$get_id[0]['id_destino']){ echo "selected"; } ?>>
                            <?php echo $list['nom_destino']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_tramite" name="nom_tramite" placeholder="Nombre" value="<?php echo $get_id[0]['nom_tramite']; ?>">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad de Uso:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cantidad_uso" name="cantidad_uso" placeholder="Cantidad de Uso" value="<?php echo $get_id[0]['cantidad_uso']; ?>">
            </div>
        </div>  	            	                	        
    </div>

    <div class="modal-footer">
        <input type="hidden" id="id_tramite" name="id_tramite" value="<?php echo $get_id[0]['id_tramite'] ?>">
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Tramite();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form> 

<script>
    $('#cantidad_uso').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Traer_Destino(){
        $(document)
        .ajaxStart(function() {
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
        .ajaxStop(function() {
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
        
        var id_motivo=$('#id_motivo').val();
        var url="<?php echo site_url(); ?>Corporacion/Traer_Destino";

        $.ajax({    
            type:"POST",
            url:url,
            data:{'id_motivo':id_motivo},
            success:function (data) {
                $('#select_destino').html(data);
            }
        });
    }
</script>