<table id="tabla_credito" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>Fecha de pago</th>
            <th>Monto de pago</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach ($list_temporal as $list)
            <tr class="text-center">
                <th>{{ $i }}</th>
                <td>{{ $list->fecha }}</td>
                <td>{{ $list->monto }}</td>
            </tr>
            @php $i++; @endphp
        @endforeach
    </tbody>
</table>