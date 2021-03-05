<?php
namespace common\repositories;

use common\entities\CartItem;
use common\entities\Rbac\AuthItem;

class AuthItemRepository
{
    public function getById($productId, $customerId)
    {
        return $this->getBy(['product_id' => $productId,'customer_id' => $customerId]);
    }

    public function getByIdCart($id) : AuthItem
    {
        return CartItem::find()
            ->where(['product_id' => $id])
            ->select('id,name,quantity,price_new,price_old,name_price')
            ->one();
    }

    public function getByName($name) : AuthItem
    {
        return $this->getBy(['name' => $name]);
    }

    public function save(AuthItem $authItem) : void
    {
        $authItem->save(false);
    }


    private function getBy($condition)
    {
        return  AuthItem::find()->where($condition)->one();
    }
}