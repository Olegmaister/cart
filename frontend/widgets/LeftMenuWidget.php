<?php

namespace frontend\widgets;

use common\services\RedisService;
use yii\base\Widget;
use Yii;

class LeftMenuWidget extends Widget
{
    public function run()
    {
        return $this->render('left-menu-widget', [
            'categories' => RedisService::getLeftMenuData(),
            'pathInfo' => Yii::$app->request->pathInfo
        ]);
    }
}
