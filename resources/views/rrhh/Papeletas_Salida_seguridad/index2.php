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
    $id_usuario= $_SESSION['usuario'][0]['id_usuario'];
    $id_puesto!=23

?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
    <?php if( $id_puesto==23 || $id_puesto==26  ){  ?>
        <div class="page-header">
            <div class="page-title">
                <h3>Permiso de Salida Personal de Seguridad</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <!-- && $estado==3  -->
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar">        
                                <div class="row">
            
                                    <div class="form-group col-md-1">
                                        <label class="control-label text-bold">&nbsp;</label>
                                        <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Actualizar_Papeletas_Salida();" title="Buscar">
                                            <svg id="Fill_out_line" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" data-name="Fill out line"><path d="m276.53 446.91 4.28 39.77a229.93706 229.93706 0 0 0 42.04-8.46l-11.52-38.31a191.42161 191.42161 0 0 1 -34.8 7z" fill="#2d80b3"/><path d="m192.60986 479.23a230.11769 230.11769 0 0 0 42.18014 7.81l3.6499-39.83a192.31768 192.31768 0 0 1 -34.8999-6.46z" fill="#379ec3"/><path d="m410.29 370.29-34.29-34.29v96h96l-33.16992-33.17a232.06529 232.06529 0 0 0 -79.43994-350.57l-17.82007 35.82a192.06183 192.06183 0 0 1 68.72 286.21z" fill="#e44042"/><path d="m24 256a231.987 231.987 0 0 0 128.60986 207.74l17.82007-35.82a192.06183 192.06183 0 0 1 -68.72-286.21l34.29007 34.29v-96h-96l33.16992 33.17a230.98265 230.98265 0 0 0 -49.16992 142.83z" fill="#8acce7"/><path d="m189.1499 33.78 11.52 38.31a191.42671 191.42671 0 0 1 34.80005-7l-4.28-39.77a229.93194 229.93194 0 0 0 -42.04005 8.46z" fill="#bf2226"/><path d="m273.56006 64.79a192.32292 192.32292 0 0 1 34.89994 6.46l10.93018-38.48a230.11769 230.11769 0 0 0 -42.18018-7.81z" fill="#d1393b"/><path d="m192 384h128a24 24 0 0 0 24-24v-184l-48-48h-104a24 24 0 0 0 -24 24v208a24 24 0 0 0 24 24z" fill="#eedc9a"/><path d="m296 128v48h48z" fill="#eebe33"/><path d="m16 256a239.98553 239.98553 0 0 0 133.04053 214.89941 8.00046 8.00046 0 0 0 10.73193-3.5957l17.81983-35.82031a7.9999 7.9999 0 0 0 -3.59278-10.72266 183.997 183.997 0 0 1 -101.99951-164.76074 182.40958 182.40958 0 0 1 30.7749-101.91113l27.56836 27.56836a8.00038 8.00038 0 0 0 13.65674-5.65723v-96a8.00008 8.00008 0 0 0 -8-8h-96a8.0001 8.0001 0 0 0 -5.65674 13.65723l28.23389 28.23339a237.462 237.462 0 0 0 -46.57715 142.10938zm16 0a221.74014 221.74014 0 0 1 47.4707-137.90039 8.00059 8.00059 0 0 0 -.644-10.58691l-19.51322-19.5127h68.68652v68.68652l-20.6333-20.63379a7.99987 7.99987 0 0 0 -12.08154.89063 200.097 200.097 0 0 0 -8.49268 225.72564 200.63449 200.63449 0 0 0 72.98584 68.70117l-10.70117 21.50976a223.96573 223.96573 0 0 1 -117.07715-196.87993z"/><path d="m368 336v96a8.00008 8.00008 0 0 0 8 8h96a8.0001 8.0001 0 0 0 5.65674-13.65723l-28.23389-28.23339a240.13378 240.13378 0 0 0 9.62549-270.11622 240.69753 240.69753 0 0 0 -96.08887-86.89257 7.99825 7.99825 0 0 0 -10.73193 3.5957l-17.82031 35.82031a7.99989 7.99989 0 0 0 3.59277 10.72266 183.99625 183.99625 0 0 1 102 164.76074 182.40958 182.40958 0 0 1 -30.7749 101.91113l-27.56836-27.56836a8.00038 8.00038 0 0 0 -13.65674 5.65723zm16 19.31348 20.6333 20.63379a7.99987 7.99987 0 0 0 12.08154-.89063 200.09575 200.09575 0 0 0 8.49216-225.72559 200.61981 200.61981 0 0 0 -72.98584-68.70019l10.70166-21.51074a223.96573 223.96573 0 0 1 117.07718 196.87988 221.74014 221.74014 0 0 1 -47.4707 137.90039 8.00059 8.00059 0 0 0 .644 10.58691l19.51322 19.5127h-68.68652z"/><path d="m270.30371 441.88672a8.00162 8.00162 0 0 0 -1.728 5.87988l4.28028 39.76953a8.0019 8.0019 0 0 0 7.94433 7.14453 7.83386 7.83386 0 0 0 .85157-.04589 238.45249 238.45249 0 0 0 43.50293-8.75391 8.001 8.001 0 0 0 5.35644-9.96484l-11.52-38.30957a8.00452 8.00452 0 0 0 -9.95947-5.35938 184.05407 184.05407 0 0 1 -33.34717 6.708 8.00188 8.00188 0 0 0 -5.38091 2.93165zm15.02 11.97168a200.34292 200.34292 0 0 0 20.60059-4.14356l6.91894 23.00879a222.96106 222.96106 0 0 1 -24.94922 5.01758z"/><path d="m184.91406 477.04492a7.99887 7.99887 0 0 0 5.51026 9.88086 238.84772 238.84772 0 0 0 43.6455 8.082c.24512.02149.48829.03321.7295.03321a8.00158 8.00158 0 0 0 7.95752-7.27051l3.6499-39.83008a7.9994 7.9994 0 0 0 -7.24219-8.69727 184.99166 184.99166 0 0 1 -33.44873-6.1914 8.00071 8.00071 0 0 0 -9.87158 5.51269zm17.61719-3.46582 6.56543-23.1123a201.21079 201.21079 0 0 0 20.66064 3.82519l-2.19189 23.91895a223.01393 223.01393 0 0 1 -25.03418-4.63184z"/><path d="m241.6958 70.11328a8.00037 8.00037 0 0 0 1.728-5.87988l-4.2798-39.76953a7.98552 7.98552 0 0 0 -8.7959-7.09864 238.43585 238.43585 0 0 0 -43.50293 8.75391 8.001 8.001 0 0 0 -5.35644 9.96484l11.52 38.30957a7.99331 7.99331 0 0 0 9.95947 5.35938 184.06575 184.06575 0 0 1 33.34668-6.708 8.00188 8.00188 0 0 0 5.38092-2.93165zm-15.02-11.97168a200.33375 200.33375 0 0 0 -20.6001 4.14356l-6.91894-23.00879a222.95262 222.95262 0 0 1 24.94873-5.01758z"/><path d="m327.08594 34.95508a7.99887 7.99887 0 0 0 -5.51026-9.88086 238.86314 238.86314 0 0 0 -43.6455-8.082 8.01128 8.01128 0 0 0 -8.687 7.2373l-3.6499 39.83008a7.9994 7.9994 0 0 0 7.24219 8.69727 184.99166 184.99166 0 0 1 33.44873 6.1914 7.991 7.991 0 0 0 9.87158-5.51269zm-17.61719 3.46582-6.56543 23.1123a201.21079 201.21079 0 0 0 -20.66064-3.8252l2.19189-23.919a223.03441 223.03441 0 0 1 25.03418 4.6319z"/><path d="m320 392a32.03635 32.03635 0 0 0 32-32v-184a8.00076 8.00076 0 0 0 -2.34326-5.65723l-48-48a8.00035 8.00035 0 0 0 -5.65674-2.34277h-104a32.03635 32.03635 0 0 0 -32 32v208a32.03635 32.03635 0 0 0 32 32zm-16-244.68652 20.68652 20.68652h-20.68652zm-128 212.68652v-208a16.01833 16.01833 0 0 1 16-16h96v40a8.00008 8.00008 0 0 0 8 8h40v176a16.01833 16.01833 0 0 1 -16 16h-128a16.01833 16.01833 0 0 1 -16-16z"/><path d="m192 152h32v16h-32z"/><path d="m208 200h80v16h-80z"/><path d="m304 200h16v16h-16z"/><path d="m288 264h32v16h-32z"/><path d="m192 264h80v16h-80z"/><path d="m256 232h64v16h-64z"/><path d="m192 232h48v16h-48z"/><path d="m192 296h64v16h-64z"/><path d="m272.798 296h31.202v16h-31.202z"/><path d="m280.798 328h31.202v16h-31.202z"/></svg>
                                        </button>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                                <label class="control-label text-bold">Bases:</label>
                                            <select id="base" name="base" placeholder="Centro de labores" data-placeholder="Your Favorite Type of Bear" tabindex="10" class="form-control chosen-select-deselect">
                                                <option value="0" >Seleccionar</option>
                                                <?php foreach($list_base as $list){ ?>
                                                            <option value="<?php echo $list['cod_base']?>"> <?php echo $list['cod_base'];?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label text-bold">Estado Solicitud:</label>
                                                <select id="estado_solicitud" name="estado_solicitud" class="form-control" >
                                                    <option value="0" >Seleccionar</option>
                                                    <option value="1" >En Proceso de aprobacion</option>
                                                    <option value="2" selected>Aprobados</option>
                                                    <option value="3">Denegados</option>
                                                    <option value="4">Todos</option>
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label text-bold">Fecha inicio:</label>
                                                <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision" value="<?php echo date("Y-m-d");?>"  name="fecha_revision" > 
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="control-label text-bold">Fecha fin:</label>
                                                <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision_fin" value="<?php echo date("Y-m-d");?>"  name="fecha_revision_fin" > 
                                        </div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label class="control-label text-bold">&nbsp;</label>
                                        <button type="button" id="busqueda_papeleta_seguridad" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad();" title="Buscar">
                                            Buscar
                                        </button>
                                    </div>
                                </div>
                        </div>

                        <div class="table-responsive mb-4 mt-4" id="lista_colaborador">
                            <table id="style-3" class="table style-3 " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Base</th>
                                        <th>Colaborador</th>
                                        <th>Motivo</th>
                                        <th>Destino</th>
                                        <th>Trámite</th>
                                        <th>Fecha</th>
                                        <th>H. Salida</th>
                                        <th>H. Retorno</th>
                                        <th>H. Real Salida</th>
                                        <th>H. Real Retorno</th>
                                        <th>Estado</th>
                                        <th class="no-content"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($list_papeletas_salida as $list) {  ?>   
                                    <tr>
                                        <td> <?php echo $list['centro_labores']; ?></td>
                                        <td> <?php echo $list['usuario_apater']." ".$list['usuario_amater']." ".$list['usuario_nombres']; ?></td>
                                        <!--<td class="text-center">
                                            <a  title="Usuario" class="profile-img"  onclick="Vista_Imagen_Perfil('<?php echo base_url().$list['foto'] ?>','<?php echo $list['usuario_nombres'] ?>');"  role="button">
                                                <span><img style="object-fit: cover;" src="<?php
                                                    if(isset($list['foto'])) {
                                                        echo base_url().$list['foto']; 
                                                    }else{
                                                        echo base_url().'template/assets/img/90x90.jpg'; 
                                                    }
                                                    ?>" class="rounded-circle profile-img" alt="avatar">
                                                </span>
                                            </a>
                                        </td>-->
                                        <td>
                                            <?php 
                                                if( $list['id_motivo']==1){
                                                    echo "laboral"; 
                                                }else if ($list['id_motivo']==2){
                                                    echo "Personal"; 
                                                }else{
                                                    echo $list['motivo']; 
                                                }
                                            ?>                                        
                                        </td>
                                        <td>
                                            <?php echo $list['destino']; ?>
                                        </td>
                                        <td>
                                            <?php echo $list['tramite']; ?>
                                        </td>
                                        <td>
                                            <?php
                                                /*$fecha_subida=strtotime(date($list['fec_solicitud']));
                                                $obj=&get_instance();
                                                $obj->load->model('Fecha');
                                                $diasemana = $obj->Fecha->dateFriendly($fecha_subida);
                                                echo $diasemana;*/
                                                echo date_format(date_create($list['fec_solicitud']), "d/m/Y");
                                            ?>     
                                        </td>
                                        <td>
                                            <?php echo $list['hora_salida']; ?>
                                        </td>
                                        <td>
                                            <?php if($list['sin_retorno'] == 1 ){ ?>
                                                Sin Retorno 
                                                <!--<a title="El trabajador se irà a su casa, problamente la actividad demorarà más allá sus horas de trabajo establecidas" class="anchor-tooltip tooltiped"><div class="divdea">
                                                <svg id="Layer_1" width="13" height="13" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><defs><style>.cls-1{fill:#2d3e50;}</style></defs><title>n</title><path class="cls-1" d="M86.15787,99.25657c-3.54161,2.827-10.03158,6.41724-14.75995,6.08384-4.67736-.3298-3.78182-4.78987-2.85481-8.295l7.83763-29.63476a13.29171,13.29171,0,0,0-25.68221-6.86278C49.55418,64.7858,40.39666,102.57942,40.34023,102.816c-1.28065,5.36943-2.81226,12.2324-.45115,17.525,3.58188,8.02819,14.46035,5.69646,21.06968,3.78541a52.68574,52.68574,0,0,0,12.91952-5.64322,118.52775,118.52775,0,0,0,13.15678-10.41187Z"/><path class="cls-1" d="M74.55393,2.049c-9.8517-.61753-19.65075,8.23893-20.034,18.3877a15.14774,15.14774,0,0,0,2.23531,8.54311c6.11649,9.89677,20.16846,7.7415,27.76526.91074C94.54734,20.87483,87.832,2.88134,74.55393,2.049Z"/></svg>
                                                </div></a>-->
                                                <?php }else{ ?>
                                                <?php echo $list['hora_retorno']; ?>
                                            <?php } ?>
                                        </td>                                        
                                        <td>
                                            <?php echo $list['horar_salida']; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if( $list['sin_retorno']=='1'){
                                                    echo "sin retorno"; 
                                                }else{
                                                    echo $list['horar_retorno']; 
                                                }
                                            ?>
                                        </td>
                                        <td> 
                                            <?php 
                                                if( $list['estado_solicitud']=='1'){
                                                    echo "<span class='shadow-none badge badge-warning'>En proceso</span>"; 
                                                }else if ($list['estado_solicitud']=='2'){
                                                    echo "<span class='shadow-none badge badge-primary'>Aprobado</span>"; 
                                                }else if ($list['estado_solicitud']=='3'){
                                                    echo " <span class='shadow-none badge badge-danger'>Denegado</span>"; 
                                                }else{
                                                    echo "<span class='shadow-none badge badge-primary'>Error</span>"; 
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center">

                                        <?php if( $list['estado_solicitud']==2) {  ?>   
                                                    <?php if( $list['horar_salida']=== '00:00:00') {  ?>   
                                                        <a style="cursor: pointer;display: block;" title="Salida"  onclick="Salida_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="salidaa" role="button">
                                                            <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#4F2410;" d="M318.314,463.959H10.969C4.911,463.959,0,459.048,0,452.989V11.607C0,5.55,4.911,0.639,10.969,0.639
                                                                    h307.344c6.058,0,10.969,4.911,10.969,10.969v441.382C329.282,459.048,324.371,463.959,318.314,463.959z M21.939,442.02h285.406
                                                                    V22.577H21.939V442.02z"/>
                                                                <path style="fill:#632C15;" d="M176.449,48.474L14.042,1.078C10.728,0.11,7.15,0.76,4.389,2.832C1.626,4.904,0,8.155,0,11.607
                                                                    v441.382c0,4.875,3.217,9.164,7.896,10.53l162.408,47.397c7.009,2.045,14.043-3.214,14.043-10.53V59.004
                                                                    C184.346,54.13,181.129,49.84,176.449,48.474z"/>
                                                                <path style="fill:#80391B;" d="M149.318,323.443c-6.058,0-10.969-4.911-10.969-10.969v-69.725c0-6.058,4.911-10.969,10.969-10.969
                                                                    c6.058,0,10.969,4.911,10.969,10.969v69.725C160.288,318.531,155.377,323.443,149.318,323.443z"/>
                                                                <path style="fill:#252D5C;" d="M191.111,249.65c-5.024,0-10.025-2.064-13.628-6.113c-6.693-7.522-6.02-19.047,1.503-25.74
                                                                    l69.745-62.052c2.777-2.471,6.244-4.034,9.934-4.479l90.535-10.927c10.003-1.209,19.079,5.919,20.286,15.916
                                                                    c1.206,9.997-5.919,19.079-15.916,20.285l-84.866,10.243l-65.48,58.256C199.749,248.13,195.422,249.65,191.111,249.65z"/>
                                                                <path style="fill:#414B82;" d="M341.579,478.067c-11.053-3.924-16.831-16.066-12.907-27.118l32.042-90.246l-53.573-84.139
                                                                    c-6.299-9.893-3.386-23.021,6.508-29.32c9.891-6.299,23.02-3.386,29.319,6.507l59.139,92.883c3.514,5.518,4.287,12.347,2.098,18.511
                                                                    l-35.51,100.014C364.791,476.163,352.679,482.008,341.579,478.067z"/>
                                                                <path style="fill:#53618C;" d="M400.355,144.46l-45.289-17.292c-14.026-5.356-29.737,1.673-35.092,15.699l-49.751,130.298
                                                                    l-25.609,88.966l-45.263,86.038c-5.461,10.38-1.473,23.221,8.907,28.682c10.403,5.473,23.234,1.45,28.682-8.907l46.255-87.924
                                                                    c0.66-1.254,1.193-2.572,1.59-3.932l25.587-87.592l5.765,2.201l54.807,6.996l45.109-118.139
                                                                    C421.41,165.527,414.381,149.815,400.355,144.46z"/>
                                                                <path style="fill:#1B224A;" d="M316.139,290.695l-45.914-17.532l49.751-130.297c5.356-14.026,21.066-21.054,35.092-15.699
                                                                    l45.289,17.292c14.026,5.356,21.054,21.066,15.699,35.092l-45.109,118.139L316.139,290.695z"/>
                                                                <circle style="fill:#FFB69E;" cx="403.766" cy="87.135" r="40.238"/>
                                                                <path style="fill:#FFFFFF;" d="M185.089,212.368l-6.103,5.43c-7.523,6.693-8.195,18.217-1.503,25.739
                                                                    c6.711,7.543,18.236,8.178,25.74,1.503l5.713-5.082L185.089,212.368z"/>
                                                                <path style="fill:#FFB69E;" d="M178.986,217.798c-7.523,6.693-8.195,18.217-1.503,25.739c6.711,7.543,18.236,8.178,25.74,1.503
                                                                    L178.986,217.798z"/>
                                                                <path style="fill:#59250F;" d="M469.267,311.312h-41.062c-4.418,0-7.999-3.581-7.999-7.999v-39.462c0-4.418,3.581-7.999,7.999-7.999
                                                                    h41.062c4.418,0,7.999,3.581,7.999,7.999v39.462C477.266,307.731,473.685,311.312,469.267,311.312z M436.204,295.314h25.064V271.85
                                                                    h-25.064V295.314z"/>
                                                                <path style="fill:#80391B;" d="M512,293.904v69.139c0,5.547-4.497,10.044-10.044,10.044H395.514
                                                                    c-5.547,0-10.044-4.497-10.044-10.044v-69.14c0-5.547,4.497-10.044,10.044-10.044h106.442C507.503,283.86,512,288.356,512,293.904z"
                                                                    />
                                                                <path style="fill:#252D5C;" d="M451.922,278.554c-1.976,0.163-4.012,0.005-6.04-0.516l-70.548-18.132
                                                                    c-5.914-1.52-10.672-5.898-12.681-11.665l-29.186-83.856c-3.311-9.51,1.716-19.902,11.226-23.212
                                                                    c9.508-3.316,19.902,1.716,23.212,11.226l25.973,74.625l61.08,15.699c9.753,2.507,15.626,12.444,13.12,22.196
                                                                    C466.094,272.643,459.445,277.933,451.922,278.554z"/>
                                                                <path style="fill:#FFFFFF;" d="M454.96,242.722l-9.069-2.331l-8.725,35.406l8.717,2.241c9.761,2.51,19.693-3.379,22.196-13.12
                                                                    C470.585,255.165,464.713,245.229,454.96,242.722z"/>
                                                                <path style="fill:#FFB69E;" d="M454.96,242.722l-9.077,35.316c9.761,2.51,19.693-3.379,22.196-13.12
                                                                    C470.585,255.165,464.713,245.229,454.96,242.722z"/>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    <?php } ?>   
                                                    <?php if($list['horar_salida'] != '00:00:00'){ ?>
                                                            <?php if( $list['horar_retorno']=== '00:00:00' && $list['sin_retorno']!='1') {  ?>   
                                                                <a style="cursor: pointer;display: block;" title="Retorno"  onclick="Retorno_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')"  class="retornoo" role="button">
                                                                    <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                        <rect x="192.545" y="13.086" style="fill:#69280F;" width="241.406" height="454.924"/>
                                                                        <path style="fill:#A56941;" d="M433.956,481.088H192.547c-7.225,0-13.083-5.858-13.083-13.083V13.083
                                                                            C179.464,5.858,185.321,0,192.547,0h241.409c7.225,0,13.083,5.858,13.083,13.083v454.923
                                                                            C447.038,475.231,441.181,481.088,433.956,481.088z M203.463,459.239H423.04V21.85H203.463V459.239z"/>
                                                                        <path style="fill:#501E0F;" d="M391.205,140.634H235.298c-4.607,0-8.341-3.735-8.341-8.341V63.969c0-4.607,3.735-8.341,8.341-8.341
                                                                            h155.906c4.607,0,8.341,3.735,8.341,8.341v68.322C399.546,136.899,395.811,140.634,391.205,140.634z"/>
                                                                        <circle style="fill:#A56941;" cx="389.776" cy="257.111" r="18.843"/>
                                                                        <g>
                                                                            <path style="fill:#E4F2F6;" d="M335.092,172.099c-2.24-3.712-1.046-8.537,2.666-10.776l40.109-24.196
                                                                                c3.712-2.238,8.538-1.046,10.776,2.666c2.24,3.712,1.046,8.537-2.666,10.776l-40.109,24.196
                                                                                C342.136,177.016,337.319,175.791,335.092,172.099z"/>
                                                                            <path style="fill:#E4F2F6;" d="M339.241,194.944c-0.459-4.311,2.662-8.178,6.973-8.637l30.105-3.209
                                                                                c4.299-0.463,8.178,2.662,8.637,6.973c0.459,4.311-2.662,8.178-6.973,8.637l-30.105,3.209
                                                                                C343.576,202.377,339.701,199.262,339.241,194.944z"/>
                                                                        </g>
                                                                        <circle style="fill:#FFB69E;" cx="162.058" cy="72.564" r="39.197"/>
                                                                        <path style="fill:#343E6B;" d="M189.23,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814
                                                                            c12.6,0,22.814,10.214,22.814,22.814v182.353C212.044,501.786,201.829,512,189.23,512z"/>
                                                                        <path style="fill:#414B82;" d="M134.157,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814
                                                                            s22.814,10.214,22.814,22.814v182.353C156.971,501.786,146.756,512,134.157,512z"/>
                                                                        <path style="fill:#252D5C;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367
                                                                            c-0.123-24.557-20.38-44.536-44.937-44.536h-0.699c-12.091,0-89.062,0-101.572,0c-25.07,0-45.568,20.081-45.691,44.765
                                                                            c0,0.032,0,0.063,0,0.095v139.67c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012V169.173
                                                                            c0.04-3.616,3.685-6.9,7.669-6.9h0.684v144.56h100.701c0-13.477,0-129.6,0-144.754c0.101,0,0.987,0,0.886,0
                                                                            c3.803,0,7.26,3.095,7.279,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617
                                                                            C325.004,206.995,327.731,195.334,322.221,186.46z"/>
                                                                        <path style="fill:#1B224A;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367
                                                                            c-0.123-24.557-20.38-44.536-44.937-44.536c-6.494,0-44.999,0-51.244,0v182.583h50.356c0-13.477,0-129.6,0-144.754
                                                                            c0.101,0,0.987,0,0.886,0c3.803,0,7.26,3.095,7.28,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617
                                                                            C325.004,206.995,327.731,195.334,322.221,186.46z"/>
                                                                        <path style="fill:#FFB69E;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l19.954,32.138
                                                                            C325.004,206.995,327.731,195.334,322.221,186.46z"/>
                                                                        <g>
                                                                            
                                                                                <rect x="283.86" y="194.463" transform="matrix(-0.5226 -0.8526 0.8526 -0.5226 291.7662 560.3716)" style="fill:#FFFFFF;" width="37.829" height="8.068"/>
                                                                            <path style="fill:#FFFFFF;" d="M64.962,298.975v9.806c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-9.806H64.962
                                                                                z"/>
                                                                        </g>
                                                                        <path style="fill:#FFB69E;" d="M64.962,308.291v0.489c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-0.489H64.962z
                                                                            "/>
                                                                        <polygon style="fill:#FFFFFF;" points="132.679,124.25 161.688,200.377 190.703,124.25 "/>
                                                                        <path style="fill:#FF4619;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.321-4.092-2.42-4.092h-18.619
                                                                            c-2.096,0-3.431,2.253-2.42,4.092l5.573,10.136l-6.427,11.688c-0.89,1.619-1.179,3.498-0.818,5.31l3.964,20.124l9.439,24.778
                                                                            l9.448-24.782l3.986-20.117C175.485,153.665,175.195,151.785,174.305,150.165z"/>
                                                                        <path style="fill:#DC1428;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.32-4.092-2.42-4.092h-9.308v76.111v0.016
                                                                            l9.448-24.783l3.986-20.117C175.485,153.666,175.195,151.785,174.305,150.165z"/>
                                                                        <rect x="175.736" y="182.74" style="fill:#252D5C;" width="25.118" height="7.745"/>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                    </svg>
                                                                </a>
                                                            <?php } //&& $list['horar_retorno']=== '00:00:00'?>
                                                            <?php if( $list['sin_retorno']!='1' && $list['horar_retorno']=== '00:00:00' ){  ?>
                                                                <a style="cursor: pointer;display: block;" title="Sin Retorno" onclick="Cambiar_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="sin_retorno" role="button">
                                                                    <svg width="40" height="40" id="Icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                                                        <defs>
                                                                            <style>
                                                                                .cls-1{fill:#45413c;opacity:0.15;}
                                                                                .cls-2{fill:#ff6242;}.cls-3{fill:#ff866e;}
                                                                                .cls-4{fill:none;stroke:#45413c;stroke-linecap:round;stroke-linejoin:round;}
                                                                            </style>
                                                                        </defs>
                                                                        <title>756-exclamation-mark</title>
                                                                        <ellipse id="_Ellipse_" data-name="&lt;Ellipse&gt;" class="cls-1" cx="24" cy="44.18" rx="8.48" ry="1.82"/>
                                                                        <path class="cls-2" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/>
                                                                        <path id="_Path_" data-name="&lt;Path&gt;" class="cls-3" d="M19.56,7.48a3.31,3.31,0,0,1,3-1.6h2.8a3.31,3.31,0,0,1,3,1.6l.19-2.41c.11-1.39-1.37-2.57-3.23-2.57H22.6c-1.86,0-3.34,1.18-3.23,2.57Z"/>
                                                                        <path class="cls-4" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/>
                                                                        <circle id="_Path_2" data-name="&lt;Path&gt;" class="cls-2" cx="24" cy="35.24" r="3.65"/>
                                                                        <path id="_Path_3" data-name="&lt;Path&gt;" class="cls-3" d="M24,33.93A3.58,3.58,0,0,1,27.57,36a3.94,3.94,0,0,0,.08-.77,3.65,3.65,0,1,0-7.3,0,3.94,3.94,0,0,0,.08.77A3.58,3.58,0,0,1,24,33.93Z"/>
                                                                        <circle id="_Path_4" data-name="&lt;Path&gt;" class="cls-4" cx="24" cy="35.24" r="3.65"/>
                                                                    </svg>
                                                                </a>
                                                            <?php } ?>
                                                    <?php } ?>
                                        <?php  }else{  ?> 


                                        <?php  }  ?>   

                                           
                                            
                                                    
                                          

                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>           
        </div>
    <?php }else{ ?>
        <div class="page-header">
            <div class="page-title">
                <h3>Permiso de Salida Personal de Seguridad</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <!-- && $estado==3  -->
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar">
                            <div class="container" style="padding-left: 0px; padding-right: 0px;">
                                <div class="row">
                                    <div class="col-sm" align="left">
                                        <div class="row">
                                            <div class="col-sm" >
                                                <button type="button" class="btn btn-primary mb-2 mr-2 form-control" onclick="Actualizar_Papeletas_Salida();" title="Buscar">
                                                        Actualizar
                                                </button>
                                            </div>
                                            <div class="col-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive mb-4 mt-4" id="lista_colaborador">
                            <table id="style-3" class="table style-3 " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Colaborador</th>
                                        <th>Motivo</th>
                                        <th>Destino</th>
                                        <th>Trámite</th>
                                        <th>Fecha</th>
                                        <th>H. Salida</th>
                                        <th>H. Retorno</th>
                                        <th>H. Real Salida</th>
                                        <th>H. Real Retorno</th>
                                        <th>Estado</th>
                                        <th class="no-content"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($list_papeletas_salida as $list) {  ?>   
                                    <tr>
                                        <td> <?php echo $list['usuario_apater']." ".$list['usuario_amater']." ".$list['usuario_nombres']; ?></td>
                                        <!--<td class="text-center">
                                            <a  title="Usuario" class="profile-img"  onclick="Vista_Imagen_Perfil('<?php echo base_url().$list['foto'] ?>','<?php echo $list['usuario_nombres'] ?>');"  role="button">
                                                <span><img style="object-fit: cover;" src="<?php
                                                    if(isset($list['foto'])) {
                                                        echo base_url().$list['foto']; 
                                                    }else{
                                                        echo base_url().'template/assets/img/90x90.jpg'; 
                                                    }
                                                    ?>" class="rounded-circle profile-img" alt="avatar">
                                                </span>
                                            </a>
                                        </td>-->
                                        <td>
                                            <?php 
                                                if( $list['id_motivo']==1){
                                                    echo "laboral"; 
                                                }else if ($list['id_motivo']==2){
                                                    echo "Personal"; 
                                                }else{
                                                    echo $list['motivo']; 
                                                }
                                            ?>                                        
                                        </td>
                                        <td>
                                            <?php echo $list['destino']; ?>
                                        </td>
                                        <td>
                                            <?php echo $list['tramite']; ?>
                                        </td>
                                        <td>
                                            <?php
                                                /*$fecha_subida=strtotime(date($list['fec_solicitud']));
                                                $obj=&get_instance();
                                                $obj->load->model('Fecha');
                                                $diasemana = $obj->Fecha->dateFriendly($fecha_subida);
                                                echo $diasemana;*/
                                                echo date_format(date_create($list['fec_solicitud']), "d/m/Y");
                                            ?>     
                                        </td>
                                        <td>
                                            <?php echo $list['hora_salida']; ?>
                                        </td>
                                        <td>
                                            <?php if($list['sin_retorno'] == 1 ){ ?>
                                                Sin Retorno 
                                                <!--<a title="El trabajador se irà a su casa, problamente la actividad demorarà más allá sus horas de trabajo establecidas" class="anchor-tooltip tooltiped"><div class="divdea">
                                                <svg id="Layer_1" width="13" height="13" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><defs><style>.cls-1{fill:#2d3e50;}</style></defs><title>n</title><path class="cls-1" d="M86.15787,99.25657c-3.54161,2.827-10.03158,6.41724-14.75995,6.08384-4.67736-.3298-3.78182-4.78987-2.85481-8.295l7.83763-29.63476a13.29171,13.29171,0,0,0-25.68221-6.86278C49.55418,64.7858,40.39666,102.57942,40.34023,102.816c-1.28065,5.36943-2.81226,12.2324-.45115,17.525,3.58188,8.02819,14.46035,5.69646,21.06968,3.78541a52.68574,52.68574,0,0,0,12.91952-5.64322,118.52775,118.52775,0,0,0,13.15678-10.41187Z"/><path class="cls-1" d="M74.55393,2.049c-9.8517-.61753-19.65075,8.23893-20.034,18.3877a15.14774,15.14774,0,0,0,2.23531,8.54311c6.11649,9.89677,20.16846,7.7415,27.76526.91074C94.54734,20.87483,87.832,2.88134,74.55393,2.049Z"/></svg>
                                                </div></a>-->
                                                <?php }else{ ?>
                                                <?php echo $list['hora_retorno']; ?>
                                            <?php } ?>
                                        </td>                                        
                                        <td>
                                            <?php echo $list['horar_salida']; ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if( $list['sin_retorno']=='1'){
                                                    echo "sin retorno"; 
                                                }else{
                                                    echo $list['horar_retorno']; 
                                                }
                                            ?>
                                        </td>
                                        <td> 
                                            <?php 
                                                if( $list['estado_solicitud']=='1'){
                                                    echo "<span class='shadow-none badge badge-warning'>En proceso</span>"; 
                                                }else if ($list['estado_solicitud']=='2'){
                                                    echo "<span class='shadow-none badge badge-primary'>Aprobado</span>"; 
                                                }else if ($list['estado_solicitud']=='3'){
                                                    echo " <span class='shadow-none badge badge-danger'>Denegado</span>"; 
                                                }else{
                                                    echo "<span class='shadow-none badge badge-primary'>Error</span>"; 
                                                }
                                            ?>
                                        </td>
                                        <td class="text-center">

                                        <?php if( $list['estado_solicitud']==2) {  ?>   
                                                    <?php if( $list['horar_salida']=== '00:00:00') {  ?>   
                                                        <a style="cursor: pointer;display: block;" title="Salida"  onclick="Salida_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="salidaa" role="button">
                                                            <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                    viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                <path style="fill:#4F2410;" d="M318.314,463.959H10.969C4.911,463.959,0,459.048,0,452.989V11.607C0,5.55,4.911,0.639,10.969,0.639
                                                                    h307.344c6.058,0,10.969,4.911,10.969,10.969v441.382C329.282,459.048,324.371,463.959,318.314,463.959z M21.939,442.02h285.406
                                                                    V22.577H21.939V442.02z"/>
                                                                <path style="fill:#632C15;" d="M176.449,48.474L14.042,1.078C10.728,0.11,7.15,0.76,4.389,2.832C1.626,4.904,0,8.155,0,11.607
                                                                    v441.382c0,4.875,3.217,9.164,7.896,10.53l162.408,47.397c7.009,2.045,14.043-3.214,14.043-10.53V59.004
                                                                    C184.346,54.13,181.129,49.84,176.449,48.474z"/>
                                                                <path style="fill:#80391B;" d="M149.318,323.443c-6.058,0-10.969-4.911-10.969-10.969v-69.725c0-6.058,4.911-10.969,10.969-10.969
                                                                    c6.058,0,10.969,4.911,10.969,10.969v69.725C160.288,318.531,155.377,323.443,149.318,323.443z"/>
                                                                <path style="fill:#252D5C;" d="M191.111,249.65c-5.024,0-10.025-2.064-13.628-6.113c-6.693-7.522-6.02-19.047,1.503-25.74
                                                                    l69.745-62.052c2.777-2.471,6.244-4.034,9.934-4.479l90.535-10.927c10.003-1.209,19.079,5.919,20.286,15.916
                                                                    c1.206,9.997-5.919,19.079-15.916,20.285l-84.866,10.243l-65.48,58.256C199.749,248.13,195.422,249.65,191.111,249.65z"/>
                                                                <path style="fill:#414B82;" d="M341.579,478.067c-11.053-3.924-16.831-16.066-12.907-27.118l32.042-90.246l-53.573-84.139
                                                                    c-6.299-9.893-3.386-23.021,6.508-29.32c9.891-6.299,23.02-3.386,29.319,6.507l59.139,92.883c3.514,5.518,4.287,12.347,2.098,18.511
                                                                    l-35.51,100.014C364.791,476.163,352.679,482.008,341.579,478.067z"/>
                                                                <path style="fill:#53618C;" d="M400.355,144.46l-45.289-17.292c-14.026-5.356-29.737,1.673-35.092,15.699l-49.751,130.298
                                                                    l-25.609,88.966l-45.263,86.038c-5.461,10.38-1.473,23.221,8.907,28.682c10.403,5.473,23.234,1.45,28.682-8.907l46.255-87.924
                                                                    c0.66-1.254,1.193-2.572,1.59-3.932l25.587-87.592l5.765,2.201l54.807,6.996l45.109-118.139
                                                                    C421.41,165.527,414.381,149.815,400.355,144.46z"/>
                                                                <path style="fill:#1B224A;" d="M316.139,290.695l-45.914-17.532l49.751-130.297c5.356-14.026,21.066-21.054,35.092-15.699
                                                                    l45.289,17.292c14.026,5.356,21.054,21.066,15.699,35.092l-45.109,118.139L316.139,290.695z"/>
                                                                <circle style="fill:#FFB69E;" cx="403.766" cy="87.135" r="40.238"/>
                                                                <path style="fill:#FFFFFF;" d="M185.089,212.368l-6.103,5.43c-7.523,6.693-8.195,18.217-1.503,25.739
                                                                    c6.711,7.543,18.236,8.178,25.74,1.503l5.713-5.082L185.089,212.368z"/>
                                                                <path style="fill:#FFB69E;" d="M178.986,217.798c-7.523,6.693-8.195,18.217-1.503,25.739c6.711,7.543,18.236,8.178,25.74,1.503
                                                                    L178.986,217.798z"/>
                                                                <path style="fill:#59250F;" d="M469.267,311.312h-41.062c-4.418,0-7.999-3.581-7.999-7.999v-39.462c0-4.418,3.581-7.999,7.999-7.999
                                                                    h41.062c4.418,0,7.999,3.581,7.999,7.999v39.462C477.266,307.731,473.685,311.312,469.267,311.312z M436.204,295.314h25.064V271.85
                                                                    h-25.064V295.314z"/>
                                                                <path style="fill:#80391B;" d="M512,293.904v69.139c0,5.547-4.497,10.044-10.044,10.044H395.514
                                                                    c-5.547,0-10.044-4.497-10.044-10.044v-69.14c0-5.547,4.497-10.044,10.044-10.044h106.442C507.503,283.86,512,288.356,512,293.904z"
                                                                    />
                                                                <path style="fill:#252D5C;" d="M451.922,278.554c-1.976,0.163-4.012,0.005-6.04-0.516l-70.548-18.132
                                                                    c-5.914-1.52-10.672-5.898-12.681-11.665l-29.186-83.856c-3.311-9.51,1.716-19.902,11.226-23.212
                                                                    c9.508-3.316,19.902,1.716,23.212,11.226l25.973,74.625l61.08,15.699c9.753,2.507,15.626,12.444,13.12,22.196
                                                                    C466.094,272.643,459.445,277.933,451.922,278.554z"/>
                                                                <path style="fill:#FFFFFF;" d="M454.96,242.722l-9.069-2.331l-8.725,35.406l8.717,2.241c9.761,2.51,19.693-3.379,22.196-13.12
                                                                    C470.585,255.165,464.713,245.229,454.96,242.722z"/>
                                                                <path style="fill:#FFB69E;" d="M454.96,242.722l-9.077,35.316c9.761,2.51,19.693-3.379,22.196-13.12
                                                                    C470.585,255.165,464.713,245.229,454.96,242.722z"/>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                                <g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                    <?php } ?>   
                                                    <?php if($list['horar_salida'] != '00:00:00'){ ?>
                                                            <?php if( $list['horar_retorno']=== '00:00:00' && $list['sin_retorno']!='1') {  ?>   
                                                                <a style="cursor: pointer;display: block;" title="Retorno"  onclick="Retorno_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')"  class="retornoo" role="button">
                                                                    <svg width="40" height="40" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                                        <rect x="192.545" y="13.086" style="fill:#69280F;" width="241.406" height="454.924"/>
                                                                        <path style="fill:#A56941;" d="M433.956,481.088H192.547c-7.225,0-13.083-5.858-13.083-13.083V13.083
                                                                            C179.464,5.858,185.321,0,192.547,0h241.409c7.225,0,13.083,5.858,13.083,13.083v454.923
                                                                            C447.038,475.231,441.181,481.088,433.956,481.088z M203.463,459.239H423.04V21.85H203.463V459.239z"/>
                                                                        <path style="fill:#501E0F;" d="M391.205,140.634H235.298c-4.607,0-8.341-3.735-8.341-8.341V63.969c0-4.607,3.735-8.341,8.341-8.341
                                                                            h155.906c4.607,0,8.341,3.735,8.341,8.341v68.322C399.546,136.899,395.811,140.634,391.205,140.634z"/>
                                                                        <circle style="fill:#A56941;" cx="389.776" cy="257.111" r="18.843"/>
                                                                        <g>
                                                                            <path style="fill:#E4F2F6;" d="M335.092,172.099c-2.24-3.712-1.046-8.537,2.666-10.776l40.109-24.196
                                                                                c3.712-2.238,8.538-1.046,10.776,2.666c2.24,3.712,1.046,8.537-2.666,10.776l-40.109,24.196
                                                                                C342.136,177.016,337.319,175.791,335.092,172.099z"/>
                                                                            <path style="fill:#E4F2F6;" d="M339.241,194.944c-0.459-4.311,2.662-8.178,6.973-8.637l30.105-3.209
                                                                                c4.299-0.463,8.178,2.662,8.637,6.973c0.459,4.311-2.662,8.178-6.973,8.637l-30.105,3.209
                                                                                C343.576,202.377,339.701,199.262,339.241,194.944z"/>
                                                                        </g>
                                                                        <circle style="fill:#FFB69E;" cx="162.058" cy="72.564" r="39.197"/>
                                                                        <path style="fill:#343E6B;" d="M189.23,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814
                                                                            c12.6,0,22.814,10.214,22.814,22.814v182.353C212.044,501.786,201.829,512,189.23,512z"/>
                                                                        <path style="fill:#414B82;" d="M134.157,512c-12.6,0-22.814-10.214-22.814-22.814V306.833c0-12.6,10.214-22.814,22.814-22.814
                                                                            s22.814,10.214,22.814,22.814v182.353C156.971,501.786,146.756,512,134.157,512z"/>
                                                                        <path style="fill:#252D5C;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367
                                                                            c-0.123-24.557-20.38-44.536-44.937-44.536h-0.699c-12.091,0-89.062,0-101.572,0c-25.07,0-45.568,20.081-45.691,44.765
                                                                            c0,0.032,0,0.063,0,0.095v139.67c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012V169.173
                                                                            c0.04-3.616,3.685-6.9,7.669-6.9h0.684v144.56h100.701c0-13.477,0-129.6,0-144.754c0.101,0,0.987,0,0.886,0
                                                                            c3.803,0,7.26,3.095,7.279,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617
                                                                            C325.004,206.995,327.731,195.334,322.221,186.46z"/>
                                                                        <path style="fill:#1B224A;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l-38.307,23.784v-35.367
                                                                            c-0.123-24.557-20.38-44.536-44.937-44.536c-6.494,0-44.999,0-51.244,0v182.583h50.356c0-13.477,0-129.6,0-144.754
                                                                            c0.101,0,0.987,0,0.886,0c3.803,0,7.26,3.095,7.28,6.897v69.172c0.074,14.811,16.376,23.745,28.891,15.974l67.029-41.617
                                                                            C325.004,206.995,327.731,195.334,322.221,186.46z"/>
                                                                        <path style="fill:#FFB69E;" d="M322.221,186.46c-5.509-8.874-17.169-11.603-26.046-6.092l19.954,32.138
                                                                            C325.004,206.995,327.731,195.334,322.221,186.46z"/>
                                                                        <g>
                                                                            
                                                                                <rect x="283.86" y="194.463" transform="matrix(-0.5226 -0.8526 0.8526 -0.5226 291.7662 560.3716)" style="fill:#FFFFFF;" width="37.829" height="8.068"/>
                                                                            <path style="fill:#FFFFFF;" d="M64.962,298.975v9.806c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-9.806H64.962
                                                                                z"/>
                                                                        </g>
                                                                        <path style="fill:#FFB69E;" d="M64.962,308.291v0.489c0,10.5,8.512,19.012,19.012,19.012s19.012-8.512,19.012-19.012v-0.489H64.962z
                                                                            "/>
                                                                        <polygon style="fill:#FFFFFF;" points="132.679,124.25 161.688,200.377 190.703,124.25 "/>
                                                                        <path style="fill:#FF4619;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.321-4.092-2.42-4.092h-18.619
                                                                            c-2.096,0-3.431,2.253-2.42,4.092l5.573,10.136l-6.427,11.688c-0.89,1.619-1.179,3.498-0.818,5.31l3.964,20.124l9.439,24.778
                                                                            l9.448-24.782l3.986-20.117C175.485,153.665,175.195,151.785,174.305,150.165z"/>
                                                                        <path style="fill:#DC1428;" d="M174.305,150.165l-6.445-11.721l5.554-10.101c1.01-1.837-0.32-4.092-2.42-4.092h-9.308v76.111v0.016
                                                                            l9.448-24.783l3.986-20.117C175.485,153.666,175.195,151.785,174.305,150.165z"/>
                                                                        <rect x="175.736" y="182.74" style="fill:#252D5C;" width="25.118" height="7.745"/>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                        <g>
                                                                        </g>
                                                                    </svg>
                                                                </a>
                                                            <?php } //&& $list['horar_retorno']=== '00:00:00'?>
                                                            <?php if( $list['sin_retorno']!='1' && $list['horar_retorno']=== '00:00:00' ){  ?>
                                                                <a style="cursor: pointer;display: block;" title="Sin Retorno" onclick="Cambiar_solicitud_papeletas_seguridad('<?php echo $list['id_solicitudes_user']; ?>')" class="sin_retorno" role="button">
                                                                    <svg width="40" height="40" id="Icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                                                                        <defs>
                                                                            <style>
                                                                                .cls-1{fill:#45413c;opacity:0.15;}
                                                                                .cls-2{fill:#ff6242;}.cls-3{fill:#ff866e;}
                                                                                .cls-4{fill:none;stroke:#45413c;stroke-linecap:round;stroke-linejoin:round;}
                                                                            </style>
                                                                        </defs>
                                                                        <title>756-exclamation-mark</title>
                                                                        <ellipse id="_Ellipse_" data-name="&lt;Ellipse&gt;" class="cls-1" cx="24" cy="44.18" rx="8.48" ry="1.82"/>
                                                                        <path class="cls-2" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/>
                                                                        <path id="_Path_" data-name="&lt;Path&gt;" class="cls-3" d="M19.56,7.48a3.31,3.31,0,0,1,3-1.6h2.8a3.31,3.31,0,0,1,3,1.6l.19-2.41c.11-1.39-1.37-2.57-3.23-2.57H22.6c-1.86,0-3.34,1.18-3.23,2.57Z"/>
                                                                        <path class="cls-4" d="M25.4,2.5H22.6c-1.86,0-3.34,1.18-3.23,2.57L21,26.32c.09,1.18,1.4,2.11,3,2.11s2.88-.93,3-2.11L28.63,5.07C28.74,3.68,27.26,2.5,25.4,2.5Z"/>
                                                                        <circle id="_Path_2" data-name="&lt;Path&gt;" class="cls-2" cx="24" cy="35.24" r="3.65"/>
                                                                        <path id="_Path_3" data-name="&lt;Path&gt;" class="cls-3" d="M24,33.93A3.58,3.58,0,0,1,27.57,36a3.94,3.94,0,0,0,.08-.77,3.65,3.65,0,1,0-7.3,0,3.94,3.94,0,0,0,.08.77A3.58,3.58,0,0,1,24,33.93Z"/>
                                                                        <circle id="_Path_4" data-name="&lt;Path&gt;" class="cls-4" cx="24" cy="35.24" r="3.65"/>
                                                                    </svg>
                                                                </a>
                                                            <?php } ?>
                                                    <?php } ?>
                                        <?php  }else{  ?> 


                                        <?php  }  ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>           
        </div>
    <?php } ?>

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
    });
    function Vista_Imagen_Perfil(image_url,imageTitle){
        $('#modelTitle').html(imageTitle); 
        $('#modalImgs').attr('src',image_url);
        $('#profileModal').modal('show');
        //var nombredeusu= $("#id_usuarioactual").val();
        var nombredeusu= 'p';
        document.getElementById("descargarcertificado_estudiog").innerHTML = "<a href='"+image_url+"' id='imga' class='btn buttonDownload' download='qr_"+nombredeusu+".jpg'>Descargar</a>"

    }   
    function Actualizar_Papeletas_Salida() {
        var url="<?php echo site_url(); ?>Corporacion/Actualizar_Papeletas_Salida";
        $.ajax({
           // type:"POST",
            url:url,
            success:function (data) {
                $('#lista_colaborador').html(data);
            }
        });
    }

    $('#estado_solicitud').change(function(){
    var data= $(this).val();
    //alert(data);            
    });
    $('#estado_solicitud').val('2').trigger('change');
    $(document).ready(function(){
    $("#busqueda_papeleta_seguridad").trigger("click");
    });

    
</script>

<script src="<?php echo base_url(); ?>assets/chossen_plugin/chosen.jquery.js"></script>
<script>
    $('.chosen-select-deselect').chosen({
        width: '100%',
        allow_single_deselect: true
    });
</script>
<?php $this->load->view('validaciones'); ?>
<?php $this->load->view('footer'); ?>