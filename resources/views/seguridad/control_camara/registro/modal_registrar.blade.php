<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Nuevo control de cámaras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha: </label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ date('d/m/Y') }}" disabled>
            </div>

            <div class="form-group col-lg-2 mostrar" style="display: none;">
                <label class="control-label text-bold">Hora programada: </label>
            </div>
            <div class="form-group col-lg-4 mostrar" style="display: none;">
                <input type="text" class="form-control" id="hora_programada" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sede: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="id_sede" name="id_sede" onchange="Traer_Hora_Programada();">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sede as $list)
                        <option value="{{ $list->id_sede }}">{{ $list->nombre_sede }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="div_ocurrencias" class="row">
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <input type="hidden" id="captura" name="captura">
        <button id="boton_disabled" class="btn btn-primary" type="button" onclick="Insert_Apertura_Cierre();" disabled>Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Traer_Hora_Programada() {
        Cargando();

        var id_sede = $('#id_sede').val();

        if(id_sede=="0"){
            $('.mostrar').hide();
            $('#hora_programada').val('');
            $('#div_ocurrencias').html('');
        }else{
            var url = "{{ route('control_camara_reg.traer_hora_programada') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: url,
                data: {'id_sede': id_sede},
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    $('.mostrar').show();
                    $('#hora_programada').val(data);
                    Traer_Tienda();
                }
            });
        }
    }

    function Traer_Tienda() {
        Cargando();

        var id_sede = $('#id_sede').val();
        var url = "{{ route('control_camara_reg.traer_tienda') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {'id_sede': id_sede},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#div_ocurrencias').html(data);
            }
        });
    }

    /*function Insert_Apertura_Cierre(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('apertura_cierre_reg.store') }}";

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
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Apertura_Cierre();
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
    }*/
</script>