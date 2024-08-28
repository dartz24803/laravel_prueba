<?php
$id_nivel = session('usuario')->id_nivel;
$id_puesto = session('usuario')->id_puesto;
?>
<table id="tabla_js" class="table table-hover" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Frase</th>
            <th class="no-content"></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($list as $list) {  ?>
            <tr class="text-center">
                <td><?php echo $list['id']; ?></td>
                <td>
                    <?php echo $list['frase']; ?>
                </td>
                <td class="text-center">
                    <?php if (
                        $id_nivel == 1 || $id_puesto == 4 || $id_puesto == 5 || $id_puesto == 27 ||
                        $id_puesto == 28 || $id_puesto == 101 ||
                        $id_puesto == 148 || $id_puesto == 157 || $id_puesto == 184 || $id_puesto == 194
                    ) { ?>
                        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('Inicio/Modal_Update_Frases_Inicio/' .$list['id']) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                            </svg>
                        </a>
                    <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Frase('<?php echo $list['id']; ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <line x1="10" y1="11" x2="10" y2="17"></line>
                            <line x1="14" y1="11" x2="14" y2="17"></line>
                        </svg>
                    </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla_js').DataTable({
            order: [
                [0, "desc"]
            ],
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
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
            "lengthMenu": [10, 20, 50],
            "pageLength": 10,
            "aoColumnDefs": [{
                'targets': [0],
                'visible': false
            }]
        });
        /*
        var tabla = $('#tabla_js').DataTable();

        $('#toggle').change(function() {
            var columnIndex = 3;
            var visible = this.checked;

            tabla.column(columnIndex).visible(visible);
        });*/
    });
</script>
<style>
/*
.toggle-switch {
  position: relative;
  display: inline-block;
  width: 40px;
  height: 24px;
  margin: 10px;
}

.toggle-switch .toggle-input {
  display: none;
}

.toggle-switch .toggle-label {
  position: absolute;
  top: 0;
  left: 0;
  width: 40px;
  height: 24px;
  background-color: gray;
  border-radius: 34px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.toggle-switch .toggle-label::before {
  content: "";
  position: absolute;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  top: 2px;
  left: 2px;
  background-color: #fff;
  box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.3);
  transition: transform 0.3s;
}

.toggle-switch .toggle-input:checked + .toggle-label {
  background-color: #4CAF50;
}

.toggle-switch .toggle-input:checked + .toggle-label::before {
  transform: translateX(16px);
}

.toggle-switch.light .toggle-label {
  background-color: #BEBEBE;
}

.toggle-switch.light .toggle-input:checked + .toggle-label {
  background-color: #9B9B9B;
}

.toggle-switch.light .toggle-input:checked + .toggle-label::before {
  transform: translateX(6px);
}

.toggle-switch.dark .toggle-label {
  background-color: #4B4B4B;
}

.toggle-switch.dark .toggle-input:checked + .toggle-label {
  background-color: #717171;
}

.toggle-switch.dark .toggle-input:checked + .toggle-label::before {
  transform: translateX(16px);
}
*/
</style>
