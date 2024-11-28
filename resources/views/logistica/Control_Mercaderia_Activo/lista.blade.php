<?php
$id_puesto = session('usuario')->id_puesto;
$id_nivel = session('usuario')->id_nivel;
?>
<table id="zero-config2" class="table style-3 " style="width:100%">
    <thead>
        <tr>
            <?php if($tvista=="C"){?>
                <th align="center">Fecha de envío</th>
                <th align="center">Base</th>
                <th align="center">Guía de Remisión</th>
                <th align="center">Observación</th>
                <th align="center">Destino</th>
                <th align="center">Estado</th>
                <th align="center">Acción</th>
            <?php }else{?>
                <th align="center">Doc Despacho</th>
                <th align="center">Fecha</th>
                <th align="center">Estilo</th>
                <th align="center">Genérico</th>
                <th align="center">Descripción</th>
                <th align="center">Sucursal Destino</th>
                <th align="center">Dirección Destino</th>
                <th align="center">Cantidad</th>
                <th align="center">Observación</th>
            <?php }?>

        </tr>
    </thead>
    <tbody>
    <?php if($tvista=="C"){
        foreach($list_reporte as $list){?>
        <tr>
            <td data-order="{{ \Carbon\Carbon::createFromFormat('d/m/Y', $list['Fecha_Doc'])->format('Y-m-d') }}" ><?php echo $list['Fecha_Doc'] ?></td>
            <td><?php echo $base ?></td>
            <td><?php echo $list['Doc_Despacho'] ?></td>
            <td><?php echo $list['Observacion'] ?></td>
            <td><?php echo $list['Direccion_Destino'] ?></td>
            <td><?php
                $busqueda = in_array($list['Doc_Despacho'], array_column($list_reporte_ln1, 'doc_despacho'));
                $posicion = array_search($list['Doc_Despacho'], array_column($list_reporte_ln1, 'doc_despacho'));
                if ($busqueda != false) {
                    $estado=$list_reporte_ln1[$posicion]['estado_control'];
                    echo $list_reporte_ln1[$posicion]['desc_estado'];
                }else{
                    $estado=1;
                    echo "Guía Emitida";
                } ?>
            </td>
            <!--<td><?php echo $list['Sucursal_Destino'] ?></td>
            <td><?php echo $list['Cantidad'] ?></td>-->
            <td class="text-center">
                <?php if($id_puesto==23 || $id_puesto==24 || $id_puesto==26 || $id_nivel==1){
                    if($estado==1 || $estado==2 ){?>
                    <a href="javascript:void(0);" class="" title="Actualizar" onclick="Update_Control_Mercaderia_Activo('<?php echo $estado ?>','<?php echo str_replace(' ', '_', $list['Doc_Despacho']); ?>')" role="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    </a>
                <?php } }?>
            </td>
        </tr>
        <?php }
     }else{
        foreach($list_reporte as $list){?>
        <tr>
            <td><?php echo $list['Doc_Despacho'] ?></td>
            <td><?php echo $list['Fecha_Doc'] ?></td>
            <td><?php echo $list['Estilo'] ?></td>
            <td><?php echo $list['Generico'] ?></td>
            <td><?php echo $list['Descripcion'] ?></td>
            <td><?php echo $list['Sucursal_Destino'] ?></td>
            <td><?php echo $list['Direccion_Destino'] ?></td>
            <td><?php echo $list['Cantidad'] ?></td>
            <td><?php echo $list['Observacion'] ?></td>
        </tr>
        <?php }
     }
     ?>
    </tbody>
</table>

<script>
    $('#zero-config2').DataTable({
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
        "oLanguage": {
            "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
            "sInfo": "Mostrando página _PAGE_ de _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Buscar...",
            "sLengthMenu": "Resultados :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [50, 70, 100],
        "pageLength": 50
    });

    function Update_Control_Mercaderia_Activo(e,doc_despacho) {
        Cargando();
        var url = "{{ url('ControlSalidaMercaderia/Update_Estado_Control_Mercaderia_Activo') }}";
        var csrfToken = $('input[name="_token"]').val();

        if(e==1){
            titulo="confirmar Salida?";
        }if(e==2){
            titulo="confirmar Recepción?";
        }
        Swal({
            title: '¿Realmente desea '+titulo,
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {'doc_despacho': doc_despacho,'estado_control':e},
                    success: function() {
                        Swal(
                            'Actualizado!',
                            '',
                            'success'
                        ).then(function() {
                            Buscar_Control_Mercaderia_Activo();
                        });
                    }
                });
            }
        })
    }

</script>
