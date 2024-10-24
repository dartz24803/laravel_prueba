<option value="0">Seleccione</option>
@foreach ($list_categoria as $list)
    <option value="{{ $list->id_categoria }}">{{ $list->nom_categoria }}</option> 
@endforeach