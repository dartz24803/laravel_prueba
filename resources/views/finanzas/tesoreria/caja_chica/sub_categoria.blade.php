<option value="0">Seleccione</option>
@foreach ($list_sub_categoria as $list)
    <option value="{{ $list->id }}">{{ $list->nombre }}</option> 
@endforeach