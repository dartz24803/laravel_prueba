<div class="col-lg-4">
    <div class="form-group">
        <label for="id_departamento">Departamento</label>
        <select class="form-control" name="id_departamento" id="id_departamento" onchange="Traer_Provincia();">
            <option value="0">Seleccione</option>
            @foreach ($list_departamento as $list)
                <option value="{{ $list->id_departamento }}"
                @php if(isset($get_domicilio->id_domicilio_usersp)){ if($get_domicilio->id_departamento==$list->id_departamento){ echo "selected"; } } @endphp>
                    {{ $list->nombre_departamento }}
                </option>
            @endforeach                                                                            
        </select>
    </div>
</div>
<div class="col-lg-4">
    <div class="form-group">
        <label for="id_provincia">Provincia</label>
        <select class="form-control" name="id_provincia" id="id_provincia" onchange="Traer_Distrito();">
            <option value="0">Seleccione</option>
            @foreach ($list_provincia as $list)
                <option value="{{ $list->id_provincia }}"
                    @php if(isset($get_domicilio->id_domicilio_usersp)){ if($get_domicilio->id_provincia==$list->id_provincia){ echo "selected"; } } @endphp>
                    {{ $list->nombre_provincia }}
                </option>
            @endforeach                                                                             
        </select>
    </div>
</div>
<div class="col-lg-4">
    <div class="form-group">
        <label for="id_distrito">Distrito</label>
        <select class="form-control" name="id_distrito" id="id_distrito">
            <option value="0">Seleccione</option>
            @foreach ($list_distrito as $list)
                <option value="{{ $list->id_distrito }}"
                    @php if(isset($get_domicilio->id_domicilio_usersp)){ if($get_domicilio->id_distrito==$list->id_distrito){ echo "selected"; } } @endphp>
                    {{ $list->nombre_distrito }}
                </option>
            @endforeach                                                                             
        </select>
    </div>
</div>