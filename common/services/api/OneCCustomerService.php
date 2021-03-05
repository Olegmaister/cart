<?php

namespace common\services\api;

use common\api\oneC\SynchronizeCustomer;
use common\entities\City;
use common\entities\Customer;

class OneCCustomerService
{
    private $synchronizeCustomer;

    public function __construct()
    {
        $this->synchronizeCustomer = new SynchronizeCustomer();
    }

    /**
     * @param Customer $customer
     */
    public function updateCustomerData($customer)
    {
        $cityRef = '';
        $city = City::findOne($customer->profile->city_id);

        if ($city) {
            $cityRef = $city->reff;
        }

        $data = [
            'guid' => $customer->guid,
            'type' => $customer->type,
            'type_id' => $customer->type_id,
            'contragent' => "{$customer->profile->last_name} {$customer->profile->first_name} {$customer->profile->father_name}",
            'first_name' => $customer->profile->first_name,
            'last_name' => $customer->profile->last_name,
            'father_name' => $customer->profile->father_name,
            'country' => !empty($customer->profile->country) ? $customer->profile->country->code : '',
            'region' => $customer->profile->state,
            'index' => $customer->profile->index,
            'city_id' => $cityRef,
            'city_name' => $customer->profile->city_name,
            'street' => $customer->profile->street,
            'house' => $customer->profile->house,
            'apartment' => $customer->profile->apartment,
            'entrance' => $customer->profile->porch,
            'email' => $customer->email,
            'phone' => str_replace('+', '', $customer->phone),
            'phone2' => str_replace('+', '', $customer->profile->phone),
            'born' => $customer->profile->date_birth,
            'gender' => $customer->profile->gender,
            'accumulatedsales' => $customer->profile->accumulation_system,
            'discount' => $customer->profile->discount,
            'card' => $customer->profile->card,
            'RegData' => date('Ymd', $customer->created_at),
        ];

        $customer->save();
        $guid = $this->synchronizeCustomer->sendCustomerData($data);

        $customer->guid = $guid['guid'];
        $customer->save();
    }
}
