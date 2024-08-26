@extends('layouts.plantilla')

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte de seguridad </h3>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#conf_seguridades").addClass('active');
        $("#hconf_seguridades").attr('aria-expanded', 'true');
    });
</script>
@endsection
