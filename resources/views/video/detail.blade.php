@extends('layouts.app')

@section('content')
    <div class="col-md-10 col-md-offset-2">
        <h2>{{ $video->title }}</h2>
        <hr>
        <div class="col-md-8">
            {{-- video --}}
            <video controls id="video-player">
                <source src="{{ route('fileVideo', ['filename' => $video->video_path]) }}">
                Seu navegador é uma bosta!
            </video>
            {{-- description --}}
            <div class="panel panel-default video-data">
                <div class="panel-heading">
                    <div class="panel-title">
                        Upload por <strong><a href="{{ route('channel', ['user_id'=>$video->user->id]) }}">{{ $video->user->name.' '.$video->user->surname }}</a> </strong> {{ $video->created_at->diffForHumans() }}
                    </div>
                </div>
                <div class="panel-body">
                    {{ $video->description }}
                </div>
            </div>
            {{-- comments --}}
                @include('video.comments')
        </div>
    </div>
@endsection

