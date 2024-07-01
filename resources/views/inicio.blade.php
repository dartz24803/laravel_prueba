@extends('layouts.plantilla')

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab" style="background-color: #f0f3f3;">
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div class="page-header d-flex justify-content-center">
                                    <div class="page-title">
                                        <h3 style="color: #8fa1b7; font-weight: bold">DEPARTAMENTOS</h3>
                                    </div>
                                </div>
                                <!-- <div class="container">
                                    <div class="row layout-top-spacing">
                                        <div class="col-md-3">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #ff295c;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                                    </div>
                                                </div>
                                                <p class="card-text text-center text-dark mt-1">Tiendas</p>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00b1f4;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                                    </div>
                                                </div>
                                                <p class="card-text text-center text-dark mt-1">Comercial</p>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #fea701;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                                    </div>
                                                </div>
                                                <p class="card-text text-center text-dark mt-1">Seguridad y Salud</p>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00ba8e;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                                    </div>
                                                </div>
                                                <p class="card-text text-center text-dark mt-1">Caja y Control interno</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <img src="{{ asset('/inicio/Estamos-trabajando.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .rounded_z{
        border-radius: 1.1rem;
    }

    .zoom-card {
        transition: transform 0.5s; /* Animación de transición suave */
    }
    .zoom-card:hover {
        transform: scale(1.25); /* Efecto de zoom */
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function() {
        $("#inicio").addClass('active');
        $("#hinicio").attr('aria-expanded','true');
    });
</script>
@endsection
