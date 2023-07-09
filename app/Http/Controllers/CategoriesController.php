<?php

namespace App\Http\Controllers;

use App\CourseCategory;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = CourseCategory::select('id','title')->get()->toArray();
        if($categories){
            return response()->json(
                $categories
            ,200);
        }
        return response()->json([
            'msg'=>'faild'
        ],204);
    }

    public function getSelectedCategories()
    {
        $selectedCategories = CourseCategory::whereIn('id',[5, 6, 7, 8, 9, 10, 11, 12, 18 ])->select('id','title')->get()->toArray();
        if($selectedCategories){
            return response()->json(
                $selectedCategories
            ,200);
        }
        return response()->json([
            'msg'=>'faild'
        ],204);
    }
}
