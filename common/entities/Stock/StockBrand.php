<?php

namespace common\entities\Stock;

use common\entities\Brands\Brand;
use common\entities\queries\StockQuery;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%stock_brand}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $brand_id
 * )))
 * @property Json $segment_json
 *
 * @property Brand $brand
 * @property Stock $stock
 */
class StockBrand extends ActiveRecord
{

    public static function create(int $brandId,$segments)
    {
        $object = new self();
        $object->brand_id = $brandId;
        $object->segment_json = $segments;
        return $object;

    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_brand}}';
    }


    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['brand_id' => 'brand_id']);
    }

    /**
     * Gets query for [[Stock]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::class, ['id' => 'stock_id']);
    }

    public static function find(): StockQuery
    {
        return new StockQuery(static::class);
    }
}
