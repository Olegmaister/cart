<?php
namespace common\services\customer;


use common\entities\Customer;
use common\forms\customer\LoginForm;
use common\repositories\CustomerRepository;

class LoginService
{
    private $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function auth(LoginForm $form) : Customer
    {


        if($form->email){
            $customer = $this->repository->getByEmailStatusActive($form->email);
        }
        else{
            $phone = str_replace('+','',preg_replace("# #",'',$form->phone));
            $customer = $this->repository->getByPhoneStatusActive($phone);
            }

        if (!$customer->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }

        return $customer;
    }
}
