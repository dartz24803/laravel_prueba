<option value="0">Seleccione</option>
@foreach ($list_gerencia as $list)
    <option value="{{ $list->id_gerencia }}">{{ $list->nom_gerencia }}</option>
@endforeach