@extends('layouts.plantilla')

@section('navbar')
    @include('caja.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Salida de Insumo</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="row mt-4">
                            <div class="col-lg-6">
                                <div class="table-responsive mb-4" id="lista_izquierda">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="toolbar d-flex">
                                    <div class="col-lg-12 d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('salida_insumo.create') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                            Registrar
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive mb-4" id="lista_derecha">
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
            $("#cajas").addClass('active');
            $("#hcajas").attr('aria-expanded', 'true');
            $("#salidas_insumos").addClass('active');

            Lista_Izquierda();
            Lista_Derecha();
        });
    
        function Lista_Izquierda(){
            Cargando();
    
            var url = "{{ route('salida_insumo.list_izquierda') }}";
    
            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) { 
                    $('#lista_izquierda').html(resp);  
                }
            });
        }
        
        function Lista_Derecha(){
            Cargando();
    
            var url = "{{ route('salida_insumo.list_derecha') }}";
    
            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#lista_derecha').html(resp);  
                }
            });
        }
    
        function solo_Numeros(e) {
            var key = event.which || event.keyCode;
            if (key >= 48 && key <= 57) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection