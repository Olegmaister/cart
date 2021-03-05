<?php
namespace common\repositories;

use common\entities\Customer\Profile;

class ProfileRepository
{
    public function getId($customerId) : Profile
    {
        return $this->getBy(['customer_id' => $customerId]);
    }

    public function getIdCheck($customerId)
    {
        return Profile::find()->where(['customer_id' => $customerId])->one();
    }


    public function save(Profile $profile)
    {
        if(!$profile->save()){
            throw new \DomainException('Ошибка при сохранение');
        }
    }

    private function getBy($condition)
    {
        if(!$profile = Profile::find()->where($condition)->one()){
            throw new \DomainException('Пользователь не найден.');
        }

        return $profile;
    }
}
