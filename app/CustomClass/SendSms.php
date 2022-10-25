<?php

namespace app\CustomClass;


use Carbon\Carbon;


class SendSms {

    public static function execute($phone, $otp, $msg)
    {
        try {
            if(!isset($msg) && $msg == null){

                $msg = "اهلا بك في منصة حبايبنا
                        رمز التحقق الخاص بك هو
                              
                ";
            }
            //           www.habaybna.net
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.releans.com/v2/message",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "sender=Habaybna&mobile=".$phone."&content=".$msg." (".$otp.")",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer ". config('appconfig.releanssecret')
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
