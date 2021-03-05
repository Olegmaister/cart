<?php

namespace common\helpers\order;

use common\entities\Order;
use common\entities\Status;
use common\helpers\LanguageHelper;
use common\models\OrderStatus;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class StatusesHelper
{
    public static function statusList(): array
    {
        $languageName = 'name_ru';

        switch (LanguageHelper::getIdByCode(Yii::$app->language)) {
            case 1 :
                $languageName = 'name_en';
                break;
            case 3 :
                $languageName = 'name_ua';
                break;
        }

        return OrderStatus::find()
            ->select([$languageName])
            ->indexBy('id')
            ->column();
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Status::NEW:
                $class = 'label label-default';
                break;
            case Status::PAID:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function getCountNewOrders()
    {
        return Order::find()
            ->where(['current_status' => Status::NEW])
            ->count();
    }
}
