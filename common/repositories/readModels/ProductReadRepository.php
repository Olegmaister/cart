<?php
namespace common\repositories\readModels;

use common\entities\Products\Product;
class ProductReadRepository
{
    public function find($productId): ?Product
    {
        return Product::find()->active()->andWhere(['product_id' => $productId])->one();
    }
}