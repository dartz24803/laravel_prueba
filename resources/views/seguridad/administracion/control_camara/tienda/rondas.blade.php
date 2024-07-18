<select class="form-control multivalue" name="rondas[]" id="rondas" multiple="multiple">
    @foreach ($list_ronda as $list)
        <option value="{{ $list->id }}">{{ $list->descripcion }}</option>
    @endforeach
</select>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalUpdate')
    });
</script>