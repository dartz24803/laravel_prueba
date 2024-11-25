<div class="table-responsive mt-4" id="lista_base_datos">
</div>

<script>
    Lista_Base_Datos();

    function Lista_Base_Datos(){
        Cargando();

        var url = "{{ route('tracking_bd.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_base_datos').html(resp);  
            }
        });
    }
</script>