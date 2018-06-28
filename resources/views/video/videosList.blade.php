<div id="videos-list">
    @if (count($videos) >= 1)
        @foreach($videos as $video)
            <div class="video-item col-md-10 pull-left panel panel-default">
                <div class="panel-body">
                    <!--img do video-->
                @if(Storage::disk('images')->has($video->image))
                    <div class="video-image-thumb  col-md-3 pull-left">
                        <div class="video-image-mask">
                            <img src="{{ url('/miniatura/'. $video->image) }}" class='video-image' alt="">
                        </div>
                    </div>
                @endif
                <div class="data">
                    <h4 class='video-title'><a href="{{ route('detailVideo', ['video_id' => $video->id]) }}">{{ $video->title }}</a></h4 class='video-title'>
                    <p>{{ $video->user->name.' '.$video->user->surname }}</p>
                </div>
                <!--botões para ações-->
                <a href="{{route('detailVideo', ['video_id' => $video->id])}}" class="btn btn-success">Ver</a>
                @if(Auth::check() && Auth::user()->id == $video->user->id)
                    <a href="{{route('videoEdit', ['video_id' => $video->id])}}" class="btn btn-warning">Editar</a>

                    <a href="#victorModal{{$video->id}}" role="button" class="btn btn-primary" data-toggle="modal">Eliminar</a>

                    <!-- Modal / Ventana / Overlay en HTML -->
                    <div id="victorModal{{$video->id}}" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Tem certeza?</h4>
                                </div>
                                <div class="modal-body">
                                    <p>Tem certeza que quer eliminar este vídeo?</p>
                                    <p class="text-warning"><small>{{$video->title}}</small></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                    <a href="{{url('/delete-video/'. $video->id)}}" type="button" class="btn btn-danger">Eliminar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning">Não há vídeos no momento.</div>
    @endif
    <div class='clearfix'></div>
    {{ $videos->links() }}
</div>
