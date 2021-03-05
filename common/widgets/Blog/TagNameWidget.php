<?php
namespace common\widgets\Blog;

use common\entities\Blog\BlogCategory;
use yii\base\Widget;

class TagNameWidget extends Widget
{
    public $category;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('tag',[
            'category' => $this->category
        ]);
    }

}