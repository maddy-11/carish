<?php

namespace App\Http\Controllers\Customers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords; 
use Input;
use App\User,View,Session,Redirect;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Validator;

class PasswordController extends Controller
{
    

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/customers';

    public function __construct()
    {
        $this->middleware('guest:customer');
    }

    
    public function showLinkRequestForm()
    { 
      // dd('here');
      return View::make('Customers.email');
    } 

//-------------------------Reference taken---------------------
         /* https://laracasts.com/discuss/channels/laravel/laravel-536-how-to-replace-password-reset-mail-with-custom-mailable-template?page=1
    http://muva.co.ke/blog/part-viii-admin-password-reset-in-our-multiple-authentication-system-for-laravel-5-4/*/

    public function postEmail(Request $request)
{
    $this->validate($request, ['customer_email_address' => 'required']);

    $response = $this->broker()->sendResetLink($request->only('customer_email_address'), function($message)
    { 
         $message->from('muhammadshakil.dev@gmail.com');
         $message->subject('Your Password Reset Link!');
    }); 
    switch ($response)
    {
        case PasswordBroker::RESET_LINK_SENT:
        return redirect()->back()->with('success', trans($response)); 

        case PasswordBroker::INVALID_USER:      
            return redirect()->back()->with('warning', trans($response))->withInput()->withErrors(['customer_email_address' => trans($response)]);
    }
}

    public function frontPostEmail(Request $request)
{
    $this->validate($request, ['customer_email_address' => 'required']);

     // Validate the form data 
     $validator =  Validator::make($request->all(), [
        'customer_email_address'   => 'required|email'
      ]); 

         if ($validator->fails()) {
        foreach ($validator->messages()->getMessages() as $field_name => $messages)
                {
                  foreach($messages AS $message) 
                         {
                          $arrayReturened = array('status'=>'error','message'=>$message); 
                         }
 
                }//end foreach
              }// end if
      else { 

    $response = $this->broker()->sendResetLink($request->only('customer_email_address'), function($message)
    { 
         $message->from('muhammadshakil.dev@gmail.com');
         $message->subject('Your Password Reset Link!');
    }); 
    switch ($response)
    {
        case PasswordBroker::RESET_LINK_SENT:
         $arrayReturened       = array('status'=>'success','message'=>trans($response)); 
         break; 
        
        case PasswordBroker::INVALID_USER:      
              $arrayReturened       = array('status'=>'error','message'=>trans($response)); 
              break;
    }

  }// end else

    return response()->json($arrayReturened);
}

    
 
   
    public function showResetForm(Request $request, $token = null) {
        return view('Customers.reset')
            ->with(['token' => $token, 'customer_email_address' => $request->customer_email_address]
            );
    }



 /**
    * Reset the given user's customer_password.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function postReset(Request $request)
   {
       $this->validate($request, [
           'token' => 'required',
           'customer_email_address' => 'required|email',
           'customer_password'      => 'required|confirmed',
       ]);

       $credentials = $request->only(
           'customer_email_address', 'customer_password', 'password_confirmation', 'token'
       );

       $response = $this->broker()->reset($credentials, function ($user, $customer_password) {
           $this->resetPassword($user, $customer_password);
       });

       switch ($response) {
           case Password::PASSWORD_RESET:
               return redirect($this->redirectPath());

           default:
               return redirect()->back()->withInput($request->only('customer_email_address'))
                           ->withErrors(['customer_email_address' => trans($response)]);
       }
   }

   /**
    * Reset the given user's customer_password.
    *
    * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
    * @param  string  $customer_password
    * @return void
    */
   protected function resetPassword($user, $customer_password)
   {
     
       $user->customer_password = bcrypt($customer_password);
       $user->save(); 
       Auth::guard('customer')->attempt(['customer_email_address' => $user->customer_email_address, 'customer_password' => $customer_password]);

       //Auth::login($user);
   }


    public function redirectPath()
   {
       if (property_exists($this, 'redirectPath')) {
           return $this->redirectPath;
       }

       return property_exists($this, 'redirectTo') ? $this->redirectTo : '/customers';
   }


 //defining which guard to use in our case, it's the customer guard
    protected function guard()
    {
        return Auth::guard('customer');
    }
    //defining our password broker function
    protected function broker() {
        return Password::broker('customers');
    } 





}
