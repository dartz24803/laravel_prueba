@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                @if (session('usuario')->id_puesto==24 || 
                                session('usuario')->id_puesto==36 || 
                                session('usuario')->id_puesto==29 || 
                                session('usuario')->id_puesto==16 ||
                                session('usuario')->id_puesto==20 || 
                                session('usuario')->id_puesto==26 || 
                                session('usuario')->id_puesto==27 || 
                                session('usuario')->id_puesto==98 ||
                                session('usuario')->id_puesto==31 || 
                                session('usuario')->id_puesto==30 || 
                                session('usuario')->id_nivel==1 || 
                                session('usuario')->id_puesto==161 || 
                                session('usuario')->id_puesto==197 || 
                                session('usuario')->id_puesto==148)
                                    <li class="nav-item">
                                        <a id="a_lec" class="nav-link" onclick="Lectura();" style="cursor: pointer;">Lectora (Asistencia con lectora)</a>
                                    </li>
                                @endif
                                @if (session('usuario')->id_puesto===10 || 
                                session('usuario')->id_nivel==1 || 
                                session('usuario')->id_puesto===23 || 
                                session('usuario')->id_puesto===24 ||
                                session('usuario')->id_puesto===12 || 
                                session('usuario')->id_puesto===13 || 
                                session('usuario')->id_puesto===104 || 
                                session('usuario')->id_puesto===155|| 
                                session('usuario')->id_puesto===134)
                                    <li class="nav-item">
                                        <a id="a_ges" class="nav-link" onclick="Gestion();" style="cursor: pointer;">Manual</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a id="a_ges" class="nav-link" onclick="Gestion();" style="cursor: pointer;">Reporte</a>
                                </li>
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_lectura_servicio" class="widget-content widget-content-area p-3">
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
            $("#seguridades").addClass('active');
            $("#hseguridades").attr('aria-expanded', 'true');
            $("#asistencias_segs").addClass('active');

            @if(session('usuario')->id_puesto==24 || session('usuario')->id_puesto==36 || 
            session('usuario')->id_puesto==29 || session('usuario')->id_puesto==16 ||
            session('usuario')->id_puesto==20 || session('usuario')->id_puesto==26 || 
            session('usuario')->id_puesto==27 || session('usuario')->id_puesto==98 ||
            session('usuario')->id_puesto==31 || session('usuario')->id_puesto==30 || 
            session('usuario')->id_nivel==1 || session('usuario')->id_puesto==161 || 
            session('usuario')->id_puesto==197 || session('usuario')->id_puesto==148)
                Lectura();
            @else
                Gestion()
            @endif
        });
        
        function Lectura(){
            Cargando();

            var url="{{ route('lectura_servicio_reg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_lectura_servicio').html(resp);  
                    $("#a_lec").addClass('active');
                    $("#a_ges").removeClass('active');
                }
            });
        }

        function Gestion(){
            Cargando();

            var url="{{ route('lectura_servicio_ges') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_lectura_servicio').html(resp);  
                    $("#a_lec").removeClass('active');
                    $("#a_ges").addClass('active');
                }
            });
        }
    </script>
@endsection