<?php

namespace App\Http\Controllers\Customers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Customer\CustomerRepositoryContract;
use Auth;
use Cartalyst\Stripe\Exception\CardErrorException;
use App\Models\Country;
use App\Models\State;

class ProfileController extends Controller
{
	private $profile;

    public function __construct(CustomerRepositoryContract $profile)
     {
     	 $this->middleware('auth:customer');
         $this->profile  = $profile;
     } 

    public function getBillingInfo()
    {
    	 $countries = $this->profile->countries();
         $customer  = $this->profile->customer();
         $months    = $this->profile->getMonths();
         $years     = $this->profile->getYears();
         if(!is_null($customer->billingInfo))
         {
            return view('Customers.bill-detail', compact('customer', 'months', 'years')); 
         }
    	 return view('Customers.billing', compact('countries','customer', 'months', 'years'));
    }


    public function postBillingInfo(Request $request)
    {
        $this->profile->createBilling($request->all());
        return redirect('customers')->with('success', 'Billing Information successfully saved.');
    }

    public function postUpdateExpiry(Request $request)
    {
        $customer = $this->profile->customer();
        try{
        $card = $this->profile->updateCardExpiry($request->except('_token'), $customer->billingInfo->billing_detail->customer_payment_id, $customer->billingInfo->billing_detail->customer_card_id);
        }catch(CardErrorException $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
        return redirect()->back()->with('success', 'Card Expiry updated successfully');
    }

    public function getUpdateCard()
    {
        $months    = $this->profile->getMonths();
        $years     = $this->profile->getYears();
        return view('Customers.update-card', compact('months', 'years'));
    }

    public function postUpdateCard(Request $request)
    {
        $customer = $this->profile->customer();
        $data = [
            'customer_token' => $customer->billingInfo->billing_detail->customer_payment_id,
            'stripeToken'    => $request->get('stripeToken')
        ];
        $card = $this->profile->createCard($data);

        $bdata  = [
                'customer_card_id' => $card['id'],
                'card_last_4' => $card['last4'],
                'card_type' => $card['brand'],
                'customer_payment_gateway' => 'Stripe',
            ];

        $billingdetail = $this->profile->updateCardDetail($bdata,$customer->billingInfo->billing_detail->id);
        return redirect('customers/billing-info')->with('success', 'Credit Card Details successfully changed');

    }

    public function getBillingUpdate()
    {
        $countries = $this->profile->countries();
        $customer = $this->profile->customer();
        $states  = $this->profile->statesForSelect($customer->billingInfo->country_id);
        return view('Customers.update-billing', compact('countries', 'customer', 'states'));
    }

    public function postBillingUpdate(Request $request)
    {
        $customer = $this->profile->customer();
        $country  = Country::find($request->get('country_id'));
        $state  = State::find($request->get('state_id'));
        $billArr = [
              'name' => $request->get('billing_first_name').' '.$request->get('billing_last_name'),
              'address_line1' => $request->get('billing_address'), 
              'address_line2' => $request->get('billing_address_2'), 
              'address_country' => $country->name, 
              'address_state' => $state->name, 
              'address_city' => $request->get('billing_city'), 
              'address_zip' => $request->get('billing_zipcode'), 
        ];
        try{
            $billinginfo = $this->profile->updateBilling($request->except('_token'), $customer->billingInfo->id);
            $card = $this->profile->updateCCardDetail($billArr, $customer->billingInfo->billing_detail->customer_payment_id, $customer->billingInfo->billing_detail->customer_card_id);
        }catch(CardErrorException $e) {
            return redirect()->back()->with('error',$e->getMessage());
        }
        return redirect()->route('customers.billing')->with('success', 'Billing Information successfully updated');
    }

    public function getShippingInfo()
    {
        $countries = $this->profile->countries();
        $customer  = $this->profile->customer();
        return view('Customers.shipping', compact('countries','customer'));
    }

    public function postShippingInfo(Request $request)
    {
        $this->profile->createShipping($request->all());
        return redirect('customers')->with('success', 'Shipping Information successfully saved.');
    }

    public function getStates(Request $request)
    {
        $country = $request->get('country');
        $state   = $this->profile->statesByCountries($country);
        return $state;
    }
}
