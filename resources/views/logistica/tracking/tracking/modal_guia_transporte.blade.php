<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        @if (session('usuario')->id_puesto==76 ||
        session('usuario')->id_puesto==97 ||
        session('usuario')->id_nivel==1)
            <h5 class="modal-title">Registrar guía de remisión de transporte</h5>
        @else
            <h5 class="modal-title">Guía de remisión de transporte</h5>
        @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Base: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_base" id="id_base">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->id_base }}"
                        @if ($list->cod_base==session('usuario')->centro_labores) selected @endif>
                            {{ $list->cod_base }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Semana: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="semana" id="semana"
                @if (session('usuario')->id_puesto!=76 &&
                session('usuario')->id_puesto!=97 &&
                session('usuario')->id_nivel!=1)
                    onchange="Traer_Guia_Remision();" 
                @endif>
                    <option value="0">Seleccione</option>
                    @php $i = 1; @endphp
                    @while ($i<=date('W'))
                        <option value="{{ $i }}" @if ($i==date('W')) selected @endif>{{ $i }}</option>
                    @php $i++; @endphp
                    @endwhile
                </select>
            </div>
        </div>

        <div class="row">
            @if (session('usuario')->id_puesto==76 ||
            session('usuario')->id_puesto==97 ||
            session('usuario')->id_nivel==1)
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Guía remisión: </label>
                    <a onclick="Limpiar_Ifile('guia_remision');" style="cursor: pointer" 
                    title="Borrar archivo seleccionado">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x text-danger">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </a>
                </div>
                <div class="form-group col-lg-6">
                    <input type="file" class="form-control-file" 
                    name="guia_remision" id="guia_remision" 
                    onchange="Valida_Archivo('guia_remision');">
                </div>
            @else
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Guía remisión: </label>
                </div>
                <div class="form-group col-lg-6" id="div_guia_remision">
                </div>
            @endif
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @if (session('usuario')->id_puesto==76 ||
        session('usuario')->id_puesto==97 ||
        session('usuario')->id_nivel==1)
            <button class="btn btn-primary" type="button" onclick="Insert_Guia_Transporte();">Guardar</button>
        @endif
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    @if (session('usuario')->id_puesto!=76 &&
    session('usuario')->id_puesto!=97 &&
    session('usuario')->id_nivel!=1)
        Traer_Guia_Remision();
    @endif

    function Traer_Guia_Remision(){
        Cargando();

        var url = "{{ route('tracking.traer_guia_transporte') }}";
        var id_base = $('#id_base').val();
        var semana = $('#semana').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'id_base':id_base,'semana':semana},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (data) {
                $('#div_guia_remision').html(data);
            }
        });
    }

    function Insert_Guia_Transporte(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('tracking.insert_guia_transporte') }}";

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
                        text: "¡No hay detalle de transporte inicial!",
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
                        Lista_Tracking();
                        $("#ModalRegistro .close").click();
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