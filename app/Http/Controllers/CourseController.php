<?php

namespace App\Http\Controllers;
use App\Courses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
   public function index()
   {
       return view('admin.courses.index');
   }

   public function create()
   {
       dd('create course');
   }
}
