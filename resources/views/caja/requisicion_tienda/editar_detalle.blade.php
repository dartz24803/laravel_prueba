<div class="form-group col-lg-2">
    <label>Stock:</label>
    <input type="text" class="form-control" name="stockde" id="stockde" placeholder="Stock"
    onkeypress="return solo_Numeros(event);" onpaste="return false;" value="{{ $get_id->stock }}">
</div>

<div class="form-group col-lg-2">
    <label>Cantidad:</label>
    <input type="text" class="form-control" name="cantidadde" id="cantidadde" 
    placeholder="Cantidad" onkeypress="return solo_Numeros(event);" onpaste="return false;" 
    value="{{ $get_id->cantidad }}">
</div>

<div class="form-group col-lg-6">
    <label>Producto:</label>
    <select class="form-control basic" name="id_productode" id="id_productode">
        <option value="0">Seleccione</option>
        @foreach ($list_producto as $list)
            <option value="{{ $list->id_producto }}"
            @if ($list->id_producto==$get_id->id_producto) selected @endif>
                {{ $list->nom_producto }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group d-flex align-items-center col-lg-2">
    <button class="btn btn-primary" type="button" onclick="Update_Detalle('{{ $get_id->id_requisicion_detalle }}');">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-save">
            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
            <polyline points="17 21 17 13 7 13 7 21"></polyline>
            <polyline points="7 3 7 8 15 8"></polyline>
        </svg>
    </button>
    <button class="btn btn-default" title="Cancelar" type="button" onclick="Cancelar_Detalle();">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="15" y1="9" x2="9" y2="15"></line>
            <line x1="9" y1="9" x2="15" y2="15"></line>
        </svg>
    </button> 
</div>

<div class="form-group col-lg-2">
    <label>Precio Unitario:</label>
    <input type="text" class="form-control" name="preciode" id="preciode" 
    placeholder="Precio" onkeypress="return solo_Numeros_Punto(event);" onpaste="return false;"
    value="{{ $get_id->precio }}">
</div>

<div class="form-group col-lg-4">
    <label>Archivo:</label>
    <input type="file" class="form-control-file" name="archivode" id="archivode" 
    onchange="Valida_Archivo('archivode');">
</div>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalRegistroGrande')
    });
</script>