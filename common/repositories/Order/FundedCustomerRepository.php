<?php
namespace common\repositories\Order;


class FundedCustomerRepository
{
    public function getById($userId) : array
    {
        return $this->getBy(['user_id' => $userId]);
    }


    private function getBy($condition)
    {
        if(!$stock = StockCustomer::find()
            ->where($condition)
            ->where(['stock.active' => 1])
            ->joinWith('stock')
            ->all()){
        }

        return $stock;
    }
}
