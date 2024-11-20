<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class PusherController extends Controller
{
    private $pusher;

    public function __construct()
    {
        $options = [
            'cluster' =>"us2",
            'useTLS' => true,
        ];

      
        $this->pusher = new Pusher(
            "45155196bf0ccbd4013a",
           "a259558be77c25891b52",
            "1897962",
            $options
        );
    }

    public function sendNotification(Request $request)
    {
        $data['message'] = $request->input('message');
        $this->pusher->trigger('my-channel', 'my-event', $data);
        return response()->json(['status' => 'Notification sent!']);
    }

    public function createEvent($mensaje)  {
        $data['message'] = $mensaje; 
        $this->pusher->trigger('my-channel', 'my-event', $data);
        return response()->json(['status' => 'Notification sent!']);
    }
}
