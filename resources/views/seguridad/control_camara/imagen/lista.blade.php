@foreach ($list_archivo as $list)
    <div class="card text-center" style="width: 18rem;">
        <img src="{{ $list->archivo }}" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">{{ $list->titulo }}</h5>
            <p class="card-text">{{ $list->fecha }}</p>
            <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#ModalUpdate" 
            app_elim="{{ route('control_camara_img.show', $list->id) }}">Detalles</a>
        </div>
    </div>
@endforeach