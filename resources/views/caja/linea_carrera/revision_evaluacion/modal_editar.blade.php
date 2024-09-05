<style>
    textarea[disabled] {
        background-color: white !important;
        color: black;
    }
    input[type="radio"]:disabled + label {
        color: inherit !important;
    }
    input[readonly] {
        background-color: white !important;
        color: black;
    }
</style>

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
                @if ($list->opciones==null)
                    <div class="form-group col-lg-12">
                        <label class="control-label text-bold">{{ $i.". ".$list->descripcion }}</label>
                        <input type="text" class="form-control col-lg-2 mb-2" id="puntaje_{{ $list->id_pregunta }}" 
                        placeholder="Puntaje" onkeypress="return solo_Numeros_Punto(event);" oninput="Actualizar_Nota(this);">
                        <textarea class="form-control" rows="3" placeholder="Respuesta" disabled>{{ $list->respuesta }}</textarea>
                    </div>
                @else
                    <div class="form-group col-lg-12">
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
                        @php $detalle = explode(",,,",$list->opciones); @endphp
                        @foreach ($detalle as $j => $opcion)
                            @php $pregunta = explode(":::",$opcion); @endphp
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="respuesta_{{ $list->id_pregunta }}" id="respuesta_{{ $j."-".$list->id_pregunta }}"
                                @php if($pregunta[0]==$list->respuesta){ echo "checked"; } @endphp disabled>
                                <label class="custom-control-label" for="respuesta_{{ $j.'-'.$list->id_pregunta }}">{{ $pregunta[1] }}</label>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @php $i++; @endphp
        @endforeach

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Nota:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="notae" id="notae" placeholder="Nota" value="{{ $nota }}" readonly>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Revision_Evaluacion();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var valores_anteriores = {};

    function Actualizar_Nota(input) {
        var id = input.id;
        var valor = parseFloat(input.value);

        // Si el valor es NaN (input vacío), considera el valor como 0
        if (isNaN(valor) || valor < 0 || valor > 1) {
            input.value = '';
            valor = 0;
        }

        // Si el input ha sido previamente llenado, resta el valor anterior
        if (valores_anteriores.hasOwnProperty(id)) {
            var valor_anterior = valores_anteriores[id];
            Actualizar_Valor_Acumulado(-valor_anterior);
        }

        // Suma el nuevo valor al acumulado
        Actualizar_Valor_Acumulado(valor);

        // Almacena el nuevo valor como el valor anterior
        valores_anteriores[id] = valor;
    }

    function Actualizar_Valor_Acumulado(valor) {
        var nota = parseFloat(document.getElementById('notae').value);
        nota += valor;
        document.getElementById('notae').value = nota.toFixed(1);
    }

    function Update_Revision_Evaluacion() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('linea_carrera_re.update', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    'Revisión Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Revision_Evaluacion();
                    $("#ModalUpdate .close").click();
                });  
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