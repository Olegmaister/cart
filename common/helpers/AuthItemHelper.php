<?php
namespace common\helpers;


use common\entities\Rbac\AuthItem;
use yii\helpers\ArrayHelper;
use function globalFunction\functions\dd;

class AuthItemHelper
{
    public static function roleList()
    {
        return ArrayHelper::map(AuthItem::find()->where(['type' => 1])->all(),'name', 'description');
    }
}