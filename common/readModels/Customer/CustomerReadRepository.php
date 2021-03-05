<?php
namespace common\readModels\Customer;

use common\services\customer\CustomerService;
use Symfony\Component\Yaml\Escaper;

class CustomerReadRepository
{
    private $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function getCustomer()
    {
        return $this->service->getProfile();
    }
}