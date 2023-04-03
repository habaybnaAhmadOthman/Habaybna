<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validat;
use Illuminate\Support\Facades\Validator;

class CommunityController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user','comments'])->orderBy('id','desc')->paginate(10);

        return response($posts, 200);
    }

    public function storePost(Post $post)
    {
        $input = request()->all();
        $input['slug'] = date('ymdhmi',time()).rand(10,100).'-'.Auth::id();

        $validator = Validator::make($input,
        ['slug'    =>  'unique:posts,slug']
        );
        $input['user_id'] =Auth::id();
        $data = Post::create($input);
        $post = Post::with(['user','comments'])->where('id',$data->id);
        return response($post->first(), 200);
    }

    public function storeComment(Post $post)
    {


       try {

        $input = request()->all();
        $input['user_id'] = Auth::id();
        $input['status'] = true;

        $post->comments()->create($input);

        $post = Post::find($post->id);
        // dd($post);
        return response($post, 200);

       } catch (\Throwable $th) {
           throw $th;
       }

        // $post = Post::with(['user','comments'])->where('id',$data->id);
        // return response($post->first(), 200);
    }
}
