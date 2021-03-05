<?php
namespace common\repositories;

use common\entities\Products\ProductInCategory;

class ProductInCategoryRepository
{
    public function getProductByCategory($categoryIds)
    {
        return  ProductInCategory::find()
            ->select('product.product_id')
            ->joinWith(['product' => function($q){
                $q->where(['sale' => 0]);
            }])
            ->where(['in','category_id', $categoryIds])
            ->all();

    }


}