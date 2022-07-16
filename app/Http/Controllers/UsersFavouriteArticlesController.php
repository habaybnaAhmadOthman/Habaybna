<?php

namespace App\Http\Controllers;

use App\NewContent;
use App\UsersFavouriteArticles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;



use Illuminate\Http\Request;

class UsersFavouriteArticlesController extends Controller
{
    public function addToFavourite(Request $request)
    {
        try {

            if(NewContent::findorfail($request->id))
            {

                if(UsersFavouriteArticles::where('user_id',Auth::id())
                                        ->where('article_id',$request->id)
                                        ->first())
                {
                    UsersFavouriteArticles::where('user_id',Auth::id())
                                        ->where('article_id',$request->id)->delete();

                    return response(
                                        UsersFavouriteArticles::where('user_id',Auth::id())->get()
                                        ,
                                        200
                                    );
                }

                $articleFav =  new UsersFavouriteArticles ();
                $articleFav->user_id = Auth::id();
                $articleFav->article_id = $request->id;

                $articleFav->save() ;

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
