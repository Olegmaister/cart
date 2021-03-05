<?php
namespace frontend\services\present;

use common\entities\Stock\StockPresent;
use frontend\entities\Present\ProductPresent;
use frontend\repositories\ProductRepository;

class PresentService
{
    public function getPresents(int $productId)
    {


        $presents = StockPresent::find()
            ->select('present_id')
            ->where(['product_id' => $productId])
            ->all();


        if(!$presents)
            return false;

        $ids = [];

        foreach ( $presents as $item) {
            $ids[] = $item['present_id'];
        }

        $objects = [];

        foreach ($ids as $id) {
            $product = ProductRepository::getProductById($id);
            $options = ProductRepository::getProductOptionsByIdForCart($id);

            $objects[] = new ProductPresent($product, $options);
        }

        return $objects;
    }

}