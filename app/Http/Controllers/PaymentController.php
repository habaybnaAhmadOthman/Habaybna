<?php

namespace App\Http\Controllers;
use App\CustomClass\PaymentCoures;
use Illuminate\Database\Eloquent\ModelNotFoundException;



use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
{
   $this->middleware('isAdmin');
}
    public function coursePayment(Request $request,PaymentCoures $paymentCoures )
    {
        $data = $paymentCoures->execute($request->all());
        return response()->json($data);
    }
}