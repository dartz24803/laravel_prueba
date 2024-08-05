@extends('layouts.plantilla')

@section('content')

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header row">
            <div class="page-title col-12 col-sm-9">
                <h3>Administrar Frases Inicio</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="col-lg-12 d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Inicio/Modal_Registrar_Frases_Inicio')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Registrar
                        </button>
                    </div>
                    @csrf
                    <div id="lista_frases_inicio" class="table-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#slider_menu").addClass('active');
        $("#inicio_slider").attr('aria-expanded','true');
        $("#frases_inicio").addClass('active');

        Frases_Inicio_Listar();
    });

    function Frases_Inicio_Listar(){
        Cargando();

        var url="{{ url('Inicio/Frases_Inicio_Listar') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url:url,
            type:"POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#lista_frases_inicio').html(resp);
            }
        });
    }

    function Delete_Frase(id) {
        Cargando();

        var csrfToken = $('input[name="_token"]').val();
        var url = "{{ url('Inicio/Delete_Frase') }}";

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Frases_Inicio_Listar();
                        });
                    }
                });
            }
        })
    }
</script>

@endsection
