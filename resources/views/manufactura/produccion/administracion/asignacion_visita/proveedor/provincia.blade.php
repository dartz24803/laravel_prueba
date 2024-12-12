<option value="0">Seleccione</option>
@foreach ($list_provincia as $list)
    <option value="{{ $list->id_provincia }}">{{ $list->nombre_provincia }}</option>
@endforeach