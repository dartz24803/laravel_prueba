<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>ID</th>
            <th>Estilo</th>
            <th>Color</th>
            <th>SKU</th>
            <th>Talla</th>
            <th>Descripción</th>
            <th>Costo Precio</th>
            <th>Almacén Descuento</th>
            <th>Almacén Discotela</th>
            <th>Almacén PB</th>
            <th>Almacén Fam</th>
            <th>Almacén Mad</th>
            <th>Fecha Documento</th>
            <th>Guía Remisión</th>
            <th>Fecha Creación</th>
            <th>Fecha Actualización</th>
        </tr>
    </thead>
    <tbody>
        <!-- Los datos se llenarán mediante DataTables -->
    </tbody>
</table>


<script>
    $('#tabla_js').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ route('tabla_facturacion.datatable') }}",
            "type": "GET"
        },
        "pageLength": 50, // Número de registros por página
        "lengthMenu": [10, 25, 50, 100],
        "columns": [{
                "data": "id"
            },
            {
                "data": "estilo"
            },
            {
                "data": "color"
            },
            {
                "data": "sku"
            },
            {
                "data": "talla"
            },
            {
                "data": "descripcion"
            },
            {
                "data": "costo_precio"
            },
            {
                "data": "alm_dsc"
            },
            {
                "data": "alm_discotela"
            },
            {
                "data": "alm_pb"
            },
            {
                "data": "alm_fam"
            },
            {
                "data": "alm_mad"
            },
            {
                "data": "fecha_documento"
            },
            {
                "data": "guia_remision"
            },
            {
                "data": "created_at"
            },
            {
                "data": "updated_at"
            }
        ]
    });
</script>