<?php

namespace App\Http\Controllers\User;

 
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Contracts\Validation;
use App\User,View,Session,Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; 
use Illuminate\Foundation\Auth\RegistersUsers;       
use Illuminate\Support\Facades\Hash;
use Auth;
use Route;
use App\EmailTemplate;
use App\EmailTemplateDescription;
use App\Mail\RegisterUserEmail;
use Mail;
//Customer Model
use App\Models\Customers\Customer;
use App\Models\Customers\InvoiceSetting;
use App\Models\Language; 
use App\Models\SmsVerify;
use Socialite;
use Cookie;
use App\City;
class AuthController extends Controller
{
    /*
    https://laracasts.com/discuss/channels/laravel/laravel-55-multi-auth-not-working-the-way-i-want-devmarketer-tutorial?page=1
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */ 

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
     * @return void
     */

    //protected $redirectTo = '/account';
    protected $redirectAfterLogout = '/user/login';
    protected $redirectPath        = '/user'; 

    use RegistersUsers;         

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {

        $validator = Validator::make($data, [  
            'customer_email_address' => 'required|email|max:255|unique:customers',
            'customer_password'      => 'required|min:6',           
            'password_confirmation'  => 'required|same:customer_password'
        ]);

              return $validator;
    }

    /**
     * Handle a registration request for the application by using sentinel framework.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     public function login()
    {
         /* if (Sentinel::check()) {
          return redirect::to('customers');
      }*/ 
      return View::make('Customers.login');   
    } 

    /**
     * Handle a login request to the application by using sentinel framework.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postLogin(Request $request)
    {  
      // dd('here');
      // dd($request->all());
      // Validate the form data
      $this->validate($request, [
        'customer_email_address'   => 'required|email',
        'password'        => 'required|min:6'
      ]); 
      $customer = Customer::where('customer_email_address',$request->customer_email_address)->first();
      if(@$customer->customer_status == 'Inactive')
      {
        return redirect('/user/login')->with('not_verified',true);
      }

      if(@$customer->customer_role == 'business' && @$customer->is_adminverify == 0)
      {
        return redirect('/user/login')->with('business_email_verify',true);
      }


      // Attempt to log the user in
      if (Auth::guard('customer')->attempt(['customer_email_address' => $request->customer_email_address, 'password' => $request->password], $request->remember)) {
        // dd('hereee');
        // if successful, then redirect to their intended location
        // return redirect()->intended(route('customers.dashboard'));
        $active = Auth::guard('customer')->user()->customer_status;
      $language_id = Auth::guard('customer')->user()->language_id;
      $language    = Language::select('id', 'language_title', 'language_code')->where('id', $language_id)->first();
      \Session::put('language', ['id' => $language->id, 'language_title' => $language->language_title, 'language_code' => $language->language_code]);
      \Session::put('locale', $language->language_code);
        return redirect()->intended(route('my-ads'));
      }  
      // if unsuccessful, then redirect back to the login with the form data
       Session::flash('error', 'Invalid credentials');
      return redirect()->back()->withInput($request->only('customer_email_address', 'remember'));
    }

//https://stackoverflow.com/questions/39374472/laravel-how-can-i-change-the-default-auth-password-field-name?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa

    public function frontlogin(Request $request)
    { 
      // Validate the form data 
     $validator =  Validator::make($request->all(), [
        'customer_email_address'   => 'required|email',
        'password'                 => 'required|min:6'
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
      // Attempt to log the user in
       if (Auth::guard('customer')->attempt(['customer_email_address' => $request->customer_email_address, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        //return redirect()->intended(route('customer.dashboard'));
      $arrayReturened       = array('status'=>'success','message'=>'you have successfully loggedin.'); 
      } else $arrayReturened = array('status'=>'error','message'=>'Invalid username/password.'); 
      // if unsuccessful, then redirect back to the login with the form data

    }// end else

      return response()->json($arrayReturened);  
    }



       
    public function signup()
    { 
      $languages = Language::all();
      $cities = City::where('status',1)->get();
      return View::make('Customers.register',compact('languages','cities'));
    } 


  //Handles registration request for customer
    public function register(Request $request)       
    {
       // dd($request->all());
      $role = $request->customer_role;
      if(@$role == 'business'){
        $msg = 'business';
        $name = 'customer_company';
      }else{
        $msg = '';
        $name = 'full_name';
      }
       //Validates data
       $validator = $this->validator($request->all());

       if ($validator->fails()) {
          if(@$role == 'business'){
          return redirect()->back()->withErrors($validator)->withInput()->with('msg',$msg);
          }else{
          return redirect()->back()->withErrors($validator)->withInput();
          }
        }
        else { 
        $customer = $this->create($request->all());


        if($customer){
         $data = [
           'id' =>  $customer->id,
            'firstname' => $request->customer_firstname,
            'lastname' => $request->customer_lastname,
            'email' => $request->customer_email_address,
            'password' => $request->customer_password,
            'fullname'=>$request->$name,
        
        ];

        if($customer)
        {
          if($role == 'business')
          {
            $invoice = new InvoiceSetting;
            $invoice->customer_id = $customer->id;
            $invoice->invoice_name = $request->customer_company;
            $invoice->address = $request->customer_address;
            $invoice->status = 1;
            $invoice->save();
          }
          else
          {
            $invoice = new InvoiceSetting;
            $invoice->customer_id = $customer->id;
            $invoice->invoice_name = $request->full_name;
            $invoice->status = 1;
            $invoice->save();
          }
        }


        $templatee = EmailTemplate::where('type', 7)->first();
        $template = EmailTemplateDescription::where('email_template_id',$templatee->id)->where('language_id',$request->prefered_language)->first();
        // dd($template);
        Mail::to($request->customer_email_address)->send(new RegisterUserEmail($data, $template));
      }

        //Authenticates customer
        // $this->guard()->login($customer); 
       //Redirects customers
        return redirect('user/login')->with('verify','Please_verify');
    } 

    }

     public function createAccount(Request $request)       
    {
      $validator      = $this->validator($request->all());
      $arrayReturened = array();
      if($validator->fails()) {
        foreach ($validator->messages()->getMessages() as $field_name => $messages)
                {
                  foreach($messages AS $message) 
                         {
                          $arrayReturened = array('status'=>'error','message'=>$message); 
                         }
 
                }//end foreach
              }// end if
              else { 
 
                       //Create customer
                       $customer = $this->create($request->all());
                       //Authenticates customer
                       // $this->guard()->login($customer);
                          $arrayReturened = array('status'=>'success','message'=>'Your account has been created successfully.You will be redirected soon.'); 
                     }// end else.

      
       return response()->json($arrayReturened);
    }


    protected function create(array $data)
    {
      try{
        if($data['customer_role'] == 'individual')
        {
        $data['customer_company'] = $data['full_name'];
        $data['customer_address'] = '';
        $data['customer_vat'] = '';
        $data['customer_registration'] = '';
        $data['customer_firstname'] = '';
        $data['customer_lastname'] = '';
        $data['is_adminverify'] = 1;
        }else{
        $data['customer_firstname'] = '';
        $data['customer_lastname'] = '';
        $data['customer_lastname'] = '';
        $data['is_adminverify'] = 0;
        }

      $customers  =  Customer::create([
          'customer_firstname'      => $data['customer_firstname'],
          'customer_lastname'       => $data['customer_lastname'],
          // 'customer_company'     => $data['full_name'],
          'customer_role'           => $data['customer_role'],
          'customers_telephone'     => $data['customer_contact'],
          'customer_company'        => $data['customer_company'],
          'customer_registeration'  => $data['customer_registration'],
          'customer_default_address'=> $data['customer_address'],
          'customer_vat'            => $data['customer_vat'],
          'customer_email_address'  => $data['customer_email_address'],
          'citiy_id' => $data['city_id'],
          'language_id'             => $data['prefered_language'],
          'customer_password'       => Hash::make($data['customer_password']),
          'is_adminverify'          => $data['is_adminverify'], 
      ]);

      //dd($customers);
      return $customers;
      } 
      catch (Illuminate\Database\QueryException $e){
      $error_code = $e->errorInfo[1];
      if($error_code == 1062){
      //self::delete($lid);
      return 'houston, we have a duplicate entry problem';
      }
      }
    }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit()
  {
    return view('Customers.edit_company_profile');
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function editProfile()
  {
    return view('Customers.edit_profile');
  }



  //Get the guard to authenticate Seller
  protected function guard()
  {
    return Auth::guard('customer');
  }

  public function logout()
  {
    Auth::guard('customer')->logout();
    return redirect($this->redirectAfterLogout);
  }

  /**
  * Redirect the user to the Google authentication page.
  *
  * @return \Illuminate\Http\Response
  */
  public function redirectToProvider($provider)
  { 
    $role = request()->get('role');
    if($role !=null){
      Cookie::queue(Cookie::make('memberRole', $role, 180));
    }
    return Socialite::driver($provider)->redirect();
  }

  public function callback($provider)
  {
    try {
      $getInfo = Socialite::driver($provider)->user();
    } catch (\Exception $e) {
      return redirect('user/login');
    }

    $user = $this->createUser($getInfo, $provider);
    Auth::guard('customer')->login($user, true);
    return redirect()->to('/user/post-ad');
  }

  function createUser($getInfo, $provider)
  {
    $user = Customer::where('provider_id', $getInfo->id)->orWhere('customer_email_address', $getInfo->email)->first(); 
    if (!$user) {
      $newUser = new Customer;
      if (Cookie::has('memberRole')) {
        $newUser->customer_role = Cookie::get('memberRole');
      }
      $newUser->customer_status = 'Active';
      $newUser->customer_firstname = $getInfo->name; 
      $newUser->customer_email_address = $getInfo->email;
      $newUser->provider_id       = $getInfo->id;
      $newUser->provider          = $provider; 
      $newUser->save();
      Cookie::forget('memberRole');
      $user = $newUser;
    }
    else {
      if (Cookie::has('memberRole')) {
        $user->customer_role = Cookie::get('memberRole');
        Cookie::forget('memberRole');
      }
      $user->customer_firstname     = $getInfo->name;
      $user->customer_email_address = $getInfo->email;
      $user->provider_id            = $getInfo->id;
      $user->provider               = $provider;
      $user->save();
    }
    return $user;
  } 

  /**
   * Redirect the user to the Google authentication page.
   *
   * @return \Illuminate\Http\Response
   */
/*   public function redirectToProvider()
  {
    return Socialite::driver('google')->redirect();
  } */

  /**
   * Obtain the user information from Google.
   *
   * @return \Illuminate\Http\Response
   */
  public function handleGoogleCallback()
  {    
    try {
      $user = Socialite::driver('google')->user();
    } catch (\Exception $e) {
      return redirect('user/login');
    }
    // only allow people with @company.com to login
   /*  if (explode("@", $user->email)[1] !== 'company.com') {
      return redirect()->to('/');
    } */
    // check if they're an existing user
    $existingUser = Customer::where('provider_id', $user->id)->first(); 
    if ($existingUser) {
      // log them in
      Auth::guard('customer')->login($existingUser, true);
    } else {

      // create a new user
      /*  "name" => "Mutahir Shah"
    "given_name" => "Mutahir"
    "family_name" => "Shah" */
      $newUser = Customer::where('customer_email_address', $user->email)->first();
      if($newUser == null || empty($newUser)){
        $newUser = new Customer;
      }
      if (Cookie::has('memberRole')) {
        $newUser->customer_role = Cookie::get('memberRole');
      }
      $newUser->customer_status = 'Active';
     // if($user->given_name == '' && $user->family_name ==''){
        $newUser->customer_firstname = $user->name;
     /* // }else {
        $newUser->customer_firstname = $user->given_name;
        $newUser->customer_lastname  = $user->family_name;
      } */
      $newUser->customer_email_address = $user->email;
      $newUser->provider_id       = $user->id;
      $newUser->provider          = 'google'; 
      $newUser->save();
      Cookie::forget('memberRole');
      Auth::guard('customer')->login($newUser, true);
    }
    return redirect()->to('/user/post-ad');
  }

  public function verifyCustomerContact(Request $request)
  {
        $finalAaary = array();
        if (request()->ajax()) {
            $customer_contact   = $request->input('customer_contact');

            $digits = 4;
            $message=rand(pow(10, $digits-1), pow(10, $digits)-1);
            $four_digit = urlencode($message);

            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
            else
            $ipaddress = 'UNKNOWN';

            $sms_verify = new SmsVerify;
            $sms_verify->user_mobile = $customer_contact;
            $sms_verify->ip_address = $ipaddress;
            $sms_verify->sms_code = $four_digit;
            $sms_verify->save();
            
            $message = "\n Teie CARISH kinnituskood on ".$four_digit.", mis kehtib 60 sekundit.";
            $message .= "\n Your CARISH verification code is ".$four_digit.", which is valid for 60 seconds.";
            $message .= "\n Ваш проверочный код CARISH — ".$four_digit.", который действителен в течение 60 секунд.";
            $message      = html_entity_decode($message, ENT_QUOTES, 'utf-8');
            $message      = urlencode($message);

            $dst = "372".$customer_contact;

            $ch  = curl_init();
            $url       = "https://smsc.txtnation.com:8093/sms/send_sms.php";
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
            "dst=".$dst."&src=CARISH&dr=1&type=0&user=omartest&password=Qzxf84D&msg=".$message.""); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            curl_close ($ch);
            //dd($output); 

            $finalAaary['status'] = 'success';
            return response()->json($finalAaary);
            
        } // END IF OF CHECK AJAX REQUEST.
        else {
            $finalAaary['status'] = 'fail';
            return response()->json($finalAaary);
        }
    }
     public function VerifySms(Request $request)
    {
      $VerifyAaary = array();
      $templatee = SmsVerify::where('user_mobile', $request->input('customer_contact'))->where('sms_code', $request->input('sms_code'))->where('status', 0)->orderBy('id', 'desc')->first();
      if ($templatee !== null) {
         $VerifyAaary['status'] = 'success';
          return response()->json($VerifyAaary);
      }
        $VerifyAaary['status'] = 'fail';
        return response()->json($VerifyAaary);      
    }

    public function ExpireSms(Request $request)
    {
      $ExpireAaary = array();
      $templatee = SmsVerify::where('user_mobile', $request->input('customer_contact'))->where('status', 0)->orderBy('id', 'desc')->first();
      if ($templatee !== null) {
        $templatee->status = 1;
        $templatee->save();
         $ExpireAaary['status'] = 'success';
          return response()->json($ExpireAaary);
      }
        $ExpireAaary['status'] = 'fail';
        return response()->json($ExpireAaary);      
    }
}