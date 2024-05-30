@include('header')
@include('navbar')
<?php
/*
use Illuminate\Support\Facades\Session;
print_r(Session::get('usuario')->id);
*/
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte Fotográfico Adm</h3>
            </div>
        </div>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="{{ route('tienda.administracion.ReporteFotografico.modal_registro')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Registrar
                        </button>
                    </div>
                    <div class="table-responsive mb-4 mt-4">
                        <table id="table_rfa" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th> Orden</th>
                                    <th class="text-center">Area</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="no-content"></th>
                                </tr>
                            </thead>
                        
                            <tbody class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#ccvtabla").addClass('active');
        $("#hccvtabla").attr('aria-expanded', 'true');
        $("#rfa").addClass('active');
        Reporte_Fotografico_Adm_Listar();
    });

    /**Listar */
    function Reporte_Fotografico_Adm_Listar() {
        //Cargando();
        $('#table_rfa').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
            "ajax": {
                url: "{{ url('ReporteFotograficoAdmListar') }}",
                type: "post",
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
@include('footer')
