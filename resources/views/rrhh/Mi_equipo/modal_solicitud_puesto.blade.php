<form id="formulario_solicitud_puesto" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Solicitar como 
            <?php 
                if($tipo==1){ 
                    echo "vendedor";
                }elseif($tipo==2){
                    echo "almacenero";
                }elseif($tipo==3){
                    echo "vendedor cajero";
                }elseif($tipo==4){
                    echo "auxiliar de caja";
                }elseif($tipo==5){
                    echo "cajero principal";
                }elseif($tipo==6){
                    echo "auxiliar de coordinador";
                }elseif($tipo==7){
                    echo "coordinador";
                }
            ?>
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-lg-12 row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Grado de instrucción: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="grado_instruccionsp" name="grado_instruccionsp">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_grado_instruccion as $list){ ?>
                        <option value="<?= $list['id_grado_instruccion']; ?>"><?= $list['nom_grado_instruccion']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
    <input type="hidden" name="tipo" value="<?= $tipo; ?>">
    <button class="btn btn-primary" type="button" onclick="Update_Solicitud_Puesto();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Solicitud_Puesto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_solicitud_puesto'));
        var url = "{{ url('MiEquipo/Update_Solicitud_Puesto') }}";
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Update_Solicitud_Puesto()) {
            $.ajax({
                url: url,
                data: dataString,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {  
                    swal.fire(
                        'Solicitud Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $("#ModalUpdate .close").click();
                        Cargar_x_Base();  
                    });
                }
            });
        }
    }

    function Valida_Update_Solicitud_Puesto(){
        if ($('#grado_instruccionsp').val() === '0'){
            Swal(
                'Ups!',
                'Debe seleccionar grado de instrucción.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }
</script>