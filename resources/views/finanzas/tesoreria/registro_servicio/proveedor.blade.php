<option value="0">Seleccione</option>
@foreach ($list_proveedor as $list)
    <option value="{{ $list->id_proveedor_servicio }}">{{ $list->nom_proveedor_servicio }}</option>
@endforeach