<option value="0">TODOS</option>
@foreach ($list_tipo_usuario as $list)
    <option value="{{ $list->tipo_usuario }}">{{ $list->tipo_usuario }}</option>
@endforeach