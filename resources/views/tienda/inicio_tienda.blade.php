@extends('layouts.plantilla')

@section('navbar')
@include('tienda.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte de tienda </h3>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#inicio").addClass('active');
        $("#hinicio").attr('aria-expanded', 'true');
    });
</script>
@endsection