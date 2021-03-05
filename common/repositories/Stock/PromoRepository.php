<?php
namespace common\repositories\Stock;

use common\entities\CartItem;
use common\entities\Rbac\AuthItem;
use common\entities\Stock\StockPromo;
use Yii;

class PromoRepository
{
    public function getById()
    {
        return $this->getBy([]);
    }

    public function validationСheckIsset($promoToken)
    {
        return $this->getBy(['token' => $promoToken]);
    }

    public function validationСheckCount($promoToken)
    {
        $promo = StockPromo::find()->where(['token' => $promoToken])->one();
        if($promo->count < 1){
            throw new \DomainException('закончились на складе');
        }

    }

    public function getByName($name) : AuthItem
    {
        return $this->getBy(['name' => $name]);
    }

    public function getByToken($token)
    {
        return StockPromo::find()
            ->with('stock')
            ->where(['token' => $token])->one();
    }


    public function save(StockPromo $promo)
    {
        $promo->save();
    }

    private function getBy($condition)
    {
        if(!$promo = StockPromo::find()
            ->with('stock')
            ->where($condition)
            ->one()){
            throw new \DomainException(Yii::t('app', 'Wrong promo code'));
        }

        return $promo;
    }

}