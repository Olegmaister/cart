<?php

namespace common\services\customer;

use common\repositories\CustomerRepository;
use common\services\mail\EmailSender;
use frontend\forms\customer\PasswordRecoveryForm;

class PasswordResetService
{
    private $repository;

    public function __construct(CustomerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PasswordRecoveryForm $form
     * @throws \yii\web\NotFoundHttpException
     */
    public function request(PasswordRecoveryForm $form)
    {
        /* @var $customer \common\entities\Customer */
        $customer = $this->repository->getByEmailStatusActive($form->email);
        $customer->requestPasswordReset();
        $this->repository->save($customer);

        (new EmailSender)->sendResetPasswordEmail($customer);
    }

    public function validateToken($token): void
    {
        if (empty($token) || !is_string($token)) {
            throw new \DomainException('Password reset token cannot be blank.');
        }
    }

    public function reset($token, $form)
    {
        //get customer by token
        $customer = $this->repository->getByPasswordToken($token);
        $customer->resetPassword($form->password);
        $this->repository->save($customer);
    }
}
