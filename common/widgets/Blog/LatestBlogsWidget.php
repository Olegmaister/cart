<?php
namespace common\widgets\Blog;

use common\entities\Blog\BlogCategory;
use common\entities\Blog\BlogTagAssignment;
use yii\base\Widget;

class LatestBlogsWidget extends Widget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {

        //получение 3 записей по блогу

        //вынести в repo
        $model = BlogCategory::find()
            ->with(['childrenDescription','tagDescriptions','mainPhoto','likes'])
            ->where(['>','depth',1])->limit(3)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        return $this->render('last',[
            'model' => $model
        ]);
    }

}