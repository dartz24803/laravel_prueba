<option value="0">Seleccione</option>
@foreach ($list_modelo as $list)
    <option value="{{ $list->id_modelo }}">{{ $list->nom_modelo }}</option>
@endforeach