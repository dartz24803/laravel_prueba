<option value="0">Seleccione</option>
@foreach ($list_distrito as $list)
    <option value="{{ $list->id_distrito }}">{{ $list->nombre_distrito }}</option>
@endforeach