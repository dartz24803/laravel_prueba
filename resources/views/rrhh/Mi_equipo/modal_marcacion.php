<style>
    #img_redonda{
        width: 100px;
        height: 100px;
        border-radius: 50px; 
    }
</style>

<form id="formulario_horario_e" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Marcaciones</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>     
    
    <div class="col-md-12 row table-responsive" style="padding:25px;">
        <div class="col-md-12 row" style="margin-bottom:20px;">
            <div class="col-md-2 text-center">
                <img id="img_redonda" src="<?php if($foto_nombre!=""){ echo session('usuario')->url_foto.$foto_nombre; }else{ echo asset("template/assets/img/avatar.jpg"); } ?>" 
                alt="avatar">
            </div>
            <div class="col-md-10" style="position:relative;">
                <label class="control-label text-bold" style="position:absolute;top:40%;"><?php echo $nom_usuario; ?></label>
            </div>
        </div>

        <table id="t_marcacion" class="table table-hover non-hover" width="100%">
            <thead>
                <tr>
                    <th>Orden</th>
                    <th width="20%%">Fecha</th>
                    <th width="20%%">Ingreso</th>
                    <th width="20%">Inicio de refrigerio</th>
                    <th width="20%">Fin de refrigerio</th>
                    <th width="20%%">Salida</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($list_marcacion as $list) {  ?>   
                    <tr>
                        <td><?php echo $list['orden']; ?></td>
                        <td><?php echo $list['fecha']; ?></td>
                        <td><?php echo $list['ingreso']; ?></td>
                        <td><?php echo $list['inicio_refrigerio']; ?></td>
                        <td><?php echo $list['fin_refrigerio']; ?></td>
                        <td><?php echo $list['salida']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="modal-footer">
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#t_marcacion').DataTable({
            order: [[0,"desc"]],
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10,
            "aoColumnDefs" : [ 
                {
                    'targets' : [ 0 ],
                    'visible' : false
                } 
            ]
        });
    });
</script>