<div class="d-flex justify-content-end align-items-center">
    <div class="col-lg-12 d-flex justify-content-end mb-4">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Modal_Registrar_Datacorp') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </button>
    </div>
</div>
@csrf
<div class="table-responsive mb-4 mt-4" id="lista_datacorp">
</div>

<script>
    Listar_Accesos_Datacorp();

    function Listar_Accesos_Datacorp() {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();
        var url = "{{ url('Listar_Accesos_Datacorp') }}";

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(resp) {
                $('#lista_datacorp').html(resp);
            }
        });
    }
</script>