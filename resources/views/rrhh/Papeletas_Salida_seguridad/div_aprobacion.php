<div class="row" id="cancel-row">
    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="toolbar">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label text-bold">Estado Solicitud:</label>
                            <select id="estado_solicitud" name="estado_solicitud" class="form-control" >
                                <option value="1" selected>En Proceso de aprobacion</option>
                                <option value="2">Aprobados</option>
                                <option value="3">Denegados</option>
                                <option value="4">Todos</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label text-bold">Fecha Inicio:</label>
                            <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision" value="<?php echo date("Y-m-d");?>" name="fecha_revision" > 
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="control-label text-bold">Fecha Fin:</label>
                                <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision_fin" value="<?php echo date("Y-m-t");?>" name="fecha_revision_fin" > 
                        </div>
                    </div>

                    <div class="form-group col-md-3">
                        <label class="control-label text-bold">&nbsp;</label>
                        <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Papeletas_Salida_Gestion();" title="Buscar">
                            Buscar
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive mb-4 mt-4" id="lista_colaborador">
            </div>
        </div>
    </div>           
</div>

<script>
    $('.buttonDownload[download]').each(function() {
        var $a = $(this),
            fileUrl = $a.attr('href');
        $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
    });

    $(document).ready(function() {
        Buscar_Papeletas_Salida_Gestion();
    });


    $('#estado_solicitud').change(function(){
        var data= $(this).val();
    });

    $('#estado_solicitud').val('1').trigger('change');
</script>