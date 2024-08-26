@foreach ($list_responsable as $list)
    <option value="{{ $list->id_usuario }}">{{ $list->nom_usuario }}</option>
@endforeach