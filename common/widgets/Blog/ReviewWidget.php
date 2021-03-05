<?php
namespace common\widgets\Blog;

use common\entities\Blog\BlogCategory;
use yii\base\Widget;

class ReviewWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('review',[
        ]);
    }

}
