<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Revisión de Evaluación:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        @php $i = 1; $nota = 0; @endphp
        @foreach ($list_detalle as $list)
            <div class="row">
                <div class="form-group col-lg-12">
                    @if ($list->opciones==null)
                        <label class="control-label text-bold">{{ $i.". ".$list->descripcion }}</label>
                        <textarea class="form-control" rows="3" placeholder="Respuesta" disabled>{{ $list->respuesta }}</textarea>
                    @else
                        @php
                            if($list->respuesta==$list->respuesta_correcta){
                                $nota++;
                            }
                        @endphp
                        <label class="control-label text-bold">
                            {{ $i.". ".$list->descripcion }}
                            <span class="text-@php if($list->respuesta==$list->respuesta_correcta){ echo 'success'; }else{ echo 'danger'; } @endphp">
                                (@php if($list->respuesta==$list->respuesta_correcta){ echo 'Respuesta correcta'; }else{ echo 'Respuesta incorrecta'; } @endphp)
                            </span>
                        </label>
                        @php
                            $j = 0;
                            $detalle = explode(",,,",$list->opciones); 
                            while($j<count($detalle)){
                                $pregunta = explode(":::",$detalle[$j]);
                        @endphp
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="respuesta_{{ $list->id_pregunta }}" id="respuesta_{{ $j."-".$list->id_pregunta }}"
                                @php if($pregunta[0]==$list->respuesta){ echo "checked"; } @endphp disabled>
                                <label class="custom-control-label" for="respuesta_{{ $j.'-'.$list->id_pregunta }}">{{ $pregunta[1] }}</label>
                            </div>
                        @php 
                                $j++;
                            }
                        @endphp 
                    @endif
                </div>
            </div>
        @php $i++; @endphp
        @endforeach

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Nota:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="nota" id="nota" placeholder="Nota" value="{{ $nota }}" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        {{--<button class="btn btn-primary" type="button" onclick="Update_Error();">Guardar</button>--}}
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Error() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('observacion_conf_err.update', $get_id->id) }}";

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
                        Lista_Error();
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