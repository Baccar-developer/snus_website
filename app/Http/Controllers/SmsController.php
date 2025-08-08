<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

require_once "../vendor/autoload.php";


use Twilio\Rest\Client;




class SmsController extends Controller
{
    static  function sendSMS($tel , $body){
        $sid = getenv("TWILIO_SID");
        
        $token = getenv("TWILIO_TOCKEN");
        
        $sender = getenv("TWILIO_PHONE");
        
        $twilio = new Client($sid, $token);
        
        
        $message = $twilio->messages->create(
            
            $tel, // To
            
            [
                "body" =>$body,
                "from" => $sender,
            ]
            
            );
        
        
        print $message->body;
    }
}
