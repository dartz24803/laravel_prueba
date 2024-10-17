<?php $this->load->view('header'); ?>
<?php $this->load->view('nav'); ?>

<style>
    svg.warning  {
        color: #e2a03f;
        fill: rgba(233, 176, 43, 0.19);

    }

    svg.primary  {
        color: #2196f3;
        fill: rgba(33, 150, 243, 0.19);
 
    }

    svg.danger  {
        color: #e7515a;
        fill: rgba(231, 81, 90, 0.19);

    }

    .pegadoleft{
        padding-left: 0px!important
    }

    .profile-img img {
        border-radius: 6px;
        background-color: #ebedf2;
        padding: 2px;
        width: 35px;
        height: 35px;
    }
</style>

<?php
    $sesion =  $_SESSION['usuario'][0];
    $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
    $desvinculacion=$_SESSION['usuario'][0]['desvinculacion'];
    $estado=$_SESSION['usuario'][0]['estado'];
    $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
    $id_cargo=$_SESSION['usuario'][0]['id_cargo'];
    $usuario_codigo=$_SESSION['usuario'][0]['usuario_codigo'];
    $centro_labores=$_SESSION['usuario'][0]['centro_labores'];
    $estado=$_SESSION['usuario'][0]['estado'];
    $acceso=$_SESSION['usuario'][0]['acceso'];
    $induccion=$_SESSION['usuario'][0]['induccion'];
    $puesto_array = $_SESSION['list_puesto'];  
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Gestion de los Permisos de Salida</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="toolbar">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label text-bold">Estado Solicitud:</label>
                                    <select id="estado_solicitud" name="estado_solicitud" class="form-control" >
                                        <option value="1" selected>En Proceso de aprobacion</option>
                                        <option value="2">Aprobados</option>
                                        <option value="3">Denegados</option>
                                        <option value="4">Todos</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label text-bold">Fecha Inicio:</label>
                                    <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision" value="<?php echo date("Y-m-d");?>" name="fecha_revision" > 
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label text-bold">Fecha Fin:</label>
                                        <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision_fin" value="<?php echo date("Y-m-t");?>" name="fecha_revision_fin" > 
                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label class="control-label text-bold">&nbsp;</label>
                                <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Papeletas_Salida_Gestion();" title="Buscar">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mb-4 mt-4" id="lista_colaborador">
                    </div>
                </div>
            </div>           
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade profile-modal" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="background-color: #1b55e2;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            <div class="modal-header justify-content-center" id="profileModalLabel">
                <div class="modal-profile">
                    <img style="border-radius: 100% !important;height: 200px;width: 200px;object-fit: cover;" id="modalImgs" alt="avatar" src="assets/img/90x90.jpg" class="rounded-circle">
                </div>
            </div>
            <div class="modal-body text-center">
                <p style="word-break: break-all;" id="modelTitle" class="mt-2">Click on view to access your profile.</p>
            </div>

            <div class="modal-footer justify-content-center mb-4" id="descargarcertificado_estudiog">
            </div>
            <div align="center" ></div>        

        </div>
    </div>
</div>

<script>
    $('.buttonDownload[download]').each(function() {
        var $a = $(this),
            fileUrl = $a.attr('href');
        $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
    });

    $(document).ready(function() {
        $("#rhumanos").addClass('active');
        $("#hrhumanos").attr('aria-expanded','true');
        $("#gestion_papeletas").addClass('active');
        Buscar_Papeletas_Salida_Gestion();
    });

    function Vista_Imagen_Perfil(image_url,imageTitle){
        $('#modelTitle').html(imageTitle); 
        $('#modalImgs').attr('src',image_url);
        $('#profileModal').modal('show');
        //var nombredeusu= $("#id_usuarioactual").val();
        var nombredeusu= 'p';
        document.getElementById("descargarcertificado_estudiog").innerHTML = "<a href='"+image_url+"' id='imga' class='btn buttonDownload' download='qr_"+nombredeusu+".jpg'>Descargar</a>"
    }

    $('#estado_solicitud').change(function(){
        var data= $(this).val();
    });

    $('#estado_solicitud').val('1').trigger('change');
</script>

<?php $this->load->view('validaciones'); ?>
<?php $this->load->view('footer'); ?>