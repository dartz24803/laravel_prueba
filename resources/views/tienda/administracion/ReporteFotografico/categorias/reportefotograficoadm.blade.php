
<div class="col-lg-12 d-flex justify-content-end">
    <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('tienda.administracion.ReporteFotografico.modal_registro')}}">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
            <line x1="12" y1="8" x2="12" y2="16"></line>
            <line x1="8" y1="12" x2="16" y2="12"></line>
        </svg>
        Registrar
    </button>
</div>
@csrf
<div class="table-responsive mb-4 mt-4">
    <table id="table_rfa" class="table table-hover" style="width:100%">
        <thead>
            <tr>
                <th> Orden</th>
                <th class="text-center">Categoria</th>
                <th class="text-center">Area</th>
                <th class="text-center">Fecha</th>
                <th class="no-content"></th>
            </tr>
        </thead>
    
        <tbody class="text-center">
        </tbody>
    </table>
</div>
<script>
    Reporte_Fotografico_Adm_Listar();

    /**Listar */
    function Reporte_Fotografico_Adm_Listar() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();

        $('#table_rfa').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            responsive: true,
            "ajax": {
                url: "{{ url('ReporteFotograficoAdmListar') }}",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 25,
            "order": [[0, "desc"]],
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "pagingType": "simple_numbers",
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            // Ordenar por la primera columna de forma descendente
            "columnDefs": [{
                "targets": 0, // La primera columna
                "visible": false, // Ocultar la primera columna
                "searchable": false // No permitir buscar en la primera columna
            }],
        });
    }
    
    function Delete_Reporte_Fotografico_Adm(id) {
        //Cargando();
        var csrfToken = $('input[name="_token"]').val();

        var id = id;
        var url = "{{ url('Delete_Reporte_Fotografico_Adm') }}";
        swal.fire({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
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
                    data: {
                        'id': id
                    },
                    success: function() {
                        swal.fire(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Reporte_Fotografico_Adm_Listar()
                        });
                    }
                });
            }
        })
    }
</script>
