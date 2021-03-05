<?php
namespace common\repositories;

use common\entities\Country;

class CountryRepository
{
    public function getByName(string $name) : Country
    {
        return $this->getBy(['name' => $name]);
    }

    public function getCode(int $code) : Country
    {
        return $this->getBy(['code' => $code]);
    }

    private function getBy($condition)
    {
        if(!$country = Country::find()->where($condition)->one()){
            throw new \DomainException('country not found.');
        }

        return $country;
    }
}