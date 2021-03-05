<?php
namespace common\repositories\Order;


use common\entities\Customer;
use common\entities\Group;
use common\entities\Stock\Stock;
use common\entities\Stock\StockBrand;
use common\entities\Stock\StockCategory;
use common\entities\Stock\StockCustomer;
use common\entities\Stock\StockGroup;
use common\entities\Stock\StockPresent;
use common\entities\Stock\StockProduct;
use common\helpers\DateHelper;
use common\repositories\NotFoundException;
use yii\db\ActiveRecord;


class StockRepository
{
    public function getById($id) : Stock
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByGuid(string $guid) : Stock
    {
        return $this->getBy(['guid' => $guid]);
    }

    public function existsByGuid($guid)
    {
        return Stock::find()->where(['guid' => $guid])->count('*');
    }

    public function test()
    {
        dd('test');
    }


    public function getStockCustomer($customerId)
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

    public function getStockGroup(int $segmentId)
    {
        return StockGroup::find()
            ->where([ 'and',
                    ['group_id' => $segmentId],
                    ['stock.active' => Stock::STATUS_ACTIVE],
                    ['<','stock.date_from', DateHelper::getCurrentTime()],
                    ['>','stock.date_to', DateHelper::getCurrentTime()]
                ]
            )
            ->joinWith('stock')
            ->all();
    }

    public function discountGroup(Customer $customer)
    {
        return Group::find()->where(['id' => $customer->group_id])->one();
    }


    public function relevantProduct($productId)
    {
        return StockProduct::find()
            ->relevantProduct($productId)
            ->joinWith(['stock','productDescription'])
            ->all();
    }

    public function relevantBrand($brandId)
    {
       return StockBrand::find()
            ->relevantBrand($brandId)
            ->joinWith('stock')
            ->all();
    }

    public function relevantCategories($categorieIds)
    {
        return StockCategory::find()
            ->relevantCategories($categorieIds)
            ->joinWith('stock')
            ->all();
    }



    public function getProductIds(Stock $stock)
    {
        return StockProduct::find()
            ->joinWith(['product'])
            //->where(['and',['stock_id' => $stock->id],['product.sale' => 1]])
            ->where(['and',['stock_id' => $stock->id]])
            ->all();
    }


    public function getBrandIds(Stock $stock)
    {
        return StockBrand::find()
            ->where(['stock_id' => $stock->id])
            ->all();
    }

    public function getCategoryIds(Stock $stock)
    {
        return StockCategory::find()->where(['stock_id' => $stock->id])->all();

    }
    public function getPresentIds(Stock $stock)
    {
        return StockPresent::find()->where(['stock_id' => $stock->id])->all();

    }

    //получение id товаров из stock_product по stockId
    public function getIdProductByStock(Stock $stock)
    {
        return StockProduct::find()
            ->select('product_id')
            ->where(['stock_id' => $stock->id])
            ->asArray()
            ->all();
    }


    //получение акций в которых участвует товар, из stock_product
    //кроме акции $stockId
    public function getStockProductByProductId($productId, $stockId)
    {
        return StockProduct::find()
            ->joinWith('stock')
            ->asArray()
            ->where(['and',
                ['product_id' => $productId],
                ['<>','stock_id',$stockId],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->all();
    }


    /*======edit========*/
    //получение акций в которых участвует товар, из stock_product
    public function getStockProductByProductIdEdit($productId, $stockId)
    {
        return StockProduct::find()
            ->joinWith('stock')
            ->asArray()
            ->where(['and',
                ['product_id' => $productId],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->all();
    }

    //получение всех акций в которых участвую категории
    public function getStockCategoryByCategoryIds($categories, $stockId)
    {
        return StockCategory::find()
            ->joinWith('stock')
            ->asArray()
            ->where(['and',
                ['in','category_id' , $categories],
                ['<>','stock_id',$stockId],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->all();
    }

    //получение всех акций в которых участвую категории
    public function getStockCategoryByCategoryIdsEdit($categories, $stockId)
    {
        return StockCategory::find()
            ->joinWith('stock')
            ->asArray()
            ->where(['and',
                ['in','category_id' , $categories],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->all();
    }



    //получение акций в которых участвует товар, из stock_brand
    //кроме акции $stockId
    public function getStockBrandByProductId($brandId, $stockId)
    {
        return StockBrand::find()
            ->joinWith('stock')
            ->asArray()
            ->where([
                'and',
                ['brand_id' => $brandId],
                ['<>','stock_id',$stockId],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
                ]
            )->all();
    }
    //получение акций в которых участвует товар, из stock_brand
    //кроме акции $stockId
    public function getStockBrandByProductIdEdit($brandId, $stockId)
    {
        return StockBrand::find()
            ->joinWith('stock')
            ->asArray()
            ->where([
                'and',
                ['brand_id' => $brandId],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
                ]
            )->all();
    }

    public function getOptDiscount(int $segmentId)
    {
        return StockGroup::find()
            ->joinWith('stock')
            ->where([
                    'and',
                    ['group_id' => $segmentId],
                    ['<','stock.date_from', DateHelper::getCurrentTime()],
                    ['>','stock.date_to', DateHelper::getCurrentTime()]
                ]
            )->all();

    }

    public function getStockProductByProduct(int $productId)
    {
        return StockProduct::find()
            ->where(['and',
                ['stock_product.product_id' => $productId],
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->joinWith(['stock','productDescription'])
            ->all();
    }

    public function getStockProductByBrand(int $manufacturerId)
    {
        return StockBrand::find()
            ->where(['and',
                ['brand_id' => $manufacturerId],
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->joinWith('stock')
            ->all();
    }

    public function getStockProductByCategory(array $categoriesIds)
    {
        return StockCategory::find()
            ->where(['and',
                ['in','category_id',$categoriesIds],
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]
            ])
            ->joinWith('stock')
            ->all();
    }


    public function save(Stock $stock)
    {
        $stock->save();
    }

    public function removeChildrenByStockId($stockClass, Stock $stock)
    {
        $stockClass::deleteAll(['stock_id' => $stock->getId()]);

    }

    private function getBy($condition)
    {
        if(!$stock = Stock::find()->where($condition)->one()){
            throw new NotFoundException('Stock not found.');
        }

        return $stock;
    }
}