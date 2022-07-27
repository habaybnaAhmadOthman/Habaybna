<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Testimonials;

class TestimonialsController extends Controller
{
    public function index()
    {
        $testimonials = Testimonials::paginate(15);
        return response($testimonials,200);
    }

    public function create(Request $request)
    {
        $testimonials = new Testimonials ();

        $testimonials->content = $request->content ;
        $testimonials->order = $request->order ;
        $testimonials->status = $request->status ;
        $testimonials->type = $request->type ;

        $testimonials->save() ;

        return response($testimonials,200);
    }

    public function update($id)
    {
        $testimonial = Testimonials::findorfail($id);

        return response($testimonial,200);
    }

    public function edit(Request $request)
    {
        $testimonial = Testimonials::findorfail($request->id);
        $testimonial->content = $request->content ;
        $testimonial->order = $request->order ;
        $testimonial->status = $request->status ;
        $testimonial->type = $request->type ;

        $testimonial->save() ;
        return response($testimonial,200);

    }

    public function getTestimonials($type)
    {
       $data =  Testimonials::where('type',$type)->paginate(5);

       return response($data,200);
    }

    public function delete($id)
    {
        $testimonial = Testimonials::findorfail($id);
        $testimonial->delete();

        return response('success',200);

    }
}
