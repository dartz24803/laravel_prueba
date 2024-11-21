@extends('layouts.plantilla')

@section('navbar')
    @include('rrhh.navbar')
@endsection

@section('content')
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

    .col-md-1, .col-md-2{
        padding-right: 0px;
        padding-left: 15px;
    }

    .btn{
        font-size: 13px;
    }
</style>

<?php
    $sesion= Session('usuario');
    $id_nivel=Session('usuario')->id_nivel;
    $desvinculacion=Session('usuario')->desvinculacion;
    $estado=Session('usuario')->estado;
    $id_puesto=Session('usuario')->id_puesto;
    $id_cargo=Session('usuario')->id_cargo;
    $usuario_codigo=Session('usuario')->usuario_codigo;
    $centro_labores=Session('usuario')->id_centro_labor;
    $acceso=Session('usuario')->acceso;
    $induccion=Session('usuario')->induccion;
    $nom_area=Session('usuario')->nom_area;
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Reporte de Control de Asistencia</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="unmark-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="true">No marcados</a>
                            </li>
                        </ul>

                        <div class="tab-content p-2" id="simpletabContent">
                            {{-- tab1 --}}
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label text-bold">C.&nbsp;Labores:</label>
                                                <select id="cod_base" name="cod_base" class="form-control basic" onchange="Limpiar_Campos()">
                                                    <option value="0" >TODOS</option>
                                                    <option value="t" >TIENDAS</option>
                                                    <?php foreach($list_base as $list){?>
                                                        <option <?php if(($id_nivel==1 || $id_nivel==2) && $list['id_ubicacion']==23){echo "selected"; }?> value="<?php echo $list['id_ubicacion']; ?>"> <?php echo $list['cod_ubi'];?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Área:</label>
                                                <select id="id_area" name="id_area" class="form-control basic" onchange="Traer_Colaborador();">
                                                    <option value="0">TODOS</option>
                                                    <?php foreach($list_area as $list){?>
                                                        <option value="<?php echo $list['id_area']; ?>"> <?php echo $list['nom_area'];?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Estado:</label><br>
                                                <input type="radio" name="estado" id="estadosi" value="1" checked="checked" onclick="Traer_Colaborador();">
                                                <label class="form-check-label" for="estadosi">Activos</label><br>
                                                <input type="radio" name="estado" id="estadono" value="2" onclick="Traer_Colaborador();">
                                                <label class="form-check-label" for="estadono">Inactivos</label>
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
                                                <label class="form-check-label" for="tipo1">Por Mes</label>
                                                <br>
                                                <input type="radio" name="tipo" id="tipo2" value="2"  onclick="TipoBusqueda('2')">
                                                <label class="form-check-label" for="tipo2">Por Rango</label>
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

                                        <div class="form-group col-md-1">
                                            <button class="btn btn-primary hidden-sm" type="button" onclick="Excel_Reporte_Asistencia();" style="margin-top:33px;background-color: #28a745!important;border-color:#28a745!important">
                                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @csrf
                                <div class="table-responsive mb-4 mt-4" id="lista_colaborador">
                                </div>
                            </div>
                            {{-- tab2 --}}
                            <div class="tab-pane fade show" id="home2" role="tabpanel" aria-labelledby="unmark-tab">
                                <div class="toolbar">
                                    <div class="row">
                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label text-bold">C.&nbsp;Labores:</label>
                                                <select id="cod_base_nm" name="cod_base_nm" class="form-control basic" onchange="Limpiar_Campos()">
                                                    <option value="0" >TODOS</option>
                                                    <option value="t" >TIENDAS</option>
                                                    <?php foreach($list_base as $list){?>
                                                        <option <?php if(($id_nivel==1 || $id_nivel==2) && $list['id_ubicacion']==23){echo "selected"; }?> value="<?php echo $list['id_ubicacion']; ?>"> <?php echo $list['cod_ubi'];?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Área:</label>
                                                <select id="id_area_nm" name="id_area_nm" class="form-control basic" onchange="Traer_Colaborador_nm();">
                                                    <option value="0">TODOS</option>
                                                    <?php foreach($list_area as $list){?>
                                                        <option value="<?php echo $list['id_area']; ?>"> <?php echo $list['nom_area'];?> </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Estado:</label><br>
                                                <input type="radio" name="estado_nm" id="estadosi_nm" value="1" checked="checked" onclick="Traer_Colaborador_nm();">
                                                <label class="form-check-label" for="estadosi_nm">Activos</label><br>
                                                <input type="radio" name="estado_nm" id="estadono_nm" value="2" onclick="Traer_Colaborador_nm();">
                                                <label class="form-check-label" for="estadono_nm">Inactivos</label>
                                            </div>
                                        </div>

                                        <input type="hidden" name="id_puesto" id="id_puesto" value="<?php echo $id_puesto; ?>">
                                        <div class="col-md-2" id="cmb_colaborador">
                                            <div class="form-group" >
                                                <label class="control-label text-bold">Colaborador:</label>
                                                <select id="num_doc_nm" name="num_doc_nm" class="form-control basic">
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
                                                <input type="radio" name="tipo_nm" id="tipo1_nm" value="1" checked="checked" onclick="TipoBusqueda_nm('1')">
                                                <label class="form-check-label" for="tipo1_nm">Por Mes</label>
                                                <br>
                                                <input type="radio" name="tipo_nm" id="tipo2_nm" value="2"  onclick="TipoBusqueda_nm('2')">
                                                <label class="form-check-label" for="tipo2_nm">Por Rango</label>
                                            </div>
                                        </div>

                                        <div class="col-md-1" id="cmb_mes_nm">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Mes:</label>
                                                <select class="form-control" id="cod_mes_nm" name="cod_mes_nm">
                                                    <?php foreach($list_mes as $list){ ?>
                                                        <option value="<?php echo $list['cod_mes'] ?>" <?php if($list['cod_mes']==date('m')){ echo "selected"; } ?>><?php echo $list['nom_mes']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-1" id="cmb_anio_nm">
                                            <div class="form-group">
                                                <label class="control-label text-bold">Año:</label>
                                                <select class="form-control" id="cod_anio_nm" name="cod_anio_nm">
                                                    <?php foreach($list_anio as $list){ ?>
                                                        <option value="<?php echo $list['cod_anio'] ?>" <?php if($list['cod_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['cod_anio']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-2" id="cmb_finicio_nm" style="display:none">
                                            <div class="form-group">
                                                <label class="control-label text-bold">F inicio:</label>
                                                    <input type="date" class="form-control formcontrolarlimpiar" id="finicio_nm"  name="finicio_nm" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-2" id="cmb_ffin_nm" style="display:none">
                                            <div class="form-group">
                                                <label class="control-label text-bold">F fin:</label>
                                                    <input type="date" class="form-control formcontrolarlimpiar" id="ffin_nm"  name="ffin_nm" value="<?php echo date('Y-m-d') ?>">
                                            </div>
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label class="control-label text-bold">&nbsp;</label>
                                            <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_No_Marcados();" title="Buscar">
                                                Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @csrf
                                <div class="table-responsive mb-4 mt-4" id="lista_colaborador_nm">
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
        ReporteControlAsistencia();
    });

    function Limpiar_Campos(){
        Cargando();
        $('#id_area').val(0).trigger('change');
        $('#id_puesto').val(0).trigger('change');
        $('#id_area_nm').val(0).trigger('change');
        $('#id_puesto_nm').val(0).trigger('change');
        Traer_Colaborador();
    }

    function Traer_Colaborador(){
        Cargando();

        var cod_base = $('#cod_base').val();
        var id_area = $('#id_area').val();
        var id_puesto = $('#id_puesto').val();
        if(id_puesto == 29){
            var estado = 1;
        }else{
            if ($('#estadosi').is(":checked")){
                var estado = 1;
            }

            if ($('#estadono').is(":checked")){
                var estado = 3;
            }
        }
        var url = "{{ url('Asistencia/Traer_Colaborador_Asistencia') }}";

        $.ajax({
            type: "GET",
            url: url,
            data: {'cod_base':cod_base,'id_area':id_area,'estado':estado},
            success: function(data) {
                $('#num_doc').html(data);
            }
        });
    }

    function TipoBusqueda() {
        Cargando();
        var div1 = document.getElementById("cmb_mes");
        var div4 = document.getElementById("cmb_anio");
        var div2 = document.getElementById("cmb_finicio");
        var div3 = document.getElementById("cmb_ffin");

        if ($('#tipo1').is(":checked")){
            div1.style.display = "block";
            div4.style.display = "block";
            div2.style.display = "none";
            div3.style.display = "none";
        }else{
            div1.style.display = "none";
            div4.style.display = "none";
            div2.style.display = "block";
            div3.style.display = "block";
        }

    }

    function Edit_asistencia_diaria(t) {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario_asistencia_diaria'));
        var url = "{{ url('Update_Asistencia_Diaria') }}"
        if (Valida_edit_asistencia_diaria()) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        if(t==2){
                            fecha=$('#fecham').val();
                            num_doc=$('#num_docm').val();
                            var url = "{{ url('Busqueda_Marcaciones_Todo') }}"
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                    'fecha': fecha,
                                    'num_doc': num_doc
                                },
                                success: function(data) {
                                    $('#busqueda_marcaciones').html(data);
                                    $('#ModalUpdate').modal('hide');
                                    Buscar_Reporte_Asistencia();
                                }
                            });


                        }else{
                            $('#ModalUpdate').modal('hide');
                            //BuscarAsistencia();
                            Buscar_Reporte_Asistencia();
                        }

                    });
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    function Delete_Marcacion_Todo(id) {
        Cargando();

        var id = id;
        var url = "{{ url('Delete_Asistencia_Diaria') }}";
        Swal({
            title: '¿Realmente desea eliminar el registro?',
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
                    type: "POST",
                    url: url,
                    data: {
                        'id_asistencia_remota': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            fecha=$('#fecham').val();
                            num_doc=$('#num_docm').val();
                            var url = "{{ url('Busqueda_Marcaciones_Todo') }}"
                            $.ajax({
                                type: "POST",
                                url: url,
                                data: {
                                    'fecha': fecha,
                                    'num_doc': num_doc
                                },
                                success: function(data) {
                                    $('#busqueda_marcaciones').html(data);
                                    Buscar_Reporte_Asistencia();
                                }
                            });
                        });
                    }
                });
            }
        })
    }

    function Reg_asistencia_diaria(t) {
        var dataString = new FormData(document.getElementById('formulario_asistencia_diariareg'));
        var url = "{{ url('Insert_Asistencia_Diaria') }}"
        if (Valida_Reg_asistencia_diaria()) {
            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        swal.fire(
                            'Registro Denegado!',
                            'El registro ya existe o el usuario no fue encontrado!',
                            'error'
                        ).then(function() {
                        });
                    }else{
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            $('#ModalUpdate').modal('hide');
                            if(t==1){
                                Buscar_Reporte_Asistencia();
                            }else{
                                fecha=$('#fecham').val();
                                num_doc=$('#num_docm').val();
                                var url = "{{ url('Busqueda_Marcaciones_Todo') }}"
                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: {
                                        'fecha': fecha,
                                        'num_doc': num_doc
                                    },
                                    success: function(data) {
                                        $('#busqueda_marcaciones').html(data);
                                        Buscar_Reporte_Asistencia();
                                    }
                                });
                            }

                        });
                    }
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }

    restaFechas = function(f1,f2) {
        var aFecha1 = f1.split('-');
        var aFecha2 = f2.split('-');
        var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]);
        var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]);
        var dif = fFecha2 - fFecha1;
        var dias = Math.floor(dif / (1000 * 60 * 60 * 24));
        return parseFloat(dias)+parseFloat(1);
    }

    function Buscar_Reporte_Asistencia() {
        Cargando();
        var cod_mes = $('#cod_mes').val();
        var cod_anio = $('#cod_anio').val();
        var cod_base = $('#cod_base').val();
        var num_doc = $('#num_doc').val();
        var area = $('#id_area').val();
        var id_puesto = $('#id_puesto').val();
        var csrfToken = $('input[name="_token"]').val();
        if(id_puesto == 29){
            var estado=1;
        }else{
            if ($('#estadosi').is(":checked")){
                var estado=1;
            }

            if ($('#estadono').is(":checked")){
                var estado=3;
            }
        }
        if ($('#tipo1').is(":checked")){
            var tipo=1;
        }if ($('#tipo2').is(":checked")){
            var tipo=2;
        }
        var finicio = $('#finicio').val();
        var ffin = $('#ffin').val();


        var url = "{{ url('Buscar_Reporte_Control_Asistencia')}}";
            if(tipo==2){
                var ini = moment(finicio);
                var fin = moment(ffin);

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
                } else {
                    var f1 = finicio;
                    var f2=ffin;
                    if(restaFechas(f1,f2)>31){
                        msgDate = 'Solo se permite busquedas de hasta 31 días';
                        inputFocus = '#hora_salida_hoy';
                        bootbox.alert(msgDate)
                        var input = $(inputFocus).parent();
                        $(input).addClass("has-error");
                        $(input).on("change", function() {
                            if ($(input).hasClass("has-error")) {
                                $(input).removeClass("has-error");
                            }
                        });
                    }else{
                        $.ajax({
                            type: "POST",
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                'cod_mes': cod_mes,
                                'cod_anio': cod_anio,
                                'cod_base': cod_base,
                                'num_doc': num_doc,
                                'area': area,
                                'estado': estado,
                                'tipo': tipo,
                                'finicio': finicio,
                                'ffin': ffin
                            },
                            success: function(data) {
                                $('#lista_colaborador').html(data);
                            }
                        });
                    }


                }
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'cod_mes': cod_mes,
                        'cod_anio': cod_anio,
                        'cod_base': cod_base,
                        'num_doc': num_doc,
                        'area': area,
                        'estado': estado,
                        'tipo': tipo,
                        'finicio': finicio,
                        'ffin': ffin
                    },
                    success: function(data) {
                        $('#lista_colaborador').html(data);
                    }
                });
            }
    }

    function Excel_Reporte_Asistencia() {
        Cargando();
        var cod_mes = $('#cod_mes').val();
        var cod_anio = $('#cod_anio').val();
        var cod_base = $('#cod_base').val();
        var num_doc = $('#num_doc').val();
        var area = $('#id_area').val();
        if ($('#estadosi').is(":checked")){
            var estado=1;
        }if ($('#estadono').is(":checked")){
            var estado=3;
        }
        if ($('#tipo1').is(":checked")){
            var tipo=1;
        }if ($('#tipo2').is(":checked")){
            var tipo=2;
        }
        var finicio = $('#finicio').val();
        var ffin = $('#ffin').val();

        var url = "{{ url('Buscar_Reporte_Control_Asistencia') }}";
        if(tipo==2){
            var ini = moment(finicio);
            var fin = moment(ffin);

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
            } else {
                var f1 = finicio;
                var f2=ffin;
                if(restaFechas(f1,f2)>31){
                    msgDate = 'Solo se permite busquedas de hasta 31 días';
                    inputFocus = '#hora_salida_hoy';
                    bootbox.alert(msgDate)
                    var input = $(inputFocus).parent();
                    $(input).addClass("has-error");
                    $(input).on("change", function() {
                        if ($(input).hasClass("has-error")) {
                            $(input).removeClass("has-error");
                        }
                    });
                }else{
                    window.location = "{{ url('Asistencia/Excel_Reporte_Asistencia')}}/"+cod_mes+"/"+cod_anio+"/"+cod_base+"/"+num_doc+"/"+area+"/"+estado+"/"+tipo+"/"+finicio+"/"+ffin;
                }


            }
        }else{
            window.location = "{{ url('Asistencia/Excel_Reporte_Asistencia')}}/"+cod_mes+"/"+cod_anio+"/"+cod_base+"/"+num_doc+"/"+area+"/"+estado+"/"+tipo+"/"+finicio+"/"+ffin;
        }


    }

    function Modal_Registrar(){
        Cargando();
        var cod_base = $('#cod_base').val();
        var id_area = $('#id_area').val();
        var id_puesto = $('#id_puesto').val();
        
        if(id_puesto == 29){
            var estado = 1;
        }else{
            if ($('#estadosi').is(":checked")){
                var estado = 1;
            }

            if ($('#estadono').is(":checked")){
                var estado = 3;
            }
        }

        var url = "{{ url('Asistencia/Modal_Reg_Asistencia') }}";

        $.ajax({
            type: "GET",
            url: url,
            data: {'cod_base':cod_base,'id_area':id_area,'estado':estado},
            success: function(data) {
                $('#ModalRegistro').modal('show');
            },
        });
    }
    
    function Buscar_No_Marcados() {
        Cargando();
        var cod_mes = $('#cod_mes_nm').val();
        var cod_anio = $('#cod_anio_nm').val();
        var cod_base = $('#cod_base_nm').val();
        var num_doc = $('#num_doc_nm').val();
        var area = $('#id_area_nm').val();
        var id_puesto = $('#id_puesto_nm').val();
        var csrfToken = $('input[name="_token"]').val();
        if(id_puesto == 29){
            var estado=1;
        }else{
            if ($('#estadosi_nm').is(":checked")){
                var estado=1;
            }

            if ($('#estadono_nm').is(":checked")){
                var estado=3;
            }
        }
        if ($('#tipo1_nm').is(":checked")){
            var tipo=1;
        }if ($('#tipo2_nm').is(":checked")){
            var tipo=2;
        }
        var finicio = $('#finicio_nm').val();
        var ffin = $('#ffin_nm').val();

        //console.log(tipo);
        var url = "{{ url('Asistencia/Buscar_No_Marcados')}}";
            if(tipo==2){
                var ini = moment(finicio);
                var fin = moment(ffin);

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
                } else {
                    var f1 = finicio;
                    var f2=ffin;
                    if(restaFechas(f1,f2)>31){
                        msgDate = 'Solo se permite busquedas de hasta 31 días';
                        inputFocus = '#hora_salida_hoy';
                        bootbox.alert(msgDate)
                        var input = $(inputFocus).parent();
                        $(input).addClass("has-error");
                        $(input).on("change", function() {
                            if ($(input).hasClass("has-error")) {
                                $(input).removeClass("has-error");
                            }
                        });
                    }else{
                        $.ajax({
                            type: "POST",
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            },
                            data: {
                                'cod_mes': cod_mes,
                                'cod_anio': cod_anio,
                                'cod_base': cod_base,
                                'num_doc': num_doc,
                                'area': area,
                                'estado': estado,
                                'tipo': tipo,
                                'finicio': finicio,
                                'ffin': ffin
                            },
                            success: function(data) {
                                $('#lista_colaborador_nm').html(data);
                            }
                        });
                    }
                }
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'cod_mes': cod_mes,
                        'cod_anio': cod_anio,
                        'cod_base': cod_base,
                        'num_doc': num_doc,
                        'area': area,
                        'estado': estado,
                        'tipo': tipo,
                        'finicio': finicio,
                        'ffin': ffin
                    },
                    success: function(data) {
                        $('#lista_colaborador_nm').html(data);
                    }
                });
            }
    }
    
    function Traer_Colaborador_nm(){
        Cargando();

        var cod_base = $('#cod_base_nm').val();
        var id_area = $('#id_area_nm').val();
        var id_puesto = $('#id_puesto_nm').val();
        if(id_puesto == 29){
            var estado = 1;
        }else{
            if ($('#estadosi_nm').is(":checked")){
                var estado = 1;
            }

            if ($('#estadono_nm').is(":checked")){
                var estado = 3;
            }
        }
        var url = "{{ url('Asistencia/Traer_Colaborador_Asistencia') }}";

        $.ajax({
            type: "GET",
            url: url,
            data: {'cod_base':cod_base,'id_area':id_area,'estado':estado},
            success: function(data) {
                $('#num_doc_nm').html(data);
            }
        });
    }

    function TipoBusqueda_nm() {
        Cargando();
        var div1 = document.getElementById("cmb_mes_nm");
        var div4 = document.getElementById("cmb_anio_nm");
        var div2 = document.getElementById("cmb_finicio_nm");
        var div3 = document.getElementById("cmb_ffin_nm");

        if ($('#tipo1_nm').is(":checked")){
            div1.style.display = "block";
            div4.style.display = "block";
            div2.style.display = "none";
            div3.style.display = "none";
        }else{
            div1.style.display = "none";
            div4.style.display = "none";
            div2.style.display = "block";
            div3.style.display = "block";
        }
    }
</script>
@endsection
