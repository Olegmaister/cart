<?php
namespace common\services\rbac;

use common\entities\Customer;
use backend\forms\rbac\AdministratorCreateForm;
use backend\forms\rbac\AdministratorUpdateForm;
use common\repositories\CustomerRepository;
use common\repositories\AuthItemRepository;
use common\services\TransactionManager;
use yii\base\Theme;
use function globalFunction\functions\dd;

class AdministratorService
{
    private $authManager;
    private $repository;
    private $customerRepository;
    private $transactionManager;

    const DEFAULT_EMAIL = 'admin@gmail.com';

    public function __construct(
        $authManager,
        AuthItemRepository $repository,
        CustomerRepository $customerRepository,
        TransactionManager $transactionManager
    )
    {
        $this->customerRepository = $customerRepository;
        $this->authManager = $authManager;
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
    }

    public function create(AdministratorCreateForm $form)
    {

        $role = $this->repository->getByName($form->role);
        $customer = Customer::signup(
            $form->username,
            $form->email,
            $form->phone,
            $form->password
        );



        if(!$customer->save()){
            throw new \DomainException('Save error');
        }

        $this->authManager->assign($role, $customer->customer_id);


        return $customer;
    }

    public function edit(AdministratorUpdateForm $form, $customerId)
    {

        $customer = $this->customerRepository->getById($customerId);
        $this->assertIsNotDefaultAdministrator($customer);

        $customer->edit(
            $form->username,
            $form->email
        );

        $this->transactionManager->wrap(function () use ($customer, $form) {
            if(is_array($customer->assignments)){
                foreach ($customer->assignments as $assignment) {
                    if($assignment->item_name !== $form->role){
                        //1 открепить все роли
                        $customer->revokeAssignments();
                        $this->customerRepository->save($customer);
                        //2 найти данную роль
                        $newRole = \Yii::$app->authManager->getRole($form->role);
                        \Yii::$app->authManager->assign($newRole, $customer->customer_id);
                        //3 прикрепить ее к пользователю сохнанить
                    }
                }
            }

            $this->customerRepository->save($customer);
        });

    }

    public function remove(int $customerId) : void
    {
        $customer = $this->customerRepository->getById($customerId);

        $this->assertIsNotDefaultAdministrator($customer);

        $this->transactionManager->wrap(function () use ($customer) {
            if(($customer->assignments)){
                foreach($customer->assignments as $assign)
                {
                    $customer->revokeAssignments();
                }

                $this->customerRepository->save($customer);
            }

            $this->customerRepository->remove($customer);

        });

    }

    private function assertIsNotDefaultAdministrator(Customer $customer)
    {
        if($customer->email == self::DEFAULT_EMAIL){
            throw new \DomainException('Вы не можете выполнить это действие');
        }
    }

}