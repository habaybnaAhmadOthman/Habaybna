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
use App\UsersQuiz;
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
public function changeQuestionStatus($id)
{
    try {
     $q = Question::findorfail($id) ;
        $q->status = !$q->status;
        $q->save();
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
public function storeQuestion(Request $request)
{
 try{
     $course = Courses::findOrFail($request->course_id);
     $quiz = Quize::updateOrCreate([
         'course_id'=>$request->course_id
     ],
     [
           'title'=>$course->courseTitle,
           'status'=>1
     ]);

     if($quiz){
         $question = $quiz->questions()->create([
             'quiz_id'=>$quiz->id,
             'title'=>$request->question,
             // 'point'=>5,
             'status'=>$request->status
         ]);
     }

     if($question){

         foreach ($request->answers as $answer) {
             $question->answers()->create([
                 'question_id'=>$question->id,
                 'title'=>$answer,
                 'is_correct'=>false,
             ]);
         }
     }
     // dd($question);
     return response()->json([
          'msg'=>'success',
          'question'=>$question->where('id',$question->id)->with('answers')->get(),
          'status'=>true,
          200
     ]);
 } catch (ModelNotFoundException $e){
     return response()->json([
         'msg'=>'faild',
         'status'=>false,
         404

    ]);
 }
}
public function setCorrectAnswer($id)
{


    try{
          $answer = Answer::findorfail($id);
          if($answer) {
             $answer->is_correct = true;
             $answer->save();
          }
     return response()->json([
          'msg'=>'success',
          'status'=>true,
          200
     ]);
 } catch (ModelNotFoundException $e){
     return response()->json([
         'msg'=>'faild',
         'status'=>false,
         404

    ]);
 }
}

    public function completeQuiz(Request $request)
    {
        $course = Courses::findorfail($request->courseID);
        if($course){
            if($course->quiz){
                $userQuiz = new UsersQuiz();

                $userQuiz->user_id = Auth::id();
                $userQuiz->course_id = $request->courseID;
                $userQuiz->quiz_id = $course->quiz->id;
                $userQuiz->is_complete =true;

                $userQuiz->save();

                return response(['is_complete'=>true],200);
            }
        }



    }

    public function getUserCourseQuiz(Request $request)
    {

        try{
             $course = Courses::findorfail($request->courseID);

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
}
