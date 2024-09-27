@extends('layouts.plantilla')

@section('navbar')
@include('manufactura.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Inicio de Manufactura</h3>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#inicio_manufactura").addClass('active');
        $("#hinicio_manufactura").attr('aria-expanded', 'true');
    });
</script>
@endsection