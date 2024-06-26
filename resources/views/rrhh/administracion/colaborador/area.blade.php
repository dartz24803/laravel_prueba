<option value="0">Seleccione</option>
@foreach ($list_area as $list)
    <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
@endforeach