<option value="0">Seleccione</option>
@foreach ($list_puesto as $list)
    <option value="{{ $list->id_puesto }}">{{ $list->nom_puesto }}</option>
@endforeach