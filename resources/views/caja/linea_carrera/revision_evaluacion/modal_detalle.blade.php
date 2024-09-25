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

<div class="modal-header">
    <h5 class="modal-title">Detalle de Evaluación:</h5>
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
                        {{--<span class="text-@php if($list->respuesta==$list->respuesta_correcta){ echo 'success'; }else{ echo 'danger'; } @endphp">
                            (@php if($list->respuesta==$list->respuesta_correcta){ echo 'Respuesta correcta'; }else{ echo 'Respuesta incorrecta'; } @endphp)
                        </span>--}}
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
            <input type="text" class="form-control" placeholder="Nota" value="{{ $get_id->nota }}" readonly>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>