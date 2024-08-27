@extends('layouts.plantilla_new')

@section('navbar')
    @include('comercial.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte de Comercial </h3>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#marketing").addClass('active');
        $("#hmarketing").attr('aria-expanded','true');
    });
</script>
@endsection