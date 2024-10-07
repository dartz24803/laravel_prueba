@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')
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
        height: 21px;
        vertical-align: bottom;
    }
</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="row layout-top-spacing" id="cancel-row">

            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                                <h4>Control de Salida de Mercadería y Activos</h4>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="home" aria-selected="true" >Reporte</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="simpletabContent">
                            <div class="tab-pane fade show active" id="registro" role="tabpanel" aria-labelledby="registro-tab">
                                <div class="row" id="cancel-row">
                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="widget-content widget-content-area br-6">
                                            <div class="toolbar">
                                                <div align="left">
                                                    <form id="form_control_merca_activo">
                                                        <div class="col-md-12 row">
                                                            <div class="form-group col-md-2">
                                                                <label class="control-label text-bold">Base: </label>
                                                                <select name="base" id="base" class="form-control">
                                                                    <option value="0">Seleccione</option>
                                                                    <?php foreach($list_base as $list){?>
                                                                        <option value="<?php echo $list->cod_base ?>"><?php echo $list->cod_base ?></option>
                                                                    <?php }?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label class="control-label text-bold">Inicio: </label>
                                                                <input type="date" class="form-control" name="f_inicio" id="f_inicio" value="<?php echo date('Y-m-d') ?>">
                                                            </div>
                                                            <div class="form-group col-md-2">
                                                                <label class="control-label text-bold">Fin: </label>
                                                                <input type="date" class="form-control" name="f_fin" id="f_fin" value="<?php echo date('Y-m-d') ?>">
                                                            </div>
                                                            <input type="hidden" name="tvista" id="tvista" value="C">
                                                            <!--<div class="form-group col-md-2">
                                                                <label class="control-label text-bold">Tipo Vista: </label>
                                                                <select name="tvista" id="tvista" class="form-control">
                                                                    <option value="0">Seleccione</option>
                                                                    <option value="D">Detalle</option>
                                                                    <option value="C">Documento</option>
                                                                </select>
                                                            </div>-->
                                                            <div class="form-group col-md-1">
                                                                <label class="control-label text-bold">&nbsp;</label>
                                                                <button type="button" class="btn btn-primary form-control" onclick="Buscar_Control_Mercaderia_Activo()">Buscar
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>

                                                </div>
                                            </div>
                                            @csrf
                                            <div class="table-responsive mb-4 mt-4" id="lista_control">

                                            </div>
                                        </div>
                                    </div>
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
        $("#logisticas").addClass('active');
        $("#rlogisticas").attr('aria-expanded','true');
        $("#controlmercaderiaactivoe").addClass('active');
    });

    function Buscar_Control_Mercaderia_Activo() {
        Cargando();
        var dataString = new FormData(document.getElementById('form_control_merca_activo'));
        var url = "{{ url('ControlSalidaMercaderia/Buscar_Control_Mercaderia_Activo') }}";
        var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#lista_control').html(data);
                },
                error:function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            });
    }
</script>


@endsection
