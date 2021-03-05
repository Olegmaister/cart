<?php

namespace frontend\services\product;

use common\entities\Brands\Brand;
use common\entities\OrderItem;
use common\entities\Products\Product;
use common\entities\Products\ProductInCategory;
use common\entities\Stock\Stock;
use common\entities\Stock\StockBrand;
use common\entities\Stock\StockCategory;
use common\entities\Stock\StockProduct;
use common\helpers\ArrayHelper;
use common\helpers\DateHelper;
use frontend\services\cart\DiscountService;

class PriceService
{
    private $service;
    public function __construct(DiscountService $service)
    {
        $this->service = $service;
    }

    public function getOutput(OrderItem $item)
    {
        return new OrderItemOutputPrice($item);
    }

    public function getCurrentDiscountPrice($productId)
    {
        $resArray = [
          'price' => 0,
          'price_old' => 0
        ];

        //get products
        $product = Product::find()
            ->select(['price','price_old','sale','manufacturer_id'])
            ->asArray()
            ->where(['product_id' => $productId])->one();


        if($product['sale'] == Product::SALE){
            $resArray['price'] = $product['price'];
            $resArray['price_old'] = $product['price_old'];
            return $resArray;
        }

        $productDiscounts = $this->getProduct($productId);

        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($productDiscounts as &$row) {
            if ($row['stock']['counting_method'] == Stock::COUNTING_MONEY) {
                $row['stock']['percent'] = round((100 * $row['stock']['money']) / $product['price']);
            }
        }

        $brandDiscounts = $this->getBrand($product['manufacturer_id']);

        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($brandDiscounts as &$row) {
            if ($row['stock']['counting_method'] == Stock::COUNTING_MONEY) {
                $row['stock']['percent'] = round((100 * $row['stock']['money']) / $product['price']);
            }
        }

        $categoryDiscounts = $this->getCategory($productId);
        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($categoryDiscounts as &$row) {
            if ($row['stock']['counting_method'] == Stock::COUNTING_MONEY) {
                $row['stock']['percent'] = round((100 * $row['stock']['money']) / $product['price']);
            }
        }

        $discounts = [];

        foreach ($productDiscounts as $productDiscount) {
            $discounts[] = $productDiscount;
        }


        foreach ($categoryDiscounts as $categoryDiscount) {
            $discounts[] = $categoryDiscount;
        }

        foreach ($brandDiscounts as $brandDiscount) {
            $discounts[] = $brandDiscount;
        }

        $items = ArrayHelper::getByKey($discounts, 'stock');
        $stock = ArrayHelper::getMaxValue($items);

        $brand = Brand::find()
                ->select('limitation_discount')
                ->where(['brand_id' => $product['manufacturer_id']])
                ->asArray()
                ->one();

        $limitationDiscount = $brand['limitation_discount'];

        if (isset($stock['percent'])) {
            if ($stock['percent'] > $limitationDiscount) {
                $stock['percent'] = $limitationDiscount;
            }
        }

        $discountPrice = 0;

        if(isset($stock)){
            if($stock->counting_method == Stock::COUNTING_MONEY){
                $discountPrice = $this->calculateDiscountMoney($product, $stock);
            }else{
                $discountPrice = $this->calculateDiscount($product, $stock);
            }

            return  [
                'price' => $discountPrice,
                'price_old' => $product['price']
            ];
        }

        return [
            'price' => $product['price'],
            'price_old' => 0
        ];

    }

    private function calculateDiscountMoney($product, $stock)
    {
        $result = $product['price'] - $stock['money'];
        if($result < 1){
            return 1;
        }

        return $result;

    }

    private function calculateDiscount($product, $stock)
    {
        return $product['price'] - (($stock['percent'] * $product['price']) / 100);
    }


    public function getProduct($productId)
    {
        return StockProduct::find()
            ->where(['and',
                ['stock_product.product_id' => $productId],
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->joinWith(['stock'])
            ->asArray()
            ->all();

    }

    public function getBrand($brandId)
    {
        return StockBrand::find()
            ->where(['and',
                ['brand_id' => $brandId],
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->asArray()
            ->joinWith('stock')
            ->all();
    }

    public function getCategory($productId)
    {
        $productsCategory = ProductInCategory::find()->where(['product_id' => $productId])->all();

        $categorieIds = [];
        foreach ($productsCategory as $productCategoryId) {
            $categorieIds[] = $productCategoryId->category_id;
        }

        return StockCategory::find()
            ->where(['and',
                ['in','category_id',$categorieIds],
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->asArray()
            ->joinWith('stock')
            ->all();
    }


}