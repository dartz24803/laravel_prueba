<table class="table mb-5" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Código Producto</th>
            <th>Descripción</th>
            <th>Color</th>
            <th>Talla</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($list_detalle as $list)
            <tr class="text-center">
                <td>{{ $list->codigo }}</td>
                <td class="text-left">{{ $list->descripcion }}</td>
                <td>{{ $list->color }}</td>
                <td>{{ $list->talla }}</td>
            </tr>
        @endforeach                                       
    </tbody>
</table>
@php
    $get_detalle = $list_detalle[0];
@endphp
<input type="hidden" name="art_codigo{{ $valida }}" value="{{ $get_detalle->codigo }}">