<?php

namespace App\Http\Controllers\Customers;

 
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
use App\Mail\RegisterUserEmail;
use Mail;
//Customer Model
use App\Models\Customers\Customer;    

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
    protected $redirectAfterLogout = '/customers/login';
    protected $redirectPath        = '/customers'; 

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
      // Validate the form data
      $this->validate($request, [
        'customer_email_address'   => 'required|email',
        'password'        => 'required|min:6'
      ]); 
      // Attempt to log the user in
      if (Auth::guard('customer')->attempt(['customer_email_address' => $request->customer_email_address, 'password' => $request->password], $request->remember)) {
        // if successful, then redirect to their intended location
        return redirect()->intended(route('customers.dashboard'));
      }  
      // if unsuccessful, then redirect back to the login with the form data
      Session::flash('error', 'Invalid credentials');
      return redirect()->back()->withInput($request->only('customer_email_address', 'remember'));
    }

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
      return View::make('Customers.register');
    } 


  //Handles registration request for customer
    public function register(Request $request)       
    {
       //Validates data
       $validator = $this->validator($request->all());
           if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else { 
       //Create customer
        $customer = $this->create($request->all());


        if($customer){
         $data = [
            'id' =>  $request->id,
            'firstname' => $request->customer_firstname,
            'lastname' => $request->customer_lastname,
            'email' => $request->customer_email_address,
            'password' => $request->customer_password,
        
        ];


        $template = EmailTemplate::where('type', 'create-customer-account')->first();
        Mail::to($request->customer_email_address)->send(new RegisterUserEmail($data, $template));
      }

        //Authenticates customer
        $this->guard()->login($customer); 
       //Redirects customers
        return redirect($this->redirectPath);
    } 

    }

     public function createAccount(Request $request)       
    {
      // dd($request-all());
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
                       $this->guard()->login($customer);
                          $arrayReturened = array('status'=>'success','message'=>'Your account has been created successfully.You will be redirected soon.'); 
                     }// end else.

      
       return response()->json($arrayReturened);
    }


    protected function create(array $data)
    {
        try{
            if($data['customer_role'] == 'individual')
            {
            $data['customer_company'] = '';
            $data['customer_address'] = '';
            $data['customer_vat'] = '';
            $data['customer_registration'] = '';
            $inputs =[
              'customer_firstname'       => $data['customer_firstname'],
              'customer_lastname'        => $data['customer_lastname'],
              'customer_role'            => $data['customer_role'],
              'customers_telephone'      => $data['customer_contact'], 
              'customer_email_address'   => $data['customer_email_address'],
              'customer_password'        => Hash::make($data['customer_password']),
            ];
            }else {
            $inputs = [ 
            'customer_role'            => $data['customer_role'],
            'customers_telephone'      => $data['customer_contact'],
            'customer_company'         => $data['customer_company'],
            'customer_registeration'   => $data['customer_registration'],
            'customer_default_address' => $data['customer_address'],
            'customer_vat'             => $data['customer_vat'],
            'customer_email_address'   => $data['customer_email_address'],
            'customer_password'        => Hash::make($data['customer_password']),
            ];
            }

        $customers  =  Customer::create($inputs);
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


}
