<?php
namespace common\services\customer;

use common\entities\Customer;
use common\repositories\CustomerRepository;

class NetworkService
{

    private $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function auth(string $networks, string $identity): Customer
    {
        if($customer = $this->repository->findByNetworkIdentity($networks, $identity)){
            return $customer;
        }
        $customer = Customer::signupByNetwork($networks, $identity);
        $this->repository->save($customer);
        return $customer;
    }

    /**
     * @userId - id пользователя в user
     * @userId - network название соц.сети
     * @identity - идентификатор в ней пользователя
     * @return Customer
     */
    public function attach(int $customerId, string $network, string $identity)
    {
        if($this->repository->findByNetworkIdentity($network,$identity)){
            throw new \DomainException('Network is already signed up.');
        }

        $customer = $this->repository->getById($customerId);
        $customer->attachNetwork($network, $identity);
        $this->repository->save($customer);

        return $customer;
    }

}