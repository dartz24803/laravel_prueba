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

    function solo_Numeros_Punto(e) {
        var key = event.which || event.keyCode;
        if ((key >= 48 && key <= 57) || key == 46) {
            if (key == 46 && event.target.value.indexOf('.') !== -1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function validarRango(input) {
        // Obtener el valor ingresado en el campo de número
        var valor = parseFloat(input.value);

        // Validar que el número esté entre 0 y 1
        if (isNaN(valor) || valor < 0 || valor > 1) {
            // Si el número no es válido, restablecer el campo a vacío
            input.value = '';
            return; // No hacer nada más si la validación falla
        }

        // Obtener el valor actual del acumulado
        var nota = parseFloat(document.getElementById('notae').value);

        // Sumar el valor ingresado al acumulado
        var nota_acumulada = nota + valor;

        // Actualizar el valor del acumulado en el input
        document.getElementById('notae').value = nota_acumulada.toFixed(1);

        // Restablecer el campo de número a vacío después de la suma
        //document.getElementById('numero').value = '';

        /*var valor = parseFloat(input.value);
        if (valor < 0 || valor > 1) {
            input.value = ''; // Borra el valor si está fuera del rango
        }*/
    }
</script>