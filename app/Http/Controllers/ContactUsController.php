<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
   public function index()
   {
       $messages = ContactUs::all();
       return response($messages,200);
   }

   public function show($id)
   {
       $message = ContactUs::findorfail($id);
       $message->seen = true ;
       $message->save() ;
       return response($message,200);
   }

   public function xxx()
   {
    dd('xxx');
    //    $count = ContactUs::all();
    //    dd($count);
   }
}
