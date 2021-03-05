<?php
namespace common\widgets\Blog;

use common\entities\Blog\BlogCategory;
use yii\base\Widget;

class BlogHotWidget extends Widget
{


    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $model = BlogCategory::find()
            ->with(['childrenDescription','tagDescriptions','mainPhoto','likes'])
            ->where(['>','depth',1])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->all();

        return $this->render('hot',[
            'model' => $model
        ]);
    }

}
