<?php 
$id_nivel=$_SESSION['usuario'][0]['id_nivel'];
$id_puesto=$_SESSION['usuario'][0]['id_puesto'];
?>
<?php $this->load->view('header'); ?>
<?php $this->load->view('nav'); ?>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/chossen_plugin/chosen.css">

<style>
    .salidaa:hover {
        background-color: yellow;
    }
    .retornoo:hover {
        background-color: red;
    }
    .sin_retorno:hover {
        background-color: green;
    }
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
    .chosen-container{
        height: 40px;
    }
    .chosen-container-single .chosen-single {
        height: 43px;
    }
    .chosen-container-single .chosen-single {
        height: 43px;
        padding-top: 9px;
    }
    .chosen-container-single .chosen-single div b {
        margin-top: 9px;
    }
    .btn svg {
        width: 29px;
        height: 30px;
        vertical-align: bottom;
    }
</style>

<?php
    $sesion =  $_SESSION['usuario'][0];
    $id_puesto=$_SESSION['usuario'][0]['id_puesto'];
    $id_nivel=$_SESSION['usuario'][0]['id_nivel'];
    $centro_labores=$_SESSION['usuario'][0]['centro_labores'];
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Permiso de Salida Personal de Seguridad</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="toolbar">        
                        <div class="row">
                            <div class="form-group col-md-1">
                                <label class="control-label text-bold">&nbsp;</label>
                                <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad();" title="Buscar">
                                    <svg id="Fill_out_line" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" data-name="Fill out line"><path d="m276.53 446.91 4.28 39.77a229.93706 229.93706 0 0 0 42.04-8.46l-11.52-38.31a191.42161 191.42161 0 0 1 -34.8 7z" fill="#2d80b3"/><path d="m192.60986 479.23a230.11769 230.11769 0 0 0 42.18014 7.81l3.6499-39.83a192.31768 192.31768 0 0 1 -34.8999-6.46z" fill="#379ec3"/><path d="m410.29 370.29-34.29-34.29v96h96l-33.16992-33.17a232.06529 232.06529 0 0 0 -79.43994-350.57l-17.82007 35.82a192.06183 192.06183 0 0 1 68.72 286.21z" fill="#e44042"/><path d="m24 256a231.987 231.987 0 0 0 128.60986 207.74l17.82007-35.82a192.06183 192.06183 0 0 1 -68.72-286.21l34.29007 34.29v-96h-96l33.16992 33.17a230.98265 230.98265 0 0 0 -49.16992 142.83z" fill="#8acce7"/><path d="m189.1499 33.78 11.52 38.31a191.42671 191.42671 0 0 1 34.80005-7l-4.28-39.77a229.93194 229.93194 0 0 0 -42.04005 8.46z" fill="#bf2226"/><path d="m273.56006 64.79a192.32292 192.32292 0 0 1 34.89994 6.46l10.93018-38.48a230.11769 230.11769 0 0 0 -42.18018-7.81z" fill="#d1393b"/><path d="m192 384h128a24 24 0 0 0 24-24v-184l-48-48h-104a24 24 0 0 0 -24 24v208a24 24 0 0 0 24 24z" fill="#eedc9a"/><path d="m296 128v48h48z" fill="#eebe33"/><path d="m16 256a239.98553 239.98553 0 0 0 133.04053 214.89941 8.00046 8.00046 0 0 0 10.73193-3.5957l17.81983-35.82031a7.9999 7.9999 0 0 0 -3.59278-10.72266 183.997 183.997 0 0 1 -101.99951-164.76074 182.40958 182.40958 0 0 1 30.7749-101.91113l27.56836 27.56836a8.00038 8.00038 0 0 0 13.65674-5.65723v-96a8.00008 8.00008 0 0 0 -8-8h-96a8.0001 8.0001 0 0 0 -5.65674 13.65723l28.23389 28.23339a237.462 237.462 0 0 0 -46.57715 142.10938zm16 0a221.74014 221.74014 0 0 1 47.4707-137.90039 8.00059 8.00059 0 0 0 -.644-10.58691l-19.51322-19.5127h68.68652v68.68652l-20.6333-20.63379a7.99987 7.99987 0 0 0 -12.08154.89063 200.097 200.097 0 0 0 -8.49268 225.72564 200.63449 200.63449 0 0 0 72.98584 68.70117l-10.70117 21.50976a223.96573 223.96573 0 0 1 -117.07715-196.87993z"/><path d="m368 336v96a8.00008 8.00008 0 0 0 8 8h96a8.0001 8.0001 0 0 0 5.65674-13.65723l-28.23389-28.23339a240.13378 240.13378 0 0 0 9.62549-270.11622 240.69753 240.69753 0 0 0 -96.08887-86.89257 7.99825 7.99825 0 0 0 -10.73193 3.5957l-17.82031 35.82031a7.99989 7.99989 0 0 0 3.59277 10.72266 183.99625 183.99625 0 0 1 102 164.76074 182.40958 182.40958 0 0 1 -30.7749 101.91113l-27.56836-27.56836a8.00038 8.00038 0 0 0 -13.65674 5.65723zm16 19.31348 20.6333 20.63379a7.99987 7.99987 0 0 0 12.08154-.89063 200.09575 200.09575 0 0 0 8.49216-225.72559 200.61981 200.61981 0 0 0 -72.98584-68.70019l10.70166-21.51074a223.96573 223.96573 0 0 1 117.07718 196.87988 221.74014 221.74014 0 0 1 -47.4707 137.90039 8.00059 8.00059 0 0 0 .644 10.58691l19.51322 19.5127h-68.68652z"/><path d="m270.30371 441.88672a8.00162 8.00162 0 0 0 -1.728 5.87988l4.28028 39.76953a8.0019 8.0019 0 0 0 7.94433 7.14453 7.83386 7.83386 0 0 0 .85157-.04589 238.45249 238.45249 0 0 0 43.50293-8.75391 8.001 8.001 0 0 0 5.35644-9.96484l-11.52-38.30957a8.00452 8.00452 0 0 0 -9.95947-5.35938 184.05407 184.05407 0 0 1 -33.34717 6.708 8.00188 8.00188 0 0 0 -5.38091 2.93165zm15.02 11.97168a200.34292 200.34292 0 0 0 20.60059-4.14356l6.91894 23.00879a222.96106 222.96106 0 0 1 -24.94922 5.01758z"/><path d="m184.91406 477.04492a7.99887 7.99887 0 0 0 5.51026 9.88086 238.84772 238.84772 0 0 0 43.6455 8.082c.24512.02149.48829.03321.7295.03321a8.00158 8.00158 0 0 0 7.95752-7.27051l3.6499-39.83008a7.9994 7.9994 0 0 0 -7.24219-8.69727 184.99166 184.99166 0 0 1 -33.44873-6.1914 8.00071 8.00071 0 0 0 -9.87158 5.51269zm17.61719-3.46582 6.56543-23.1123a201.21079 201.21079 0 0 0 20.66064 3.82519l-2.19189 23.91895a223.01393 223.01393 0 0 1 -25.03418-4.63184z"/><path d="m241.6958 70.11328a8.00037 8.00037 0 0 0 1.728-5.87988l-4.2798-39.76953a7.98552 7.98552 0 0 0 -8.7959-7.09864 238.43585 238.43585 0 0 0 -43.50293 8.75391 8.001 8.001 0 0 0 -5.35644 9.96484l11.52 38.30957a7.99331 7.99331 0 0 0 9.95947 5.35938 184.06575 184.06575 0 0 1 33.34668-6.708 8.00188 8.00188 0 0 0 5.38092-2.93165zm-15.02-11.97168a200.33375 200.33375 0 0 0 -20.6001 4.14356l-6.91894-23.00879a222.95262 222.95262 0 0 1 24.94873-5.01758z"/><path d="m327.08594 34.95508a7.99887 7.99887 0 0 0 -5.51026-9.88086 238.86314 238.86314 0 0 0 -43.6455-8.082 8.01128 8.01128 0 0 0 -8.687 7.2373l-3.6499 39.83008a7.9994 7.9994 0 0 0 7.24219 8.69727 184.99166 184.99166 0 0 1 33.44873 6.1914 7.991 7.991 0 0 0 9.87158-5.51269zm-17.61719 3.46582-6.56543 23.1123a201.21079 201.21079 0 0 0 -20.66064-3.8252l2.19189-23.919a223.03441 223.03441 0 0 1 25.03418 4.6319z"/><path d="m320 392a32.03635 32.03635 0 0 0 32-32v-184a8.00076 8.00076 0 0 0 -2.34326-5.65723l-48-48a8.00035 8.00035 0 0 0 -5.65674-2.34277h-104a32.03635 32.03635 0 0 0 -32 32v208a32.03635 32.03635 0 0 0 32 32zm-16-244.68652 20.68652 20.68652h-20.68652zm-128 212.68652v-208a16.01833 16.01833 0 0 1 16-16h96v40a8.00008 8.00008 0 0 0 8 8h40v176a16.01833 16.01833 0 0 1 -16 16h-128a16.01833 16.01833 0 0 1 -16-16z"/><path d="m192 152h32v16h-32z"/><path d="m208 200h80v16h-80z"/><path d="m304 200h16v16h-16z"/><path d="m288 264h32v16h-32z"/><path d="m192 264h80v16h-80z"/><path d="m256 232h64v16h-64z"/><path d="m192 232h48v16h-48z"/><path d="m192 296h64v16h-64z"/><path d="m272.798 296h31.202v16h-31.202z"/><path d="m280.798 328h31.202v16h-31.202z"/></svg>
                                </button>
                            </div>
                            <?php if($id_puesto==23 || $id_puesto==26 || $id_puesto==128 || $id_nivel==1 || $id_nivel==21 || $id_nivel==19 || $centro_labores==="CD" || $centro_labores==="OFC" || $centro_labores==="AMT") { ?>
                                <div class="col-md-2 form-group">
                                    <label class="control-label text-bold">Bases:</label>
                                    <select id="base" name="base" placeholder="Centro de labores" data-placeholder="Your Favorite Type of Bear" tabindex="10" class="form-control chosen-select-deselect">
                                    <option value="0">Todas</option>
                                    <?php foreach($list_base as $list){ ?>
                                        <option value="<?php echo $list['cod_base']?>"> <?php echo $list['cod_base'];?> </option>
                                    <?php } ?>
                                    </select>
                                </div>
                            <?php } ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label text-bold">Estado Solicitud:</label>
                                    <select id="estado_solicitud" name="estado_solicitud" class="form-control" >
                                        <option value="1">En Proceso de aprobacion</option>
                                        <option value="2">Aprobados</option>
                                        <option value="3">Denegados</option>
                                        <option value="4" selected>Todos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label text-bold">Fecha Inicio:</label>
                                        <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision" value="<?php echo date("Y-m-d");?>"  name="fecha_revision" > 
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label text-bold">Fecha Fin:</label>
                                        <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision_fin" value="<?php echo date("Y-m-d");?>"  name="fecha_revision_fin" > 
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <label class="control-label text-bold">&nbsp;</label>
                                <button type="button" id="busqueda_papeleta_seguridad" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad();" title="Buscar">
                                    Buscar
                                </button>
                            </div>
                            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26 || $id_nivel==21 || $id_nivel==19){?> 
                                <div class="form-group col-md-1">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <a class="btn mb-2 mr-2" style="background-color: #28a745 !important;" onclick="Excel_Estado_Solicitud_Papeletas_Salida_Seguridad()">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>
                                    </a>
                                </div>
                            <?php }?>
                            
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
        $("#gestion_papeletas_seguridad").addClass('active');
        $("#busqueda_papeleta_seguridad").trigger("click");
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

    $('#estado_solicitud').val('4').trigger('change');    
</script>

<script src="<?php echo base_url(); ?>assets/chossen_plugin/chosen.jquery.js"></script>
<script>
    $('.chosen-select-deselect').chosen({
        width: '100%',
        allow_single_deselect: true
    });
</script>

<?php /*if( $id_puesto!=23 ){  ?>
    <script>
        //$("#base").prop('disabled',true).trigger('chosen:updated').prop('disabled',false);
    </script>
<?php //} */?>


<?php $this->load->view('validaciones'); ?>
<?php $this->load->view('footer'); ?>