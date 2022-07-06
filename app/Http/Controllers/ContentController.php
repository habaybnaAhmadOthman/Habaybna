<?php

namespace App\Http\Controllers;
use App\CustomClass\CreateContent;
use App\CustomClass\UpdateContent;
use Illuminate\Http\Request;
use App\Content;
use App\NewContent;

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

      $contents = Content::paginate(15);
        return response()->json($contents);
   }
   public function indexNew()
   {

      $contents = NewContent::with('intrests','author')->orderBy('id', 'DESC')->paginate(15);

        return response()->json($contents);
   }

   public function update(Request $request, $id)
   {
    $content = Content::findorfail($id);
    return response()->json($content);


   }
   public function updateNew($id)
   {
    $content = NewContent::with('intrests','author')->findorfail($id);

    return response()->json($content);
   }

   public function edit(Request $request, $id)
   {
    $content = Content::findorfail($id);
    return response()->json($content);

   }

   public function showArticle(Request $request)
   {
       $article = NewContent::where('title',$request->title)->first();
       if($article){
           return response($article,200);
       }
       return response('notFound',404);

   }


   public function editNew(Request $request, UpdateContent $updateContent )
   {
       $content = $updateContent->execute($request->all());
       return response()->json($content, 200);
   }

   public function deleteNew($id)
   {
       $content = NewContent::findorfail($id);
       $content->delete();
   }




   private function authorData($author)
   {
        if($author !== null)
            $user = \App\User::findorfail($author);
            if($user->user_data  !== null)
            return $user->user_data->firstName . " " . $user->user_data->lastName;
                // return $user->user_data->firstName . " " .$user->user_data['lastName'];
   }

   public function getIndexNew()
   {

      $contents = NewContent::with('intrests','author')->orderBy('id', 'DESC')->paginate(15);

        return response()->json($contents);
   }

}
