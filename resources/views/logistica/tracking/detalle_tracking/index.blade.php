<div class="table-responsive mt-4" id="lista_detalle">
</div>

<script>
    Lista_Detalle();

    function Lista_Detalle(){
        Cargando();

        var url = "{{ route('tracking_det.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_detalle').html(resp);  
            }
        });
    }
</script>