<style>
    .img-presentation-small {
        width: 80%;
        height: 30%;
        cursor: pointer;
        margin: 5px;
    }
</style>

<form id="formulariod" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Detalle</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo falla: </label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" placeholder="Tipo falla" value="{{ $get_devolucion->tipo_falla }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" placeholder="Cantidad" value="{{ $get_devolucion->cantidad }}" disabled>
            </div>
        </div>

        <div class="row justify-content-center">
            @foreach ($list_archivo as $list)
                <div class="col-lg-4">
                    <div>
                        <img loading="lazy" class="img_post img-presentation-small" src="{{ $list->archivo }}">
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold"><strong>Aprobación: </strong></label>
            </div>
            <div class="form-group col-lg-4">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="si" name="aprobacion" class="custom-control-input" value="1" 
                    @if (isset($get_id->aprobacion) && $get_id->aprobacion==1) checked @endif>
                    <label class="custom-control-label" for="si">Si</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="no" name="aprobacion" class="custom-control-input" value="2" 
                    @if (isset($get_id->aprobacion) && $get_id->aprobacion==2) checked @endif>
                    <label class="custom-control-label" for="no">No</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sustento de respuesta: </label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="sustento_respuesta" name="sustento_respuesta" 
                placeholder="Sustento de respuesta" value="{{ $get_id->sustento_respuesta ?? '' }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Forma de proceder: </label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="forma_proceder" name="forma_proceder" 
                placeholder="Forma de proceder" value="{{ $get_id->forma_proceder ?? '' }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Evaluacion_Temporal();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".img_post").click(function () {
        var popupWidth = this.naturalWidth;
        var popupHeight = this.naturalHeight;
        
        // Calcular las coordenadas X e Y para centrar la ventana emergente
        var leftPosition = (window.screen.width - popupWidth) / 2;
        var topPosition = (window.screen.height - popupHeight) / 2;

        // Abrir la ventana emergente en el centro de la pantalla
        window.open($(this).attr("src"), 'popUpWindow', "height=" + popupHeight + ",width=" + popupWidth + ",top=" + topPosition + ",left=" + leftPosition + ",resizable=yes,toolbar=yes,menubar=no");
    });

    function Insert_Evaluacion_Temporal(){ 
        Cargando();

        var dataString = new FormData(document.getElementById('formulariod'));
        var url = "{{ route('tracking.insert_evaluacion_temporal', $get_devolucion->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success:function (data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Debe ingresar cantidad disponible!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        $("#ModalUpdate .close").click();
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