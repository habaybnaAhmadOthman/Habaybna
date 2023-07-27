<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sbuscribe;
use Carbon\Carbon;
use Stevebauman\Location\Facades\Location;

class SbuscribeController extends Controller
{
    public function index()
    {
        return Sbuscribe::orderBy('id','DESC')->paginate(10);
    }
    public function store(Request $request)
    {
        try {

            $subscriber = new Sbuscribe();

            $subscriber->name = $request->name;
            $subscriber->email = $request->email;
            $subscriber->phone = $request->phone;
            $subscriber->transactionID = (int)microtime(true)*1000; //output to be like: 1495004320389
            $subscriber->country = $this->getUserCountry(request()->ip());
            $subscriber->save();

            $back_url = url('/api/payment/subscribe');
                //Step 1: Generate Secure Hash
            $SECRET_KEY = config('appconfig.stssecret'); // Use Yours, Please Store
                        // Your Secret Key in safe Place(e.g. database)
                // put the parameters in a array to have the parameters to have them sorted
                        //alphabetically via ksort.


            //   $initOrder = $this->createInitOrder($data, $transactionId);
                $parameters = [];
                // fill required parameters
                $parameters["Amount"] =$request->info['amount'];
                $parameters["Channel"] = "0";
                $parameters["CurrencyISOCode"] = $request->info['currency']; // for uae
                $parameters["Language"] = "en";
                $parameters["MerchantID"] = config('appconfig.stsmerchantid');
                $parameters["MessageID"] = "1";
                $parameters['PaymentDescription']='subscriber';
                $parameters["Quantity"] = "1";
                $parameters['ResponseBackURL'] = $back_url;
                $parameters["ThemeID"] = "1000000001";
                $parameters["TransactionID"] = $subscriber->transactionID;
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
                //  $data = [session()->all()];
                return response($parameters, 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function subscribPaymentCallback(Request $request)
    {
        $subscriber = Sbuscribe::where('transactionID',$request->Response_TransactionID)->first();

        if($subscriber) {
            $subscriber->status = $request->Response_StatusCode == "00000" ? true : false ;
            $subscriber->card_holder_name = $request->Response_CardHolderName;
            $subscriber->card_number = $request->Response_CardNumber;
            $subscriber->amount = $request->Response_Amount;
            $subscriber->secure_hash = $request->Response_SecureHash;
            $subscriber->approval_code = $request->Response_ApprovalCode ;

            if($request->Response_StatusCode == "00000") {
                $subscriber->start_at = Carbon::now()->toDateTimeString();
            }

            $subscriber->save();
        }


        return redirect()->to('subscribe-status')->send();


    }
    public function checkPaymentStatus()

    {
        $params = session('SmartRouteParams');
        $order = Sbuscribe::where('transactionID',$params['TransactionID'])->first();
        $status = $order->status ? 'success' : 'faild';
        return response($status,
        200
       );
    }

    private function getUserCountry($ip)
    {
        return serialize(Location::get($ip));
        
    }
}
