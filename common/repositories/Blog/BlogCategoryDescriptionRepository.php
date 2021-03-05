<?php
namespace common\repositories\Blog;

use common\entities\Blog\BlogCategoryChildrenDescription;
use common\entities\Blog\BlogCategoryDescription;
use common\entities\Blog\BlogCategoryMainDescription;

class BlogCategoryDescriptionRepository
{
    public function getByMainId($id) : BlogCategoryMainDescription
    {
        return BlogCategoryMainDescription::find()
            ->where(['id' => $id])
            ->one();
    }
    public function getById($id) : BlogCategoryChildrenDescription
    {
        return BlogCategoryChildrenDescription::find()
            ->where(['id' => $id])
            ->one();
    }


    private function getBy($condition)
    {
        if(!$categoryDescription = BlogCategoryDescription::find()
            ->where($condition)->one()){
            throw new \DomainException('CategoryDescription not found.');
        }

        return $categoryDescription;
    }
}