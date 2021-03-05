<?php
namespace common\repositories\Order;

use common\entities\Stock\Stock;
use common\entities\Stock\StockCustomer;
use common\helpers\DateHelper;

class StockCustomerRepository
{
   public function getStocks($customerId)
   {
       if(!$stock = StockCustomer::find()
           ->where(
               ['and',
                   ['stock.active' => Stock::STATUS_ACTIVE],
                   ['customer_id' => $customerId],
                   ['<','stock.date_from', DateHelper::getCurrentTime()],
                   ['>','stock.date_to', DateHelper::getCurrentTime()]
               ]
           )
           ->joinWith('stock')
           ->all()){
       }

       return $stock;

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