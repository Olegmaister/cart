<?php

namespace common\helpers\stock;


use common\entities\Stock\Stock;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class StockHelper
{
    public static function statusList(): array
    {
        return [
            Stock::STATUS_ACTIVE => 'активна',
            Stock::STATUS_DRAFT => 'нет',
        ];
    }

    public static function countingList(): array
    {
        return [
            Stock::COUNTING_MONEY => 'фиксированная',
            Stock::COUNTING_PERCENT => 'процент',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Stock::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            case Stock::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function countingLabel($counting_method): string
    {
        switch ($counting_method) {
            case Stock::COUNTING_MONEY:
                $class = 'label label-info';
                break;
            case Stock::COUNTING_PERCENT:
                $class = 'label label-primary';
                break;
        }

        return Html::tag('span', ArrayHelper::getValue(self::countingList(), $counting_method), [
            'class' => $class,
        ]);
    }
}


