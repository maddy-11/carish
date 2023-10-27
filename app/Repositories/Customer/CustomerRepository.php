<?php
namespace App\Repositories\Customer;

use App\Models\Customers\Customer;   
use App\Models\Customers\CustomerBillingAddress;
use App\Models\Customers\CustomerBillingDetail;
use App\Models\Customers\CustomerShippingAddress;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use DB;
use Response;
use Auth;
use Cartalyst\Stripe\Stripe;
use Cartalyst\Stripe\Exception\CardErrorException;
/**
 * Class ClientRepository
 * @package App\Repositories\Category
 */
class CustomerRepository implements CustomerRepositoryContract
{
    const CREATED        = 'created';
    const UPDATED_ASSIGN = 'updated_assign';

    /**
     * @param $id
     * @return mixed
     */
    public function __construct()
    {
        
    }

    public function find($id)
    {
        return Customer::findOrFail($id);
    }

    public function customer()
    {
        return Auth::guard('customer')->user();
    }

    /**
     * @return mixed
     */
    public function countries()
    {
        return Country::pluck('name', 'id');
    }

    public function statesForSelect($countryId)
    {
        return State::where('country_id', $countryId)->pluck('name', 'id');
    }

    public function statesByCountries($countryId)
    {
        $states = State::where(['country_id'=> $countryId, 'status' => '1'])->get();
        return Response::json(array('states' => $states));
    }

    public function citiesByStates($stateId)
    {
        $countries = City::where(['state_id'=> $stateId, 'status' => 1])->where('status',1)->get();
        return Response::json(array('countries' => $countries));
    }

    public function getMonths() {
        $months = array();
        for ($x = 1; $x <= 12; $x++) {
            $x = str_pad($x, 2, '0', STR_PAD_LEFT);
            $months[$x] = date("F", mktime(0, 0, 0, $x, 10)) . " ($x)"; //January (01)
        }
 
        return $months;
    }
 
    public function getYears() {
        $years = array();
        $curYear = date("Y");
        $limit = 10;
        for ($x = $curYear; $x < $curYear + $limit; $x++) {
            $years[$x] = $x;
        }
        return $years;
    }


    public function createBilling($requestData)
    {
        $data = $requestData;
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $billinginfo = CustomerBillingAddress::create($data);
        $customer->billinginfo()->save($billinginfo);
        $customer = $this->createCustomer($data);
        $data['customer_token'] = $customer['id'];
        $card  = $this->createCard($data);
        $billingArr  = [
                'billing_id' => $billinginfo->id,
                'customer_payment_id' => $customer['id'],
                'customer_card_id' => $card['id'],
                'card_last_4' => $card['last4'],
                'card_type' => $card['brand'],
                'customer_payment_gateway' => 'Stripe',
            ];
        $billingdetail = $this->createCardDetail($billingArr);    

    }

    public function updateBilling($requestData, $id)
    {
        $billinginfo = CustomerBillingAddress::where('id', $id)->update($requestData);
        return $billinginfo;
    }

    public function createCardDetail($requestData)
    {
        $billingdetail = CustomerBillingDetail::create($requestData);
        return $billingdetail;
    }

    public function updateCardDetail($requestData, $id)
    {
        $billingdetail = CustomerBillingDetail::where('id', $id)->update($requestData);
        return $billingdetail;
    }

    public function updateCCardDetail($requestData, $customerToken, $cardId)
    {
        $stripe = new Stripe(config('services.stripe.secret'));
        $card = $stripe->cards()->update($customerToken, $cardId, $requestData);
        
        return $card;
    }

     public function createShipping($requestData)
    {
        $data = $requestData;
        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $shippinginfo = CustomerShippingAddress::create($data);
        $customer->shippinginfo()->save($shippinginfo);
    }

    public function createCustomer($requestData)
    {
        $stripe = new Stripe(config('services.stripe.secret'));
        $data   = $requestData;
        $customer = $stripe->customers()->create([
                'email' => $data['billing_email'],
            ]);
        return $customer;
    }

    public function createCard($requestData)
    {
        $stripe = new Stripe(config('services.stripe.secret'));
        $data = $requestData;
        $card = $stripe->cards()->create($data['customer_token'], $data['stripeToken']);
        return $card;
    }

    public function retriveCard($requestData)
    {   
        $stripe = new Stripe(config('services.stripe.secret'));
        $data =  $requestData;
        $card = $stripe->cards()->find($data['customer_id'], $data['card_id']);
        return $card;
    }   


}
