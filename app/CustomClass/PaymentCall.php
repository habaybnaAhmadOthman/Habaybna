<?php

namespace app\CustomClass;

use App\AppointmentChildInfo;
use Illuminate\Support\Facades\Http;
use App\PromoCode;
use App\CallPurchaseOrders;
use App\CallsAppointments;
use App\CallsStatus;
use App\Specialist;
use App\User;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;
use Session;
use Illuminate\Http\Request;

class PaymentCall {

    public function execute(array $data)
    {

        try {
            $back_url = url('/api/payment/call');

                //Step 1: Generate Secure Hash
            $SECRET_KEY = config('appconfig.stssecret'); // Use Yours, Please Store
                        // Your Secret Key in safe Place(e.g. database)
                // put the parameters in a array to have the parameters to have them sorted
                        //alphabetically via ksort.
            do{
                $transactionId = (int)microtime(true)*1000; //output to be like: 1495004320389
                $transIdExist = CallPurchaseOrders::where('transaction_id', $transactionId)->first();
            } while ($transIdExist);

              $initOrder = $this->createInitOrder($data, $transactionId);
                $parameters = [];
                // fill required parameters
                $parameters["Amount"] =$initOrder->amount * 100 ;
                $parameters["Channel"] = "0";
                $parameters["CurrencyISOCode"] = "840";
                $parameters["Language"] = "en";
                $parameters["MerchantID"] = config('appconfig.stsmerchantid');
                $parameters["MessageID"] = "1";
                $parameters['PaymentDescription']='callpayment';
                $parameters["Quantity"] = "1";
                $parameters['ResponseBackURL'] = $back_url;
                $parameters["ThemeID"] = "1000000001";
                $parameters["TransactionID"] = $transactionId;
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
                return $data;

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    private function createInitOrder($data,$tranID)
    {

        try {

            $appointment = CallsAppointments::where('id',$data['appointmentID'])->first();
        } catch (\Throwable $th) {
            throw $th;
        }
            // store initial order data
            $initData = new CallPurchaseOrders () ;

            $initData->user_id = Auth::id();
            $initData->specialist_id = $appointment->specialist_id;
            $initData->appointment_id = $appointment->id;
            $initData->transaction_id = $tranID ;
            $initData->price = 45 ;
            $initData->status = false;  // not complete change to true when payment complete success
            $initData->save();

                // check hasPromoCode


            if(array_key_exists('id',$data['hasPromoCode']) && isset($data['hasPromoCode']['id']) ){
                $promoCode = PromoCode::findorfail($data['hasPromoCode']['id']);
                // $disscountAmount = $course->price * $promoCode->discount_percentage/100 ;
                $disscountAmount = 45 * $promoCode->discount_percentage/100 ;
                $newPrice = 45 - $disscountAmount ;

                $initData->coupon_id = $promoCode->id;
                $initData->discount_amount = $disscountAmount;
                $initData->amount = $newPrice;

                $initData->save();
            }
            else {
                $initData->amount = 45;

                $initData->save();
            }
            return $initData;
    }

    public function completeOrder($data)
    {
        try {
            $order = CallPurchaseOrders::where('transaction_id',$data['Response_TransactionID'] )->first();
            $user = User::findorfail($order->user_id);
            Auth::login($user);
        } catch (\Throwable $th) {
                throw $th;
            }

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

        $order->status = $data['Response_StatusCode'] == "00000" ? true : false;
        $order->status_description = $data['Response_StatusDescription'];
        $order->card_holder_name = $data['Response_CardHolderName'];
        $order->card_expiry_date = $data['Response_CardExpiryDate'];
        $order->card_number = $data['Response_CardNumber'];

        $order->save();

        if($order->status){
            if(isset($order->coupon_id) && $order->coupon_id !==""){
                $coupon = PromoCode::findorfail($order->coupon_id);
                $coupon->increment('usage_count');
                $coupon->save();
            }

            $call_status = new CallsStatus() ;

            $call_status->appointment_id = $order->appointment_id ;
            $call_status->status = '0';
            $call_status->save();

            $appChildInfo = new AppointmentChildInfo() ;

            $appChildInfo->appointment_id = $order->appointment_id ;
            $appChildInfo->save() ;

        }




        // dd($slug);
        // dd($order);

        return redirect()->to('call-payment-success')->send();



    }




}
