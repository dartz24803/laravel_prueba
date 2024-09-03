@csrf
<div class="table-responsive mb-4 mt-4" id="lista_revision_evaluacion">
</div>

<script>
    Lista_Revision_Evaluacion();

    function Lista_Revision_Evaluacion(){
        Cargando();

        var url = "{{ route('linea_carrera_re.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_revision_evaluacion').html(resp);  
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