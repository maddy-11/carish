<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AdsNotification;

class AdNotificationController extends Controller
{
    public function notify(Request $request)
    {
       
      $notify = new AdsNotification;
      $notify->email = $request->email;
      $notify->type = $request->selectType;
      $notify->save();

      return redirect()->back()->with('successmsg','Ad notification added Successfuly');
      
    }
}
