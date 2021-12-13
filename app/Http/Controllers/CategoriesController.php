<?php

namespace App\Http\Controllers;

use App\CourseCategory;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::select('id','title')->get();
        if($categories){
            return response()->json(
                $categories
            ,200);
        }
        return response()->json([
            'msg'=>'faild'
        ],204);
    }
}
