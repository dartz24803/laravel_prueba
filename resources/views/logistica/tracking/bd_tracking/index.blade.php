<div class="table-responsive mt-4" id="lista_bd_tracking">
</div>

<script>
    Lista_Bd_Tracking();

    function Lista_Bd_Tracking(){
        Cargando();

        var url = "{{ route('tracking_bd.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_bd_tracking').html(resp);  
            }
        });
    }
</script>