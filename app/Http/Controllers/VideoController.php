<?php

namespace App\Http\Controllers;

use Carbon;
use App\Video;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class VideoController extends Controller
{
    protected $dates = ['created_at', 'updated_at'];
    public function createVideo()
    {
        return view('video.createVideo');
    }
    public function saveVideo(Request $request)
    {
        //validar formulario
        $validatedData = $this->validate($request, [
            'title' => 'required | min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);
        $video = new Video();
        $user = \Auth::user();
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');
        //upload da imagem
        $image = $request->file('image');

        if ($image) {
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }
        //upload do video
        $video_file = $request->file('video');

        if ($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }

        $video->save();
        return redirect()->route('home')->with([
            'message' => 'O upload do video foi feito com sucesso.'
        ]);
    }
    public function getImage($filename)
    {
        $file = Storage::disk('images')->get($filename);
        return new Response($file, 200);
    }
    public function getVideoDetail($video_id)
    {
        $video = Video::find($video_id);
        return view('video.detail', [
            'video'=> $video
        ]);
    }
    public function getVideo($filename)
    {
        $file = Storage::disk('videos')->get($filename);
        return new Response($file, 200);
    }
    public function delete($video_id)
    {
        $user = \Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();

        if ($user && $video->user_id == $user->id) {
            //eliminar comments
            if ($comments && count($comments) >=1) {
                $comments->delete();
            }

            //eliminar imagens
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);
            //eliminar registro
            $video->delete();
            $message = ['message'=>'Vídeo eliminado!'];
        } else {
            $message = ['message'=>'Vídeo NÂO FOI ELIMINADO!'];
        }
        return redirect()->route('home')->with($message);
    }
    public function edit($video_id)
    {
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        if ($user && $video->user_id == $user->id) {
            return view('video.edit', ['video'=>$video]);
        } else {
            return redirect()->route('home');
        }
    }
    public function update(Request $request, $video_id)
    {
        $validatedData = $this->validate($request, [
            'title' => 'required | min:5',
            'description' => 'required',
            'video' => 'mimes:mp4'
        ]);
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        $video->user->id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //upload da imagem
        $image = $request->file('image');

        if ($image) {
            $image_path = time().$image->getClientOriginalName();
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }
        //upload do video
        $video_file = $request->file('video');

        if ($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }
        $video->update();
        return redirect()->route('home')->with(['message'=>'O vídeo foi atualizado!']);
    }
    public function search($search = null)
    {
        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->paginate(5);//procura por: comeeeeeça c qq coisa + $search e termina com qq coisa
        if (is_null($search)) {
            $search = \Request::get('search');
            return redirect()->route('videoSearch', ['search'=>$search]);
        }
        return view('video.search', [
            'videos'=>$videos,
            'search'=>$search
        ]);
    }
}
