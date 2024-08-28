@extends('layouts.plantilla_new')

@section('navbar')
    @include('rrhh.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Inicio de Talento Humano</h3>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#rhumanos").addClass('active');
            $("#hrhumanos").attr('aria-expanded', 'true');
        });
    </script>
@endsection