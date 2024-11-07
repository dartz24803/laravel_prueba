<div class="col-md-12 row">
    <div class="form-group col-md-1">
        <label for="" class="control-label text-bold">Base&nbsp;</label>
        <div>
            <select id="baseau" name="baseau" class="form-control" onchange="Cmb_Colaboradoriau()">
                <option value="0" selected>Todos</option>
                <?php foreach ($data['list_base'] as $list) { ?>
                    <option value="<?php echo $list->cod_base; ?>"><?php echo $list->cod_base; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label for="" class="control-label text-bold">Área</label>
        <div>
            <select class="form-control" id="areaau" name="areaau" onchange="Cmb_Colaboradoriau()">
                <option value="0">Todos</option>
                <?php foreach ($data['list_area'] as $list) { ?>
                    <option value="<?php echo $list->id_area ?>"><?php echo $list->nom_area ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group col-md-3">
        <label for="" class="control-label text-bold">Colaborador</label>
        <div>
            <select class="form-control basic" id="usuarioau" name="usuarioau">
                <option value="0">Todos</option>
                <?php foreach ($data['list_colaborador'] as $list) { ?>
                    <option value="<?php echo $list->id_usuario ?>"><?php echo $list->usuario_nombres . " " . $list->usuario_apater . " " . $list->usuario_amater ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="form-group col-md-1">
        <label for=""></label>
        <div>
            <label class="new-control new-radio radio-primary">
                <input type="radio" class="new-control-input" id="r_diaau" value="1" name="tipo_fechaau" checked onclick="Div_Tipo_Fechaau()">
                <span class="new-control-indicator"></span>Dia
            </label>
            <label class="new-control new-radio radio-primary">
                <input type="radio" class="new-control-input" id="r_semanaau" value="2" name="tipo_fechaau" onclick="Div_Tipo_Fechaau()">
                <span class="new-control-indicator"></span>Semana
            </label>
        </div>
    </div>
    <div class="form-group col-md-3">
        <label for="">&nbsp;</label>
        <div id="div1au">
            <input type="date" name="diaau" id="diaau" class="form-control" value="<?php echo date("Y-m-d", strtotime(date("Y-m-d") . " -1 day")) ?>" max="<?php echo date("Y-m-d", strtotime(date("Y-m-d") . " -1 day")) ?>">
        </div>
        <div id="div2au" style="display:none">
            <select name="semanaau" id="semanaau" class="form-control basic">
                <?php foreach ($data['list_semanas'] as $list) { ?>
                    <option value="<?php echo $list->id_semanas ?>"><?php echo "Semana " . $list->nom_semana . " (" . date('d/m/Y', strtotime($list->fec_inicio)) . " - " . date('d/m/Y', strtotime($list->fec_fin)) . ")" ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-2">
        <label for="">&nbsp;</label>
        <div>
            <button type="button" class="btn btn-primary mb-2 mr-2 " title="Buscar" onclick="Buscar_Ausencia_Colaborador()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
        </div>
    </div>


    @csrf
    <div class="table-responsive mb-4 mt-0" id="div_ausencia">
    </div>
</div>




<script>
    function Buscar_Asistencia_Colaborador() {
        Cargando();

        var base = $('#baseau').val();
        var area = $('#areaau').val();
        var usuario = $('#usuarioau').val();
        var tipo_fecha = $('input:radio[name=tipo_fechaau]:checked').val();
        var dia = $('#diaau').val();
        var semana = $('#semanaau').val();

        var url = "{{ route('ausencia_colaborador.list') }}";
        var csrfToken = $('input[name="_token"]').val();
        console.log(base)
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'base': base,
                'area': area,
                'usuario': usuario,
                'tipo_fecha': tipo_fecha,
                'dia': dia,
                'semana': semana
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#div_ausencia').html(data);
            }
        });

    }

    function Div_Tipo_Fechaau() {
        Cargando();
        var div1 = document.getElementById("div1au");
        var div2 = document.getElementById("div2au");
        if ($('#r_diaau').is(":checked")) {
            div1.style.display = "block";
            div2.style.display = "none";
        } else {
            div1.style.display = "none";
            div2.style.display = "block";
        }
    }
</script>