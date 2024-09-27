@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Inicio de Logística</h3>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#inicio_logistica").addClass('active');
        $("#hinicio_logistica").attr('aria-expanded', 'true');
    });
</script>
@endsection