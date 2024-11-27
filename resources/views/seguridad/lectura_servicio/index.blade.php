@extends('layouts.plantilla')

@section('navbar')
    @include('seguridad.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area simple-tab">
                            <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                                @if (session('usuario')->id_nivel==1 || 
                                session('usuario')->id_puesto==24 || 
                                session('usuario')->id_puesto==27 || 
                                session('usuario')->id_puesto==30 || 
                                session('usuario')->id_puesto==31 || 
                                session('usuario')->id_puesto==36 || 
                                session('usuario')->id_puesto==148 || 
                                session('usuario')->id_puesto==161)
                                    <li class="nav-item">
                                        <a id="a_lec" class="nav-link" onclick="Lectura();" style="cursor: pointer;">Lectura</a>
                                    </li>
                                @endif
                                @if (session('usuario')->id_nivel==1 || 
                                session('usuario')->id_puesto===10 || 
                                session('usuario')->id_puesto===12 || 
                                session('usuario')->id_puesto===13 ||                                 
                                session('usuario')->id_puesto===23 || 
                                session('usuario')->id_puesto===24 ||
                                session('usuario')->id_puesto===155 || 
                                session('usuario')->id_puesto==158 || 
                                session('usuario')->id_puesto==209)
                                    <li class="nav-item">
                                        <a id="a_ges" class="nav-link" onclick="Gestion();" style="cursor: pointer;">Gestión</a>
                                    </li>
                                @endif
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
            $("#lecturas_servicios").addClass('active');

            @if(session('usuario')->id_nivel==1 || 
            session('usuario')->id_puesto==24 || 
            session('usuario')->id_puesto==27 || 
            session('usuario')->id_puesto==30 || 
            session('usuario')->id_puesto==31 || 
            session('usuario')->id_puesto==36 || 
            session('usuario')->id_puesto==148 || 
            session('usuario')->id_puesto==161)
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