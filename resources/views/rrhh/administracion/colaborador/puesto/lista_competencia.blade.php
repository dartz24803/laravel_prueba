<table class="table">
    <thead>
        <tr>
            <th width="90%">Nombre</th>
            <th width="10%" class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_competencia as $list)
            <tr>
                <td>{{ $list->nom_competencia }}</td>
                <td class="text-center">
                    <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Competencia('{{ $list->id_competencia_puesto }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>