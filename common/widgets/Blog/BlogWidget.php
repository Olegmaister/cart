<?php
namespace common\widgets\Blog;

use common\entities\Blog\BlogCategory;
use common\entities\Blog\BlogCategoryAssignment;
use common\readModels\Blog\BlogReadRepository;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

class BlogWidget extends Widget
{
    public $category;
    private $blogReadRepository;

    public function __construct(
        BlogReadRepository $blogReadRepository,
        $config = [])
    {
        $this->blogReadRepository = $blogReadRepository;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $ids = $this->getIds($this->category);

        $model = BlogCategory::find()
            ->with(['childrenDescription','tagDescriptions','mainPhoto','likes'])
            ->where(['in','id',$ids])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->all();

        return $this->render('index',[
            'model' => $model
        ]);
    }



    public function getIds($category)
    {

        $ids = [];

        foreach ( $result = array_merge(
            $this->blogReadRepository->getIdsMain($category),
            $this->blogReadRepository->getIdsChildren($category->id)
        ) as $item){
            $ids[$item] = $item;
        }


        return $ids;

    }


}