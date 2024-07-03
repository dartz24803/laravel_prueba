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
                                        <h2 style="color: #8fa1b7; font-weight: bold">DEPARTAMENTOS</h2>
                                    </div>
                                </div>
                                <div class="container" id="container" style="background-image: url('{{ asset('inicio/NEW.Intranet-Icono-Fondo2.jpg') }}');">
                                    <div class="row layout-top-spacing">
                                        <!-- Logo Logistica-->
                                        <div id="logo_logistica" class="col-md-12">
                                            <div class="zoom-card" style="width: 6rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #fea701;height:6rem">
                                                    <img class="imagen_1"  src="{{ asset('inicio/NEW.Intranet-Icono-Logistica.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Logística</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Comercial-->
                                        <div id="logo_comercial" class="col-md-4 d-flex justify-content-end">
                                            <div class="zoom-card mb-4" style="width: 7rem">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #ff295c; height: 7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Comercial.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Comercial</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Talento Humano-->
                                        <div id="logo_talento_humano" class="col-md-2 d-flex justify-content-center">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00b1f4; height:7rem;">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-TalentoHumano.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Talento Humano</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Infraestructura-->
                                        <div id="logo_infraestructura" class="col-md-3">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00ba8e; height: 7rem;">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Infraestructuras.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Infraestructura</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Interna-->
                                        <div id="logo_interna" class="col-md-3 d-flex justify-content-end">
                                            <div class="zoom-card" style="width: 6rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00ba8e;height:6rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Interna.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Interna</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo central LN1-->
                                        <div id="logo_central" class="col-md-4 zoom-card-2 d-flex justify-content-center">
                                            <div class="card text-center border-0 rounded_z" style="background-color: #00b1f4;">
                                                <div class="card-body text-center">
                                                    <img src="{{ asset('/inicio/logo_ln1.png') }}" alt="La número 1" style="height: 6rem">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Finanzas-->
                                        <div id="logo_finanzas" class="col-md-3 d-flex justify-content-center align-items-end">
                                            <div class="zoom-card" style="width: 6rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00b1f4;height:6rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Finanzas.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Finanzas</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Seguridad y Salud-->
                                        <div id="logo_seguridad" class="col-md-5 d-flex justify-content-end">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00b1f4; height:7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-SeguridadSalud.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Seguridad y Salud</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Caja y Control-->
                                        <div id="logo_caja" class="col-md-2 d-flex justify-content-center">
                                            <div class="zoom-card" style="width: 6rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #fea701; height: 6rem;">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-CajaControlInterno.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Caja y Control Interno</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Manufactura-->
                                        <div id="logo_manufactura" class="col-md-2 d-flex align-items-start">
                                            <div class="zoom-card" style="width: 7rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #00ba8e; height: 7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Manufactura.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Manufactura</p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Logo Tiendas-->
                                        <div id="logo_tiendas" class="col-md-3 d-flex justify-content-start">
                                            <div class="zoom-card" style="width: 7rem; margin-top: 2rem;">
                                                <div class="card text-center border-0 rounded_z d-flex justify-content-center" style="background-color: #ff295c;height: 7rem">
                                                    <img class="imagen_1" src="{{ asset('inicio/NEW.Intranet-Icono-Tiendas.png')}}" alt="">
                                                    <p class="card-text text-center text-white">Tiendas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <img src="{{ asset('/inicio/Estamos-trabajando.png') }}" alt="" style="max-width: 100%;"> -->
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
    #container {
        background-position: center;
        background-repeat: no-repeat;
        background-size: 135rem auto;
    }
    #logo_logistica{
        margin-left: 39.5rem;
        margin-top: 4rem;
        height: 9rem;
    }
    #logo_comercial{
        margin-left: 4rem;
        margin-top: -2rem;
        height: 10rem;
    }
    #logo_talento_humano{
        margin-top: -4rem;
    }
    #logo_infraestructura{
        margin-left: 9rem;
        margin-top: -1rem
    }
    #logo_interna{
        margin-left: 5rem;
    }
    #logo_central{
        margin-top: -1.5rem;
        margin-left: 3rem;
    }
    #logo_finanzas{
        margin-left: -2.5rem;
    }
    #logo_seguridad{
        margin-left: -2rem;
        margin-top: 1rem;
    }
    #logo_caja{
        margin-top: 10rem;
        height: 12rem;
    }
    #logo_manufactura{
        margin-top: 5rem;
        margin-left: -1rem;
    }
    #logo_tiendas{
        margin-top: 1rem
    }
    .imagen_1{
        mix-blend-mode: multiply;
        position: absolute;
        filter: brightness(88%);
    }
    .card-text{
        z-index: 9;
        transition: opacity 0.5s ease; /* Transición para el texto */
    }
    .zoom-card:hover .imagen_1{
        filter: none;
        mix-blend-mode: unset;
    }
    .zoom-card:hover .card-text{
        opacity: 0;
    }
</style>
<script>
    $(document).ready(function() {
        $("#inicio").addClass('active');
        $("#hinicio").attr('aria-expanded','true');
    });
</script>
@endsection
