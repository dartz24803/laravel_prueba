<div class="form-group col-lg-2">
    <label>Stock:</label>
    <input type="text" class="form-control" name="stockd" id="stockd" placeholder="Stock"
    onkeypress="return solo_Numeros(event);" onpaste="return false;">
</div>

<div class="form-group col-lg-2">
    <label>Cantidad:</label>
    <input type="text" class="form-control" name="cantidadd" id="cantidadd" 
    placeholder="Cantidad" onkeypress="return solo_Numeros(event);" onpaste="return false;">
</div>

<div class="form-group col-lg-7">
    <label>Producto:</label>
    <select class="form-control basic" name="id_productod" id="id_productod">
        <option value="0">Seleccione</option>
        @foreach ($list_producto as $list)
            <option value="{{ $list->id_producto }}">{{ $list->nom_producto }}</option>
        @endforeach
    </select>
</div>

<div class="form-group d-flex align-items-center col-lg-1">
    <button class="btn btn-primary" type="button" onclick="Insert_Detalle();">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus">
            <line x1="12" y1="5" x2="12" y2="19"></line>
            <line x1="5" y1="12" x2="19" y2="12"></line>
        </svg>
    </button>
</div>

<div class="form-group col-lg-2">
    <label>Precio Unitario:</label>
    <input type="text" class="form-control" name="preciod" id="preciod" 
    placeholder="Precio" onkeypress="return solo_Numeros_Punto(event);" 
    onpaste="return false;">
</div>

<div class="form-group col-lg-4">
    <label>Archivo:</label>
    <input type="file" class="form-control-file" name="archivod" id="archivod" 
    onchange="Valida_Archivo('archivod');">
</div>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalRegistroGrande')
    });
</script>