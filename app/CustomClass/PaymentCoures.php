<?php

namespace app\CustomClass;
use Illuminate\Support\Facades\Http;


use phpDocumentor\Reflection\Types\Object_ as TypesObject_;
use PhpParser\Node\Expr\Cast\Object_;

class PaymentCoures {

    public function execute(array $data)
    {

        try {

                //Step 1: Generate Secure Hash
                $SECRET_KEY = "YmZlYjQzNDBmMGU3ZDcwZGRkM2I2ZTMx"; // Use Yours, Please Store
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
                $parameters["MerchantID"] = "2000000140";
                $parameters["MessageID"] = "1";
                $parameters["Quantity"] = "1";
                $parameters['ResponseBackURL'] = "http://localhost:8000";
                $parameters["TransactionID"] = $transactionId;
                $parameters["Version"] = "1.0";
                //fill some optional parameters
                $parameters["ThemeID"] = "1000000001";
                //Create an Ordered String of The Parameters Map with Secret Key
                // $parameters["RedirectURL"] = "http://SmartrouteURL/SmartRoutePaymentWEB/SRPayMsgHandler";

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

