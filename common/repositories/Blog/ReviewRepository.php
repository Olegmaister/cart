<?php
namespace common\repositories\Blog;

use common\entities\Blog\review\BlogReview;

class ReviewRepository
{
    public function getRoot() : BlogReview
    {
        return BlogReview::find()
            ->where(['slug' => BlogReview::SLUG_ROOT])
            ->one();
    }

    public function getId($id) : BlogReview
    {
        $review = BlogReview::find()
            ->where(['id' => $id])
            ->one();

        if(!$review)
            throw new \DomainException('not found');

        return $review;
    }

    public function deleteCategoryWithChildren(BlogReview $review) : void
    {
        if(!$review->deleteWithChildren()){
            throw new \DomainException('Delete error.');
        }
    }

    public function getById($id) : BlogReview
    {
        return BlogReview::find()
            ->where(['id' => $id])
            ->one();
    }

    public function save(BlogReview $review)
    {
        $review->save();
    }

}