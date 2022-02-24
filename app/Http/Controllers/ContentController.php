<?php

namespace App\Http\Controllers;
use App\CustomClass\CreateContent;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function create(Request $request, CreateContent $createContent )
    {
        $content = $createContent->execute($request->all());

        return response()->json($content, 200);
    }

   public function index(Request $request)
   {
       dd('xxxxxxxx');
   }

   public function update(Request $request)
   {
       dd('xxxxxxxx');
   }


}
