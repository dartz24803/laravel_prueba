<form id="formulario_registrar_tramite" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Trámite</h5>
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
                    <option value="0">Seleccione</option>
                    <option value="1">Laboral</option>
                    <option value="2">Personal</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Destino:</label>
            </div>
            <div id="select_destino" class="form-group col-md-4">
                <select class="form-control" id="id_destino" name="id_destino">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Nombre:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="nom_tramite" name="nom_tramite" placeholder="Nombre">
            </div>

            <div class="form-group col-md-2">
                <label class="control-label text-bold">Cantidad de Uso:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" id="cantidad_uso" name="cantidad_uso" placeholder="Cantidad de Uso" value="1">
            </div>
        </div>  	           	                	        
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Tramite();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form> 

<script>
    $('#cantidad_uso').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    function Traer_Destino(){
        Cargando();
        
        var id_motivo=$('#id_motivo').val();
        var url="{{ url('PapeletasConf/Traer_Destino') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({    
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data:{'id_motivo':id_motivo},
            success:function (data) {
                $('#select_destino').html(data);
            }
        });
    }

    function Insert_Tramite() {
        Cargando();

        var dataString = $("#formulario_registrar_tramite").serialize();
        var url = "{{ url('PapeletasConf/Insert_Tramite') }}";
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
                            TablaTramite();
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
</script>