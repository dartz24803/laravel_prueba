<option value="0">Seleccione</option>
@foreach ($list_lugar as $list)
    <option value="{{ $list->id_lugar_servicio }}">{{ $list->nom_lugar_servicio }}</option>
@endforeach