<?php
namespace api\entities;

use Yii;
use yii\db\ActiveRecord;
/**
 * @property int $id
 * @property string $data
 * @property string $type
 * @property int $server_ip
 */
class Synchronize extends ActiveRecord
{
    const TYPE = 'stock';

    public static function create($data) : self
    {
        $object = new self();
        $object->data = $data;
        $object->type = self::TYPE;
        $object->server_ip = Yii::$app->request->userIP;

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%synchronize_log}}';
    }
}