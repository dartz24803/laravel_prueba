@extends('layouts.plantilla')

@section('navbar')
@include('rrhh.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                            <div class="d-flex align-items-center overflow-auto py-1" id="scroll_tabs">
                                <li class="nav-item">
                                    <a id="a_di" class="nav-link" onclick="Direccion();" style="cursor: pointer;">Dirección</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ge" class="nav-link" onclick="Gerencia();" style="cursor: pointer;">Gerencia</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_de" class="nav-link" onclick="Sub_Gerencia();" style="cursor: pointer;">Departamento</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ar" class="nav-link" onclick="Area();" style="cursor: pointer;">Área</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ubi" class="nav-link" onclick="Ubicacion();" style="cursor: pointer;">Ubicación</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ni" class="nav-link" onclick="Nivel_Jerarquico();" style="cursor: pointer;">Nivel Jerárquico</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_se" class="nav-link" onclick="Sede_Laboral();" style="cursor: pointer;">Sede Laboral</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_co" class="nav-link" onclick="Competencia();" style="cursor: pointer;">Competencia</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_pu" class="nav-link" onclick="Puesto();" style="cursor: pointer;">Puesto</a>
                                </li>
                                <li class="nav-item">
                                    <a id="a_ca" class="nav-link" onclick="Cargo();" style="cursor: pointer;">Cargo</a>
                                </li>
                                <li class="nav-item">
                                    <a id="datacorp" class="nav-link" onclick="Index_Datacorp();" style="cursor: pointer;">Datacorp</a>
                                </li>
                                <li class="nav-item">
                                    <a id="paginas_web" class="nav-link" onclick="Index_Paginas_Web();" style="cursor: pointer;">Páginas web</a>
                                </li>
                                <li class="nav-item">
                                    <a id="programas" class="nav-link" onclick="Index_Programas();" style="cursor: pointer;">Programas</a>
                                </li>
                                <?php if (session('usuario')->id_nivel == 1 || session('usuario')->id_nivel == 2) { ?>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="EstadoCivil" onclick="TablaEstadoCivil()">Estado Civil</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="Idioma" onclick="TablaIdiomas()">Idiomas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="Nacionalidad" onclick="TablaNacionalidad()">Nacionalidad</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="Parentesco" onclick="TablaParentesco()">Parentesco</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="Referencia" onclick="TablaReferencia()">Referencia Laboral</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="Regimen" onclick="TablaRegimen()">Régimen Laboral</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="Situacion" onclick="TablaSituacion()">Situacion Laboral</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="TipoContrato" onclick="TablaTipoContrato()">Tipo de Contrato</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="TipoDocumento" onclick="TablaTipoDocumento()">Tipo de Documento</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="TipoSangre" onclick="TablaTipoSangre()">Tipo de Sangre</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="TipoVia" onclick="TablaTipoVia()">Tipo de Via</a>
                                    </li>
                                    <li class="nav-item">
                                        <a style="cursor: pointer;" class="nav-link" id="TipoVivienda" onclick="TablaTipoVivienda()">Tipo de Vivienda</a>
                                    </li>
                                    {{-- empresas(administracion finanzas), --}}
                                <?php } ?>
                            </div>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_colaborador_conf" class="widget-content widget-content-area p-3">
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
        $("#conf_rrhhs").addClass('active');
        $("#hconf_rrhhs").attr('aria-expanded', 'true');
        $("#conf_colaboradores").addClass('active');

        Direccion();
    });


    //-------------------------------TABLAS MAESTRAS REGISTRO COLABORADORES---------------------
    function Active_Tabla_Colaboradores() {
        $("#TipoVia").removeClass('active');
        $("#TipoSangre").removeClass('active');
        $("#TipoDocumento").removeClass('active');
        $("#TipoContrato").removeClass('active');
        $("#Situacion").removeClass('active');
        $("#Regimen").removeClass('active');
        $("#Referencia").removeClass('active');
        $("#Parentesco").removeClass('active');
        $("#Nacionalidad").removeClass('active');
        $("#EstadoCivil").removeClass('active');
        $("#Idioma").removeClass('active');
        $("#paginas_web").removeClass('active');
        $("#datacorp").removeClass('active');
        $("#programas").removeClass('active');
        $("#a_di").removeClass('active');
        $("#a_ge").removeClass('active');
        $("#a_de").removeClass('active');
        $("#a_ar").removeClass('active');
        $("#a_ubi").removeClass('active');
        $("#a_ni").removeClass('active');
        $("#a_se").removeClass('active');
        $("#a_co").removeClass('active');
        $("#a_pu").removeClass('active');
        $("#a_ca").removeClass('active');
    }

    function Direccion() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_di') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_di").addClass('active');
            }
        });
    }

    function Gerencia() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_ge') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_ge").addClass('active');
            }
        });
    }

    function Sub_Gerencia() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_sg') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_de").addClass('active');
            }
        });
    }

    function Area() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_ar') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_ar").addClass('active');
            }
        });
    }

    function Ubicacion() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_ubi') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_ubi").addClass('active');
            }
        });
    }

    function Nivel_Jerarquico() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_ni') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_ni").addClass('active');
            }
        });
    }

    function Sede_Laboral() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_se') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_se").addClass('active');
            }
        });
    }

    function Competencia() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_co') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_co").addClass('active');
            }
        });
    }

    function Puesto() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_pu') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_pu").addClass('active');
            }
        });
    }

    function Cargo() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ route('colaborador_conf_ca') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#a_ca").addClass('active');
            }
        });
    }

    function Index_Datacorp() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ url('Index_Datacorp') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#datacorp").addClass('active');
            }
        });
    }

    function Index_Paginas_Web() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ url('Index_Paginas_Web') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#paginas_web").addClass('active');
            }
        });
    }

    function Index_Programas() {
        Cargando();

        Active_Tabla_Colaboradores();
        var url = "{{ url('Index_Programas') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
                $("#programas").addClass('active');
            }
        });
    }
    //-----------------------------------------------------ESTADO CIVIL-----------------------------------------------
    function TablaEstadoCivil() {
        Cargando();
        Active_Tabla_Colaboradores();
        $("#EstadoCivil").addClass('active');

        var url = "{{ url('ColaboradorConfController/Estado_Civil') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });
    }

    function TablaIdiomas() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#Idioma").addClass('active');

        var url = "{{ url('ColaboradorConfController/Idioma') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });
    }

    function TablaNacionalidad() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#Nacionalidad").addClass('active');

        var url = "{{ url('ColaboradorConfController/Nacionalidad') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });
    }

    function TablaParentesco() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#Parentesco").addClass('active');
        var csrfToken = $('input[name="_token"]').val();
        var url = "{{ url('ColaboradorConfController/Parentesco') }}";

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp)
            }
        });
    }

    function TablaReferencia() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#Referencia").addClass('active');
        var url = "{{ url('ColaboradorConfController/Referencia_Laboral') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });

    }

    function TablaRegimen() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#Regimen").addClass('active');

        var url = "{{ url('ColaboradorConfController/Regimen') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });
    }

    function TablaSituacion() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#Situacion").addClass('active');
        var csrfToken = $('input[name="_token"]').val();

        var url = "{{ url('ColaboradorConfController/Situacion_Laboral') }}";

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },

            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });
    }

    function TablaTipoContrato() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#TipoContrato").addClass('active')
        var url = "{{ url('ColaboradorConfController/Tipo_Contrato') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });

    }

    function TablaTipoDocumento() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#TipoDocumento").addClass('active');

        var url = "{{ url('ColaboradorConfController/Tipo_Documento') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },

            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });
    }

    function TablaTipoSangre() {
        Cargando();
        Active_Tabla_Colaboradores();

        $("#TipoSangre").addClass('active');
        var csrfToken = $('input[name="_token"]').val();

        var url = "{{ url('ColaboradorConfController/Grupo_Sanguineo') }}";
        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#div_colaborador_conf').html(resp);
            }
        });
    }
    /*-------------------------------------Paolo*/
        function TablaTipoVia() {
            Cargando();
            Active_Tabla_Colaboradores();

            $("#TipoVia").addClass('active');
            var csrfToken = $('input[name="_token"]').val();

            var url = "{{ url('ColaboradorConfController/Tipo_Via') }}";
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(resp) {
                    $('#div_colaborador_conf').html(resp);
                }
            });
        }
/*
        function TablaTipoVivienda() {
            Cargando();
            Active_Tabla_Colaboradores();

            $("#TipoVivienda").addClass('active');

            var url = "<?php // echo url();
                        ?>Corporacion/Tipo_Vivienda";
            $.ajax({
                type: "POST",
                url: url,
                success: function(resp) {
                    $('#lista_escogida').html(resp);
                    //$("#ModalRegistro .close").click()
                    $('#TipoVivienda').parents().parents().parents().parents().find('.textocambio').text('Tipo de Vivienda');
                }
            });
        }
        --------------------------------------------Paolo-----------------------------------------------*/
</script>
@endsection
