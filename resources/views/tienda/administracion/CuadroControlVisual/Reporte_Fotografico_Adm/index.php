<?php $this->load->view('header'); ?>
<?php $this->load->view('nav'); ?>
<?php
$id_nivel = $_SESSION['usuario'][0]['id_nivel'];
$base = $_SESSION['usuario'][0]['centro_labores'];
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
                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="<?= site_url('Tienda/Modal_Registrar_Reporte_Fotografico_Adm') ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Registrar
                        </button>
                    </div>
                    <div class="table-responsive mb-4 mt-4" id="lista">
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

    function Reporte_Fotografico_Adm_Listar() {
        Cargando();
        var url = "<?php echo site_url(); ?>Tienda/Reporte_Fotografico_Adm_Listar";

        $.ajax({
            url: url,
            type: 'POST',
            success: function(data) {
                $('#lista').html(data);
            }
        });
    }
</script>
<?php $this->load->view('validaciones'); ?>
<?php $this->load->view('footer'); ?>