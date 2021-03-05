<?php
namespace common\entities\queries;

use common\entities\Products\Product;
use yii\db\ActiveQuery;

class ProductQuery extends ActiveQuery
{
    public function active($alias = null)
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Product::STATUS_ACTIVE,
        ]);
    }

    public function brandId($id)
    {
        return $this->andWhere([
            'brand_id' => $id
        ]);
    }
}
