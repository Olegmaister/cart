<?php
namespace common\services\stock;

use common\entities\Customer;
use common\entities\Products\Product;
use common\entities\Stock\Stock;
use yii\helpers\Json;

class SegmentService extends SegmentServiceBasic
{
    public function checkConditionForSegment(Customer $customer = null)
    {
        if(!isset($customer) || empty($customer) || $customer->isRetail()){
            return false;
        }

        return true;
    }

    public function applyStockBySegment($stock , Product $product, $customer)
    {
        //преобразование json=>array
        $segmentJson = Json::decode($stock->segment_json);

        $userCurrentDiscount = $this->existsSegment($segmentJson,$customer);

        if(!$userCurrentDiscount)
            return $stock;

        if($stock->stock->counting_method == Stock::COUNTING_MONEY){
            $userCurrentDiscount['value'] = round((100 * $userCurrentDiscount['value']) / $product->price);
        }

        if($stock->stock->percent < $userCurrentDiscount){
            $stock->stock->percent = $userCurrentDiscount['value'];
        }

        return $stock;

    }
}