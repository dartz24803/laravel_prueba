@extends('layouts.plantilla')

@section('navbar')
    @include('interna.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a id="a_ser" class="nav-link" style="cursor: pointer;">Puesto Areas</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_pser" class="nav-link" style="cursor: pointer;">Sugerencias</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_ocurrencias_conf" class="widget-content widget-content-area p-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#procesosconf").addClass('active');
        $("#procesosconf").attr('aria-expanded', 'true');
        $("#portalprocesosconf").addClass('active');

        GestionOcurrencias();
    });
</script>
@endsection