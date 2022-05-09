<?php

namespace App\Http\Controllers;
use App\CustomClass\PaymentCoures;
use App\CustomClass\JoinFreeCourse;
use App\CustomClass\GetCoursesOrders;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Coursespurchaseorders;
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

}
