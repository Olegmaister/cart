<?php
namespace console\services;

use common\entities\Customer;
use common\helpers\StringHelper;
use Yii;


class RbacService
{

    private $authManager;
    public function __construct($authManager)
    {
        $this->authManager = $authManager;
    }

    public function getAdministrator()
    {
        $customer = new Customer();
        $customer->username = 'admin';
        $customer->email = 'admin@gmail.com';
        $customer->salt = StringHelper::saltString();
        $customer->password = sha1($customer->salt . sha1($customer->salt . sha1('qwerty')));
        $customer->created_at = time();
        $customer->status = Customer::STATUS_ACTIVE;

        $customer->save();

        $roleAdministrator = $this->createDefaultAdmin();
        $this->createDefaultCustomer();

        $permission = $this->createDefaultPermission();

        $this->authManager->addChild($roleAdministrator,$permission);
        $this->authManager->assign($roleAdministrator,$customer->customer_id);


    }

    private function createDefaultAdmin()
    {

        $role = $this->authManager->createRole('administrator');
        $role->description = 'Администратор';
        $this->add($role);
        return $role;
    }

    private function createDefaultCustomer() : void
    {
        $role = $this->authManager->createRole('customer');
        $role->description = 'Пользователь';
        $this->add($role);
    }


    private function createDefaultPermission()
    {
        $permission = $this->authManager->createPermission('accessControlPanel');
        $this->add($permission);
        return $permission;
    }

    private function add($param)
    {
        $this->authManager->add($param);
    }

    public function dd($data)
    {
        echo '<pre>';
            print_r($data);
            exit;
    }




}