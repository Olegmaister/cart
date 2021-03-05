<?php
namespace common\readModels\Blog;

use common\entities\Blog\BlogCategory;
use common\entities\Blog\BlogCategoryAssignment;
use frontend\entities\Blog\Blogs;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class BlogReadRepository
{
    /*
     *
     * **/
    public function getAllByBlog($blogs)
    {
        $providers = [];


        $page = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;

        foreach ($blogs as $i=>$blog) {
            if(!$blog->id){
                $ids = $this->getAllIdsCategories($blog);
            }else{
                $ids = $this->getIdsByCategoriesAndAssignments($blog->id);
            }


            $query = $this->getQueryBuilderBlogs($ids);
            $count = $this->getCount($query);
            $provider = $this->getProvider($query);
            $providers[] = new Blogs($provider, $blog->id, $count,$page);

        }

        return $providers;
    }
    public function getAllByBlogAbout($blogs)
    {


        $providers = [];

        $page = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;

        foreach ($blogs as $i=>$blog) {
            if(!$blog->id){
                $ids = $this->getAllIdsCategories($blog);
            }else{
                $ids = $this->getIdsByCategoriesAndAssignments($blog->id);
            }

            $query = $this->getQueryBuilderBlogs($ids);
            $count = $this->getCount($query);
            $provider = $this->getProvider($query);
            $providers[] = new Blogs($provider, $blog->id, $count,$page);

        }

        return $providers;
    }


    public function getByBlog(int $id, int $page,$tempory)
    {

        if(!$id){
            $ids = $this->getAllIdsCategories($tempory);
        }else{
            $ids = $this->getIdsByCategoriesAndAssignments($id);
        }
        $query = $this->getQueryBuilderBlogs($ids);
        $count = $this->getCount($query);

        $provider =  $this->getProvider($query);
        return new Blogs($provider, $id, $count, $page);

    }

    public function getSimilarBlogs(BlogCategory $category)
    {
        $parent = $category->parent;


        $model = BlogCategory::find()
            ->with(['childrenDescription','tagDescriptions','mainPhoto'])
            ->where(['and',['>','lft',$parent->lft],['<','rgt',$parent->rgt],['<>','id',$category->id]])
            ->all();


        return $model;

    }

    private function getCategory($id)
    {
        return BlogCategory::find()->where(['id' => $id])->one();
    }

    private function getCount($query)
    {
        return $query->count();
    }

    public function getIdsChildren($id)
    {
        return $this->getIdsByCategoriesAndAssignments($id);
    }

    private function getIdsByCategoriesAndAssignments($id)
    {
        //получение главной категории(вынести в репо)
        /**@var BlogCategory $category*/
        $category = $this->getCategory($id);

        //получение id блогов по данной категории
        $blogIds = BlogCategory::find()
            ->select('id')
            ->where(['and',['>','lft',$category->lft],['<','rgt',$category->rgt]])
            ->asArray()->all();


        //получение из таблицы category_assignment id блогов ,
        // которые нужно показать в данной категории
        $blogsIds1 = BlogCategoryAssignment::find()
            ->select('blog_id as id')
            ->where(['main_id' => $category->id])
            ->asArray()
            ->all();


        return ArrayHelper::getColumn(ArrayHelper::merge($blogIds, $blogsIds1),'id');


    }

    public function getIdsMain($category)
    {
        return $this->getAllIdsCategories($category);
    }

    private function getAllIdsCategories($blog)
    {

        //получение id блогов по данной категории
        $blogIds = BlogCategory::find()
            ->select('id')
            ->where(['and',['>','depth',1],['>=','lft',$blog->lft],['<=','rgt',$blog->rgt]])
            ->asArray()->all();

        return ArrayHelper::getColumn($blogIds,'id');

    }

    private function getQueryBuilderBlogs($ids)
    {

        return  BlogCategory::find()
            ->where(['in','id',$ids])
            ->orderBy(['created_at' => SORT_DESC])
            ->with(['childrenDescription','tagDescriptions','mainPhoto']);
    }


    private function getProvider($query, $page = 1) : ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Blogs::DISPLAY_ON_PAGE,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],

        ]);
    }
}