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
                $SECRET_KEY = "NGIyNTQzOTc2ZTkxZGFhZDFlMjhjMTNk"; // Use Yours, Please Store
                        // Your Secret Key in safe Place(e.g. database)
                // put the parameters in a array to have the parameters to have them sorted
                        //alphabetically via ksort.
                        $transactionId = (int)microtime(true)*1000; //output to be like: 1495004320389
                $parameters = [];
                // fill required parameters
                $parameters["TransactionID"] = $transactionId;
                $parameters["MerchantID"] = "2000000103";
                $parameters["Amount"] = "2000";
                $parameters["CurrencyISOCode"] = "400";
                $parameters["MessageID"] = "1";
                $parameters["Quantity"] = "1";
                $parameters["Channel"] = "0";
                // $parameters["PaymentMethod"] = "1";
                //  $parameters["ClientIPaddress"] = "127.0.0.1";
                //for Card Payment (conditional;paymentMethod=1)
                // $parameters["CardNumber"] = "4508750015741019";
                // $parameters["ExpiryDateYear"] = "2021";
                // $parameters["ExpiryDateMonth"] = "05";
                // $parameters["SecurityCode"] = "100";
                // $parameters["CardHolderName"] = "1";
                //for Sadad Payment (conditional;paymentMethod=2)
                //$parameters["SadadOlpId"] = "testSadad";
                //$parameters["mfu"] = "https://MerchantSite/RedirectPaymentRequestPage";

                //fill some optional parameters
                $parameters["Language"] = "en";
                $parameters["ThemeID"] = "1000000001";
                $parameters['ResponseBackURL'] = "https://MerchantSite/RedirectPaymentResponsePage";
                $parameters["Version"] = "1.0";
                //Create an Ordered String of The Parameters Map with Secret Key
                $parameters["RedirectURL"] = "http://SmartrouteURL/SmartRoutePaymentWEB/SRPayMsgHandler";
                ksort($parameters);
                $orderedString = $SECRET_KEY;
                foreach($parameters as  $k=>$param){
                $orderedString .= $param;
                }

                // echo ("orderdString ". $orderedString);
                // Generate SecureHash with SHA256
                // Using DigestUtils from appache.commons.codes.jar Library
                $secureHash = hash('sha256', $orderedString, false);
                $parameters["secureHash"] = $secureHash;

                 session(['SmartRouteParams' => $parameters]);
                 $data = [session()->all()];
                return $data;
                // $response = Http::asForm()->post('https://srstaging.stspayone.com/SmartRoutePaymentWeb/SRPayMsgHandler', [
                //         'MerchantID' => $parameters["MerchantID"],
                //         'Amount' => $parameters["Amount"],
                //         // 'CurrencyISOCode' => $parameters["CurrencyISOCode"],
                //         'currencyCode' => $parameters["CurrencyISOCode"],
                //         'Language' => $parameters["Language"],
                //         'MessageID' => $parameters["MessageID"],
                //         'TransactionID' => $parameters["TransactionID"],
                //         'ThemeID' => $parameters["ThemeID"],
                //         'ResponseBackURL' => 'https://test.habaybna.ps',
                //         'Quantity' => $parameters["Quantity"],
                //         'Channel' => $parameters["Channel"],
                //         'Version' => $parameters["Version"],
                //         'SecureHash' => $secureHash,

                // $response = Http::get('https://jsonplaceholder.typicode.com/posts');
                    // dd(session()->all());
                //     ]);
                // return redirect()->to('https://srstaging.stspayone.com/SmartRoutePaymentWeb/SRPayMsgHandler',header('Access-Control-Allow-Origin: *'))->send();
                    // return redirect()->to('http://www.google.com')
                                // ->with('MerchantID' , $parameters["MerchantID"])
                                // ->with('Amount' , $parameters["Amount"])
                                // ->with('currencyCode' , $parameters["CurrencyISOCode"])
                                // ->with('Language' , $parameters["Language"])
                                // ->with('MessageID' , $parameters["MessageID"])
                                // ->with('TransactionID' , $parameters["TransactionID"])
                                // ->with('ThemeID' , $parameters["ThemeID"])
                                // ->with('ResponseBackURL' , 'https://test.habaybna.ps')
                                // ->with('Quantity' , $parameters["Quantity"])
                                // ->with('Channel' , $parameters["Channel"])
                                // ->with('Version' , $parameters["Version"])
                                // ->with('SecureHash' , $secureHash);
;
                // $response = Http::post('http://test.com/users', [
                //     'name' => 'Steve',
                //     'role' => 'Network Administrator',
                // ]);
                // dd($response);

                //////////////
                  //in the response, if the received status code was “20002” it needs Sadad
                //authentication,
                 //and after Authentication, you will send APIApprove Request to SmartRoute.

                //  $requestQueryArr = [
                // "TransactionID" => $transactionId,
                // "MerchantID" => "2000000103",
                // "Amount" => "2000",
                // "CurrencyISOCode" => "400",
                // "MessageID" => "2",
                // "Quantity" => "1",
                //  "Channel" => "0",
                // "PaymentMethod" => "1",
                // "ClientIPaddress" => "127.0.0.1",
                // //for Card Payment (conditional.append("&")paymentMethod=1)
                // "CardNumber" => "4508750015741019",
                // "ExpiryDateYear" => "2021",
                // "ExpiryDateMonth" => "05",
                // "SecurityCode" => "100",
                // // "CardHolderName" => "1",
                // "SecureHash" => $secureHash,

                // //for Sadad Payment (conditional.append("&")paymentMethod=2)
                // // "SadadOlpId" => "testSadad",
                // // "mfu" => "https://MerchantSite/RedirectPaymentRequestPage",
                // //fill some optional parameters
                // "Language" => "en",
                // "ThemeID" => "1000000001",
                // "Version" => "1.0",
                // "SecureHash" => $secureHash,
                // ];
                //configure query string
                // $newRequestQuery = http_build_query($requestQueryArr);
                // //Send the request
                // $ch = curl_init("https://srstaging.stspayone.com/SmartRoutePaymentWeb/SRMsgHandler");
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch,CURLOPT_POST, true);
                // curl_setopt($ch,CURLOPT_POSTFIELDS, $newRequestQuery);

                // Get the response
                // $output = curl_exec($ch);
                // curl_close($ch);

                //Output the response
                // echo ('output  '.$output);
                // this string is formatted as a "Query String" -
                //name=value&name2=value2.......

                // To read the output string you might want to split it
                // on '&' to get pairs then on '=' to get name and value using parse_str then
                // order it using ksort
                // $result = [];
                // parse_str($output, $result);
                // ksort($result);
                // dd($result);
                // Now that we have the map, order it to generate secure hash and compare it
                //with the received one
                // $responseOrderdString = $SECRET_KEY;
                // foreach($result as $resParam) {
                // $responseOrderdString .= $resParam;
                // }
                // echo "Response Orderd String is " . $responseOrderdString;
                // Generate SecureHash with SHA256
                // $generatedsecureHash = hash('sha256',$responseOrderdString);
                // get the received secure hash from result map
                // $receivedSecurehash = $result['Response.SecureHash'];
                // if($receivedSecurehash !== $generatedsecureHash){
                //IF they are not equal then the response shall not be accepted
                // echo ("Received Secure Hash does not Equal generated Secure hash");
                ////////////////////////
                // complete the Action get other parameters from result map and do
                //your processes
                // please refer to The Integration Manual to See The List of The
                //Received Parameters
                // $status= $result["Response.Status"];
                // echo ("Status is :". $status);
                // if("20002" == $status) {
                // $responseEstn = $result["Response.estn"];
                // $responseMfu = $result["Response.mfu"];
                // $responseAuthenticationUrl = $result["Response.AuthenticationU
                // RL"];
                // $_SESSION["responseEstn"] = $responseEstn;
                // $_SESSION["responseMfu"] = $responseMfu;
                // $_SESSION["responseAuthenticationUrl"] = $responseAuthenticationUrl;
                // // header("location: AuthenticateSadad.php");
                // // exit();
                // }else {
                // // then the card is not 3ds enrolled
                // // this means your payment has been completed
                // echo ("Status is :". $status);
                // }
                // }

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}

