<?php

namespace app\CustomClass;
use Illuminate\Support\Facades\Http;
use App\Courses;
use App\Coursespurchaseorders;
use App\PromoCode;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class PaymentCoures {

    public function execute(array $data)
    {

        try {

            // session(['SmartRouteParams' => $parameters]);

            $data['hasPromoCode']['id'] = '22'; // sent from zalum
            // $initData = $this->createInitOrder($data);


            $back_url = url('/api/payment/course');

                //Step 1: Generate Secure Hash
                $SECRET_KEY = "NGIyNTQzOTc2ZTkxZGFhZDFlMjhjMTNk"; // Use Yours, Please Store
                        // Your Secret Key in safe Place(e.g. database)
                // put the parameters in a array to have the parameters to have them sorted
                        //alphabetically via ksort.
                $transactionId = (int)microtime(true)*1000; //output to be like: 1495004320389
                $parameters = [];
                // fill required parameters
                $parameters["Amount"] = "2000";
                $parameters["Channel"] = "0";
                $parameters["CurrencyISOCode"] = "400";
                $parameters["Language"] = "en";
                $parameters["MerchantID"] = "2000000103";
                $parameters["MessageID"] = "1";
                $parameters['PaymentDescription']='coursepayment';
                $parameters["Quantity"] = "1";
                $parameters['ResponseBackURL'] = 'http://localhost:8000/api/payment/course';
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
                $initData = $this->createInitOrder($data,$parameters['TransactionID']);

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

            // store initial order data
            $initData = new Coursespurchaseorders () ;

            $initData->user_id = Auth::id();
            $initData->course_id = $data['courseID'];
            $initData->status = false;  // not complete change to true when payment complete success
            $initData->price = $course->price ;
            $initData->transactionID = $tranID ;
            $initData->save();

                // check hasPromoCode
            if($data['hasPromoCode'] !== ""){

                $promoCode = PromoCode::findorfail($data['hasPromoCode']['id']);
                $disscountAmount = $course->price * $promoCode->discount_percentage/100 ;
                $newPrice = $course->price - $disscountAmount ;

                $initData->coupon_id = $promoCode->id;
                $initData->discount_amount = $disscountAmount;
                $initData->new_price = $newPrice;
                $initData->amount = $newPrice;

                $initData->save();
            }
            else {
                $initData->amount = $course->price;

                $initData->save();
            }
            return $initData;
        } catch (\Throwable $th) {
            // throw $th->getMessage();
        }
    }



}
