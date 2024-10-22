<option value="0">Seleccione</option>
@foreach ($list_evaluador as $list)
    <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
@endforeach