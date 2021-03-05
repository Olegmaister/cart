<?php
namespace common\widgets\Blog;

use common\entities\Blog\BlogCategory;
use common\entities\Blog\BlogTagAssignment;
use common\readModels\Blog\BlogReadRepository;
use yii\base\Widget;

class RightWidget extends Widget
{

    public $category;

    private $repository;

    public function __construct(BlogReadRepository $repository,$config = [])
    {

        $this->repository = $repository;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    public function run()
    {


        $model = $this->repository->getSimilarBlogs($this->category);
        $parent = $this->category->parent->mainDescription;

        return $this->render('right',[
                'model' => $model,
                'parent' => $parent
            ]);
    }

}
