<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SMSNotificationController extends Controller
{
    public function __construct()
    {
    }

    public function sendSMSNotification($receiver = '237672517118')
    {
        $basic  = new \Vonage\Client\Credentials\Basic("686d3349", "bwSgLNLvg9P4Stpw");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($receiver, 'Tech Briva', 'A text message sent using the Nexmo SMS API')
        );
        
        $message = $response->current();

        return $message;
        
        // if ($message->getStatus() == 0) {
        //     echo "The message was sent successfully\n";
        // } else {
        //     echo "The message failed with status: " . $message->getStatus() . "\n";
        // }
    }
}
