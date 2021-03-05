<?php
namespace common\readModels\Blog\review;

use common\entities\Blog\review\BlogReview;
use frontend\entities\Blog\Blogs;
use frontend\entities\Blog\Review;
use yii\data\ActiveDataProvider;

class ReviewReadRepository
{
    public function getAllByBlog($blogId)
    {

        $page = \Yii::$app->request->get('page') ? \Yii::$app->request->get('page') : 1;

        $result = BlogReview::find()
            ->where(
                [
                    'and',
                    ['blog_id' => $blogId],
                    ['depth' => 1],
                    ['status' => BlogReview::STATUS_ACTIVE]
                ])
            ->asArray()
            ->all();


        $ids = [];

        foreach ($result as $item) {
            $ids[] = $item['id'];
        }


            $query = $this->getQueryBuilderBlogs($ids);
            $count = $this->getCount($query);
            $provider =  $this->getProvider($query);
            return $providers = new Review($provider, $count, $page);

        //получить все коменты первого уровня для блога

    }

    private function getCount($query)
    {
        return $query->count();
    }

    private function getQueryBuilderBlogs($ids)
    {
        return BlogReview::find()
            ->where(['in','id',$ids])
            ->orderBy(['created_at' => SORT_DESC])
            ->where(['and',['status' => BlogReview::STATUS_ACTIVE],['depth' => 1]])
            ->with(['blogReviewDescription']);
    }

    private function getProvider($query, $page = 1) : ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Review::DISPLAY_ON_PAGE,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],

        ]);
    }
}