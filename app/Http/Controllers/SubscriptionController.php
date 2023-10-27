<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Subscription;
use Mail;
use App\EmailTemplate;
use App\Customer;
use App\Mail\SubscriptionMailable;
use App\User,View,Session,Redirect;
use Lang;

class SubscriptionController extends Controller
{
    public function subscription(Request $request,$email)
    {
        $check = Subscription::where('email',$email)->first();
        if($check == null)
        {
            	$subscription = new Subscription;
            	//dd($subscription);

            	$subscription->email = $email;
            	// $subscription->date = "11-3-2019";

            	$subscription->save();

            	//$template = EmailTemplate::where('type', 'send-mail-to-subbscribed-customers')->first();

               // Mail::to($email)->send(new SubscriptionMailable($template));

        	  return response()->json([
            'success' => Lang::get('footer.thankYouForYourSubscription'),
            ]);
        }else{
            return response()->json([
            'success' => Lang::get('footer.alreadySubscribe'),
            ]);
        }
    }

    public function changeLanguage($locale)
    {
        \Session::put('locale', $locale);
       /*  $language = Language::select('id','language_title','language_code')->where('language_code',$locale)->first();
        \Session::put('language', ['id'=>$language->id,'language_title'=>$language->language_title,'language_code'=>$language->language_code]);  */
        return redirect()->back();
    }

    public function unSubscribe()
    { 
        // dd('here');
      return View::make('Customers.unsubscribe');
    }

    public function unSubscribeEmail(Request $request)
    {
        // dd($request->all());
        $check = Subscription::where('email',$request->customer_email_address)->first();
        if($check != null)
        {
            $check->delete();
            return redirect()->back()->with('msg','Email Unsubscribed Successfully !!!');
        }else{

            return redirect()->back()->with('error','Email Not Found !!!');
        }

        
    }

}
