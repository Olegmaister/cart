<?php
namespace common\repositories;


use common\entities\Customer;

class CustomerRepository
{
    public function getById($customerId) : Customer
    {
        return $this->getBy(['customer_id' => $customerId]);
    }
    public function getByIdGuest($customerId)
    {
        return Customer::find()->where(['customer_id' => $customerId])->one();
    }

    public function getProfile(int $customerId)
    {
        return Customer::find()
            ->where(['customer_id' => $customerId])
            ->with('profile')
            ->one();
    }

    public function getByEmailStatusActive(string $email) : Customer
    {
        return $this->getBy([
            'email' => $email,
            'status' => Customer::STATUS_ACTIVE
        ]);
    }

    public function getByPhoneStatusActive(string $phone) : Customer
    {
        return $this->getBy([
            'phone' => $phone,
            'status' => Customer::STATUS_ACTIVE
        ]);
    }



    public function getByPasswordToken($token) : Customer
    {
        return $this->getBy([
            'password_reset_token' =>  $token
        ]);
    }

    public function findByNetworkIdentity($network, $identity): Customer
    {
        return Customer::find()->joinWith('networks n')
            ->andWhere(['n.network' => $network, 'n.identity' => $identity])
            ->one();
    }

    public function getByUsername($username) : Customer
    {
        return $this->getBy(['username' => $username]);
    }

    public function save(Customer $customer) : void
    {
        if(!$user =  $customer->save()){
            throw new \DomainException('Ошибка во время сохранения.');
        }

    }

    public function remove(Customer $customer)
    {
        if(!Customer::deleteAll(['customer_id' => $customer->customer_id])){
            throw new \DomainException('Ошибка во время удаления.');
        }
    }

    private function getBy($condition)
    {
        if(!$customer = Customer::find()->where($condition)->one()){
            throw new \DomainException('Пользователь не найден.');
        }

        return $customer;
    }
}