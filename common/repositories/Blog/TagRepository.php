<?php
namespace common\repositories\Blog;



use common\entities\Blog\BlogTag;

class TagRepository
{
    public function getById($id) : BlogTag
    {
        return $this->getBy(['id' => $id]);
    }



    public function save(BlogTag $tag) : void
    {
        if(!$tag->save()){
            throw new \DomainException('Saving error.');
        }
    }


    private function getBy($condition)
    {
        if(!$tag = BlogTag::find()->where($condition)->one()){
            throw new \DomainException('Tag not found.');
        }

        return $tag;
    }
}