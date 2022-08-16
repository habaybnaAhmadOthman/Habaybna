<?php

namespace App\Http\Controllers;
use App\CustomClass\PaymentCoures;
use App\CustomClass\PaymentCall;
use App\CustomClass\GetUsersCourseProgress;
use App\CustomClass\JoinFreeCourse;
use App\CustomClass\GetCoursesOrders;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Coursespurchaseorders;
use App\CallPurchaseOrders;
use App\Specialist;
use App\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(GetCoursesOrders $getAllCoursesOrders)
    {

        $orders = $getAllCoursesOrders->execute();
        return response($orders, 200);
    }

    public function coursePayment(Request $request,PaymentCoures $paymentCoures )
    {
        $data = $paymentCoures->execute($request->all());
        return response()->json($data);
    }

    public function joinFreeCourse(Request $request,JoinFreeCourse $joinFreeCourse )
    {
        $data = $joinFreeCourse->execute($request->all());
        return response()->json($data);
    }

    public function coursePaymentCallback(Request $request, PaymentCoures $paymentCoures )
    {
        $data = $paymentCoures->completeOrder($request->all());

    }

    public function checkPaymentStatus(Request $request)
    {
        $params = session('SmartRouteParams');
        $order = Coursespurchaseorders::where('transactionID',$params['TransactionID'])->first();

        return response()->json(
        $order,
        200
       );
    }

    public function usersCourseProgress(GetUsersCourseProgress $getUsersCourseProgress)
    {
        $orders = $getUsersCourseProgress->execute();
        return response($orders, 200);
    }

    public function callPayment(Request $request,PaymentCall $paymentCall )
    {
        $data = $paymentCall->execute($request->all());
        return response()->json($data);
    }

    public function callPaymentCallback(Request $request, PaymentCall $paymentCall )
    {
        $data = $paymentCall->completeOrder($request->all());

    }

    public function checkCallPaymentStatus()
    {
        $params = session('SmartRouteParams');
        if($params && $params != "") {

            $order = CallPurchaseOrders::where('transaction_id',$params['TransactionID'])->first();
            $specialist  = Specialist::where('user_id',$order->specialist_id)->first();
            $slug = $specialist->firstName ? $specialist->firstName.'-' : false;
            $slug = $specialist->lastName ? $slug.$specialist->lastName.'--'.$specialist->user_id : $slug.'--'.$specialist->user_id;
            $data['slug'] = $slug;
            if ($order && $order->status) {
                if($specialist && $specialist != null) {

                    $data['appo_id'] = $order->appointment_id ;
                    $data['status'] = 'success' ;
                    return response(
                        $data,
                    200
                   );
                }
                
                return response(
                    $data,
                200
               );
            }
            $data['status']= 'faild';
            return response(
                $data,
                200
           );
        }
        return response(

            200
       );

    }


}
