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
        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-lg-12 d-flex justify-content-end">
                        <?php //adm y coord de tienda registran
                        //if($_SESSION['usuario'][0]['id_puesto'] == 29 || $_SESSION['usuario'][0]['id_puesto'] == 161 || $_SESSION['usuario'][0]['id_puesto'] == 197 || $_SESSION['usuario'][0]['id_usuario'] == 139){ ?>
                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="{{ route('tienda.ReporteFotografico.modal_registro')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Registrar
                        </button>
                        <?php //} ?>
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
<script>
    $(document).ready(function() {
        $("#tienda").addClass('active');
        $("#htienda").attr('aria-expanded', 'true');
        $("#reporte_foto").addClass('active');
        Reporte_Fotografico_Listar();
    });
</script>
@include('footer')
