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
class PaymentCoures {

    public function execute(array $data)
    {
        try {
            $back_url = url('/api/payment/course');
                //Step 1: Generate Secure Hash
            $SECRET_KEY = "NGIyNTQzOTc2ZTkxZGFhZDFlMjhjMTNk"; // Use Yours, Please Store
                        // Your Secret Key in safe Place(e.g. database)
                // put the parameters in a array to have the parameters to have them sorted
                        //alphabetically via ksort.
            do{
                $transactionId = (int)microtime(true)*1000; //output to be like: 1495004320389
                $transIdExist = Coursespurchaseorders::where('transactionID', $transactionId)->first();
            } while ($transIdExist);

              $initOrder = $this->createInitOrder($data, $transactionId);
                $parameters = [];
                // fill required parameters
                $parameters["Amount"] =$initOrder->amount * 1000 ;
                $parameters["Channel"] = "0";
                $parameters["CurrencyISOCode"] = "400";
                $parameters["Language"] = "en";
                $parameters["MerchantID"] = "2000000103";
                $parameters["MessageID"] = "1";
                $parameters['PaymentDescription']='coursepayment';
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
                $parameters["RedirectURL"] = "https://srstaging.stspayone.com/SmartRoutePaymentWeb/SRPayMsgHandler";
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

            $course = Courses::findorfail($data['courseID']);
        } catch (\Throwable $th) {
            throw $th;
        }
            // store initial order data
            $initData = new Coursespurchaseorders () ;

            $initData->user_id = Auth::id();
            $initData->course_id = $course->id;
            $initData->status = false;  // not complete change to true when payment complete success
            $initData->price = $course->price ;
            $initData->transactionID = $tranID ;
            $initData->save();
                // check hasPromoCode
            if(array_key_exists('id',$data['hasPromoCode']) && isset($data['hasPromoCode']['id']) ){
                $promoCode = PromoCode::findorfail($data['hasPromoCode']['id']);
                $disscountAmount = $course->price * $promoCode->discount_percentage/100 ;
                $newPrice = $course->price - $disscountAmount ;
                $initData->coupon_id = $promoCode->id;
                $initData->discount_amount = $disscountAmount;
                $initData->new_price = $newPrice;
                $initData->amount = $newPrice ;

                $initData->save();
            }
            else {
                $initData->amount = $course->price;

                $initData->save();
            }
            return $initData;
    }

    public function completeOrder($data)
    {
        try {
            $order = Coursespurchaseorders::where('transactionID',$data['Response_TransactionID'] )->first();
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
        $order->approval_code = $data['Response_ApprovalCode'];
        $order->secure_hash = $data['Response_SecureHash'];
        $order->approval_code = $data['Response_ApprovalCode'];
        $order->approval_code = $data['Response_ApprovalCode'];

        $order->save();

        if(!$order->status){
            return redirect()->to('payment-success')->send();
        }
        if(isset($order->coupon_id) && $order->coupon_id !==""){
            $coupon = PromoCode::findorfail($order->coupon_id);
            $coupon->increment('usage_count');
            $coupon->save();
        }

        return redirect()->to('payment-success')->send();



    }




}
