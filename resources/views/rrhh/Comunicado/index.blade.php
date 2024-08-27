@extends('layouts.plantilla_new')

@section('navbar')
    @include('rrhh.navbar')
@endsection

@section('content')

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs mb-3 mt-3" id="simpletab" role="tablist">
                            <li class="nav-item">
                                <a id="a_sr" class="nav-link" onclick="Slider_Rrhh();" style="cursor: pointer;">Slider RRHH</a>
                            </li>
                            <li class="nav-item">
                                <a id="a_ai" class="nav-link" onclick="Anuncio_Intranet();" style="cursor: pointer;">Anuncios Intranet</a>
                            </li>
                        </ul>

                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_comunicado" class="widget-content widget-content-area">
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
        $("#rhumanos").addClass('active');
        $("#hrhumanos").attr('aria-expanded','true');
        $("#recomunicados").addClass('active');

        Slider_Rrhh();
    });

    function Slider_Rrhh(){ 
        Cargando();

        var url="{{ url('Cargar_Slider_Rrhh')}}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_comunicado').html(resp);  
                $("#a_sr").addClass('active');
                $("#a_ai").removeClass('active');
            }
        });
    }

    function Anuncio_Intranet(){ 
        Cargando();

        var url="{{ url('Cargar_Anuncio_Intranet') }}";

        $.ajax({
            url: url,
            type:"GET",
            success:function (resp) {
                $('#div_comunicado').html(resp);  
                $("#a_sr").removeClass('active');
                $("#a_ai").addClass('active');
            }
        });
    }

    function Delete_Bolsa_Trabajo(id){
        var id = id;
        var url="{{ url('Delete_Bolsa_Trabajo') }}";
        Swal({
            title: '¿Realmente desea eliminar el registro',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type:"GET",
                    url:url,
                    data: {'id_bolsa_trabajo':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "{{ url('Bolsa_Trabajo') }}";
                        });
                    }
                });
            }
        })
    }
</script>

@endsection