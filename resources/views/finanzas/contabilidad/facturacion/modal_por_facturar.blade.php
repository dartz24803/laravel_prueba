@section('content')
<div class="container">
    <h2>Facturación Exitosa</h2>

    <!-- Verificar si hay registros -->
    @if($updated_records && $updated_records->count() > 0)
    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="table table-striped" style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr>
                    <th>Estilo</th>
                    <th>Color</th>
                    <th>Talla</th>
                    <th>SKU</th>
                    <th>Descripción</th>
                    <th>Costo Precio</th>
                    <th>Empresa</th>
                    <th>Almacén</th>
                    <th>Guía de Remisión</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($updated_records as $record)
                <tr>
                    <td>{{ $record->estilo }}</td>
                    <td>{{ $record->color }}</td>
                    <td>{{ $record->talla }}</td>
                    <td>{{ $record->sku }}</td>
                    <td>{{ $record->descripcion }}</td>
                    <td>{{ $record->costo_precio }}</td>
                    <td>{{ $record->empresa }}</td>
                    <td>{{ $record->alm_dsc }}</td>
                    <td>{{ $record->guia_remision }}</td>
                    <td>{{ $record->estado }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p>No se encontraron registros para mostrar.</p>
    @endif
</div>
@endsection