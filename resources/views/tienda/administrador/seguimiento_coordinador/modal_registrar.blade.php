<link href="{{ asset('template/inputfiles/css/fileinput.css') }}" media="all" rel="stylesheet" type="text/css"/>
<link href="{{ asset('template/inputfiles/themes/explorer-fas/theme.css') }}" media="all" rel="stylesheet" type="text/css"/>
<script src="{{ asset('template/inputfiles/js/plugins/piexif.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/plugins/sortable.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/fileinput.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/js/locales/es.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/fas/theme.js') }}" type="text/javascript"></script>
<script src="{{ asset('template/inputfiles/themes/explorer-fas/theme.js') }}" type="text/javascript"></script>

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nueva seguimiento al coordinador:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row ml-2 mr-2">
            <table class="table">
                <tr> 
                    <td><label class="control-label text-bold">Si</label></td>
                    <td><label class="control-label text-bold">No</label></td>
                    <td><label class="control-label text-bold">Tarea</label></td>
                    <td><label class="control-label text-bold">Periocidad</label></td>
                </tr>
                @foreach ($list_contenido as $list)
                    <tr>
                        <td>
                            <div class="radio-buttons">
                                <label class="radio-button radio-button-si">
                                    <input type="radio" name="radio_{{ $list->id }}" value="1">
                                    <div class="radio-circle"></div>
                                </label>
                            </div>
                        </td>
                        <td>
                            <div class="radio-buttons">
                                <label class="radio-button radio-button-no">
                                    <input type="radio" name="radio_{{ $list->id }}" value="2">
                                    <div class="radio-circle"></div>
                                </label>
                            </div>
                        </td>
                        <td>
                            <label class="control-label text-bold">{{ $list->descripcion }}</label>
                        </td>
                        <td class="text-center">
                            <label class="control-label text-bold">{{ $list->periocidad }}</label>
                        </td>
                    </tr>                    
                @endforeach
            </table>
        </div>

        <div class="row ml-2 mr-2">
            <div class="form-group col-lg-12">
                <label class="control-label text-bold">Observación: </label>
                <textarea class="form-control" name="observacion" id="observacion" rows="5" placeholder="Observación"></textarea>
            </div>  
        </div>

        <div class="row ml-2 mr-2">
             <div class="form-group col-lg-12">
                <label class="control-label text-bold">Evidencia(s): </label>
            </div>
            <div class="form-group col-lg-12">
                <input type="file" class="form-control" name="archivos[]" id="archivos" multiple>
            </div>
        </div>           	                	        
    </div>

    <div class="modal-footer">
        @csrf
        <input type="hidden" name="base" value="{{ session('usuario')->centro_labores }}">
        <input type="hidden" name="fecha" value="{{ date('Y-m-d') }}">
        <button class="btn btn-primary" type="button" onclick="Insert_Seguimiento_Coordinador();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('#archivos').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        maxTotalFileCount: 5,
        showUpload: false,
        overwriteInitial: false,
        initialPreviewAsData: true,
        allowedFileExtensions: ['jpg','png','jpeg','JPG','PNG','JPEG'],
    });

    function Insert_Seguimiento_Coordinador(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('administrador_sc.store') }}";

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
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data=="sin_contenido"){
                        Swal({
                            title: '¡Registro Denegado!',
                            text: "¡No tiene tareas asignadas!",
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
                        Lista_Seguimiento_Coordinador();
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
    }
</script>
