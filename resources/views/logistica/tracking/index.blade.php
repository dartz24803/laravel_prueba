@extends('layouts.plantilla')

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Tracking</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar d-flex mt-3">
                            <div class="col-lg-12 d-flex justify-content-end">
                                <!--<button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('tracking.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Registrar
                                </button>-->
                                <!--<a title="Actualizar" class="btn btn-dark" onclick="Iniciar_Tracking();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <polyline points="1 20 1 14 7 14"></polyline>
                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                                    </svg>
                                </a>-->
                            </div>
                        </div>

                        @csrf
                        <div class="table-responsive mt-4" id="lista_tracking">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#logisticas").addClass('active');
            $("#hlogisticas").attr('aria-expanded', 'true');
            $("#trackings").addClass('active');

            Lista_Tracking();
            //Iniciar_Tracking();
        });

        function Iniciar_Tracking(){
            Cargando();

            var url = "{{ route('tracking.iniciar_tracking') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success:function (resp) {
                    Lista_Tracking();
                }
            });
        }

        function Lista_Tracking(){
            Cargando();

            var url = "{{ route('tracking.list') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success:function (resp) {
                    $('#lista_tracking').html(resp);  
                }
            });
        }

        function soloNumeros(e) {
            var key = e.keyCode || e.which,
            tecla = String.fromCharCode(key).toLowerCase(),
            letras = "0123456789",
            especiales = [8, 37, 39, 46],
            tecla_especial = false;

            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }
        }
    </script>
@endsection