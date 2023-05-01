<?php

namespace App\Http\Controllers;

use App\BirthdayGift;
use App\ContactUs;
use App\CourseCategory;
use App\SearchKeyWord;
use App\Courses;
use App\User;
use Illuminate\Http\Request;
// use App\Http\Controllers\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Stevebauman\Location\Facades\Location;
use App\Providers\VerifyUser;
use Illuminate\Support\Facades\Hash;
use App\NewContent;
use App\Specialist;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');+
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getUserCountry(Request $request)
    {
        // request()->ip() ::: 37.220.117.144
        try {
            $position = Location::get(request()->ip());
            return response()->json([
                'msg'=>'success',
                'status'=>true,
                'data'=>$position,
            ]);

           } catch (ModelNotFoundException $e){
            return response()->json([
                'msg'=>'faild',
                'status'=>false,
                404
           ]);
       }
    }

    public function ckUploadImages(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            // $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename = str_replace(' ', '', pathinfo($filenamewithextension, PATHINFO_FILENAME));

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;

            //Upload File
            $request->file('upload')->storeAs('public/images/media/', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/images/media/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            // @header('Content-type: text/html; charset=utf-8');
            return response([$url] ,200);
        }
    }

    public function forgetPassword (Request $request) {
        if($request->mobileNumber && $request->mobileNumber != ""){
            $user = User::where('phone',$request->mobileNumber)->first();
                if($user){
                    $user->otp = random_int(100000, 999999);
                    $user->save();
                    event(new VerifyUser($user->phone, $user->otp,$msg=" رمز تحقق إعادة كلمة المرور هو"));

                    return response($user->phone,200);

                }
                return response('invalidPhoneNumber',403);

        }
        return response('invalidPhoneNumber',403);

    }

    public function checkForgetPassword (Request $request) {

        if($request->mobileNumber && $request->mobileNumber != ""){
            $user = User::where('phone',$request->mobileNumber)->first();
                if($user){
                    if($user->otp == $request->otp){
                        $user->is_verify = 1 ;
                        $user->save() ;
                        return response($user->phone,200);
                    }
                    return response('invalidOtp',403);
                }

        }
        return response('invalidOtp',403);

    }

    public function changePassword (Request $request) {

        if($request->mobileNumber && $request->mobileNumber != ""){
            $user = User::where('phone',$request->mobileNumber)->first();
                if($user && $user->is_verify){
                    $user->password = Hash::make($request->password) ;
                    $user->save() ;
                    return response($user->phone,200);
                }

                return response('notVerify',403);
        }
        return response('invalidPhoneNumber',403);

    }

    public function sendGift(Request $request)
    {
        try {

            $gift = new BirthdayGift();

            $gift->firstName = $request->first;
            $gift->lastName = $request->last;
            $gift->email = $request->email;
            $gift->show_in_list = $request->showinList;
            $gift->msg = $request->msg;
            $gift->transactionID = (int)microtime(true)*1000; //output to be like: 1495004320389
            $gift->amount = $request->amount;
            $gift->save();

            $back_url = url('/api/payment/gift');
                //Step 1: Generate Secure Hash
            $SECRET_KEY = config('appconfig.stssecret'); // Use Yours, Please Store
                        // Your Secret Key in safe Place(e.g. database)
                // put the parameters in a array to have the parameters to have them sorted
                        //alphabetically via ksort.


            //   $initOrder = $this->createInitOrder($data, $transactionId);
                $parameters = [];
                // fill required parameters
                $parameters["Amount"] =$request->amount * 1000;
                $parameters["Channel"] = "0";
                $parameters["CurrencyISOCode"] = "400";
                $parameters["Language"] = "en";
                $parameters["MerchantID"] = config('appconfig.stsmerchantid');
                $parameters["MessageID"] = "1";
                $parameters['PaymentDescription']='Aziz-birthday';
                $parameters["Quantity"] = "1";
                $parameters['ResponseBackURL'] = $back_url;
                $parameters["ThemeID"] = "1000000001";
                $parameters["TransactionID"] = $gift->transactionID;
                $parameters["Version"] = "1.0";
                //fill some optional parameters
                //Create an Ordered String of The Parameters Map with Secret Key
                // echo $transactionId;
                ksort($parameters);
                $orderedString = $SECRET_KEY;
                foreach($parameters as  $k=>$param){
                $orderedString .= $param;
                }
                $secureHash = hash('sha256', $orderedString, false);
                $parameters["RedirectURL"] = config('appconfig.stsredirecturl');
                $parameters["secureHash"] = $secureHash;
                 session(['SmartRouteParams' => $parameters]);
                 $data = [session()->all()];
                return response($data, 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function giftPaymentCallback(Request $request)
    {
        $giftOrder = BirthdayGift::where('transactionID',$request->Response_TransactionID)->first();

        if($giftOrder) {
            $giftOrder->status = $request->Response_StatusCode == "00000" ? true : false ;
            $giftOrder->card_holder_name = $request->Response_CardHolderName;
            $giftOrder->card_number = $request->Response_CardNumber;
            $giftOrder->card_expiry_date = $request->Response_CardExpiryDate;

            $giftOrder->save();
        }

        return redirect()->to('gift-payment-status')->send();

    }
    public function checkGiftStatus()
    {
        $params = session('SmartRouteParams');
        $order = BirthdayGift::where('transactionID',$params['TransactionID'])->first();
        $status = $order->status ? 'success' : 'faild';
        return response($status,
        200
       );
    }

    public function getGifts(Request $request)
    {
        if($request->success && $request->success !=null){
            $giftsOrders = BirthdayGift::where('status',1)
            ->where('show_in_list',1)
            ->get(['firstName','lastName','amount','msg']);
            return response($giftsOrders, 200);
        }

            $giftsOrders = BirthdayGift::all();
        return response($giftsOrders, 200);
    }
    public function getSearchResults(Request $request)
    {
        if($request->keyWord)
        {
            // dd([config('appconfig.mailerliteapikey'),config('appconfig.stssecret')]);
            $data['showMoreArticles'] = DB::table('course_categories')

                                            ->where('course_categories.title','LIKE','%' . $request->keyWord .'%')
                                            ->join('articles_tags','course_categories.id','=','articles_tags.tag_id')
                                            ->join('contents', function($join) {
                                                $join->on('contents.id','=','articles_tags.article_id')
                                                ->where('contents.status', '=', 1);
                                            })
                                            ->select('contents.*')
                                            ->paginate(20);
                                            $data['showMoreCourses'] = DB::table('course_categories')

                                            ->where('course_categories.title','LIKE','%' . $request->keyWord .'%')
                                            ->join('category_courses','course_categories.id','=','category_courses.cat_id')
                                            ->join('courses', function($join){
                                                $join->on('courses.id','=','category_courses.course_id')
                                                ->where('courses.is_publish', '=' , 1);
                                            }

                                            )
                                            ->select('courses.*')
                                            ->paginate(20);




            // articles
            $data['articles'] = NewContent::with('author')
                                ->where([
                                            ['title','LIKE','%' . $request->keyWord .'%'],
                                            ['status','=','1'],

                                        ]
                                )
                                ->orWhere([['content','like','%'. $request->keyWord .'%'],['status','=','1']])
                                -> paginate(20);

                // courses

                $data['courses'] = Courses::where('courseTitle','like','%'. $request->keyWord .'%')->orWhere('courseDescription','like','%'. $request->keyWord .'%')
                ->where('is_publish',1)
                ->paginate(20);

                                $callers = DB::table('specialists')
                                            ->where('make_calls',1)
                                            ->where(function ($q) use($request)
                                                {
                                                    $q->where('specialists.firstName','like','%'.$request->keyWord.'%')
                                                      ->orWhere('specialists.lastName', 'like', '%'.$request->keyWord.'%');

                                                })
                                            ->get();

                                $writers = DB::table('specialists')
                                ->where(function ($q) use($request)
                                {
                                    $q->where('specialists.firstName','like','%'.$request->keyWord.'%')
                                      ->orWhere('specialists.lastName', 'like', '%'.$request->keyWord.'%');

                                })
                                                ->join('contents', 'specialists.user_id', '=', 'contents.author_id')
                                                ->select('specialists.*')
                                                ->distinct()
                                                ->get();
                                $teachers = DB::table('specialists')
                                ->where(function ($q) use($request)
                                {
                                    $q->where('specialists.firstName','like','%'.$request->keyWord.'%')
                                      ->orWhere('specialists.lastName', 'like', '%'.$request->keyWord.'%');

                                })
                                                ->join('course_specialists', 'specialists.user_id', '=', 'course_specialists.specialist_id')
                                                ->select('specialists.*')
                                                ->distinct()
                                                ->get();
                                                $data['specialists'] = $callers->union($writers)->union($teachers);


            $keyWord =  SearchKeyWord::where('key_word',$request->keyWord)->first();

            if(!$keyWord) {
                $keyWord = new SearchKeyWord();
                $keyWord->key_word = $request->keyWord ;
                // $keyWord->user_id = $request->keyWord ;
                $keyWord->count = 1;
            }
            else {
                $keyWord->count = ++$keyWord->count ;
            }
                $keyWord->save();
            return response($data, 200);

        }
    }







}
