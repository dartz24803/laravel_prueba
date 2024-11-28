<option value="0">Todos</option>
@foreach ($list_estado as $list)
    <option value="{{ $list->id }}">{{ $list->descripcion }}</option>
@endforeach