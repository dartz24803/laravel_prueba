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
                <h3>Reporte Fotográfico</h3>
            </div>
        </div>
        <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ url('ModalUpdatedReporteFotografico') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Editar
        </a>
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <?php //adm y coord de tienda registran
                        //if($_SESSION['usuario'][0]['id_puesto'] == 29 || $_SESSION['usuario'][0]['id_puesto'] == 161 || $_SESSION['usuario'][0]['id_puesto'] == 197 || $_SESSION['usuario'][0]['id_usuario'] == 139){ ?>
                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistrar" app_reg_metalikas="{{ url('modalRegistrarReporteFotografico') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Registrar
                        </button>
                        <?php //} ?>
                    </div>
                    <div class="toolbar d-flex">
                        <?php
                        //Cada coordinador le debe aparecer su base respectivamente definido
                        $disabled = '';
                        /*if ($base == 'OFC') {
                            $disabled = '';
                        } else {
                            $disabled = 'disabled';
                        }
                        AÑADIR SELECT 2
                        */?>
                        <div class="form-group col-md-4">
                            <label>Base: </label>
                            <select class="form-control basic" id="base" name="base" onchange="Reporte_Fotografico_Listar();"<?= $disabled ?>>
                                <option value="0">TODOS</option>
                                    <?php foreach ($list_bases as $list) { ?>
                                        <option value="<?php echo $list['cod_base']; ?>"
                                        <?php /*if ($list['cod_base'] == $base) {
                                            echo "selected";
                                        }*/ ?>>
                                    <?php echo $list['cod_base']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Area: </label>
                            <select class="form-control basic" id="area" name="area" onchange="Reporte_Fotografico_Listar();">
                                <option value="0" selected>TODOS</option>
                                <?php foreach($list_area as $list){ ?>
                                    <option value="<?php echo $list['id_area']; ?>"><?php echo $list['nom_area']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Codigo: </label>
                            <select class="form-control basic" id="codigo_filtro" name="codigo_filtro" onchange="Reporte_Fotografico_Listar();">
                                <option value="0">TODOS</option>
                                <?php foreach ($list_codigos as $list) { ?>
                                    <option value="<?php echo $list['descripcion']; ?>">
                                        <?php echo $list['descripcion']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4" id="lista">
                        <table id="table_rf" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th> Orden</th>
                                    <th class="text-center">Base</th>
                                    <th class="text-center">Codigo</th>
                                    <th class="text-center">Categoría</th>
                                    <th class="text-center">Area</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center no-content">Foto</th>
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
@include('tienda.ReporteFotografico.modal_registrar')
<script>
    $(document).ready(function() {
        $("#tienda").addClass('active');
        $("#htienda").attr('aria-expanded', 'true');
        $("#reporte_foto").addClass('active');
        Reporte_Fotografico_Listar();
    });

    /**Listar */
    function Reporte_Fotografico_Listar() {
        //Cargando();
        var base = $('#base').val();
        var area = $('#area').val();
        var codigo = $('#codigo_filtro').val();
        $('#table_rf').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
            "ajax": {
                url: "{{ url('ReporteFotograficoListar') }}",
                type: "post",
                data: {
                    base: base,
                    area: area,
                    codigo: codigo
                }
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

    /**EDITAR */
    function editar(id) {
        $('#ModalUpdated').modal('show');
        /*$.post(ruta + "/Area/buscar", { id: id_area },
            function (data) {
                $('#ModalUpdated').modal('show');
                $('#area_id').val(data.data[0].id_area);
                $('#descripcion_area').val(data.data[0].descripcion_area);
            },
            "json"
        );*/
    }
    
    function Delete_Reporte_Fotografico(id) {
        //Cargando();

        var id = id;
        var url = "{{ url('Delete_Reporte_Fotografico') }}";
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
                            Reporte_Fotografico_Listar()
                        });
                    }
                });
            }
        })
    }
</script>
@include('footer')
