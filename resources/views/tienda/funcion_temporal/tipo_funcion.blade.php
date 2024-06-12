@if ($id_tipo=="1")
    <div class="form-group col-lg-2">
        <label class="control-label text-bold">Función: </label> 
    </div>
    <div class="form-group col-lg-10">
        <select class="form-control basicm" id="tarea{{ $v }}" name="tarea{{ $v }}">
            <option value="0">Seleccione</option> 
            @foreach ($list_puesto as $list)
                <option value="{{ $list->id_puesto }}">{{ $list->nom_puesto }}</option>
            @endforeach
        </select>
    </div>
@else
    <div class="form-group col-lg-2">
        <label class="control-label text-bold">Tipo de tarea: </label>
    </div>
    <div class="form-group col-lg-10">
        <select class="form-control basicm" id="select_tarea{{ $v }}" name="select_tarea{{ $v }}" onchange="Tarea_Otros('{{ $v }}');">
            <option value="0">Seleccione</option>
            @foreach ($list_tarea as $list)
                <option value="{{ $list->id }}">{{ $list->descripcion }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-lg-2 esconder{{ $v }}" style="display: none;">
        <label class="control-label text-bold">Tarea: </label>
    </div>
    <div class="form-group col-lg-10 esconder{{ $v }}" style="display: none;">
        <input type="text" class="form-control" id="tarea{{ $v }}" name="tarea{{ $v }}" placeholder="Ingresar tarea">
    </div>
@endif

<script>
    @if ($v=="e")
        $('.basicm').select2({
            dropdownParent: $('#ModalUpdate')
        });
    @else
        $('.basicm').select2({
            dropdownParent: $('#ModalRegistro')
        });
    @endif
</script>