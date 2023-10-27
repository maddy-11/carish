<?php
namespace App\Repositories\Customer;

interface CustomerRepositoryContract
{
    public function find($id);

    public function customer();

    public function countries();

    public function statesForSelect($countryId);

    public function statesByCountries($countryId);

    public function citiesByStates($stateId);

    public function getMonths();

    public function getYears();

    public function createBilling($requestData);

    public function updateBilling($requestData, $id);

    public function createCardDetail($requestData);

    public function updateCardDetail($requestData, $id);

    public function updateCCardDetail($requestData, $customerToken, $cardId);

    public function createCustomer($requestData);

    public function createCard($requestData);

    public function retriveCard($requestData);

}
