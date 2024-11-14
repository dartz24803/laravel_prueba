<form id="formulario_historico_puesto" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"><b>Actualizar Puesto: </b> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:500px; overflow:auto;" >
        <div class="row">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Gerencia: </label>
                <select class="form-control" name="id_gerencia_hp" id="id_gerencia_hp" 
                onchange="Busca_Sub_Gerencia_Hp();">
                    <option value="0">Seleccione</option>
                    @foreach ($list_gerencia as $list)
                        <option @if (isset($get_historico->id_puesto) && 
                        $list->id_gerencia==$get_historico->id_gerencia) selected @endif
                        value="{{ $list->id_gerencia }}">
                            {{ $list->nom_gerencia }}
                        </option> 
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Sub-Gerencia: </label>
                <select class="form-control" name="id_sub_gerencia_hp" id="id_sub_gerencia_hp" 
                onchange="Busca_Area_Hp();">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sub_gerencia as $list)
                        <option @php if(isset($get_historico->id_puesto) && 
                        $list->id_sub_gerencia==$get_historico->id_sub_gerencia){ echo "selected"; } @endphp 
                        value="{{ $list->id_sub_gerencia }}">
                            {{ $list->nom_sub_gerencia }}
                        </option> 
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Área: </label>
                <select class="form-control" name="id_area_hp" id="id_area_hp" 
                onchange="Busca_Puesto_Hp();">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option @php if(isset($get_historico->id_puesto) && 
                        $list->id_area==$get_historico->id_area){ echo "selected"; } @endphp 
                        value="{{ $list->id_area }}">
                            {{ $list->nom_area }}
                        </option> 
                    @endforeach
                </select>
            </div>            
            
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Puesto: </label>
                <select class="form-control" name="id_puesto_hp" id="id_puesto_hp" 
                onchange="Limpiar_Fechas_Historico_Puesto();">
                    <option value="0">Seleccione</option>
                    @foreach ($list_puesto as $list)
                        <option @php if(isset($get_historico->id_puesto) && 
                        $list->id_puesto==$get_historico->id_puesto){ echo "selected"; } @endphp 
                        value="{{ $list->id_puesto }}">
                            {{ $list->nom_puesto }}
                        </option> 
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Centro de labor: </label>
                <select class="form-control" name="id_centro_labor_hp" id="id_centro_labor_hp">
                    <option value="0">Seleccione</option>
                    @foreach ($list_ubicacion as $list)
                        <option @php if(isset($get_historico->id_puesto) && 
                        $list->id_ubicacion==$get_historico->id_centro_labor){ echo "selected"; } @endphp 
                        value="{{ $list->id_ubicacion }}">
                            {{ $list->cod_ubi }}
                        </option> 
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Fecha de Inicio: </label>
                <input type="date" class="form-control" name="fec_inicio_hp" id="fec_inicio_hp" 
                value="@php if(isset($get_historico->id_puesto)){ echo $get_historico->fec_inicio; } @endphp">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Tipo: </label>
                <select class="form-control" name="id_tipo_cambio_hp" id="id_tipo_cambio_hp" >
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_cambio as $list)
                        <option @php if(isset($get_historico->id_puesto) && 
                        $list->id_tipo_cambio==$get_historico->id_tipo_cambio){ echo "selected"; } @endphp 
                        value="{{ $list->id_tipo_cambio }}">
                            {{ $list->nom_tipo_cambio }}
                        </option> 
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <input type="checkbox" name="con_fec_fin_hp" id="con_fec_fin_hp" value="1" 
                @php if(isset($get_historico->id_puesto) && 
                $get_historico->con_fec_fin=="1"){ echo "checked"; } @endphp 
                onclick="Mostrar_FecFin_Puesto();">
                <label class="control-label text-bold" for="con_fec_fin_hp">Con fecha fin: </label>
                <input type="date" class="form-control" name="fec_fin_hp" id="fec_fin_hp"
                value="@php if(isset($get_historico->id_puesto)){ echo $get_historico->fec_fin; } @endphp"
                style="display:@php if(isset($get_historico->id_puesto) && 
                $get_historico->con_fec_fin=="1"){ echo "block"; }else{ echo "none"; } @endphp">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" onclick="Update_Historico_Puesto();" 
        type="button">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Busca_Sub_Gerencia_Hp(){
        Cargando();

        var id_gerencia = $('#id_gerencia_hp').val();
        var url = "{{ route('colaborador_conf.traer_sub_gerencia') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_gerencia':id_gerencia},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data){
                $('#id_sub_gerencia_hp').html(data);
                $('#id_area_hp').html('<option value="0">Seleccione</option>');
                $('#id_puesto_hp').html('<option value="0">Seleccione</option>');
            }
        });
    }

    function Busca_Area_Hp(){
        Cargando();

        var id_sub_gerencia = $('#id_sub_gerencia_hp').val();
        var url = "{{ route('colaborador_conf.traer_area') }}";

        $.ajax({
            url: url, 
            type: 'POST',
            data: {'id_sub_gerencia':id_sub_gerencia},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data){
                $('#id_area_hp').html(data);
                $('#id_puesto_hp').html('<option value="0">Seleccione</option>');      
            }
        });
    }

    function Busca_Puesto_Hp(){
        Cargando();

        var id_area = $('#id_area_hp').val();
        var url = "{{ route('colaborador_conf.traer_puesto') }}";

        $.ajax({
            url: url, 
            type: 'POST',
            data: {'id_area':id_area},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data){
                $('#id_puesto_hp').html(data);    
            }
        });
    }

    function Limpiar_Fechas_Historico_Puesto(){
        $('#fec_inicio_hp').val('');
        $('#fec_fin_hp').val('');
    }

    function Mostrar_FecFin_Puesto(){
        var div = document.getElementById("fec_fin_hp");
        $('#fec_fin_hp').val('');
        if ($('#con_fec_fin_hp').is(":checked")){
            div.style.display = "block";
        }else{
            div.style.display = "none";
        }
    }
    
    function Update_Historico_Puesto() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_historico_puesto'));
        var url = "{{ route('colaborador_perfil.update_puesto', $id_usuario) }}";

            $.ajax({
                type: "POST",
                url: url,
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    swal.fire(
                        'Actualización Exitosa!',
                        'Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        List_Datos_Laborales({{ $id_usuario }});
                        $("#ModalUpdate .close").click();
                    });
                },
                error:function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            });
    }
</script>