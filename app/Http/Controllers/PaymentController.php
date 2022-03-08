<?php

namespace App\Http\Controllers;
use App\CustomClass\PaymentCoures;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Coursespurchaseorders;
use App\User;




use Illuminate\Http\Request;

class PaymentController extends Controller
{
//     public function __construct()
// {
//    $this->middleware('isAdmin');
// }
    public function coursePayment(Request $request,PaymentCoures $paymentCoures )
    {
        $data = $paymentCoures->execute($request->all());
        return response()->json($data);
    }

    public function coursePaymentCallback(Request $request )
    {
        $this->storeData($request);
    }

    public function storeData($request)
    {
        $order = Coursespurchaseorders::where('transactionID',$request->Response_TransactionID )->first();
        $user = User::findorfail($order->user_id);
        Auth::login($user);
        session()->put('currentOrder', $order);
                return redirect()->to('payment-success')->send();
        // return redirect('payment-success');
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
