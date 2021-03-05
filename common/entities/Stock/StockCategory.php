<?php

namespace common\entities\Stock;

use common\entities\queries\StockQuery;
use Yii;
use common\entities\Categories\Category;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock_category}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property int $category_id
 * @property  $segment_json
 *
 * @property Category $category
 * @property Stock $stock
 */
class StockCategory extends ActiveRecord
{


    public static function create($categoryId,$segments)
    {
        $object = new self();
        $object->category_id = $categoryId;
        $object->segment_json = $segments;

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_category}}';
    }


    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['category_id' => 'category_id']);
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
