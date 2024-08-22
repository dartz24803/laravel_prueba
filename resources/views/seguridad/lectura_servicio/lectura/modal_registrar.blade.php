<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva lectura de servicio:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ date('d/m/Y') }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Servicio:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_servicio" id="id_servicio" onchange="Traer_Suministro('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_servicio as $list)
                        <option value="{{ $list->id_servicio }}">{{ $list->nom_servicio }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Suministro:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_datos_servicio" id="id_datos_servicio" onchange="Traer_Lectura('');">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12">
                <h5 class="modal-title">Ingreso</h5>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Hora:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="time" class="form-control" name="hora_ing" id="hora_ing" value="{{ date('H:i') }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Lectura:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="lect_ing" id="lect_ing" placeholder="Ingresar lectura"
                onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Imagen:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="file" class="form-control-file" name="img_ing" id="img_ing" onchange="Valida_Archivo('img_ing');">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Lectura_Servicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Lectura_Servicio() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('lectura_servicio_reg.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="parametro"){
                    Swal({
                        title: '¿Realmente desea registrar?',
                        text: "La lectura es mayor a los parámetros definidos para el suministro",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                        padding: '2em'
                    }).then((result) => {
                        if (result.value) {
                            var dataString = new FormData(document.getElementById('formulario'));
                            var url = "{{ route('lectura_servicio_reg.store_directo') }}";

                            $.ajax({
                                url: url,
                                data: dataString,
                                type: "POST",
                                processData: false,
                                contentType: false,
                                success: function(data) {
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
                                            Lista_Lectura_Servicio();
                                            $("#ModalRegistro .close").click();
                                        })
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
                    })
                }else if(data=="error"){
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
                        Lista_Lectura_Servicio();
                        $("#ModalRegistro .close").click();
                    })
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
