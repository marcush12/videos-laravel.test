<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'body'=>'required'
        ]);
        //criar um objeto
        $comment = new Comment();
        $user = \Auth::user();
        $comment->user_id = $user->id;//user_id id do user
        $comment->video_id = $request->input('video_id');//veio por post
        $comment->body = $request->input('body');

        $comment->save();
        return redirect()->route('detailVideo', ['video_id'=>$comment->video_id])->with([
            'message'=>'Comentário adicionado!'//tem q ser message em inglês
        ]);
    }
    public function delete($comment_id)
    {
        $user = \Auth::user();
        $comment = Comment::find($comment_id);
        if ($user && ($comment->user_id == $user->id || $comment->video->user_id == $user->id)) {
            $comment->delete();
        }
        return redirect()->route('detailVideo', ['video_id'=>$comment->video_id])->with([
            'message'=>'Comentário eliminado!'//tem q ser message em inglês
        ]);
    }
}
