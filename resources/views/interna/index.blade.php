@extends('layouts.plantilla_sinsoporte')

@section('navbar')
    @include('interna.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Inicio de Interna</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#inicio_interna").addClass('active');
            $("#hinicio_interna").attr('aria-expanded', 'true');
        });
    </script>
@endsection
