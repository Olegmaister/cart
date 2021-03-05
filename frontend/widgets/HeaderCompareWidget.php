<?php

namespace frontend\widgets;

use common\helpers\LanguageHelper;
use frontend\helpers\CompareHelper;
use yii\base\Widget;
use Yii;

class HeaderCompareWidget extends Widget
{
    public function run(): string
    {
        return $this->render('header_compare', [
            'data' => (new CompareHelper())->getCompareCategories(Yii::$app->user->id, LanguageHelper::getCurrentId())
        ]);
    }
}
