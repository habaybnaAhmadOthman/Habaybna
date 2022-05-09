<?php

namespace app\CustomClass;
use Illuminate\Support\Facades\Http;
use App\Courses;
use App\Coursespurchaseorders;
use App\PromoCode;
use App\User;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;
use Session;
class JoinFreeCourse {


    public function execute ($data)
    {
        try {

            $course = Courses::findorfail($data['courseID']);
        } catch (\Throwable $th) {
            throw $th;
        }
            // store initial order data
            $initData = new Coursespurchaseorders () ;

            $initData->user_id = Auth::id();
            $initData->course_id = $course->id;
            $initData->status = true;  // not complete change to true when payment complete success
            $initData->price = 0 ;
            $initData->transactionID = (int)microtime(true)*1000 ;
            $initData->amount = 0 ;

            $initData->save();
            // }

            return $initData;
    }

    public function completeOrder($data)
    {
        // try {
        //     $order = Coursespurchaseorders::where('transactionID',$data['Response_TransactionID'] )->first();
        //     $user = User::findorfail($order->user_id);
        //     Auth::login($user);

        // } catch (\Throwable $th) {
        //         throw $th;
        //     }

        // complete order
        // $SECRET_KEY = "NGIyNTQzOTc2ZTkxZGFhZDFlMjhjMTNk"; // Use Yours, Please Store
        // $parameterNames = isset($data)?array_keys($data):[] ;
        // $responseParameters = [];
        // foreach($parameterNames as $paramName){
        //     $responseParameters[$paramName] = filter_input(INPUT_POST,$paramName);
        // }
        // ksort($responseParameters);
        // $orderedString = $SECRET_KEY;
        // foreach($responseParameters as $k=>$param){
        // $orderedString .= $param;
        // }
        // $secureHash = hash('sha256', $orderedString, false);
        // if($data['Response_SecureHash'] !== $secureHash){
        //  dd ("Received Secure Hash does not Equal generated Secure hash");
        // }
        //     else{
        // dd('accepted');
        //}

        // $order->status = $data['Response_StatusCode'] == "00000" ? true : false;
        // $order->status_description = $data['Response_StatusDescription'];
        // $order->card_holder_name = $data['Response_CardHolderName'];
        // $order->card_expiry_date = $data['Response_CardExpiryDate'];
        // $order->card_number = $data['Response_CardNumber'];
        // $order->approval_code = $data['Response_ApprovalCode'];
        // $order->secure_hash = $data['Response_SecureHash'];
        // $order->approval_code = $data['Response_ApprovalCode'];
        // $order->approval_code = $data['Response_ApprovalCode'];

        // $order->save();


        if(isset($order->coupon_id) && $order->coupon_id !==""){
            $coupon = PromoCode::findorfail($order->coupon_id);
            $coupon->increment('usage_count');
            $coupon->save();
        }

        // return redirect()->to('payment-success')->send();



    }




}
