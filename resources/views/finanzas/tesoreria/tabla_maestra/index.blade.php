@extends('layouts.plantilla')

@section('navbar')
    @include('finanzas.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Tabla maestra</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="table-responsive" id="lista_maestra">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#tesorerias").addClass('active');
            $("#htesorerias").attr('aria-expanded', 'true');
            $("#tablas_maestras").addClass('active');

            Lista_Maestra();
        });

        function Lista_Maestra(){
            Cargando();

            var url = "{{ route('tabla_maestra_tesoreria.list') }}";

            $.ajax({
                url: url,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#lista_maestra').html(resp);
                }
            });
        }
    </script>
@endsection