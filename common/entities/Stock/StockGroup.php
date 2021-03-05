<?php

namespace common\entities\Stock;

use common\entities\Group;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock_group}}".
 *
 * @property int $id
 * @property int|null $stock_id
 * @property int|null $group_id
 */
class StockGroup extends ActiveRecord
{

    public static function create($groupId)
    {
        $object = new self();
        $object->group_id = $groupId;

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_group}}';
    }

    public function getStock()
    {
        return $this->hasOne(Stock::class, ['id' => 'stock_id']);
    }

    public function getGroup()
    {
        return $this->hasOne(Group::class, ['id' => 'group_id']);
    }
}
