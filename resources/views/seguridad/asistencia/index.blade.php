@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                @if (session('usuario')->id_puesto!=21 && 
                                session('usuario')->id_puesto!=279 && 
                                session('usuario')->id_puesto!=209)
                                    <li class="nav-item">
                                        <a id="a_lec" class="nav-link" onclick="Lectora();" style="cursor: pointer;">Lectora (Asistencia con lectora)</a>
                                    </li>
                                @endif
                                @if (session('usuario')->id_puesto==21 || 
                                session('usuario')->id_puesto==279 || 
                                session('usuario')->id_puesto==23 || 
                                session('usuario')->id_puesto==24 || 
                                session('usuario')->id_puesto==36 || 
                                session('usuario')->id_nivel==1 || 
                                session('usuario')->id_puesto==19 || 
                                session('usuario')->id_puesto==22 || 
                                session('usuario')->id_puesto==209)
                                    <li class="nav-item">
                                        <a id="a_man" class="nav-link" onclick="Manual();" style="cursor: pointer;">Manual</a>
                                    </li>
                                @endif
                                @if (session('usuario')->id_puesto==23 || 
                                session('usuario')->id_puesto==19 || 
                                session('usuario')->id_nivel==1)
                                    <li class="nav-item">
                                        <a id="a_rep" class="nav-link" onclick="Reporte();" style="cursor: pointer;">Reporte</a>
                                    </li>
                                @endif
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_asistencia" class="widget-content widget-content-area p-3">
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

            @if(session('usuario')->id_puesto!=21 && 
            session('usuario')->id_puesto!=279 && 
            session('usuario')->id_puesto!=209)
                Lectora();
            @else
                Manual()
            @endif
        });
        
        function Lectora(){
            Cargando();

            var url="{{ route('asistencia_seg_lec') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_asistencia').html(resp);  
                    $("#a_lec").addClass('active');
                    $("#a_man").removeClass('active');
                    $("#a_rep").removeClass('active');
                }
            });
        }

        function Manual(){ 
            Cargando();

            var url="{{ route('asistencia_seg_man') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_asistencia').html(resp);  
                    $("#a_lec").removeClass('active');
                    $("#a_man").addClass('active');
                    $("#a_rep").removeClass('active');
                }
            });
        }

        function Reporte(){
            Cargando();

            var url="{{ route('lectura_servicio_ges') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_asistencia').html(resp);  
                    $("#a_lec").removeClass('active');
                    $("#a_man").removeClass('active');
                    $("#a_rep").addClass('active');
                }
            });
        }
    </script>
@endsection