<option value="0">TODOS</option>
@foreach ($list_tipo_prenda as $list)
    <option value="{{ $list->tipo_prenda }}">{{ $list->tipo_prenda }}</option>
@endforeach