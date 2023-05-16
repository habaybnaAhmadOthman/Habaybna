<?php

use Illuminate\Support\Facades\Broadcast;
use App\User;
use App\Post;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// Broadcast::channel('usernewcomment.{postId}',function($user, $postId){
//               return   $user->whereHas('specialist',function($query) {
//                     $query->where('can_make_comments', true);

//                     }) || Post::find($postId)->user_id === $user->id  ?  true : false ;


// });

