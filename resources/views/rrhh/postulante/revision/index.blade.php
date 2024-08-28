@extends('layouts.plantilla_new')

@section('navbar')
    @include('rrhh.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Postulantes en Revisión</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        @csrf
                        <div class="table-responsive mt-4" id="lista_revision">
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

            Lista_Revision();
        });

        function Lista_Revision(){
            Cargando();

            var url = "{{ route('postulante_revision.list') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success:function (resp) {
                    $('#lista_revision').html(resp);  
                }
            });
        }
    </script>
@endsection