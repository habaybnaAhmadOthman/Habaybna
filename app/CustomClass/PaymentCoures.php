<?php

namespace app\CustomClass;
use Illuminate\Support\Facades\Http;


use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class PaymentCoures {

    public function execute(array $data)
    {
        try {
            $back_url = url('/api/course-payment-callback');
                
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
                $parameters['ResponseBackURL'] = $back_url;
                $parameters["ThemeID"] = "1000000001";
                $parameters["TransactionID"] = $transactionId;
                $parameters["Version"] = "1.0";
                //fill some optional parameters

                //Create an Ordered String of The Parameters Map with Secret Key

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

}

