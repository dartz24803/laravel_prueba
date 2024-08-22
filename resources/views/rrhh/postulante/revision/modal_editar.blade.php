<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Detalle de Vínculos:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Resultado:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="resultado" id="resultado">
                    <option value="0">Seleccione</option>
                    <option value="10">SELECCIONADO</option>
                    <option value="9">NO SELECCIONADO</option>
                </select>
            </div>
        </div>

        <div class="table-responsive row">
            <table id="tabla_vinculo" class="table" style="width:100%">
                <thead>
                    <tr class="text-center"> 
                        <th>Base</th>
                        <th>N° Documento</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Nombres</th>
                        <th>Estado</th>
                        <th>Fecha Cese</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_vinculo as $list)
                        <tr class="text-center">
                            <td>{{ $list->centro_labores }}</td>
                            <td>{{ $list->num_doc }}</td>
                            <td class="text-left">{{ $list->usuario_apater }}</td>
                            <td class="text-left">{{ $list->usuario_amater }}</td>    
                            <td class="text-left">{{ $list->usuario_nombres }}</td>
                            <td>{{ $list->nom_estado_usuario }}</td>
                            <td>{{ $list->fecha_cese }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Revision();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $('#tabla_vinculo').DataTable({
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
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
            "stripeClasses": [],
            "lengthMenu": [10, 20, 50],
            "pageLength": 10
        });
    });

    function Update_Revision() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('postulante_revision.update', $get_id->id_postulante) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Revision();
                    $("#ModalUpdate .close").click();
                });  
            },
            error:function(xhr) {
                var errors = xhr.responseJSON.errors;
                var firstError = Object.values(errors)[0][0];
                Swal.fire(
                    '¡Ups!',
                    firstError,
                    'warning'
                );
            }
        });
    }
</script>