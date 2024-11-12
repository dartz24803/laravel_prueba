<div class="col-md-12 row">

    <div class="form-group col-md-1">
        <label for="" class="control-label text-bold">Base&nbsp;</label>
        <div>
            <select id="baseih" name="baseih" class="form-control" onchange="Cmb_Colaboradori()">
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
            <select class="form-control" id="areaih" name="areaih" onchange="Cmb_Colaboradorih()">
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
            <select class="form-control basic" id="usuarioih" name="usuarioih">
                <option value="0">Todos</option>
                <?php foreach ($data['list_colaborador'] as $list) { ?>
                    <option value="<?php echo $list->id_usuario ?>">
                        <?php echo $list->usuario_nombres . " " . $list->usuario_apater . " " . $list->usuario_amater ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group col-md-1">
        <label for=""></label>
        <div>
            <label class="new-control new-radio radio-primary">
                <input type="radio" class="new-control-input" id="r_diah" value="1" name="tipo_fechah" checked onclick="Div_Tipo_Fechah()">
                <span class="new-control-indicator"></span>Dia
            </label>
            <label class="new-control new-radio radio-primary">
                <input type="radio" class="new-control-input" id="r_semanah" value="2" name="tipo_fechah" onclick="Div_Tipo_Fechah()">
                <span class="new-control-indicator"></span>Semana
            </label>
        </div>
    </div>

    <div class="form-group col-md-3">
        <label for="">&nbsp;</label>
        <div id="div1h">
            <!-- Input for selecting the date -->
            <input type="date" name="diaih" id="diaih" class="form-control" value="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day')) ?>" max="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day')) ?>">
        </div>
        <div id="div2h" style="display:none">
            <!-- Dropdown for selecting week -->
            <select name="semanaih" id="semanaih" class="form-control basic">
                <?php foreach ($data['list_semanas'] as $list) { ?>
                    <option value="<?php echo $list->id_semanas ?>">
                        <?php echo "Semana " . $list->nom_semana . " (" . date('d/m/Y', strtotime($list->fec_inicio)) . " - " . date('d/m/Y', strtotime($list->fec_fin)) . ")" ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>


    <div class="form-group col-md-2">
        <label for="">&nbsp;</label>
        <div>
            <button type="button" class="btn btn-primary mb-2 mr-2" title="Buscar" onclick="Buscar_Asistencia_Colaborador_Inconsistencia()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
            </button>
            <button type="button" class="btn mb-2 mr-2" style="background-color: #28a745 !important;" onclick="Excel_Asistencia_Colaborador_Inconsistencia();" title="Excel">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;">
                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                        <path d="M0,172v-172h172v172z" fill="none"></path>
                        <g fill="#ffffff">
                            <path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-16.125z"></path>
                        </g>
                    </g>
                </svg>
            </button>
        </div>
    </div>


    @csrf
    <div class="table-responsive mb-4 mt-0" id="lista_asistencia_inconsistencia">
    </div>
</div>

<script>
    function Buscar_Asistencia_Colaborador_Inconsistencia() {
        Cargando();

        var base = $('#baseih').val();
        var area = $('#areaih').val();
        var usuario = $('#usuarioih').val();
        var tipo_fecha = $('input:radio[name=tipo_fechah]:checked').val();
        var dia = $('#diaih').val();
        var semana = $('#semanaih').val();

        var url = "{{ route('inconsistencias_colaborador.list') }}";
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
                $('#lista_asistencia_inconsistencia').html(data);
            }
        });

    }


    function Div_Tipo_Fechah() {
        Cargando();
        var div1 = document.getElementById("div1h");
        var div2 = document.getElementById("div2h");
        if ($('#r_diah').is(":checked")) {
            div1.style.display = "block";
            div2.style.display = "none";
        } else {
            div1.style.display = "none";
            div2.style.display = "block";
        }
    }




    function Excel_Asistencia_Colaborador_Inconsistencia() {
        Cargando();
        var base = $('#baseih').val();
        var area = $('#areaih').val();
        var usuario = $('#usuarioih').val();
        var tipo_fecha = $('input:radio[name=tipo_fechah]:checked').val();
        var dia = $('#diaih').val();
        var semana = $('#semanaih').val();
        window.location = "{{ route('inconsistencias_colaborador.excel', ['base' => ':base', 'area' => ':area', 'usuario' => ':usuario', 'tipo_fecha' => ':tipo_fecha', 'dia' => ':dia', 'semana' => ':semana']) }}"
            .replace(':base', base)
            .replace(':area', area)
            .replace(':usuario', usuario)
            .replace(':tipo_fecha', tipo_fecha)
            .replace(':dia', dia)
            .replace(':semana', semana)
    }
</script>