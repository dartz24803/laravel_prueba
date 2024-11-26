<div class="modal-header">
    <h5 class="modal-title">Ver suceso:</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<div class="modal-body" style="max-height:700px; overflow:auto;">
    <div class="row">
        <div class="form-group col-lg-2">
            <label>Suceso: </label>
        </div>
        <div class="form-group col-lg-10">
            <textarea class="form-control" rows="4" placeholder="Ingresar suceso"
            >{{ $get_id->nom_suceso }}</textarea>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>