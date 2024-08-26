@extends('layouts.plantilla')

@section('content')
<?php
    $id_nivel = session('usuario')->id_nivel;
    $id_area = session('usuario')->id_area;
    $usuario_codigo = session('usuario')->usuario_codigo;
    $centro_labores = session('usuario')->centro_labores;
?>

<style>
    .img-presentation-small {
        width: 100px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        margin: 5px;
    }

    .table-condensed td{
        vertical-align: middle;
    }
    .chosen-container .chosen-results {
        max-height:70px;
    }

    #base_chosen{
        margin-top: 7px;
    }


    @media (max-width: 600px) {
        .registrof {
            margin-top: 10px;
        }
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Listado de Slides Marketing</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">

                    <div class="toolbar">
                        <div class="container" style="padding-left: 0px; padding-right: 0px;">
                            <div class="row">
                                <div class="col-sm" align="left">

                                    <div class="row">
                                        <div class="col-sm" >
                                            <!-- Fade in up modal  href=""-->

                                            <a  onclick="Ver_Slide()" role="button" target="_blank" class="btn btn-primary mb-2 mr-2" title="Ver" >
                                                Visualizar Slide
                                            </a>
                                        </div>
                                        <div class="col-sm">
                                            <select id="base" name="base" class="form-control basic" onchange="Busca_Slide_Comercial()">
                                                <option value="0" >Seleccionar</option>
                                                <?php foreach($list_base as $list){
                                                    if($list['id_base'] == 1){ ?>
                                                            <option value="<?php //$variable = Encryptor('encrypt', $list['id_base']);  echo $variable;  ?>" selected > <?php echo $list['nom_base'];?> </option>
                                                    <?php }else{?>
                                                            <option value="<?php //$variablee = Encryptor('encrypt', $list['id_base']); echo $variablee; ?>"> <?php echo $list['nom_base'];?> </option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm registrof">
                                    <div align="right">
                                        <!-- Fade in up modal -->
                                        <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistroSlide" app_reg=" url('Marketing/Modal_Slide_Insertar_Comercial') }}" >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                            Registrar
                                        </button>
                                    </div>
                                </div>
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
    <?php //$funcioncontrolador=Encryptor('encrypt', 'Slider_Vista_Comercial'); ?>
<script>
    $(document).ready(function() {
        //$("#comercial").addClass('active');
        //$("#hcomercial").attr('aria-expanded','true');
        //$("#sliderc").addClass('active');
        $("#marketing").addClass('active');
        $("#hmarketing").attr('aria-expanded','true');
        $("#sliderc").addClass('active');
        $("#entrada_slide").inputmask({mask:"9.9"});
        $("#salida_slide").inputmask({mask:"9.9"});
        Busca_Slide_Comercial();
    });
    function Ver_Slide() {
        var base = $('#base').val();
        var funcion = "";
        var url = "{{ url('SliderComercial') }}/" + funcion + "/" + base;
        window.open(url, "_blank");
    }


    function Busca_Slide_Comercial(){
        Cargando();

        var base = $('#base').val();
        var url = "{{ url('Corporacion/Buscar_Base_Slide_Comercial') }}";
        $.ajax({
            type:"POST",
            url:url,
            data: {'base':base },
            success:function (data) {
                $('#lista_colaborador').html(data);
            }
        });
    }
    /*$('#base').on('change', function() {

    });
    $('#base').trigger("change");*/

</script>
<script>
    $('.chosen-select-deselect').chosen({
        width: '100%',
        allow_single_deselect: true
    });
</script>

@endsection

