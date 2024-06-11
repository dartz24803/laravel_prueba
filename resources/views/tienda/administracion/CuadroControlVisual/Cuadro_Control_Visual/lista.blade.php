<table id="tabla_js" class="table" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>Puesto</th>
            <th>Horario</th>
            <th>Colaborador</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($list_cuadro_control_visual as $list) { ?>
            <tr>
                <td>
                    <?php echo $list['nom_puesto']; ?>
                </td>
                <td>
                    <?php
                        $sql = "SELECT id_horarios_cuadro_control,
                                CASE WHEN t_refrigerio_h=1 THEN CONCAT(hora_entrada,' - ',ini_refri,' ',
                                fin_refri,' - ',hora_salida) 
                                WHEN t_refrigerio_h=2 THEN CONCAT(hora_entrada,' - ',hora_salida) 
                                WHEN t_refrigerio_h=3 THEN CONCAT(hora_entrada,' - ',ini_refri,' ',
                                fin_refri,' - ',ini_refri2,' ',fin_refri2,' - ',hora_salida) END AS horario 
                                FROM horarios_cuadro_control 
                                WHERE cod_base='".$list['centro_labores']."' AND 
                                id_puesto = " . $list['id_puesto'] . " AND 
                                dia = ((DAYOFWEEK(CURDATE()) + 5) % 7 + 1)";
                        $result = DB::select($sql);
                        $list_horarios = json_decode(json_encode($result), true);
                    ?>
                    <select class="form-control" name="horario" id="horario_<?php echo $list['id_usuario']; ?>" onchange="Asignar_Horario(<?php echo $list['id_usuario']; ?>);">
                        <option value="0">Seleccione</option>
                        <?php foreach ($list_horarios as $list2){ ?>
                            <option value="<?php echo $list2['id_horarios_cuadro_control']; ?>" 
                            <?php if($list2['id_horarios_cuadro_control']==$list['id_horario']){ echo "selected"; } ?>>
                                <?= $list2['horario']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </td>
                <td><?php echo $list['colaborador']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla_js').DataTable({
            "oLanguage": {
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Todos"]],
            "pageLength": -1
        });
    });

    function Asignar_Horario(id_usuario) {
        Cargando();
        
        var id_horario = $('#horario_' + id_usuario).val();
        var url = "{{ url('Insert_Cuadro_Control_Visual_Horario') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            data: {'id_horario': id_horario,'id_usuario': id_usuario},
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                Lista_Cuadro_Control_Visual();
            }
        });
    }
</script>