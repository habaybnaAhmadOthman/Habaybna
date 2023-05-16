<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validat;
use Illuminate\Support\Facades\Validator;
use App\Specialist;
use App\Events\NewPost;
use App\Events\NewComment;


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

        event(new NewPost());
        // $pushNotifications = new \Pusher\PushNotifications\PushNotifications(array(
        //     "instanceId" => "ec559eac-30e5-473c-8414-adabb00c204e",
        //     "secretKey" => "2BDF11FE0671710DBAD88E52F2C96CB0E7D8BAB0ABC5F25DBF61404CAC1DBEC8",
        //   ));
        //   $publishResponse = $pushNotifications->publishToInterests(
        //     ["newpost"],
        //     [
        //                       "apns" => [
        //         "aps" => [
        //           "alert" => "Hello!",
        //         ],
        //       ],

        //       "web" => [
        //         "notification" => [
        //           "title" => "منشور جديد!",
        //           "body" => "لقد قام احد المستخدمين باضافة منشور",
        //           "deep_link"=> "https://www.pusher.com"
        //         ],
        //         "data" => [
        //             "name" => "adam",
        //             "type" => "user",
        //         ],
        //       ],
        //     ]
        //   );

        //   dd($pushNotifications);
        //   dd("Published with Publish ID: " . $publishResponse->publishId . "\n");
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
        // broadcast(new NewComment($post->user))->toOthers();


        event(new NewComment($post->id, $post->user_id));
        // NewComment::dispatch($post->id);



        $pushNotifications = new \Pusher\PushNotifications\PushNotifications(array(
            "instanceId" => "ec559eac-30e5-473c-8414-adabb00c204e",
            "secretKey" => "2BDF11FE0671710DBAD88E52F2C96CB0E7D8BAB0ABC5F25DBF61404CAC1DBEC8",
          ));
        //   $publishResponse = $pushNotifications->publishToInterests(
        //     ["newcomment"],
        //     [
        //       "apns" => [
        //         "aps" => [
        //           "alert" => "Hello!",
        //         ],
        //       ],
        //       "web" => [
        //         "notification" => [
        //           "title" => "تعليق  جديد!",
        //           "body" => "لقد قام احد المختصين باضافة تعلق",
        //           "deep_link"=> "https://www.pusher.com"
        //         ],
        //         "data" => [
        //             "name" => "adam",
        //             "type" => "user",
        //         ],
        //       ],
        //     ]
        //   );
        return response($post, 200);

       } catch (\Throwable $th) {
           throw $th;
       }

        // $post = Post::with(['user','comments'])->where('id',$data->id);
        // return response($post->first(), 200);
    }

    public function deleteComment(Post $post)
    {
        $comment = $post->comments->where('id',request()->id)->first();

        if($comment->user_id == Auth::id() || Auth::user()->role == 'admin'){

            $comment->delete();

            return response($post, 200) ;
        }
        return response($post, 404) ;
    }

    public function deletePost(Post $post)
    {


        if($post->user_id == Auth::id() || Auth::user()->role == 'admin'){

            $post->delete();

            return response('success', 200) ;
        }
        return response('faild', 404) ;
    }

    public function adminIndex()
    {
    //     $posts = Post::with(['comments',function($q){
    //         dd($q->get());
    //         // $q->withoutGlobalScopes();
    //     }])->get();
        // dd(Post::with('comments')->withoutGlobalScopes()->get());

        // dd(Post::latest()->get());
        return response(Post::latest()->get(), 200);
    }

    public function changeCommentStatus()
    {
        // $comment = $post->comments->where('id',request()->id)->first();
        $comment = Comment::findOrFail( request()->id );


        if($comment){

            $comment->status = !$comment->status;
            $comment->save();

            return response('success', 200) ;
        }
        return response('faild', 404) ;
    }

    public function specialistPermesion()
    {
        if($specialist = Specialist::where('user_id', request()->id)->first()){
            $specialist->can_make_comments = !$specialist->can_make_comments ;
            $specialist->save();

            return response('success', 200);
        }
        return response('fail', 404);

    }


}
