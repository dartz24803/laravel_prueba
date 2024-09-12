@extends('layouts.plantilla')

@section('navbar')
@include('interna.navbar')
@endsection

@section('content')

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header row">
            <div class="page-title col-12 col-sm-9">
                <h3>Administrar Slider Inicio</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    @csrf
                    <div id="lista_slider_inicio" class="table-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#slider_menu").addClass('active');
        $("#inicio_slider").attr('aria-expanded', 'true');
        $("#slider_inicio").addClass('active');

        Slider_Inicio_Listar();
    });

    function Slider_Inicio_Listar() {
        Cargando();

        var url = "{{ url('Inicio/Slider_Inicio_Listar') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#lista_slider_inicio').html(resp);
            }
        });
    }
</script>

@endsection