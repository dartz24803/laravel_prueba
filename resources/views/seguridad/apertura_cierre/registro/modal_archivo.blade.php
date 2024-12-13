<div class="modal-header">
    <h5 class="modal-title">Fotos {{ $get_id->cod_base }} - {{ $get_id->fecha_v }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>

<div class="modal-body" style="max-height:610px; overflow:auto;">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @php $i = 0; @endphp
            @foreach ($list_archivo as $list)
                <li data-target="#carouselExampleCaptions" data-slide-to="{{ $i }}" 
                @if ($i=="0") class="active" @endif></li>
                @php $i++; @endphp
            @endforeach
        </ol>
        <div class="carousel-inner">
            @php $i = 0; @endphp
            @foreach ($list_archivo as $list)
                <div class="carousel-item @php if($i=="0"){ echo 'active'; } @endphp">
                    <img class="d-block w-100" src="{{ $list->archivo }}">
                    <div class="carousel-caption d-none d-sm-block">
                        <h3 style="color: white;">{{ $list->titulo }}</h3>
                    </div>
                </div>
                @php $i++; @endphp
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>