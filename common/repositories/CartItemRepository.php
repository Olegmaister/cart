<?php
namespace common\repositories;

use common\entities\CartItem;

class CartItemRepository
{
    public function getById($productId, $customerId)
    {
        return $this->getBy(['product_id' => $productId,'customer_id' => $customerId]);
    }

    public function getByIdCart($id) : CartItem
    {
        return CartItem::find()
            ->where(['product_id' => $id])
            ->select('id,name,quantity,price_new,price_old,name_price')
            ->one();
    }

    public function getByName($name) : CartItem
    {
        return $this->getBy(['name' => $name]);
    }

    public function save(CartItem $product) : void
    {
        $product->save(false);
    }

    public function updateQuantityProduct()
    {

    }




    public function remove($product) : void
    {
        if(!CartItem::deleteAll(['id' => $product->id])){
            throw new NotFoundException('Not delete product.');
        }
    }

    private function getBy($condition)
    {
        return  CartItem::find()->where($condition)->one();
    }
}