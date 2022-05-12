<?php

namespace App\Http\Controllers;

use App\Content;
use App\UsersFavouriteArticles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;



use Illuminate\Http\Request;

class UsersFavouriteArticlesController extends Controller
{
    public function addToFavourite(Request $request)
    {
        try {
            $article = Content::findorfail($request->id) ;

            if($article)
            {
                if(UsersFavouriteArticles::where('user_id',Auth::id())
                                        ->where('article_id',$request->id)
                                        ->first())
                {
                    UsersFavouriteArticles::where('user_id',Auth::id())
                                        ->where('article_id',$request->articleID)->delete();

                    return response(
                                        UsersFavouriteArticles::where('user_id',Auth::id())->get()
                                        ,
                                        200
                                    );
                }

                $articleFav = UsersFavouriteArticles::create([
                   'user_id'=> Auth::id(),
                   'article_id'=> $request->id
                ]);

            }
            return response($articleFav,200);

        }catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
        ]);
        }

    }
}
