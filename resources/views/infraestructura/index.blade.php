@extends('layouts.plantilla_sinsoporte')

@section('navbar')
@include('infraestructura.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Inicio de Infraestructura</h3>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#inicio_infraestructura").addClass('active');
        $("#hinicio_infraestructura").attr('aria-expanded', 'true');
    });
</script>
@endsection