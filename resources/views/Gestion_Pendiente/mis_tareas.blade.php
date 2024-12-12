<div class="toolbar d-flex">
    <div class="col-lg-2">
        <div class="col-md-12">
            <label>Estado</label>
        </div>
        <div class="col-md-12">
            <input type="checkbox" id="cpiniciar" checked name="cpiniciar" value="1" onchange="Lista_Mis_Tareas()">
            <label for="cpiniciar" style="font-weight:normal">Por Iniciar</label>
        </div>
        <div class="col-md-12">
            <input type="checkbox" id="cproceso" checked name="cproceso" value="2" onchange="Lista_Mis_Tareas()">
            <label for="cproceso" style="font-weight:normal">En Proceso</label>
        </div>
        <div class="col-md-12">
            <input type="checkbox" id="cfinalizado" name="cfinalizado" value="3" onchange="Lista_Mis_Tareas()">
            <label for="cfinalizado" style="font-weight:normal">Completado</label>
        </div>
        <div class="col-md-12">
            <input type="checkbox" id="cstandby" name="cstandby" value="4" onchange="Lista_Mis_Tareas()">
            <label for="cstandby" style="font-weight:normal">Stand by</label>
        </div>
    </div>

    <?php if(session('usuario')->id_nivel==1){?>
        <div class="col-lg-2">
            <label>Área</label>
            <select class="form-control" id="area_busq" name="area_busq" onchange="Lista_Mis_Tareas();">
                <option value="0" selected>TODOS</option>
                <?php foreach($list_area as $list){ ?>
                    <option value="<?php echo $list['id_area']; ?>"><?php echo $list['nom_area']; ?></option>
                <?php } ?>
            </select>
        </div>
    <?php }else{?>
        <input type="hidden" name="area_busq" id="area_busq" value="0">
    <?php }?>

    <div class="col-lg-2">
        <label>Sede</label>
        <select class="form-control" id="busq_base" name="busq_base" onchange="Lista_Mis_Tareas();">
            <option value="0" selected>TODOS</option>
            <?php foreach($list_base as $list){ ?>
                <option value="<?php echo $list['cod_base'] ; ?>">
                    <?php echo $list['cod_base'];?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="col-lg-2">
        <label>&nbsp;</label>
        <div>
            <a class="btn mb-2" id="btn_mistareas" onclick="MisTareas_Btn();" style="background-color:#1b55e2;color:white;border-radius: 20px;">
                Mis tareas
            </a>
            <a class="btn " id="btn_miequipo" onclick="MiEquipo_Btn();" style="background-color:#d6d6d7;color:black;border-radius: 20px;">
                Mi equipo
            </a>
        </div>
        <input type="hidden" name="mis_tareas" id="mis_tareas">
        <input type="hidden" name="mi_equipo" id="mi_equipo">
    </div>

    <div class="col-lg-3" id="div_asignado">
        <label>Asignado a</label>
        <select class="form-control basic" id="responsablei" name="responsablei" onchange="Lista_Mis_Tareas();">
            <option value="0" selected>Todos</option>
            <?php foreach($list_responsable as $list){ ?>
                <option value="<?php echo $list['id_usuario'] ; ?>">
                    <?php echo $list['usuario_nombres']." ".$list['usuario_apater']." ".$list['usuario_amater'];?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="col-lg-1">
        <label>&nbsp;</label>
        <div>
            <a class="btn mb-2 mr-2 " style="background-color: #28a745 !important;" onclick="Excel_Gestion_Pendiente();">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>
            </a>
        </div>
    </div>
</div>
@csrf
<div class="table-responsive" id="lista_gestion_pendiente">
</div>

<script>
    MisTareas_Btn();

    function MisTareas_Btn(){
        $('#mis_tareas').val('1');
        $('#mi_equipo').val('0');
        $('#responsablei').val('0');
        var div = document.getElementById("div_asignado");
        div.style.display = "none";
        var boton = document.getElementById("btn_mistareas");
        boton.style.backgroundColor = "#1b55e2";
        boton.style.color = "white";
        var boton = document.getElementById("btn_miequipo");
        boton.style.backgroundColor = "#d6d6d7";
        boton.style.color = "black";
        Lista_Mis_Tareas();
    }

    function MiEquipo_Btn(){
        $('#mis_tareas').val('0');
        $('#mi_equipo').val('1');
        $('#responsablei').val('0');
        var ss = $(".basic").select2({
            tags: true
        });
        var div = document.getElementById("div_asignado");
        div.style.display = "block";
        var boton = document.getElementById("btn_mistareas");
        boton.style.backgroundColor = "#d6d6d7";
        boton.style.color = "black";
        var boton = document.getElementById("btn_miequipo");
        boton.style.backgroundColor = "#1b55e2";
        boton.style.color = "white";
        Lista_Mis_Tareas();
    }

    function Lista_Mis_Tareas(tipo){
        Cargando();

        var id_area = $('#area_busq').val();
        var base = $('#busq_base').val();
        var mis_tareas = $('#mis_tareas').val();
        var mi_equipo = $('#mi_equipo').val();
        var responsablei = $('#responsablei').val();
        var cpiniciar=0;
        var cproceso=0;
        var cfinalizado=0;
        var cstandby=0;
        if($('#cpiniciar').is(":checked")){
            var cpiniciar=1;
        }
        if($('#cproceso').is(":checked")){
            var cproceso=1;
        }
        if($('#cfinalizado').is(":checked")){
            var cfinalizado=1;
        }
        if($('#cstandby').is(":checked")){
            var cstandby=1;
        }

        var url = "{{ url('Tareas/Lista_Mis_Tareas') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'id_area':id_area,'base':base,'cpiniciar':cpiniciar,
                'cproceso':cproceso,'cfinalizado':cfinalizado,'cstandby':cstandby,
                'mis_tareas':mis_tareas,'mi_equipo':mi_equipo,'responsablei':responsablei},
            success: function(data){
                $('#lista_gestion_pendiente').html(data);
            }
        });
    }

    function Delete_Gestion_Pendiente(id){
        Cargando();

        var url="{{ url('Tareas/Delete_Pendiente') }}";
        var csrfToken = $('input[name="_token"]').val();

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
                    type:"POST",
                    url:url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {'id_pendiente':id},
                    success:function () {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Mis_Tareas();
                        });
                    }
                });
            }
        })
    }

    function Excel_Gestion_Pendiente() {
        var id_nivel = $('#nivel_actual').val();
        var mis_tareas = $('#mis_tareas').val();
        var mi_equipo = $('#mi_equipo').val();
        var responsablei = $('#responsablei').val();
        if(id_nivel==1){
            var id_area = $('#area_busq').val();
            var base = $('#busq_base').val();
        }else{
            var id_area = "0";
            var base = $('#busq_base').val();
        }
        var cpiniciar=0;
        var cproceso=0;
        var cfinalizado=0;
        var cstandby=0;
        if($('#cpiniciar').is(":checked")){
            var cpiniciar=1;
        }
        if($('#cproceso').is(":checked")){
            var cproceso=1;
        }
        if($('#cfinalizado').is(":checked")){
            var cfinalizado=1;
        }
        if ($('#cstandby').is(":checked")){
            var cstandby=1;
        }

        window.location = `{{ url('Tareas/Excel_Gestion_Pendiente') }}/${id_area}/${base}/${cpiniciar}/${cproceso}/${cfinalizado}/${cstandby}/${mis_tareas}/${mi_equipo}/${responsablei}`;
    }
</script>
