<table id="tabla_credito" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>Fecha de pago</th>
            <th>Monto de pago</th>
            <th class="no-content"></th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($list_temporal as $list)
            <tr class="text-center">
                <th>{{ $i }}</th>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->monto }}</td>
                <td>
                    <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Credito('{{ $list->id }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                </td>
            </tr>
            @php $i++; @endphp
        @endforeach
    </tbody>
</table>