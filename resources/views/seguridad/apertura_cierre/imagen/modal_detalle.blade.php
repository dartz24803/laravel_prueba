<div class="modal-header bg-primary">
    <h5 class="modal-title"></h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
    </button>
</div>

<div class="modal-body text-center" style="max-height:610px; overflow:auto;">
    <div class="mb-5 mt-5">
        <img id="foto_{{ $get_id->id }}" loading="lazy" class="img_post" src="{{ $get_id->archivo }}" alt="Evidencia" style="width: 22rem;">
    </div>
    <div class="row d-flex p-4 align-items-center">
        <div class="col-lg-4">
            <span class="badge badge-dark" style="font-size: 2rem; padding: 0.8rem">{{ $get_id->cod_base }}</span>
        </div>
        <div class="col-lg-4">
            <span>{{ $get_id->tipo_apertura }}</span><br>
            <span>{{ $get_id->fecha }}</span>
        </div>
        <div class="col-lg-4">
            <div class="d-flex justify-content-center align-items-center">
                <div class="form-check">
                    <button class="btn btn-warning" value="90" name="orientation" id="rotateButton">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>

<script>
    var rotationAngle_{{ $get_id->id }} = 0;

    document.getElementById("rotateButton").addEventListener("click", function() {
        rotationAngle_{{ $get_id->id }} += 90;
        document.getElementById('foto_' + {{ $get_id->id }}).style.transform = "rotate(" + rotationAngle_{{ $get_id->id }} + "deg)";
    });
    $(document).on("click", ".img_post", function () {
        window.open($(this).attr("src"), 'popUpWindow', "height=" + this.naturalHeight + ",width=" + this.naturalWidth + ",resizable=yes,toolbar=yes,menubar=no");
    });
</script>