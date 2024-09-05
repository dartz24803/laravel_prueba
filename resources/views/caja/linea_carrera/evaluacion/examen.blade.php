<style>
    input[type=radio]:checked{
        border-color: #00B1F4 !important;
        background-color: #00B1F4 !important; 
    }
</style>

@php $i = 1; @endphp
@foreach ($list_pregunta as $list)
    <div class="row justify-content-center mb-3">
        <div class="col-12 col-md-9 bg-white rounded-3 p-3">
            <div class="row">
                <div class="col-12 py-2">
                    <p class="lead m-0">{{ $i.". ".$list->descripcion }}</p>
                </div>
                <div class="col-12 py-2">
                    @if ($list->opciones==null)
                        <textarea class="form-control" id="respuesta_{{ $list->id_pregunta }}" name="respuesta_{{ $list->id_pregunta }}" placeholder="Respuesta" rows="3"></textarea>
                    @else
                        @php $detalle = explode(",,,",$list->opciones); @endphp
                        @foreach ($detalle as $j => $opcion)
                            @php $pregunta = explode(":::",$opcion); @endphp

                            <div class="justify-content-center">
                                <input type="radio" name="respuesta_{{ $list->id_pregunta }}" id="respuesta_{{ $j."-".$list->id_pregunta }}" class="form-check-input" value="{{ $pregunta[0] }}">
                                <label for="respuesta_{{ $j."-".$list->id_pregunta }}">{{ $pregunta[1] }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@php $i++; @endphp
@endforeach

@if (count($list_pregunta)>0)
    <div class="row justify-content-center">
        <div class="col-12 col-md-9">
            <button type="button" class="btn btn-lg boton" onclick="Terminar_Evaluacion(1);">
                Enviar
            </button> 
        </div>
    </div>
@endif

<script>
    let timerInterval;
    const display = document.getElementById('timer');
    const endTime = new Date();
    endTime.setHours({{ $hora }}, {{ $minuto }}, {{ $segundo }}); // Definición de hora fin

    // Función para actualizar el display del temporizador
    function updateTimerDisplay(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const remainingSeconds = seconds % 60;
        display.textContent = `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
    }

    // Función para calcular el tiempo restante en segundos
    function calculateRemainingTime() {
        const now = new Date();
        const remainingTime = Math.floor((endTime - now) / 1000); // Tiempo restante en segundos
        return remainingTime > 0 ? remainingTime : 0;
    }

    // Función para iniciar el temporizador
    function startTimer() {
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            const remainingTime = calculateRemainingTime();
            if (remainingTime <= 0) {
                clearInterval(timerInterval);
                Terminar_Evaluacion(2);
            }
            updateTimerDisplay(remainingTime);
        }, 1000);
    }

    // Iniciar temporizador con tiempo restante
    startTimer();

    // Función para guardar respuestas del examen en localStorage
    function saveResponses() {
        const form = document.getElementById('formulario');
        const formData = new FormData(form);
        formData.forEach((value, key) => {
            localStorage.setItem(key, value);
        });
    }

    // Evento para guardar las respuestas del examen al cambiar un campo
    document.getElementById('formulario').addEventListener('input', saveResponses);

    // Función para cargar respuestas guardadas del localStorage
    function loadResponses() {
        const form = document.getElementById('formulario');
        Array.from(form.elements).forEach(element => {
            if (element.name) {
                const savedValue = localStorage.getItem(element.name);
                if (savedValue) {
                    if (element.type === 'radio') {
                        // Para radio buttons, marca el radio button adecuado
                        if (element.value === savedValue) {
                            element.checked = true;
                        }
                    } else {
                        // Para otros campos, simplemente establece el valor
                        element.value = savedValue;
                    }
                }
            }
        });
    }

    // Cargar respuestas guardadas al cargar la página
    loadResponses();
</script>