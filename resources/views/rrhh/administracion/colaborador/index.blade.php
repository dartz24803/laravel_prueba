@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
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
                                    <a id="paginas_web" class="nav-link" onclick="Listar_Paginas_Web();" style="cursor: pointer;">Páginas web</a>
                                </li>
                                <li class="nav-item">
                                    <a id="programas" class="nav-link" onclick="Listar_Programas();" style="cursor: pointer;">Programas</a>
                                </li>
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
        
        function Direccion(){
            Cargando();

            var url="{{ route('colaborador_conf_di') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").addClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }

        function Gerencia(){
            Cargando();

            var url="{{ route('colaborador_conf_ge') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").addClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }

        function Sub_Gerencia(){
            Cargando();

            var url="{{ route('colaborador_conf_sg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").addClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }

        function Area(){
            Cargando();

            var url="{{ route('colaborador_conf_ar') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").addClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                }
            });
        }

        function Nivel_Jerarquico(){
            Cargando();

            var url="{{ route('colaborador_conf_ni') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").addClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }

        function Sede_Laboral(){
            Cargando();

            var url="{{ route('colaborador_conf_se') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").addClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }

        function Competencia(){
            Cargando();

            var url="{{ route('colaborador_conf_co') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").addClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }

        function Puesto(){
            Cargando();

            var url="{{ route('colaborador_conf_pu') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").addClass('active');
                    $("#a_ca").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }

        function Cargo(){
            Cargando();

            var url="{{ route('colaborador_conf_ca') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").addClass('active');
                    $("#datacorp").removeClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                }
            });
        }
        
        function Index_Datacorp(){
            Cargando();

            var url="{{ url('Index_Datacorp') }}";

            $.ajax({
                url: url,
                type:"GET",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#datacorp").addClass('active');
                    $("#paginas_web").removeClass('active');
                    $("#programas").removeClass('active');
                    $("#a_di").removeClass('active');
                    $("#a_ge").removeClass('active');
                    $("#a_de").removeClass('active');
                    $("#a_ar").removeClass('active');
                    $("#a_ni").removeClass('active');
                    $("#a_se").removeClass('active');
                    $("#a_co").removeClass('active');
                    $("#a_pu").removeClass('active');
                    $("#a_ca").removeClass('active');
                }
            });
        }

        function Listar_Paginas_Web(){
            Cargando();

            var url="{{ url('Listar_Paginas_Web') }}";

            $.ajax({
                url: url,
                type:"POST",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#paginas_web").addClass('active');
                    $("#datacorp").removeClass('active');
                    $("#programas").removeClass('active');
                    $("#a_dir").removeClass('active')
                    $("#a_ger").removeClass('active');
                    $("#a_dep").removeClass('active');
                    $("#a_are").removeClass('active');
                    $("#a_pue").removeClass('active');
                    $("#a_car").removeClass('active');
                }
            });
        }
        
        function Listar_Programas(){
            Cargando();

            var url="{{ url('Listar_Programas') }}";

            $.ajax({
                url: url,
                type:"POST",
                success:function (resp) {
                    $('#div_colaborador_conf').html(resp);  
                    $("#paginas_web").removeClass('active');
                    $("#datacorp").removeClass('active');
                    $("#programas").addClass('active');
                    $("#a_dir").removeClass('active')
                    $("#a_ger").removeClass('active');
                    $("#a_dep").removeClass('active');
                    $("#a_are").removeClass('active');
                    $("#a_pue").removeClass('active');
                    $("#a_car").removeClass('active');
                }
            });
        }

    </script>
@endsection