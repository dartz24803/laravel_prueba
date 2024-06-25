<option value="0">Seleccione</option>
@foreach ($list_sub_gerencia as $list)
    <option value="{{ $list->id_sub_gerencia }}">{{ $list->nom_sub_gerencia }}</option>
@endforeach