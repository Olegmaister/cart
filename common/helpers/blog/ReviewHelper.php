<?php

namespace common\helpers\blog;

use common\entities\Blog\review\BlogReview;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class ReviewHelper
{
    public static function statusList(): array
    {
        return [
            BlogReview::STATUS_NEW => 'Новый',
            BlogReview::STATUS_ACTIVE => 'опубликован',
            BlogReview::STATUS_REJECTED => 'откланен',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case BlogReview::STATUS_NEW:
                $class = 'label label-default';
                break;
            case BlogReview::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            case BlogReview::STATUS_REJECTED:
                $class = 'label label-danger';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}

