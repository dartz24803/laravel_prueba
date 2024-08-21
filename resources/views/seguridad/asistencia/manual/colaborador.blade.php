@if ($validacion!="")
    <option value="0">TODOS</option>
@endif
@foreach ($list_colaborador as $list)
    <option value="{{ $list->id_usuario }}">
        {{ $list->nom_usuario }}
    </option>
@endforeach