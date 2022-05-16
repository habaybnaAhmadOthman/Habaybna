<?php

namespace App\Http\Controllers;
use App\CustomClass\CreateContent;
use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Auth;

class ContentController extends Controller
{
    public function create(Request $request, CreateContent $createContent )
    {
        $content = $createContent->execute($request->all());

        return response()->json($content, 200);
    }

   public function index()
   {


    // $contents = Content::where('article_type','Text');
    // foreach($contents as $content){
    //     if($content->image){
    //         $rest = substr($content->image, 39);  // returns "abcde"


    //         $newUrl = "http://localhost:8000/storage/media/".$rest;

    //         $content->image = $newUrl ;
    //         $content->save();
    //     }
    // }
    //     foreach($contents as $content){
    //     if($content->image){
    //         $rest = substr($content->image, 39);  // returns "abcde"

    //         $newUrl = "https://habaybna.net/storage/media/".$rest;

    //         $content->image = $newUrl ;
    //         $content->save();
    //     }
    // }
    // if(Auth::user() && Auth::user()->role != 'admin'){
    //     if(Auth::user()->articles->count() > 0){
    //     $contents = Content::with('userFavArticles')->paginate(15);
    //     // dd($contents);

    //     }

    // }
      $contents = Content::where('article_type','Video')->paginate(15);
        return response()->json($contents);
   }

   public function update(Request $request, $id)
   {
    $content = Content::findorfail($id);
    return response()->json($content);


   }
   public function edit(Request $request, $id)
   {
    $content = Content::findorfail($id);
    return response()->json($content);


   }

   public function showArticle(Request $request)
   {
       $article = Content::where('title',$request->title)->first();
       if($article){
           return response($article,200);
       }
       return response('notFound',404);

   }


}
