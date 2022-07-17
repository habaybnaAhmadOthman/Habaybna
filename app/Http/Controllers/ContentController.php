<?php

namespace App\Http\Controllers;
use App\CustomClass\CreateContent;
use App\CustomClass\UpdateContent;
use Illuminate\Http\Request;
use App\Content;
use App\CourseSpecialist;
use App\NewContent;
use App\ArticlesTags;

use App\Specialist;
use App\User;
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
       $data['article'] = NewContent::with('intrests','author','isLiked')->where('title',$request->title)->first();

        // related contents
       foreach ($data['article']->intrests as $one) {
           $data['relatedArticle'][$one->id] =
            ArticlesTags::with('article')
            ->where('tag_id',$one->id)
            ->inRandomOrder()->limit(2)->get()
           ;
    }
       if($data['article']){
           return response($data,200);
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

      $contents = NewContent::with('intrests','author','isLiked')->orderBy('id', 'DESC')->paginate(15);

        return response()->json($contents);
   }

   public function getSpecialistData($slug)
   {

       $id = explode ("--", $slug);
        $courses = CourseSpecialist::where('specialist_id',$id[1])->with('course')->get();
        if($courses->count() > 0) {
            $data['specialist']['courses'] = $courses;
        }
        $article = NewContent::where('author_id',$id[1])->with('author')->get();

        if($article) {
            $data['specialist']['articles'] = $article ;
        }
        return response($data,200);

   }

//    public function addToFavourite(Request $request)
//    {
//        if(Auth::user()){
//             if(NewContent::findorfail($request->id)){
//                     dd(NewContent::findorfail($request->id));
//             }
//        }
//    }

    public function getUserLikedArticles()
    {
        return response(
            Auth::user()->articles()->with('articles')->paginate(6),
            200
        );
    }

    }
