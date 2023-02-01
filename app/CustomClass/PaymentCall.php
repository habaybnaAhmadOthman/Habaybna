<?php

namespace app\CustomClass;

use App\AppointmentChildInfo;
use Illuminate\Support\Facades\Http;
use App\PromoCode;
use App\CallPurchaseOrders;
use App\UsersPromoCode;
use App\CallsAppointments;
use App\CallsStatus;
use App\Specialist;
use App\User;
use App\SpecialistZoomAccount;
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
                $parameters["Amount"] = isset($initOrder->amount) ?  $initOrder->amount * 100 : 0 ;
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
                if($initOrder['Amount'] == 0) {
                    $parameters['slug'] = $initOrder['slug'];
                    $parameters["appointment_id"] = $initOrder['appointment_id'];
                 }
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
            $initData->price = 54 ;
            $initData->status = false;  // not complete change to true when payment complete success
            $initData->save();

                // check hasPromoCode


            if(array_key_exists('id',$data['hasPromoCode']) && isset($data['hasPromoCode']['id']) ){
                $promoCode = PromoCode::findorfail($data['hasPromoCode']['id']);

                // $disscountAmount = $course->price * $promoCode->discount_percentage/100 ;
                $disscountAmount = 54 * $promoCode->discount_percentage/100 ;
                $newPrice = 54 - $disscountAmount ;

                $initData->coupon_id = $promoCode->id;
                $initData->discount_amount = $disscountAmount;
                $initData->amount = $newPrice;

                $initData->save();
                if($promoCode->type =='free')
                   return $this->completeOrderFree ($initData) ;
            }
            else {
                $initData->amount = 54;

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

            // coupon increments
            if(isset($order->coupon_id) && $order->coupon_id !==""){
                $coupon = PromoCode::findorfail($order->coupon_id);
                $coupon->increment('usage_count');
                $coupon->save();

                $userPromoCode = new UsersPromoCode() ;
                $userPromoCode->order_id = $order->id ;
                $userPromoCode->user_id = $order->user_id ;
                $userPromoCode->coupon_id = $order->coupon_id ;
                $userPromoCode->usage = 'Call' ;
                $userPromoCode->call_package_id = $order->specialist_id ;

                $userPromoCode->save();
            }

            //  call status //

            //  $table->enum('status', [0, 1, 2, 3]);
            //  0=> booked not happend yet ,
            //  1=> booked and happend ,
            //  2=>booked and not happend almost

            // specialist zoom link account

            $zoomAccount = SpecialistZoomAccount::where('spec_id',$order->specialist_id)->first();
            if($zoomAccount && isset($zoomAccount)) {

                $call_status = new CallsStatus() ;
                $call_status->appointment_id = $order->appointment_id ;
                $call_status->call_zoom_link = $zoomAccount->zoom_link ;
                $call_status->status = '0';

                $call_status->save();

                if(isset($call_status) ) {

                    // send sms to parent and specialist
                    $numbers = $call_status->callAppointment->Parnet->phone.','.$call_status->callAppointment->specialist->Phone ;
                    // $numbers = "+962795982977".','."+962792819107" ;
                    $msg ="تم إضافة رابط المكالمة إلى سجل المكالمات الخاص بك على موقع حبايبنا.نت";

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.releans.com/v2/batch",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "sender=Habaybna&mobile=".$numbers."&content=".$msg,
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Bearer ". config('appconfig.releanssecret')
                        ),
                    ));

                    $response = curl_exec($curl);


                    curl_close($curl);


                    // return response('success', 200);
                }

            }else{
                $call_status = new CallsStatus() ;
                    // $call_status->call_zoom_link = $zoomAccount->zoomLink ;
                    $call_status->appointment_id = $order->appointment_id ;
                    $call_status->status = '0';
                    $call_status->save();
                }


            $appChildInfo = new AppointmentChildInfo() ;

            $appChildInfo->appointment_id = $order->appointment_id ;
            $appChildInfo->save() ;

        }




        // dd($slug);
        // dd($order);

        return redirect()->to('call-payment-success')->send();



    }

    private function completeOrderFree($data)
    {
        try {
            $order = CallPurchaseOrders::findorfail($data->id );
        } catch (\Throwable $th) {
                throw $th;
            }

        $order->status = true;
        $order->status_description = "free code";
        $order->save();

        if($order->status){
            if(isset($order->coupon_id) && $order->coupon_id !==""){
                $coupon = PromoCode::findorfail($order->coupon_id);
                $coupon->increment('usage_count');
                $coupon->save();

                $userPromoCode = new UsersPromoCode() ;
                $userPromoCode->order_id = $order->id ;
                $userPromoCode->user_id = $order->user_id ;
                $userPromoCode->coupon_id = $order->coupon_id ;
                $userPromoCode->usage = 'Call' ;
                $userPromoCode->call_package_id = $order->specialist_id ;
                $userPromoCode->save();

            }

            //  call status //

            //  $table->enum('status', [0, 1, 2, 3]);
            //  0=> booked not happend yet ,
            //  1=> booked and happend ,
            //  2=>booked and not happend almost

            // specialist zoom link account
            $zoomAccount = SpecialistZoomAccount::where('spec_id',$order->specialist_id)->first();

            if($zoomAccount && isset($zoomAccount)) {

                $call_status = new CallsStatus() ;
                $call_status->appointment_id = $order->appointment_id ;
                $call_status->call_zoom_link = $zoomAccount->zoom_link ;
                $call_status->status = '0';

                $call_status->save();

                if(isset($call_status) ) {


                    // send sms to parent and specialist
                    $numbers = $call_status->callAppointment->Parnet->phone.','.$call_status->callAppointment->specialist->Phone ;
                    // $numbers = "+962795982977".','."+962792819107" ;
                    $msg ="تم إضافة رابط المكالمة إلى سجل المكالمات الخاص بك على موقع حبايبنا.نت";

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.releans.com/v2/batch",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "sender=Habaybna&mobile=".$numbers."&content=".$msg,
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Bearer ". config('appconfig.releanssecret')
                        ),
                    ));

                    $response = curl_exec($curl);


                    curl_close($curl);


                    // return response('success', 200);
                }

            }else{
                $call_status = new CallsStatus() ;
                    $call_status->appointment_id = $order->appointment_id ;
                    $call_status->status = '0';
                    $call_status->save();
                }

            $appChildInfo = new AppointmentChildInfo() ;

            $appChildInfo->appointment_id = $order->appointment_id ;
            $appChildInfo->save() ;

        }

        $specialist  = Specialist::where('user_id',$order->specialist_id)->first();
        $slug = $specialist->firstName ? $specialist->firstName.'-' : false;
        $slug = $specialist->lastName ? $slug.$specialist->lastName.'--'.$specialist->user_id : $slug.'--'.$specialist->user_id;

        $dataF['slug'] = $slug;

        $dataF['appointment_id'] = $order->appointment_id ;
        $dataF['status'] = 'success' ;
        $dataF["Amount"] =$order->amount * 100 ;



        if ($order && $order->status) {
            if($specialist && $specialist != null) {

                return
                    $dataF;
            }
        }

    }


}
