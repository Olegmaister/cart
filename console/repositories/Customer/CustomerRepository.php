<?php
namespace console\repositories\Customer;

use core\entities\Customer\Customer;
use core\helpers\string\StringHelper;

class CustomerRepository
{
    const ADMIN_USERNAME = 'admin';
    const ADMIN_EMAIL = 'admin@gmail.com';
    const ADMIN_PASSWORD = '123456';

    public function defaultAdministrator()
    {
        $customer = new Customer();
        $customer->username = self::ADMIN_USERNAME;
        $customer->email = self::ADMIN_EMAIL;
        $customer->salt = StringHelper::saltString();
        $customer->password = sha1($customer->salt . sha1($customer->salt . sha1(self::ADMIN_PASSWORD)));
        $customer->created_at = time();
        $customer->status = Customer::STATUS_ACTIVE;

        return $customer;
    }



    public function getByEmailStatusActive(string $email) : Customer
    {
        return $this->getBy([
            'email' => $email,
            'status' => Customer::STATUS_ACTIVE
        ]);
    }

    public function getByUsername($username) : User
    {
        return $this->getBy(['username' => $username]);
    }

    public function save(Customer $customer) : void
    {
        if(!$customer->save()){
            throw new RuntimeException('Saving error.');
        }
    }

    private function getBy($condition)
    {
        if(!$customer = Customer::find()->where($condition)->one()){
            throw new NotFoundException('Customer not found.');
        }

        return $customer;
    }

}