<?php

namespace common\services\customer;

use common\entities\Customer;
use common\forms\customer\SignupForm;
use Yii;

class SignupService
{
    public function signup(SignupForm $form): Customer
    {
        $auth = Yii::$app->authManager;
        $roleCustomer = $auth->getRole('customer');
        $phone = $form->phone !== null ? str_replace('+', '', $form->phone) : null;

        $customer = Customer::signup(
            $form->username,
            $form->email,
            $phone,
            $form->password
        );

        $customer->assignProfileSignup($form);



        if (!$customer->save()) {
            throw new \RuntimeException('Saving error.');
        }

        //set role default
        $auth->assign($roleCustomer, $customer->customer_id);

        return $customer;
    }
}
