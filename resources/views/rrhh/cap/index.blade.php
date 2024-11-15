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
                                <li class="nav-item">
                                    <a id="a_reg" class="nav-link" onclick="Registro();" style="cursor: pointer;">Registro CAP</a>
                                </li>
                                @if (session('usuario')->id_nivel == 1 ||
                                session('usuario')->id_puesto == 21 ||
                                session('usuario')->id_puesto == 22 ||
                                session('usuario')->id_puesto == 27 ||
                                session('usuario')->id_puesto == 128 ||
                                session('usuario')->id_puesto == 148 ||
                                session('usuario')->id_puesto == 157 ||
                                session('usuario')->id_puesto == 158 ||
                                session('usuario')->id_puesto == 209 ||
                                session('usuario')->id_puesto == 277 ||
                                session('usuario')->id_puesto == 310)
                                    <li class="nav-item">
                                        <a id="a_ges" class="nav-link" onclick="Gestion();" style="cursor: pointer;">Gestión Registro CAP</a>
                                    </li>
                                @endif
                            </ul>

                            <div class="row" id="cancel-row">
                                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                    <div id="div_cap" class="widget-content widget-content-area p-3">
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
            $("#hrhumanos").attr('aria-expanded', 'true');
            $("#caps").addClass('active');

            Registro();
        });
        
        function Registro(){
            Cargando();

            var url="{{ route('cap_reg') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#div_cap').html(resp);  
                    $("#a_reg").addClass('active');
                    $("#a_ges").removeClass('active');
                }
            });
        }

        function Gestion(){
            Cargando();

            var url="{{ route('cap_ges') }}";

            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#div_cap').html(resp);  
                    $("#a_reg").removeClass('active');
                    $("#a_ges").addClass('active');
                }
            });
        }

        function Detalle_Gestion(id){
            Cargando();

            var mes = $('#mesb').val();
            var anio = $('#aniob').val();
            var url = "{{ route('cap_ges.detalle', ':id') }}".replace(':id', id);

            $.ajax({
                url: url,
                type: "POST",
                data: {'mes':mes,'anio':anio},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#div_cap').html(resp);
                }
            });
        }

        function Regresar_Gestion(mes,anio){
            Cargando();
            
            var url = "{{ route('cap_ges') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {'mes':mes,'anio':anio},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#div_cap').html(resp);
                }
            });
        }
    </script>
@endsection