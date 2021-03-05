<?php
namespace common\repositories;



use common\entities\City;




class CityRepository
{
    public function getById($cityId)
    {
        return $this->getBy(['id' => $cityId]);
    }

    private function getBy($condition)
    {
        return $city = City::find()->where($condition)->one();
    }
}