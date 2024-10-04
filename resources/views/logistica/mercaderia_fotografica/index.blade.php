@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Consumibles
                </h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-2">
                    <div class="toolbar d-flex p-4">
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Año</label>
                            <select class="form-control" id="anio" name="anio" onchange="Lista_Requerimientos_Prendas();">
                                @for ($year = date('Y'); $year >= 1990; $year--) <!-- Invertir el orden -->
                                <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label class="control-label text-bold">Mes</label>
                            <select class="form-control" id="mesi" name="mesi" onchange="Lista_Requerimientos_Prendas();">
                                <option value="0">Seleccione</option>
                                @foreach ([
                                ['cod_mes' => '01', 'nom_mes' => 'Enero'],
                                ['cod_mes' => '02', 'nom_mes' => 'Febrero'],
                                ['cod_mes' => '03', 'nom_mes' => 'Marzo'],
                                ['cod_mes' => '04', 'nom_mes' => 'Abril'],
                                ['cod_mes' => '05', 'nom_mes' => 'Mayo'],
                                ['cod_mes' => '06', 'nom_mes' => 'Junio'],
                                ['cod_mes' => '07', 'nom_mes' => 'Julio'],
                                ['cod_mes' => '08', 'nom_mes' => 'Agosto'],
                                ['cod_mes' => '09', 'nom_mes' => 'Septiembre'],
                                ['cod_mes' => '10', 'nom_mes' => 'Octubre'],
                                ['cod_mes' => '11', 'nom_mes' => 'Noviembre'],
                                ['cod_mes' => '12', 'nom_mes' => 'Diciembre']
                                ] as $list)
                                <option value="{{ $list['cod_mes'] }}" {{ date('m') == $list['cod_mes'] ? 'selected' : '' }}>
                                    {{ $list['nom_mes'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_requerimiento_prendas">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#logisticas").addClass('active');
        $("#hlogisticas").attr('aria-expanded', 'true');
        $("#mercaderiafotografia").addClass('active');

        Lista_Requerimientos_Prendas();
    });

    function Lista_Requerimientos_Prendas() {
        Cargando();

        // Obtener el mes y año desde los elementos del HTML
        var mes = $('#mesi').val(); // Asegúrate de que este ID coincide con tu select de mes
        var anio = $('#anio').val(); // Asegúrate de que este ID coincide con tu select de año

        var url = "{{ route('mercaderiafotografia.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            data: {
                mes: mes,
                anio: anio
            },
            success: function(resp) {
                $('#lista_requerimiento_prendas').html(resp);
            }
        });
    }



    function Delete_Consumible(id) {
        Cargando();

        var url = "{{ route('consumible.destroy', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro consumible?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Requerimientos_Prendas();
                        });
                    }
                });
            }
        })
    }
</script>

@endsection