<div class="modal-header">
    <h5 class="modal-title">Opciones:</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>
            
<div class="modal-body" style="max-height:700px; overflow:auto;">
    <div class="row">
        <table class="table" style="width:100%">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Alternativa</th>
                    <th>Respuesta correcta</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($list_opcion as $list)
                    <tr class="text-center">
                        <td>{{ $i }}</td>
                        <td class="text-left">{{ $list->opcion }}</td>
                        <td>
                            @if ($list->respuesta=="1")
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                            @endif
                        </td>
                    </tr>
                @php $i++; @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>
