<?php
namespace common\repositories\Blog;

use common\entities\Blog\BlogLikes;
use common\repositories\NotFoundException;

class BlogLikeRepository
{

    public function getId($blogId,$customerIp)
    {
        return BlogLikes::find()->where(['and',['blog_id' => $blogId],['ip' => $customerIp]])->one();
    }

    public static function save(BlogLikes $like)
    {
        $like->save();
    }

    public function remove(BlogLikes $likes)
    {
        BlogLikes::deleteAll(['id' => $likes->id]);
    }


    private function getBy($condition)
    {
        if(!$category = BlogLikes::find()
            ->where($condition)->one()){
            throw new NotFoundException('Blog like not found.');
        }

        return $category;
    }
}
