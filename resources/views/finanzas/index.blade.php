@extends('layouts.plantilla')

@section('navbar')
    @include('finanzas.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Inicio de Finanzas</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#tesorerias").addClass('active');
            $("#tesorerias").attr('aria-expanded', 'true');
        });
    </script>
@endsection