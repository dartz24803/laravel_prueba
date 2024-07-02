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
                                <div class="container">
                                    <div class="row layout-top-spacing">
                                        <!-- Logo Logistica-->
                                        <div class="col-md-12 mb-4 offset-md-6">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #fea701;">
                                                    <div class="card-body text-center">
                                                        <img src="" alt="">
                                                    </div>
                                                    <p class="card-text text-center text-white">Logística</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Comercial-->
                                        <div class="col-md-3 d-flex justify-content-end mb-1" style="margin-left: 2rem;">
                                            <div class="zoom-card mb-4" style="width: 8rem">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #ff295c; height: 8rem">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                                    </div>
                                                    <p class="card-text text-center text-white">Comercial</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Talento Humano-->
                                        <div class="col-md-3 d-flex justify-content-center">
                                            <div class="zoom-card" style="width: 8rem; margin-top: -4rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00b1f4; height:8rem;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                                    </div>
                                                    <p class="card-text text-center text-white">Talento Humano</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Infraestructura-->
                                        <div class="col-md-3 offset-md-2">
                                            <div class="zoom-card" style="width: 8rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00ba8e; height: 7rem;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                                    </div>
                                                    <p class="card-text text-center text-white">Infraestructura</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Interna-->
                                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00ba8e;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                                    </div>
                                                    <p class="card-text text-center text-white">Interna</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo central LN1-->
                                        <div class="col-md-6 zoom-card-2 d-flex justify-content-center">
                                            <div class="card text-center border-0 rounded_z" style="background-color: #00b1f4;">
                                                <div class="card-body text-center">
                                                    <img src="{{ asset('/inicio/logo_ln1.png') }}" alt="La número 1" style="width: 20rem; height: 6rem">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Finanzas-->
                                        <div class="col-md-3 d-flex justify-content-center align-items-end">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00b1f4;">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                                        <p class="card-text text-center text-white">Finanzas</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Seguridad y Salud-->
                                        <div class="col-md-3 mt-4 d-flex justify-content-end">
                                            <div class="zoom-card" style="width: 10rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00b1f4; height:10rem">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-package"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                                        <p class="card-text text-center text-white">Seguridad y Salud</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Caja y Control-->
                                        <div class="col-md-3 d-flex justify-content-center">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #fea701; height: 7rem; margin-top: 11rem">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slack"><path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"></path><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"></path><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"></path><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"></path><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"></path><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"></path><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"></path></svg>
                                                        <p class="card-text text-center text-white">Caja y Control Interno</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Manufactura-->
                                        <div class="col-md-2 d-flex align-items-center">
                                            <div class="zoom-card" style="width: 10rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #00ba8e; height: 10rem">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                                    </div>
                                                    <p class="card-text text-center text-white">Manufactura</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Tiendas-->
                                        <div class="col-md-3 d-flex justify-content-center">
                                            <div class="zoom-card" style="width: 8rem; margin-top: 2rem;">
                                                <div class="card text-center border-0 rounded_z" style="background-color: #ff295c;height: 8rem">
                                                    <div class="card-body text-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 24 24" fill="none" stroke="#8ca1b5" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slack"><path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"></path><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"></path><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"></path><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"></path><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"></path><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"></path><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"></path><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"></path></svg>
                                                    </div>
                                                    <p class="card-text text-center text-white">Tiendas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <img src="{{ asset('/inicio/Estamos-trabajando.png') }}" alt=""> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .icon i{
            color: #00b1f4;
            font-size: 25px;
        }
        @media screen and (min-width: 2000px) {
            .footer{
                margin-top: 5%;
            }
        }
    </style>
    
    <div class="layout-px-spacing footer">
        <div class="row">
            <div class="col-lg-6">
                <div class="icon d-flex align-items-center py-1 py-lg-0">
                    <i class="bx bxs-navigation"></i>
                    <a href="https://www.lanumero1.com.pe" target="_blank">www.lanumero1.com.pe</a>
                </div>
            </div>
    
            <div class="col-lg-6 d-block d-sm-flex justify-content-lg-end">
                <div class="icon d-flex align-items-center py-1 py-lg-0">
                    <i class="bx bxl-facebook-square"></i>
                    <a href="https://www.facebook.com/Lanumero1.peru" target="_blank">Lanumero1.peru</a>
                </div>
    
                <div class="icon d-flex align-items-center py-1 py-lg-0 px-sm-3">
                    <i class="bx bxl-instagram"></i>
                    <a href="https://www.instagram.com/lanumero1moda" target="_blank">lanumero1moda</a>
                </div>
    
                <div class="icon d-flex align-items-center py-1 py-lg-0">
                    <i class="bx bxl-tiktok"></i>
                    <a href="https://www.tiktok.com/@lanumero1.peru" target="_blank">lanumero1.peru</a>
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
        transform: scale(1.1); /* Efecto de zoom */
        cursor: pointer;
    }

    img{
        max-width: 100%;
    }
    
    .zoom-card-2 {
        transition: transform 1s; /* Animación de transición suave */
    }
    .zoom-card-2:hover {
        transform: scale(1.05); /* Efecto de zoom */
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
