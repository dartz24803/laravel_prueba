@extends('layouts.plantilla')

@section('navbar')
    @include('comercial.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        
        <div class="page-header">
            <div class="page-title">
                <h3>Registro de Requerimiento</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
        
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6 p-3">
                    <div class="toolbar">
                        <form id="formulario" class="control">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Semana</label>
                                    <select class="form-control" id="semana" name="semana" onchange="Buscar_Semana();">
                                        <option value="0">Seleccione</option>
                                        <?php foreach($list_semanas as $list){ ?>
                                            <?php if(date('W') == $list->semana){ ?>
                                                <option selected value="<?php echo $list->semana; ?>"><?php echo $list->semana;?></option> 
                                            <?php }else{ ?>
                                                <option value="<?php echo $list->semana; ?>"><?php echo $list->semana;?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Año</label>
                                    <select class="form-control" id="anio" name="anio" onchange="Buscar_Semana();">
                                        <option value="0">Seleccione</option>
                                        <?php foreach($list_anio as $list){ ?>
                                            <?php if(date('Y') == $list['cod_anio']){ ?>
                                                <option selected value="<?php echo $list['cod_anio']; ?>"><?php echo $list['cod_anio'];?></option> 
                                            <?php }else{ ?>
                                                <option value="<?php echo $list['cod_anio']; ?>"><?php echo $list['cod_anio'];?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2" id="btnregistarm">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <button type="button" class="btn btn-primary mb-2 mr-2 form-control" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('RequerimientoSurtido/Modal_Requerimiento') }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                        Registrar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_semana">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {
        $("#comercial").addClass('active');
        $("#hcomercial").attr('aria-expanded','true');
        $("#rsurtido").addClass('active');
        
        Buscar_Semana();
    });
    
    function Buscar_Semana() {
        Cargando();
        
        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ url('RequerimientoSurtido/Buscar_Semana') }}";
        var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                processData: false,
                contentType: false,
                success: function(data) {
                    $('#lista_semana').html(data);
                }
            });
    }
</script>
@endsection