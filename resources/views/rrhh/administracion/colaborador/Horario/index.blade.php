    <div class="d-flex justify-content-between">
        <div class="form-group col-lg-2"> 
            <label>Base</label>
            <select class="form-control" id="cod_base_f" name="cod_base_f" onchange="Lista_Horario();">
                <option value="0">Todos</option>
                <?php foreach($list_base as $list){ ?>
                    <option value="<?php echo $list['cod_base']; ?>"><?php echo $list['cod_base']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-lg-2"> 
            <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ url('ColaboradorConfController/Modal_Horario') }}" >
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                Registrar
            </button>
        </div>
    </div>
    @csrf
    <div class="table-responsive mb-4 mt-4" id="lista_horario">
    </div>

<script>
    $(document).ready(function() {
        document.title = 'Horario';
        Lista_Horario();
    });

    function Lista_Horario(){
        Cargando();

        var url="{{ url('ColaboradorConfController/Lista_Horario') }}";
        var cod_base = $("#cod_base_f").val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'cod_base':cod_base},
            success:function (resp) {
                $('#lista_horario').html(resp);
            }
        });
    }
</script>