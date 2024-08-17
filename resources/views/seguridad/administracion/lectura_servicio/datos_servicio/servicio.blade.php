<option value="0">Seleccione</option>
@foreach ($list_servicio as $list)
    <option value="{{ $list->id_servicio }}">{{ $list->nom_servicio }}</option>
@endforeach