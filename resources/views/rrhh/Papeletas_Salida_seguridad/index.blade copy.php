@extends('layouts.plantilla')

@section('navbar')
@include('rrhh.navbar')
@endsection

@section('content')

<?php
$id_puesto=session('usuario')->id_puesto;
$id_nivel=session('usuario')->id_nivel;
?>
<style>
    #tabla_estilo{
        color: #000;
    }
    #tabla_estilo tbody tr:hover{
        background-color: #E3E4E5;
    }
    #tabla_estilo th:nth-child(<?php echo date('j')+2; ?>),td:nth-child(<?php echo date('j')+2; ?>){
        background-color: #FFE1E2;
    }
</style>
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
    $id_puesto = session('usuario')->id_puesto;
    $id_nivel = session('usuario')->id_nivel;
    $centro_labores = session('usuario')->centro_labores;

    $usuario_codigo = session('usuario')->usuario_codigo;
    $permiso_pps =   session('usuario')->estadopps; 

    $registro_masivo = session('usuario')->registro_masivo;
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="home" aria-selected="true">Registro</a>
                                </li>
                            <?php if($permiso_pps==1 || $id_nivel==1 || $id_puesto==19 || $id_puesto==21 || $id_puesto==23 || $id_puesto==40 || 
                                    $id_puesto==10 || $id_puesto==93 || $id_puesto==314 || $id_puesto==315){?> 
                                <li class="nav-item">
                                    <a class="nav-link" id="aprobacion-tab" data-toggle="tab" href="#aprobacion" role="tab" aria-controls="home" aria-selected="true" onclick="Buscar_Papeletas_Salida_Gestion()">Aprobación</a>
                                </li>
                            <?php }?>
                            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==36 || $id_puesto==24 || $id_puesto==26 || $id_puesto==128 || 
                            $id_puesto==21 || $id_puesto==19 || $id_puesto==279 || $id_puesto==209 || $id_puesto==307 || $id_puesto==315){?>
                                <li class="nav-item">
                                    <a class="nav-link" id="control-tab" data-toggle="tab" href="#control" role="tab" aria-controls="home" aria-selected="true" onclick="Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad()">Control</a>
                                </li>    
                            <?php }?>
                        </ul>
                        
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_papeletas" class="widget-content widget-content-area p-3">
                                </div>
                            </div>
                        </div>
                        <div class="tab-content" id="simpletabContent">
                                <div class="tab-pane fade show active" id="registro" role="tabpanel" aria-labelledby="registro-tab">
                                    <div class="row" id="cancel-row">
                                        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                            <div class="widget-content widget-content-area br-6 p-3">
                                                <div class="toolbar">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-5 col-lg-3">
                                                            <label class="control-label text-bold">Estado Solicitud:</label>
                                                            <select id="estado_solicitud" name="estado_solicitud" class="form-control" onchange="Busca_Registro_Papeleta()">
                                                                <option value="0">Todos</option>    
                                                                <option value="1" selected>En Proceso de aprobacion</option>
                                                                <option value="2">Aprobados</option>
                                                                <option value="3">Denegados</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg="{{ url('Papeletas/Modal_Papeletas_Salida/0') }}" >
                                                                Registrar
                                                            </button>
                                                        </div>

                                                        <?php if($registro_masivo == 1 || $id_nivel==1 || $id_puesto==314) {  ?>  
                                                            <div class="col-md-4 col-lg-3">
                                                                <button type="button" class="btn btn-primary" title="Registrar Masivo" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="{{ url('Papeletas/Modal_Papeletas_Salida/1') }}" >
                                                                    Registro Masivo
                                                                </button>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="table-responsive mb-4 mt-4" id="lista_colaborador" style="max-width:100%; overflow:auto;">
                                                    <table id="zero-config" class="table style-3 " style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>Motivo</th>
                                                                <th>Destino</th>
                                                                <th>Trámite</th>
                                                                <th><div align="center">Fecha</div></th>
                                                                <th><div align="center">H. Salida</div></th>
                                                                <th><div align="center">H. Retorno</div></th>
                                                                <th><div align="center">Estado</div></th>
                                                                <?php if($ultima_papeleta_salida_todo > 0) {  ?><th class="no-content"></th><?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach($list_papeletas_salida as $list) {  ?>   
                                                            <tr>
                                                                <td>
                                                                    <?php 
                                                                        if( $list['id_motivo']==1){
                                                                            echo "Laboral"; 
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
                                                                <td align="center">
                                                                    <?php
                                                                        echo date_format(date_create($list['fec_solicitud']), "d/m/Y");
                                                                    ?>     
                                                                </td>
                                                                <td align="center">
                                                                    <?php
                                                                        if($list['sin_ingreso'] == 1 ){
                                                                            echo "Sin Ingreso";
                                                                        }else{
                                                                            echo $list['hora_salida']; 
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <td align="center">
                                                                    <?php 
                                                                        if($list['sin_retorno'] == 1 ){
                                                                            echo "Sin Retorno";
                                                                        }else{ 
                                                                            echo $list['hora_retorno'];
                                                                        } 
                                                                    ?>
                                                                </td>
                                                                <td align="center">
                                                                    <?php 
                                                                        if( $list['estado_solicitud']=='1'){
                                                                            echo "<span class='shadow-none badge badge-warning'>En proceso</span>"; 
                                                                        }else if ($list['estado_solicitud']=='2'){
                                                                            echo "<span class='shadow-none badge badge-primary'>Aprobado</span>"; 
                                                                        }else if ($list['estado_solicitud']=='3'){
                                                                            echo " <span class='shadow-none badge badge-danger'>Denegado</span>"; 
                                                                        }else if ($list['estado_solicitud']=='4'){
                                                                            echo "<span class='shadow-none badge badge-warning'>En proceso - Aprobación Gerencia</span>"; 
                                                                        }else if($list['estado_solicitud']=='5') {
                                                                            echo "<span class='shadow-none badge badge-warning'>En proceso - Aprobación RRHH</span>"; 
                                                                        }else{
                                                                            echo "<span class='shadow-none badge badge-primary'>Error</span>"; 
                                                                        }
                                                                    ?>
                                                                </td>
                                                                <?php if( $ultima_papeleta_salida_todo > 0){ ?>
                                                                    <td class="text-center">
                                                                        <?php if( $list['estado_solicitud']=='1'){ ?>
                                                                            <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('Papeletas/Modal_Update_Papeletas_Salida/'. $list["id_solicitudes_user"]) }}">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                                            </a>
                                                                            <a href="#" class="" title="Eliminar" onclick="Delete_Papeletas_Salida('<?php echo $list['id_solicitudes_user']; ?>')" id="Eliminar" role="button">
                                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                                                </svg>
                                                                            </a>
                                                                        <?php }else{?>
                                                                            <a title="No puedes editar" class="anchor-tooltip tooltiped"><div class="divdea">
                                                                            <svg id="Layer_1" width="13" height="13" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><defs><style>.cls-1{fill:#2d3e50;}</style></defs><title>n</title><path class="cls-1" d="M86.15787,99.25657c-3.54161,2.827-10.03158,6.41724-14.75995,6.08384-4.67736-.3298-3.78182-4.78987-2.85481-8.295l7.83763-29.63476a13.29171,13.29171,0,0,0-25.68221-6.86278C49.55418,64.7858,40.39666,102.57942,40.34023,102.816c-1.28065,5.36943-2.81226,12.2324-.45115,17.525,3.58188,8.02819,14.46035,5.69646,21.06968,3.78541a52.68574,52.68574,0,0,0,12.91952-5.64322,118.52775,118.52775,0,0,0,13.15678-10.41187Z"/><path class="cls-1" d="M74.55393,2.049c-9.8517-.61753-19.65075,8.23893-20.034,18.3877a15.14774,15.14774,0,0,0,2.23531,8.54311c6.11649,9.89677,20.16846,7.7415,27.76526.91074C94.54734,20.87483,87.832,2.88134,74.55393,2.049Z"/></svg>
                                                                            </div></a>
                                                                        <?php } ?>
                                                                    </td>
                                                                <?php } ?>
                                                            </tr>
                                                        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==36 || $id_puesto==24 || $id_puesto==26 || $id_puesto==128 ||
                                $id_puesto==21 || $id_puesto==19 || $id_puesto==279 || $id_puesto==209 || $id_puesto==307 || $id_puesto==315){ ?>
                                <div class="tab-pane fade show" id="control" role="tabpanel" aria-labelledby="control-tab">
                                    <div class="toolbar">        
                                        <div class="row">
                                            <div class="form-group col-md-1">
                                                <label class="control-label text-bold">&nbsp;</label>
                                                <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad();" title="Buscar">
                                                    <svg id="Fill_out_line" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" data-name="Fill out line"><path d="m276.53 446.91 4.28 39.77a229.93706 229.93706 0 0 0 42.04-8.46l-11.52-38.31a191.42161 191.42161 0 0 1 -34.8 7z" fill="#2d80b3"/><path d="m192.60986 479.23a230.11769 230.11769 0 0 0 42.18014 7.81l3.6499-39.83a192.31768 192.31768 0 0 1 -34.8999-6.46z" fill="#379ec3"/><path d="m410.29 370.29-34.29-34.29v96h96l-33.16992-33.17a232.06529 232.06529 0 0 0 -79.43994-350.57l-17.82007 35.82a192.06183 192.06183 0 0 1 68.72 286.21z" fill="#e44042"/><path d="m24 256a231.987 231.987 0 0 0 128.60986 207.74l17.82007-35.82a192.06183 192.06183 0 0 1 -68.72-286.21l34.29007 34.29v-96h-96l33.16992 33.17a230.98265 230.98265 0 0 0 -49.16992 142.83z" fill="#8acce7"/><path d="m189.1499 33.78 11.52 38.31a191.42671 191.42671 0 0 1 34.80005-7l-4.28-39.77a229.93194 229.93194 0 0 0 -42.04005 8.46z" fill="#bf2226"/><path d="m273.56006 64.79a192.32292 192.32292 0 0 1 34.89994 6.46l10.93018-38.48a230.11769 230.11769 0 0 0 -42.18018-7.81z" fill="#d1393b"/><path d="m192 384h128a24 24 0 0 0 24-24v-184l-48-48h-104a24 24 0 0 0 -24 24v208a24 24 0 0 0 24 24z" fill="#eedc9a"/><path d="m296 128v48h48z" fill="#eebe33"/><path d="m16 256a239.98553 239.98553 0 0 0 133.04053 214.89941 8.00046 8.00046 0 0 0 10.73193-3.5957l17.81983-35.82031a7.9999 7.9999 0 0 0 -3.59278-10.72266 183.997 183.997 0 0 1 -101.99951-164.76074 182.40958 182.40958 0 0 1 30.7749-101.91113l27.56836 27.56836a8.00038 8.00038 0 0 0 13.65674-5.65723v-96a8.00008 8.00008 0 0 0 -8-8h-96a8.0001 8.0001 0 0 0 -5.65674 13.65723l28.23389 28.23339a237.462 237.462 0 0 0 -46.57715 142.10938zm16 0a221.74014 221.74014 0 0 1 47.4707-137.90039 8.00059 8.00059 0 0 0 -.644-10.58691l-19.51322-19.5127h68.68652v68.68652l-20.6333-20.63379a7.99987 7.99987 0 0 0 -12.08154.89063 200.097 200.097 0 0 0 -8.49268 225.72564 200.63449 200.63449 0 0 0 72.98584 68.70117l-10.70117 21.50976a223.96573 223.96573 0 0 1 -117.07715-196.87993z"/><path d="m368 336v96a8.00008 8.00008 0 0 0 8 8h96a8.0001 8.0001 0 0 0 5.65674-13.65723l-28.23389-28.23339a240.13378 240.13378 0 0 0 9.62549-270.11622 240.69753 240.69753 0 0 0 -96.08887-86.89257 7.99825 7.99825 0 0 0 -10.73193 3.5957l-17.82031 35.82031a7.99989 7.99989 0 0 0 3.59277 10.72266 183.99625 183.99625 0 0 1 102 164.76074 182.40958 182.40958 0 0 1 -30.7749 101.91113l-27.56836-27.56836a8.00038 8.00038 0 0 0 -13.65674 5.65723zm16 19.31348 20.6333 20.63379a7.99987 7.99987 0 0 0 12.08154-.89063 200.09575 200.09575 0 0 0 8.49216-225.72559 200.61981 200.61981 0 0 0 -72.98584-68.70019l10.70166-21.51074a223.96573 223.96573 0 0 1 117.07718 196.87988 221.74014 221.74014 0 0 1 -47.4707 137.90039 8.00059 8.00059 0 0 0 .644 10.58691l19.51322 19.5127h-68.68652z"/><path d="m270.30371 441.88672a8.00162 8.00162 0 0 0 -1.728 5.87988l4.28028 39.76953a8.0019 8.0019 0 0 0 7.94433 7.14453 7.83386 7.83386 0 0 0 .85157-.04589 238.45249 238.45249 0 0 0 43.50293-8.75391 8.001 8.001 0 0 0 5.35644-9.96484l-11.52-38.30957a8.00452 8.00452 0 0 0 -9.95947-5.35938 184.05407 184.05407 0 0 1 -33.34717 6.708 8.00188 8.00188 0 0 0 -5.38091 2.93165zm15.02 11.97168a200.34292 200.34292 0 0 0 20.60059-4.14356l6.91894 23.00879a222.96106 222.96106 0 0 1 -24.94922 5.01758z"/><path d="m184.91406 477.04492a7.99887 7.99887 0 0 0 5.51026 9.88086 238.84772 238.84772 0 0 0 43.6455 8.082c.24512.02149.48829.03321.7295.03321a8.00158 8.00158 0 0 0 7.95752-7.27051l3.6499-39.83008a7.9994 7.9994 0 0 0 -7.24219-8.69727 184.99166 184.99166 0 0 1 -33.44873-6.1914 8.00071 8.00071 0 0 0 -9.87158 5.51269zm17.61719-3.46582 6.56543-23.1123a201.21079 201.21079 0 0 0 20.66064 3.82519l-2.19189 23.91895a223.01393 223.01393 0 0 1 -25.03418-4.63184z"/><path d="m241.6958 70.11328a8.00037 8.00037 0 0 0 1.728-5.87988l-4.2798-39.76953a7.98552 7.98552 0 0 0 -8.7959-7.09864 238.43585 238.43585 0 0 0 -43.50293 8.75391 8.001 8.001 0 0 0 -5.35644 9.96484l11.52 38.30957a7.99331 7.99331 0 0 0 9.95947 5.35938 184.06575 184.06575 0 0 1 33.34668-6.708 8.00188 8.00188 0 0 0 5.38092-2.93165zm-15.02-11.97168a200.33375 200.33375 0 0 0 -20.6001 4.14356l-6.91894-23.00879a222.95262 222.95262 0 0 1 24.94873-5.01758z"/><path d="m327.08594 34.95508a7.99887 7.99887 0 0 0 -5.51026-9.88086 238.86314 238.86314 0 0 0 -43.6455-8.082 8.01128 8.01128 0 0 0 -8.687 7.2373l-3.6499 39.83008a7.9994 7.9994 0 0 0 7.24219 8.69727 184.99166 184.99166 0 0 1 33.44873 6.1914 7.991 7.991 0 0 0 9.87158-5.51269zm-17.61719 3.46582-6.56543 23.1123a201.21079 201.21079 0 0 0 -20.66064-3.8252l2.19189-23.919a223.03441 223.03441 0 0 1 25.03418 4.6319z"/><path d="m320 392a32.03635 32.03635 0 0 0 32-32v-184a8.00076 8.00076 0 0 0 -2.34326-5.65723l-48-48a8.00035 8.00035 0 0 0 -5.65674-2.34277h-104a32.03635 32.03635 0 0 0 -32 32v208a32.03635 32.03635 0 0 0 32 32zm-16-244.68652 20.68652 20.68652h-20.68652zm-128 212.68652v-208a16.01833 16.01833 0 0 1 16-16h96v40a8.00008 8.00008 0 0 0 8 8h40v176a16.01833 16.01833 0 0 1 -16 16h-128a16.01833 16.01833 0 0 1 -16-16z"/><path d="m192 152h32v16h-32z"/><path d="m208 200h80v16h-80z"/><path d="m304 200h16v16h-16z"/><path d="m288 264h32v16h-32z"/><path d="m192 264h80v16h-80z"/><path d="m256 232h64v16h-64z"/><path d="m192 232h48v16h-48z"/><path d="m192 296h64v16h-64z"/><path d="m272.798 296h31.202v16h-31.202z"/><path d="m280.798 328h31.202v16h-31.202z"/></svg>
                                                </button>
                                            </div>
                                            <?php if($id_puesto==23 || $id_puesto==26 || $id_puesto==128 || $id_nivel==1 || $id_nivel==21 || $id_nivel==19 || $centro_labores==="CD" || $centro_labores==="OFC" || $centro_labores==="AMT" || $id_puesto==279 || $id_puesto==209) { ?>
                                                <div class="col-md-2 form-group">
                                                    <label class="control-label text-bold">Bases:</label>
                                                    <select id="base" name="base" placeholder="Centro de labores" data-placeholder="Your Favorite Type of Bear" tabindex="10" class="form-control chosen-select-deselect" onchange="Busca_Colaborador_Control()">
                                                    <option value="0">Todas</option>
                                                    <?php foreach($list_base as $list){ ?>
                                                        <option value="<?php echo $list['cod_base']?>"> <?php echo $list['cod_base'];?> </option>
                                                    <?php } ?>
                                                    </select>
                                                </div>
                                            <?php }else{?> 
                                            <input type="hidden" name="base" id="base" value="<?php echo $centro_labores ?>">    
                                            <?php } ?>
                                            <div class="col-md-3">
                                                <div class="form-group" id="colaborador_control">
                                                    <label class="control-label text-bold">Colaborador:</label>
                                                    <select id="num_doc_control" name="num_doc_control" class="form-control basic">
                                                        <option value="0">TODOS</option>
                                                        <?php foreach($list_colaborador_control as $list){?> 
                                                            <option value="<?php echo $list['id_usuario']; ?>"> <?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres'];?> </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="control-label text-bold">Estado Solicitud:</label>
                                                    <select id="estado_solicitud3" name="estado_solicitud3" class="form-control" >
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
                                                        <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision3" value="<?php echo date("Y-m-d");?>"  name="fecha_revision3" > 
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="control-label text-bold">Fecha Fin:</label>
                                                        <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision_fin3" value="<?php echo date("Y-m-d");?>"  name="fecha_revision_fin3" > 
                                                </div>
                                            </div>
                                            <div class="form-group col-md-1">
                                                <label class="control-label text-bold">&nbsp;</label>
                                                <button type="button" id="busqueda_papeleta_seguridad" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad();" title="Buscar">
                                                    Buscar
                                                </button>
                                            </div>
                                            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==128 || $id_puesto==26 || $id_nivel==21 || $id_nivel==19 || $id_puesto==279){?> 
                                                <div class="form-group col-md-1">
                                                    <label class="control-label text-bold">&nbsp;</label>
                                                    <a class="btn mb-2 mr-2 form-control" style="background-color: #28a745 !important;" onclick="Excel_Estado_Solicitud_Papeletas_Salida_Seguridad()">
                                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>
                                                    </a>
                                                </div>
                                            <?php }?>
                                            
                                        </div>
                                    </div>
                                    @csrf
                                    <div class="table-responsive mb-4 mt-4" id="lista_colaborador3" style="max-width:100%; overflow:auto;">
                                    </div>
                                </div>
                            <?php } ?>
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
        $("#papeletas").addClass('active');
        $("#busqueda_papeleta_seguridad").trigger("click");
        if('<?php echo $permiso_pps ?>'==1 || '<?php echo $id_nivel ?>'==1 || '<?php echo $usuario_codigo ?>'==="44582537" || '<?php echo $usuario_codigo ?>'==="46553611" || '<?php echo $usuario_codigo ?>'==="29426417" || '<?php echo $usuario_codigo ?>'==="08584691" || '<?php echo $usuario_codigo ?>'==="46156858" || '<?php echo $id_puesto ?>'==19 || '<?php echo $id_puesto ?>'==21 || '<?php echo $id_puesto ?>'==279 || '<?php echo $id_puesto ?>'==23 || '<?php echo $id_puesto ?>'==40){
            console.log('ppp');
            Busca_Registro_Papeleta()
        }
    });

    function Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad() {
        Cargando();

        var base = $('#base').val();
        var num_doc = $('#num_doc_control').val();
        var estado_solicitud = $('#estado_solicitud3').val();
        //var id_area = $('#id_area').val();
        var fecha_revision = $('#fecha_revision3').val();
        var fecha_revision_fin = $('#fecha_revision_fin3').val();
        var url = "{{ url('Papeletas/Buscar_Base_Papeletas_Seguridad') }}";
        var ini = moment(fecha_revision);
        var fin = moment(fecha_revision_fin);
        var csrfToken = $('input[name="_token"]').val();

        if (ini.isAfter(fin) == true) {
            msgDate = 'La Fecha de Inicio no debe ser mayor a la de Fecha de Fin. <br> Porfavor corrígelo. ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else if (fecha_revision != '' && fecha_revision_fin === '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha final también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });

        } else if (fecha_revision === '' && fecha_revision_fin != '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha inicial también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'base': base,
                    'estado_solicitud': estado_solicitud,
                    'fecha_revision': fecha_revision,
                    'fecha_revision_fin': fecha_revision_fin,
                    'num_doc':num_doc
                },
                success: function(data) {
                    $('#lista_colaborador3').html(data);
                }
            });
        }

    }

    function Buscar_Papeletas_Salida_Gestion() {
        Cargando();
        var estado_solicitud = $('#estado_solicitud2').val();
        var fecha_revision = $('#fecha_revision').val();
        var fecha_revision_fin = $('#fecha_revision_fin').val();
        var url = "{{ url('Papeletas/Buscar_Papeletas_Salida_Gestion') }}";
        var csrfToken = $('input[name="_token"]').val();

        var ini = moment(fecha_revision);
        var fin = moment(fecha_revision_fin);

        if (ini.isAfter(fin) == true) {
            msgDate = 'La Fecha de Inicio no debe ser mayor a la de Fecha de Fin. <br> Porfavor corrígelo. ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else if (fecha_revision != '' && fecha_revision_fin === '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha final también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });

        } else if (fecha_revision === '' && fecha_revision_fin != '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha inicial también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'estado_solicitud': estado_solicitud,
                    'fecha_revision': fecha_revision,
                    'fecha_revision_fin': fecha_revision_fin
                },
                success: function(data) {
                    $('#lista_colaborador2').html(data);
                }
            });
        }
    }

    function Busca_Registro_Papeleta(){
        Cargando();
        var estado_solicitud = $('#estado_solicitud').val();//this.value;
        var url = "{{ url('Papeletas/Buscar_Estado_Solicitud_Papeletas_Salida_Usuario') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'estado_solicitud':estado_solicitud },
            success:function (data) {
                $('#lista_colaborador').html(data);
            }
        });
    }
   
</script>
@endsection

<script>
    
    /***********primero tooltip */
    var anchors = document.querySelectorAll('.anchor-tooltip');
    anchors.forEach(function(anchor) {
        var toolTipText = anchor.getAttribute('title'),
            toolTip = document.createElement('span');
        toolTip.className = 'title-tooltip';
        toolTip.innerHTML = toolTipText;
        anchor.appendChild(toolTip);
    });
    /***********primero tooltip. */

    $('.buttonDownload[download]').each(function() {
        var $a = $(this),
        fileUrl = $a.attr('href');
        $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
    });

    function Vista_Imagen_Perfil(image_url,imageTitle){
        $('#modelTitle').html(imageTitle); 
        $('#modalImgs').attr('src',image_url);
        $('#profileModal').modal('show');
        //var nombredeusu= $("#id_usuarioactual").val();
        var nombredeusu= 'p';
        document.getElementById("descargarcertificado_estudiog").innerHTML = "<a href='"+image_url+"' id='imga' class='btn buttonDownload' download='qr_"+nombredeusu+".jpg'>Descargar</a>"
    }
    
</script>

<!----segundo tab aprobacion-->
