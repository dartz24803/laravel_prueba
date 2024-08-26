<option value="0">Seleccione</option>
@foreach ($list_error as $list)
    <option value="{{ $list->id_error }}">{{ $list->nom_error }}</option>
@endforeach