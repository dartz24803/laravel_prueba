@csrf
<div class="table-responsive mb-4 mt-4" id="lista_revision">
</div>

<script>
    Lista_Revision();

    function Lista_Revision(){
        Cargando();

        var url = "{{ route('linea_carrera_conf_reva.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_revision').html(resp);  
            }
        });
    }

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }
</script>