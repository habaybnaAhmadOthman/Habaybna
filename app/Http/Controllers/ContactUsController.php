<?php

namespace App\Http\Controllers;

use App\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
   public function index()
   {
       $messages = ContactUs::orderBy('id', 'DESC')->paginate(15);
       return response($messages,200);
   }

   public function show($id)
   {
       $message = ContactUs::findorfail($id);
       $message->seen = true ;
       $message->save();
       return response($message,200);
   }

   public function contactUs(Request $request)
   {
       $message = new ContactUs() ;

       $message->name = $request->name ;
       $message->email = $request->email ;
       $message->message = $request->message ;

       $message->save();
       return response('success',200);
   }

   public function delete($id)
   {
       $msg = ContactUs::findorfail($id);
    $msg->delete();

    return response(200);
   }
}
