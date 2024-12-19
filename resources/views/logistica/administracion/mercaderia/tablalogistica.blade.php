@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')

<?php $id_nivel = session('usuario')->id_nivel;
$id_cargo = session('usuario')->id_cargo;
$id_puesto = session('usuario')->id_puesto; ?>

<style>
    @media (min-width:1200px) {
        .col-xl-9 {
        -ms-flex: 0 0 75%;
        flex: 1 0 92%;
        max-width: 89.9%;
        }
        .responsivenavsection{
            display:none!important;
        }
    }

    @media (max-width: 1199px){
        .col-lg-9 {
            -ms-flex: 0 0 75%;
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    @media (min-width:1200px) {
        html{
            --scrollbarBG: #CFD8DC;
            --thumbBG: #90A4AE;
        }
        .sidenav {
            position: fixed;
            right: -30px;
            top: 125px;
            width: 160px;
            height: 100%;
            border-left: 1px solid #e0e6ed;
            overflow-y: scroll;
            overflow-x: none;
            /*Estilos estándar experimentales (Principalmente Firefox)*/
            scrollbar-width: thin;
            scrollbar-color: var(--thumbBG) var(--scrollbarBG);
        }
        .sidenav .sidenav-content::-webkit-scrollbar {
            -webkit-appearance: none;
        }
        .sidenav .sidenav-content::-webkit-scrollbar:vertical {
            width:10px;
        }
        .sidenav .sidenav-content::-webkit-scrollbar-button:increment,.sidenav .sidenav-content::-webkit-scrollbar-button {
            display: none;
        } 
        .sidenav .sidenav-content::-webkit-scrollbar:horizontal {
            height: 10px;
        }
        .sidenav .sidenav-content::-webkit-scrollbar-thumb {
            background-color: var(--thumbBG) ;
            border-radius: 6px;
            border: 3px solid var(--scrollbarBG);
        }
        .sidenav .sidenav-content::-webkit-scrollbar-track {
            background: var(--scrollbarBG);
        }
        .sidenav .sidenav-content {
            scrollbar-width: thin;
            scrollbar-color: var(--thumbBG) var(--scrollbarBG);
            height: 80%;
            /*overflow-y: scroll;*/
            overflow-x: none;
        }
    }

    @media (max-width: 1199px){

        .responsivenavsection{
            display:inline;
        }
        /*
        .responsivenavsectioncontent{
            margin-bottom: 10px;
        }
        */
        .responsivenavsectioncontent {
            margin-bottom: -18px;
            margin-top: 7px;
            margin-left: 3px;
        }

        .sidenav .sidenav-content {
            scrollbar-width: thin;
            scrollbar-color: var(--thumbBG) var(--scrollbarBG);
            height: 5%;
            overflow-x: scroll;
        }
        .sidenav .sidenav-content {
            background-color: transparent;
            display: -webkit-box;
            border: none;
            flex-direction: row;
        }
        .sidenav {
            position: inherit;
            left: 0;
            top: 90px;
            width: 100%;
            height: 60%;
            border: 1px solid #e0e6ed;
            overflow-x: scroll;
            scrollbar-width: thin;
            scrollbar-color: var(--thumbBG) var(--scrollbarBG);
        }
        .sidenav .sidenav-content a:hover {
            color: #1b55e2;
            font-weight: 700;
            border: 1px solid #5c1ac3;
        }
        .sidenav .sidenav-content a {
            display: block;
            color: #3b3f5c;
            font-size: 12px;
            padding: 0px 10px 10px 10px;
        }
        .sidenav .sidenav-content a.active {
            color: #5c1ac3;
            font-weight: 700;
            border: 1px solid #5c1ac3;
        }
    }

    @media (max-width:1198px) {
            .col-lg-10 {
            -ms-flex: 0 0 83.333333%!important;
            flex: 0 0 99.333%!important;
            max-width: 99.333%!important;
        }
    }


</style>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area simple-tab">
                    <ul class="nav nav-tabs mt-4 ml-2" id="simpletab" role="tablist">
                        <div class="d-flex align-items-center overflow-auto py-1" id="scroll_tabs">
                            <?php if($id_nivel==1 || $id_puesto==131 || $id_puesto==74){ ?> 
                                <a class="nav-link active" style="cursor: pointer;" id="Perchaar" onclick="TablaPercha()">Percha</a>
                                <a class="nav-link " style="cursor: pointer;" id="Nichoar" onclick="TablaNicho()">Nicho</a>
                            <?php } ?>
                        </div>
                    </ul>

                    <div class="row" id="cancel-row">
                        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                            <div id="lista_escogida" class="widget-content widget-content-area p-3">
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
        $("#logisticaconf").addClass('active');
        $("#rlogisticaconf").attr('aria-expanded','true');
        $("#mercaderiaconf").addClass('active');
        
        TablaPercha();   
    });

    function TablaPercha() {
        Cargando();

        $(".nav-link").removeClass('active');
        $("#Perchaar").addClass('active');

        var url = "{{ url('MercaderiaConf/Percha') }}";
        $.ajax({
            type: "GET",
            url: url,
            success: function(resp) {
                $('#lista_escogida').html(resp);
            }
        });
    }
    
    function TablaNicho() {
        Cargando();

        $(".nav-link").removeClass('active');
        $("#Nichoar").addClass('active');

        var url = "{{ url('MercaderiaConf/Nicho') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "GET",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#lista_escogida').html(resp);
            }
        });

    }
</script>
@endsection