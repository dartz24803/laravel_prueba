@extends('layouts.plantilla')

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
        $("#inicio_comercial").addClass('active');
        $("#hinicio_comercial").attr('aria-expanded', 'true');
    });
</script>
@endsection