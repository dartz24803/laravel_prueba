@csrf
<div class="table-responsive" id="lista_maestra_ft" style="padding: 10px">
</div>

<script>
    Redirigir_Lista_Contabilidad_ft();

    function Redirigir_Lista_Contabilidad_ft() {
        Cargando();
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();

        var ini = moment(fecha_inicio);
        var fin = moment(fecha_fin);
        var url = "{{ route('tabla_facturacion_total.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: {
                'fecha_inicio': fecha_inicio,
                'fecha_fin': fecha_fin
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(resp) {
                $('#lista_maestra_ft').html(resp);
            }
        });
    }
</script>