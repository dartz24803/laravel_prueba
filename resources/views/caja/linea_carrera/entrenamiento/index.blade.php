@csrf
<div class="table-responsive mb-4 mt-4" id="lista_entrenamiento">
</div>

<script>
    Lista_Entrenamiento();

    function Lista_Entrenamiento(){
        Cargando();

        var url = "{{ route('linea_carrera_en.list') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#lista_entrenamiento').html(resp);  
            }
        });
    }

    function Insert_Examen_Entrenamiento(id){
        Cargando();

        var url = "{{ route('linea_carrera_en.update', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type:"PUT",
            data: {'id':id},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (data) {
                Lista_Entrenamiento();
            }
        });
    }
</script>