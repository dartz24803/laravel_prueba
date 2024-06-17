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
    $acceso=$_SESSION['usuario'][0]['acceso'];
    $induccion=$_SESSION['usuario'][0]['induccion'];
    $nom_area=$_SESSION['usuario'][0]['nom_area'];

?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
            
        <div class="row layout-top-spacing" id="cancel-row">

            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <!--<div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Reporte de Control de Asistencia</h4>
                            </div>
                        </div>
                    </div>-->
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Reporte de Control de Asistencia</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="simpletabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="toolbar">
                                    <div class="row">

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label text-bold">C.&nbsp;Labores:</label>
                                                <?php echo $centro_labores; ?>
                                                <input type="hidden" name="cod_base" id="cod_base" value="<?php echo $centro_labores; ?>">
                                            </div>
                                        </div>
                                        <input type="hidden" name="id_puesto" id="id_puesto" value="<?php echo $id_puesto; ?>">

                                        <div class="col-md-2" id="cmb_colaborador">
                                            <div class="form-group" >
                                                <label class="control-label text-bold">Colaborador:</label>
                                                <select id="num_doc" name="num_doc" class="form-control basic">
                                                    <option value="0">TODOS</option>
                                                    <?php foreach($list_colaborador as $list){?> 
                                                        <option value="<?php echo $list['num_doc']; ?>"> <?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres'];?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Tipo:</label><br>
                                                <input type="radio" name="tipo" id="tipo1" value="1" checked="checked" onclick="TipoBusqueda('1')">
                                                Por Mes<br>
                                                <input type="radio" name="tipo" id="tipo2" value="2"  onclick="TipoBusqueda('2')"> 
                                                Por Rango
                                            </div>
                                        </div> 
                                        <div class="col-md-1" id="cmb_mes">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Mes:</label>
                                                <select class="form-control" id="cod_mes" name="cod_mes">
                                                    <?php foreach($list_mes as $list){ ?>
                                                        <option value="<?php echo $list['cod_mes'] ?>" <?php if($list['cod_mes']==date('m')){ echo "selected"; } ?>><?php echo $list['nom_mes']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-1" id="cmb_anio">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Año:</label>
                                                <select class="form-control" id="cod_anio" name="cod_anio">
                                                    <?php foreach($list_anio as $list){ ?>
                                                        <option value="<?php echo $list['cod_anio'] ?>" <?php if($list['cod_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['cod_anio']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div> 
                                        </div>
                                        <div class="col-md-2" id="cmb_finicio" style="display:none">
                                            <div class="form-group">
                                                <label class="control-label text-bold">F inicio:</label>
                                                    <input type="date" class="form-control formcontrolarlimpiar" id="finicio"  name="finicio" value="<?php echo date('Y-m-d') ?>"> 
                                            </div>
                                        </div>

                                        <div class="col-md-2" id="cmb_ffin" style="display:none">
                                            <div class="form-group">
                                                <label class="control-label text-bold">F fin:</label>
                                                    <input type="date" class="form-control formcontrolarlimpiar" id="ffin"  name="ffin" value="<?php echo date('Y-m-d') ?>"> 
                                            </div>
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class="control-label text-bold">&nbsp;</label>
                                            <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Reporte_Asistencia();" title="Buscar">
                                                Buscar
                                            </button>
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group" id="dias_l">
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

        </div>
                
    </div>
</div>



<script>


    $(document).ready(function() {
        $("#rhumanos").addClass('active');
        $("#hrhumanos").attr('aria-expanded','true');
        $("#reporteasistenciap").addClass('active');
        //Buscar_Reporte_Asistencia();
    });



</script>


<?php $this->load->view('validaciones'); ?>
<?php $this->load->view('footer'); ?>