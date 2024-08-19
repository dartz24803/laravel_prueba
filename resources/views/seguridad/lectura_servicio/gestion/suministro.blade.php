<option value="0">Seleccione</option>
@foreach ($list_suministro as $list)
    <option value="{{ $list->id_datos_servicio }}">{{ $list->suministro }}</option>
@endforeach