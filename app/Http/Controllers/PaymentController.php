<?php

namespace App\Http\Controllers;
use App\CustomClass\PaymentCoures;
use Facade\FlareClient\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;




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
        dd($request);
    }
}
