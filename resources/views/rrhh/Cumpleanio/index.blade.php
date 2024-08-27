@extends('layouts.plantilla_new')

@section('navbar')
    @include('rrhh.navbar')
@endsection

@section('content')

<?php
$id_nivel = session('usuario')->id_nivel;
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row">
            <div id="btnGroupInput-group" class="col-xl-12 col-lg-12 col-sm-12 layout-spacing" style="margin-bottom: -28px;" >
                <div class="widget-content text-center split-buttons" style="background-color: transparent;">
                    <div class="btn-toolbar justify-content-between mr-2" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mb-2" role="group" aria-label="First group">
                        <div class="page-title">
                            <h3 class="page-title textocambio">Cumpleaños</h3>              
                        </div>                            
                        </div>
                        <div class="input-group mb-2" style="display: flex;justify-content: center;align-content: center;" >
                            <div class="toolbar" style="height: 37px;" id="boton_list">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="toolbar">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="cod_mes">Mes</label>
                                    <select class="form-control" name="cod_mes" id="cod_mes">
                                    <?php foreach($list_mes as $list){ ?>
                                        <option value="<?php echo $list['cod_mes']; ?>" <?php if(date('m')==$list['cod_mes']){echo "selected";}?>><?php echo $list['nom_mes'];?></option>
                                    <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <label class="control-label text-bold">&nbsp;</label>
                                <button type="button" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Cumpleanios();" title="Buscar">
                                    Buscar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-4 mt-4" id="lista_cumple">
                        
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
        $("#recumpleanio").addClass('active');
        $('.sorting_asc').click();
        Buscar_Cumpleanios();
    });
    
    function Buscar_Cumpleanios() {
        Cargando();
        var mes=$('#cod_mes').val();
        var url = "{{ url('RecursosHumanos/Buscar_Cumpleanios') }}";
        $.ajax({
            type: "GET",
            url: url,
            data: {'cod_mes':mes},
            success: function(data) {
                $('#lista_cumple').html(data);
                
            }
        });
    }
</script>

@endsection