<?php

namespace App\Http\Controllers;

use Carbon;
use App\User;
use App\Video;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function channel($user_id)
    {
        $user = User::find($user_id);
        if (!is_object($user)) {//não existe o usuario
            return redirect()->route('home');
        }
        $videos = Video::where('user_id', $user_id)->paginate(5);
        return view('user.channel', [
            'user'=>$user,
            'videos'=>$videos
        ]);
    }
}
