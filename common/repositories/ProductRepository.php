<?php
namespace common\repositories;


use common\entities\Products\Product;
use \backend\entities\Order\Product as BackendProduct;
use common\entities\Products\ProductInCategory;
use common\helpers\LanguageHelper;

class ProductRepository
{

    public function getId($productId) : Product
    {

       return Product::find()
            ->joinWith(['description'])
            ->where(['and',['product.product_id' => $productId],['product_description.language_id' => LanguageHelper::getCurrentId()]])
            ->one();
    }

    public function getByIdNotification($productId) : Product
    {
        if(!$product = Product::find()
            ->select(['product_id','manafacturer_id'])
            ->where($productId)->one()){
            throw new \DomainException('Product not found.');
        }
    }

    public function getByIdInfoStock($productId)
    {
        return Product::find()->select(
            [
                'product_id',
                'manufacturer_id'
            ]
        )->where(['product_id' => $productId])->one();
    }

    public function getByIds(array $ids)
    {
        return Product::find()
            ->select(['product_id','shares','shares_date_to'])
            ->where(['in','product_id',$ids])
            ->asArray()
            ->all();
    }

    public function getByStock($productId) : Product
    {
        return Product::find()
            ->select(['product_id','shares'])
            ->where(['product_id' => $productId])
            ->one();
    }

    public function getByIdCart($productId)
    {
        return Product::find()
            ->select(['product_id','model','sku','image','manufacturer_id','price','weight','sale'])
            ->where(['product.product_id' => $productId])
            ->with(['categoryId'],['url'],['brandLimitation'],['description' => function($q){
                $q->where(['language_id' => \Yii::$app->language]);
                $q->select(['name']);
            }])
            ->one();
    }

    public function getByIdCartPresent($productId, $languageId)
    {
        return Product::find()
            ->select(['product_id','image','color'])
            ->where(['product.product_id' => $productId])
            ->with(['url'],['description' => function($q){
                $q->where(['language_id' => 2]);
                $q->select(['name']);
            }])
            ->one();
    }

    public function getByIdCartOrder($productId)
    {
        return BackendProduct::find()
            ->select(['product_id','color','model','sku','image','manufacturer_id','price','price_old','weight','sale'])
            ->where(['product.product_id' => $productId])
            ->with(['categoryId'],['url'],['description' => function($q){
                $q->where(['language_id' => \Yii::$app->language]);
                $q->select(['name']);
            }])
            ->one();
    }




    public function save(Product $product)
    {
        if(!$product->save(false)){
            dd('упссс...');
        }
    }

    private function getBy($condition)
    {
        if(!$product = Product::find()->where($condition)->one()){
            throw new \DomainException('Product not found.');
        }
        return $product;
    }
}