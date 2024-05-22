@include('header')
@include('navbar')
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
                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="">
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
                        } */?>
                        <div class="form-group col-md-4">
                            <label>Base: </label>
                            <select class="form-control basic" id="base" name="base" onchange="Reporte_Fotografico_Listar();"<?= $disabled ?>>
                                <option value="0">TODOS</option>
                                    <?php //foreach ($list_bases as $list) { ?>
                                        <option value="<?php// echo $list['cod_base']; ?>" 
                                        <?php /*if ($list['cod_base'] == $base) {
                                            echo "selected";
                                        }*/ ?>>
                                    <?php //echo $list['cod_base']; ?>
                                </option>
                                <?php //} ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Area: </label>
                            <select class="form-control basic" id="area" name="area" onchange="Reporte_Fotografico_Listar();">
                                <option value="0" selected>TODOS</option>
                                <?php //foreach($list_area as $list){ ?>
                                    <option value="<?php //echo $list['id_area']; ?>"><?php //echo $list['nom_area']; ?></option>
                                <?php //} ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Codigo: </label>
                            <select class="form-control basic" id="codigo_filtro" name="codigo_filtro" onchange="Reporte_Fotografico_Listar();">
                                <option value="0">TODOS</option>
                                    <?php //foreach ($list_codigos as $list) { ?>
                                        <option value="<?php //echo $list['descripcion']; ?>">
                                    <?php //echo $list['descripcion']; ?>
                                </option>
                                <?php //} ?>
                            </select>
                        </div>
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
        $("#tienda").addClass('active');
        $("#htienda").attr('aria-expanded', 'true');
        $("#reporte_foto").addClass('active');
        Reporte_Fotografico_Listar();
    });

    function Reporte_Fotografico_Listar() {
        //Cargando();

        var base = $('#base').val();
        var area = $('#area').val();
        var codigo = $('#codigo_filtro').val();
        var url = "{{ url('ReporteFotograficoListar') }}";

        $.ajax({
            url: url,
            type: 'POST',
            /*data: {
                'base': base,
                'area': area,
                'codigo': codigo
            },*/
            success: function(data) {
                $('#lista').html(data);
            }
        });
    }
</script>
@include('footer')
