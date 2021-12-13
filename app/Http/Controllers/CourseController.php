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


class CourseController extends Controller
{
   public function index(Request $request)
   {
            $courses = Courses::select('id','courseTitle', 'category_id', 'price', 'is_publish', 'is_free')->get();
            $data=[];

            foreach ($courses as $one) {
                $data[] =[
                    'course_id' => $one->id,
                    'courseTitle' => $one->courseTitle,
                    'courseCategory' => $one->category_name,
                    'coursePrice' => $one->price,
                    'publish' => $one->is_publish ? 'Published' : 'Unpublished',
                    'free' => $one->is_free ? 'Free' : 'Paid',
                ];
            }
            return response()->json([
                'courses' => $data,
                'status'=>true,
            ],200);
   }

   public function create()
   {
    //    return view ('admin.courses.create',['categories'=>$categories]);
   }

   public function storeCourseInfo(Request $request)
   {
    //    dd($request->category);
       $course = new Courses();

       if ($request->hasFile('coverImage')) {
        $coverImage = $request->file('coverImage');
        $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
        $pathImg = $coverImage->storeAs('public/images/courseCoverImg', $imageName);

        }
        if ($request->hasFile('promoVideo')) {
            $promoVideo = $request->file('promoVideo');
            $videoName = 'coursePromoVideo' . '-' . $promoVideo->getClientOriginalName();
            $pathVid = $promoVideo->storeAs('public/videos/promoVideo', $videoName);
        }

       $course->courseTitle = $request->title;
       $course->courseDescription= $request->description;
    //    $course->category_id= $request->category;
       $course->whatWeLearn= $request->watWeLearn;
       $course->is_publish= $request->is_publish;
       $course->is_free= $request->is_free;
       $course->price= $request->price;
       $course->promo_video= $request->hasFile('promoVideo') ? $videoName : '';
       $course->cover_photo = $request->hasFile('coverImage') ? $imageName: '';

       $course->save();
       if($request->has('category')){
        $categories = explode( ',', $request->category );

        foreach ($categories as $one) {
            $categoryCourse = new CategoryCourse();
            $categoryCourse->course_id = $course->id;
            $categoryCourse->cat_id = $one;
            $categoryCourse->save();
        }
    }
    if($request->has('specialists')){
        $specialists = explode( ',', $request->specialists );
        foreach ($categories as $one) {
            $courseSpecialist = new CourseSpecialist();
            $courseSpecialist->course_id = $course->id;
            $courseSpecialist->specialist_id = $one;
            $courseSpecialist->save();
        }
    }
       return response([
           'msg'=>'success',
           'status'=>true,
           'course_id'=>$course->id,
           200
       ]);

       return response([
        'msg'=>'fail',
        'status'=>false,
        201
    ]);

   }

   public function UploadCourseVideo(Request $request)
   {


       $videoCourse = new CourseVideos();

       if ($request->hasFile('coverImage')) {
        $coverImage = $request->file('coverImage');
        $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
        $pathImg = $coverImage->storeAs('public/images/videoCoverImgs', $imageName);

        }
        if ($request->hasFile('video')) {
            $track = GetId3::fromUploadedFile($request->file('video'));
            $length = $track->getPlaytime();
            $video = $request->file('video');
            $videoName = 'courseVideo' . '-' . $video->getClientOriginalName();
            $pathVid = $video->storeAs('public/videos/courseVideos', $videoName);
        }



        $videoCourse->url= $request->hasFile('video') ? $videoName : '';
        $videoCourse->cover_image = $request->hasFile('coverImage') ? $imageName: '';
        $videoCourse->course_id= $request->course_id;
        $videoCourse->status= $request->is_publish;
        $videoCourse->description= $request->description;
        $videoCourse->title= $request->title ;
        $videoCourse->length= $length ;
        $videoCourse->save();
        if($videoCourse){
            $courseVideos = CourseVideos::where('course_id',$videoCourse->course_id)->get();

            return response([
                'msg'=>'success',
                'status'=>true,
                'videos'=>$courseVideos,
                200
            ]);
        }
        return response([
         'msg'=>'fail',
         'status'=>false,
         201
     ]);
    }

   public function getCoursesInitData()
   {
        $categories = CourseCategory::all()->where('status',1);
        $specialists = Specialist::all();
        $data = [];
        foreach ($specialists as  $specialist) {
            $specialist->user->toArray();
            $specialist->toArray();
            array_push($data,$specialist);
        }
               if(count($categories) > 0)
        return response()->json([
                'specialists'=>$specialists,
                'categories'=>$categories,
            'status'=>true,
            200
        ]);
        return response([
            'msg'=>'fail',
            'status'=>false,
        ],204);
   }

   public function getAllcourses()
   {
      $courses = Courses::with('videos')->get();
       if($courses){
        return response()->json([
            'courses' => $courses,
            'status'=>true,
            200
        ]);
       }
   }

   public function getCourseVideos($id)
   {
       try{
        $course = Courses::findOrFail($id);
        return response()->json([
             'msg'=>'success',
             'courseInfo'=>[
                 'title'=>$course->courseTitle,

             ],
             'count'=>$course->videos->count(),
             'videos'=>$course->videos ? $course->videos : [] ,
             'haveVideos'=>$course->videos->count() > 0 ? true : false
        ]);
    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404

       ]);
    }



   }

   public function getCourseAndVideos($id)
   {
       try{
        $course = Courses::findOrFail($id);
        return response()->json([
             'msg'=>'success',
             'course'=>$course,
             'count'=>$course->videos->count(),
            //  'videos'=>$course->videos ? $course->videos : [] ,
             'haveVideos'=>$course->videos->count() > 0 ? true : false
        ]);
    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404

       ]);
    }
   }

   public function updateVideo(Request $request, $id)
   {
       try{
        $video = CourseVideos::findOrFail($id);

        if ($request->hasFile('coverImage')) {
            Storage::delete('public/images/videoCoverImgs/'.$video->cover_image);
            $coverImage = $request->file('coverImage');
            $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/videoCoverImgs', $imageName);

            }
            if ($request->hasFile('video')) {
                Storage::delete('public/videos/courseVideos/'.$video->url);
                $nVideo = $request->file('video');
                $videoName = 'courseVideo' . '-' . $nVideo->getClientOriginalName();
                $pathVid = $nVideo->storeAs('public/videos/courseVideos', $videoName);
            }

            $video->url= $request->hasFile('video') ? $videoName :$video->url;
            $video->cover_image = $request->hasFile('coverImage') ? $imageName:$video->cover_image;
            $video->status= $request->is_publish;
            $video->description= $request->description;
            $video->title= $request->title ;
            $video->save();
        return response()->json([
             'msg'=>'success',
                200,
                'status'=>true
        ]);
    } catch (ModelNotFoundException $e){
        return response()->json([
            'msg'=>'faild',
            'status'=>false,
            404

       ]);
    }
   }

   public function getCoruseInfo($id)
   {

    try{
        $course = Courses::findOrFail($id);
        return response()->json([
             'msg'=>'success',
             'course'=>$course,
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

   public function updateCoruseInfo(Request $request, $id)
   {
    try{
        $course = Courses::findOrFail($id);

        if ($request->hasFile('coverImage')) {
            Storage::delete('public/images/courseCoverImg/'.$course->cover_image);

            $coverImage = $request->file('coverImage');
            $imageName = 'courseCoverImg' . '-' . $coverImage->getClientOriginalName();
            $pathImg = $coverImage->storeAs('public/images/courseCoverImg', $imageName);

            }
            if ($request->hasFile('promoVideo')) {
                Storage::delete('public/videos/promoVideo/'.$course->cover_image);
                $promoVideo = $request->file('promoVideo');
                $videoName = 'coursePromoVideo' . '-' . $promoVideo->getClientOriginalName();
                $pathVid = $promoVideo->storeAs('public/videos/promoVideo', $videoName);
            }

           $course->courseTitle = $request->title;
           $course->courseDescription= $request->description;
           $course->category_id= $request->category;
           $course->whatWeLearn= $request->watWeLearn;
           $course->is_publish= $request->is_publish;
           $course->is_free= $request->is_free;
           $course->price= $request->price;
           $course->promo_video= $request->hasFile('promoVideo') ? $videoName :$course->promo_video  ;
           $course->cover_photo = $request->hasFile('coverImage') ? $imageName :$course->cover_photo;

           $course->save();

        return response()->json([
             'msg'=>'success',
             'course'=>$course,
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

   public function storeQuestion(Request $request)
   {
    try{
        $course = Courses::findOrFail($request->course_id);
        $quiz = Quize::updateOrCreate([
            'course_id'=>$request->course_id
        ],
        [
              'title'=>$request->title,
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


   public function getQuiz($id)
   {


       try{
            $course = Courses::findorfail($id);

            $data = [];
            $data['course_title'] = $course->courseTitle;
            $data['quiz_title'] = $course->quiz->title;
            $question = $course->quiz->questions()->with('answers')->get();
            $data['quesiotns']=$question;

        return response()->json([
             'msg'=>'success',
             'status'=>true,
             $data,
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
   public function editAnswer(Request $request ,$id)
   {
       try {
        $q = Question::findorfail($id) ;
        foreach ($q->answers as $key) {
            if($key->id == $request->answerId)
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
        return response()->json([
            'msg'=>'success',
            'status'=>true,
            $answer,
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
}
