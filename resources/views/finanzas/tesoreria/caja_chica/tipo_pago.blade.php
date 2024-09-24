<option value="0">Seleccione</option>
@foreach ($list_tipo_pago as $list)
    <option value="{{ $list->id }}">{{ $list->nombre }}</option>
@endforeach