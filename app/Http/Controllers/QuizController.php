<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Courses;
use App\Specialist;
use App\Quize;
use App\CourseCategory;
use App\CourseVideos;
use App\CourseSpecialist;
use App\CategoryCourse;
use App\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Owenoj\LaravelGetId3\GetId3;


class QuizController extends Controller
{
    public function getCourseQuiz($id)
    {

        try{
             $course = Courses::findorfail($id);

             $data = [];
             $data['course_title'] = $course->courseTitle;
             $data['quiz_title'] = $course->quiz? $course->quiz->title:null;
             $question = $course->quiz ?
                $course->quiz->questions()->with('answers')->get()
                :null;
            //  $question = $course->quiz->questions()->with('answers')->get();
             $data['quiz']=$question;

         return response()->json(
              $data,
              200
         );
     } catch (ModelNotFoundException $e){
         return response()->json([
             'msg'=>'faild',
             'status'=>false,
             404

        ]);
     }
    }

    public function editAnswer(Request $request ,$id)
   {
       try {
        $q = Question::findorfail($id) ;
        foreach ($q->answers as $key) {
            if($key->id == $request->answer_id)
              {
                  $answer = $key ;
                  $key->is_correct = true;
                  $key->save();
              }
              else{
                  $key->is_correct = false;
                  $key->save();

              }
        }
        return response()->json(

            $answer,
            200
       );
       } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404

       ]);

   }


}
public function deleteQuestion($id)
{
    try {
     $q = Question::findorfail($id) ;
        $q->delete();
     return response()->json(

         200
    );
    } catch (ModelNotFoundException $e){
     return response()->json([
         'msg'=>'faild',
         'status'=>false,
         404

    ]);

}
}
}
