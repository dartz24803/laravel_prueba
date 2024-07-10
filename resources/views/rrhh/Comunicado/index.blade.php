@extends('layouts.plantilla')

@section('content')

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a id="a_sr" class="nav-link" onclick="Slider_Rrhh();" style="cursor: pointer;">Slider RRHH</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_ai" class="nav-link" onclick="Anuncio_Intranet();" style="cursor: pointer;">Anuncios Intranet</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_comunicado" class="widget-content widget-content-area">
                                </div>
                            </div>
                        </div>
                        <!--<div class="tab-content" id="simpletabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="registro-tab-1">
                                <div class="row" id="cancel-row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="widget-content widget-content-area br-6">

                                            <div class="toolbar">
                                                <div class="container" style="padding-left: 0px; padding-right: 0px;">
                                                    <div class="row col-md-12">
                                                        <div class="form-group col-md-2">
                                                            <label for="" class="col-sm-12 control-label text-bold">Tipo</label>
                                                        </div>
                                                        <div class="form-group col-sm-2">
                                                            <select name="tipoi" id="tipoi" class="form-control" onchange="Tipo_Slide()">
                                                                <option value="2">Tienda</option>
                                                                <?php foreach($list_base as $list){?> 
                                                                    <option value="<?php echo $list['cod_base'] ?>"><?php echo $list['cod_base'] ?></option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div align="left">
                                                                <?php
                                                                    //$funcioncontrolador=Encryptor('encrypt', 'Slider_Vista_RRHH');
                                                                    //$funcioncontrolador_tienda=Encryptor('encrypt', 'Slider_Vista_Tienda');
                                                                ?>
                                                                <div id="btn_slide">
                                                                <a id="hslider" target="_blank" class="btn btn-primary mb-2 mr-2" title="Registrar" href=" {{ url('SliderRRHH/'.$funcioncontrolador) }}">
                                                                    Visualizar Slide OFC
                                                                </a>    
                                                                </div>
                                                                
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-sm">
                                                            <div align="right">
                                                                <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg_slide="<?= site_url('Corporacion/Modal_Slide_Insertar_RRHH') ?>" >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                                    Registrar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive mb-4 mt-4" id="lista_slide">
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show" id="bolsa" role="tabpanel" aria-labelledby="bolsa-tab">
                                <div class="row">
                                    <div id="btnGroupInput-group" class="col-xl-12 col-lg-12 col-sm-12 layout-spacing" style="margin-bottom: -28px;" >
                                        <div class="widget-content text-center split-buttons" style="background-color: transparent;">
                                            <div class="btn-toolbar justify-content-between mr-2" role="toolbar" aria-label="Toolbar with button groups">
                                                
                                                <div class="input-group mb-2" style="display: flex;justify-content: center;align-content: center;" >
                                                    <div class="toolbar" style="height: 37px;" id="boton_list">
                                                        <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="<?= site_url('Corporacion/Modal_Bolsa_Trabajo') ?>" >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                                            Registrar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="cancel-row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="widget-content widget-content-area br-6">
                                            <div class="table-responsive mb-4 mt-4" id="lista_colaborador">
                                                <table id="zero-config2" class="table table-hover" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th width="8%">Base</th>
                                                            <th width="8%">Orden</th>
                                                            <th width="68%">URL</th>
                                                            <th width="8%">Publicado</th>
                                                            <th width="8%" class="no-content"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach($list_bolsa_trabajo as $list) {  ?>   
                                                        <tr>
                                                            <td><?php echo $list['cod_base']; ?></td>
                                                            <td><?php echo $list['orden']; ?></td>
                                                            <td><?php echo $list['url']; ?></td>
                                                            <td><?php if($list['publicado']==1){ echo "SI"; }else{ echo "NO"; } ?></td>
                                                            <td class="text-center">
                                                                <a href="javascript:void(0);"  title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= site_url('Corporacion/Modal_Update_Bolsa_Trabajo') ?>/<?php echo $list['id_bolsa_trabajo']; ?>" >
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                                    </svg>
                                                                </a>
                                                                <a style="cursor:pointer;display: -webkit-inline-box;" title="Imagen" data-toggle="modal" data-target="#Modal_IMG_Link" data-imagen="<?php echo $url[0]['url_config'].$list['imagen']; ?>" >
                                                                    <svg version="1.1" id="Capa_1" style="width:20px; height:20px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 512.81 512.81" style="enable-background:new 0 0 512.81 512.81;" xml:space="preserve"><rect x="260.758" y="276.339" transform="matrix(0.7071 -0.7071 0.7071 0.7071 -125.9193 303.0804)" style="fill:#344A5E;" width="84.266" height="54.399"/><circle style="fill:#8AD7F8;" cx="174.933" cy="175.261" r="156.8"/><path style="fill:#415A6B;" d="M299.733,300.061c-68.267,68.267-180.267,68.267-248.533,0s-68.267-180.267,0-248.533s180.267-68.267,248.533,0S368,231.794,299.733,300.061z M77.867,78.194c-53.333,53.333-53.333,141.867,0,195.2s141.867,53.333,195.2,0s53.333-141.867,0-195.2S131.2,23.794,77.867,78.194z"/><path style="fill:#F05540;" d="M372.267,286.194c-7.467-7.467-19.2-7.467-26.667,0l-59.733,59.733c-7.467,7.467-7.467,19.2,0,26.667s19.2,7.467,26.667,0l59.733-59.733C379.733,305.394,379.733,293.661,372.267,286.194z"/><path style="fill:#F3705A;" d="M410.667,496.328C344.533,436.594,313.6,372.594,313.6,372.594l59.733-59.733c0,0,65.067,32,123.733,97.067c21.333,24.533,21.333,60.8-2.133,84.267l0,0C471.467,517.661,434.133,518.728,410.667,496.328z"/></svg>
                                                                </a>
                                                                <a href="#" class="" title="Eliminar" onclick="Delete_Bolsa_Trabajo('<?php echo $list['id_bolsa_trabajo']; ?>')" id="delete" role="button">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                        <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
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
        $("#recomunicados").addClass('active');

        Slider_Rrhh();
    });

    function Slider_Rrhh(){ 
        Cargando();

        var url="<?php echo site_url(); ?>Recursos_Humanos/Cargar_Slider_Rrhh";

        $.ajax({
            url: url,
            type:"POST",
            success:function (resp) {
                $('#div_comunicado').html(resp);  
                $("#a_sr").addClass('active');
                $("#a_ai").removeClass('active');
            }
        });
    }

    function Anuncio_Intranet(){ 
        Cargando();

        var url="<?php echo site_url(); ?>Recursos_Humanos/Cargar_Anuncio_Intranet";

        $.ajax({
            url: url,
            type:"POST",
            success:function (resp) {
                $('#div_comunicado').html(resp);  
                $("#a_sr").removeClass('active');
                $("#a_ai").addClass('active');
            }
        });
    }

    function Delete_Bolsa_Trabajo(id){
        var id = id;
        var url="<?php echo site_url(); ?>Corporacion/Delete_Bolsa_Trabajo";
        Swal({
            title: '¿Realmente desea eliminar el registro',
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
                    type:"POST",
                    url:url,
                    data: {'id_bolsa_trabajo':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "<?php echo site_url(); ?>Corporacion/Bolsa_Trabajo";
                        });
                    }
                });
            }
        })
    }
</script>

@endsection