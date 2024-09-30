@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Stock Actual INFOSAP
                </h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-2">
                    <div class="toolbar d-flex p-4">

                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_reproceso">
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
        $("#infosapstock").addClass('active');

        Lista_Maestra();
    });

    function Lista_Maestra() {
        Cargando();

        var url = "{{ route('infosapstock.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#lista_reproceso').html(resp);
            }
        });
    }
</script>

@endsection