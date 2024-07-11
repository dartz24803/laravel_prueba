<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Slider RRHH</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label for="" class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-lg-2">
                <select name="tipo" id="tipo" class="form-control">
                    <option value="0">Seleccione</option>
                    <option value="2">Tienda</option>
                    <?php foreach($list_base as $list){ ?> 
                        <option value="<?= $list['cod_base']; ?>"><?= $list['cod_base']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label for="" class="control-label text-bold">Orden:</label>
            </div>            
            <div class="form-group col-lg-2">
                <input type="text" name="orden" id="orden" class="form-control" placeholder="Ingresar orden" onkeypress="return solo_Numeros(event);" maxlength="6">
            </div>

            <div class="form-group col-lg-2">
                <label for="entrada_slide" class="control-label text-bold">Tiempo de entrada:<a href="#" title="La aparicion del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped"><div class="divdea">?</div><span class="title-tooltip">La aparicion del slide va de 0.1s hasta 2.0</span></a></label>
            </div>
            <div class="form-group col-lg-2">
                <input type="text" name="entrada_slide" id="entrada_slide" class="form-control" placeholder="Ingresar tiempo de entrada" maxlength="3" onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label for="salida_slide" class="control-label text-bold">Tiempo de salida:<a href="#" title="La desaparción del slide va de 0.1s hasta 2.0" class="anchor-tooltip tooltiped"><div class="divdea">?</div><span class="title-tooltip">La desaparción del slide va de 0.1s hasta 2.0</span></a></label>
            </div>
            <div class="form-group col-lg-2">
                <input type="text" name="salida_slide" id="salida_slide" placeholder="Ingresar tiempo de salida" class="form-control" maxlength="3" onkeypress="return solo_Numeros_Punto(event);">
            </div>

            <div class="form-group col-lg-2">
                <label for="duracion" class="control-label text-bold">Tiempo de duracion:<a href="#" title="Especificado en segundos y solo perimite nùmeros enteros" class="anchor-tooltip tooltiped"><div class="divdea">?</div><span class="title-tooltip">Especificado en segundos y solo perimite nùmeros enteros</span></a></label>
            </div>
            <div class="form-group col-lg-2">
                <input type="text" name="duracion" id="duracion" placeholder="Ingresar tiempo de duración" class="form-control" maxlength="3" onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label for="tipo_slide" class="control-label text-bold">Tipo de slide:</label>
            </div> 
            <div class="form-group col-lg-2">
                <select name="tipo_slide" class="form-control" id="tipo_slide">
                    <option value="0">Seleccione</option>
                    <option value="1">Imagen</option>
                    <option value="2">Video</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label for="titulo" class="control-label text-bold">Título:</label>
            </div>            
            <div class="form-group col-lg-10">
                <input type="text" name="titulo" id="titulo" placeholder="Ingresar título" class="form-control">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label for="descripcion" class="control-label text-bold">Descripción:</label>
            </div>            
            <div class="form-group col-lg-10">
                <textarea name="descripcion" cols="40" rows="2" id="descripcion" placeholder="Ingresar descripción" class="form-control"></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label for="archivoslide" class="control-label text-bold">Archivo:</label>                
            </div>
            <div class="form-group col-lg-10">
                <input type="file" name="archivoslide" id="archivoslide" class="form-control-file" onchange="return Validar_Archivo('')">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" type="button" onclick="Insert_Slider_Rrhh();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Slider_Rrhh() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ url('Insert_Slider_Rrhh') }}";

        //if (Valida_Slider_Rrhh('')) {
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
                    if(data == "error"){
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Slider_Rrhh();
                            $("#ModalRegistroGrande .close").click();
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
        //}
    }
</script>