<?php
namespace common\services\customer;

use Yii;

use common\entities\Customer;
use common\entities\Customer\Profile;
use common\repositories\CustomerRepository;
use common\repositories\ProfileRepository;
use frontend\forms\customer\CustomerForm;
use frontend\forms\customer\PasswordForm;
use frontend\forms\order\OrderForm;
use common\entities\Customer\CustomerOrder;




class CustomerService
{
    private $repository;
    private $profileRepository;

    public function __construct(
        CustomerRepository $repository,
        ProfileRepository $profileRepository
    )
    {
        $this->repository = $repository;
        $this->profileRepository = $profileRepository;
    }

    public function edit(CustomerForm $form, int $customerId)
    {
        $customer = $this->repository->getById($customerId);
        $customer->edit(
            $form->email,
            $form->phone
        );

        $this->checkProfile($customerId);

        $profile = $this->profileRepository->getId($customerId);

        $customer->assignProfile($form, $profile);

        $this->repository->save($customer);
    }

    public function getId()
    {
        return \Yii::$app->getUser()->id;
    }

    public function getProfile()
    {
        $customer = $this->getCustomer();
        if(!$customer)
            return null;

        return $this->repository->getProfile($customer->customer_id);
    }

    public function newPassword(Customer $customer, PasswordForm $form)
    {
        $customer->setNewPassword($form->password);
        $this->repository->save($customer);
    }

    /*
     * обновление информации во время оформления заказа
     * **/
    public function updateAtTimeOrder(OrderForm $form)
    {

        if(Yii::$app->user->isGuest)
            return false;

        /**@var $customer Customer*/
        $customer = $this->repository->getProfile($this->getId());
        $customerData = new CustomerOrder($form);

        $customer->editProfile($customerData);

         $this->repository->save($customer);
    }

    private function getCustomer()
    {
        return \Yii::$app->user->identity;
    }


    private function checkProfile($customerId)
    {
        if(!$this->profileRepository->getIdCheck($customerId))
        {
            $profile = Profile::blankEmptyCreate($customerId);
            $this->profileRepository->save($profile);
        }
    }
}
