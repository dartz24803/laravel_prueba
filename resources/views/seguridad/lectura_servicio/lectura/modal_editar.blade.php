<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar lectura de servicio:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <?php if(session('usuario')->id_puesto==24 || session('usuario')->id_puesto==307 || session('usuario')->id_usuario==139){?>
                <div class="form-group col-lg-4">
                    <input id="fecha_lectura" name="fecha_lectura" type="date" class="form-control" value="{{ $get_id->fecha }}">
                </div>
            <?php }else{ ?>
                <div class="form-group col-lg-4">
                    <input type="date" class="form-control" value="{{ $get_id->fecha }}" disabled>
                </div>
            <?php } ?>

            <div class="form-group col-lg-2">
                <label>Servicio:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    @foreach ($list_servicio as $list)
                        <option value="{{ $list->id_servicio }}"
                        @if ($list->id_servicio==$get_id->id_servicio) selected @endif>
                            {{ $list->nom_servicio }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Suministro:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    @foreach ($list_suministro as $list)
                        <option value="{{ $list->id_datos_servicio }}"
                        @if ($list->id_datos_servicio==$get_id->id_datos_servicio) selected @endif>
                            {{ $list->suministro }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-12">
                @if ($tipo=="ing")
                    <h5 class="modal-title">Ingreso</h5>
                @else
                    <h5 class="modal-title">Salida</h5>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Hora:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="time" class="form-control" name="hora_{{ $tipo }}e" id="hora_{{ $tipo }}e" value="@php if($tipo=="ing"){ echo $get_id->hora_ing; }else{ echo $get_id->hora_sal; } @endphp">
            </div>

            <div class="form-group col-lg-2">
                <label>Lectura:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="lect_{{ $tipo }}e" id="lect_{{ $tipo }}e" placeholder="Ingresar lectura"
                onkeypress="return solo_Numeros_Punto(event);" value="@php if($tipo=="ing"){ echo $get_id->lect_ing; }else{ echo $get_id->lect_sal; } @endphp">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Imagen:</label>
                @if ($tipo=="ing")
                    @if ($get_id->img_ing!="")
                        <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Archivo({{ $get_id->id }},{{ $tipo }});">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                                <polyline points="8 17 12 21 16 17"></polyline>
                                <line x1="12" y1="12" x2="12" y2="21"></line>
                                <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                            </svg>
                        </a>
                    @endif
                @else
                    @if ($get_id->img_sal!="")
                        <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Archivo({{ $get_id->id }},'{{ $tipo }}');">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                                <polyline points="8 17 12 21 16 17"></polyline>
                                <line x1="12" y1="12" x2="12" y2="21"></line>
                                <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                            </svg>
                        </a>
                    @endif
                @endif
            </div>
            <div class="form-group col-lg-10">
                <input type="file" class="form-control-file" name="img_{{ $tipo }}e" id="img_{{ $tipo }}e" onchange="Valida_Archivo('img_{{ $tipo }}e');">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Lectura_Servicio();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Lectura_Servicio() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('lectura_servicio_reg.update', [$get_id->id, $tipo]) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="parametro"){
                    Swal({
                        title: '¿Realmente desea editar?',
                        text: "La lectura es mayor a los parámetros definidos para el suministro",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Si',
                        cancelButtonText: 'No',
                        padding: '2em'
                    }).then((result) => {
                        if (result.value) {
                            var dataString = new FormData(document.getElementById('formularioe'));
                            var url = "{{ route('lectura_servicio_reg.update_directo', [$get_id->id, $tipo]) }}";

                            $.ajax({
                                url: url,
                                data: dataString,
                                type: "POST",
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    if(data=="error"){
                                        Swal({
                                            title: '¡Actualización Denegada!',
                                            text: "¡El registro ya existe!",
                                            type: 'error',
                                            showCancelButton: false,
                                            confirmButtonColor: '#3085d6',
                                            confirmButtonText: 'OK',
                                        });
                                    }else{
                                        swal.fire(
                                            '¡Actualización Exitosa!',
                                            '¡Haga clic en el botón!',
                                            'success'
                                        ).then(function() {
                                            Lista_Lectura_Servicio();
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
                    })
                }else if(data=="error"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Lectura_Servicio();
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