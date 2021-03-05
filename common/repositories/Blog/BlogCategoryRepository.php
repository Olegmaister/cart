<?php
namespace common\repositories\Blog;

use common\entities\Blog\BlogCategory;
use common\entities\Blog\BlogCategoryAssignment;
use common\helpers\LanguageHelper;
use common\repositories\NotFoundException;

class BlogCategoryRepository
{
    const SLUG_ROOT = 'root';



    public function getId($id) : BlogCategory
    {
        return BlogCategory::find()
            ->where(['id' => $id])
            ->one();
    }

    public function getById($id) : BlogCategory
    {
        return $this->getBy(['id' => $id]);
    }

    public function getByName($name) : BlogCategory
    {
        return $this->getBy(['name' => $name]);
    }

    public function getRoot() : BlogCategory
    {
        return BlogCategory::find()
            ->where(['slug' => self::SLUG_ROOT])
            ->one();
    }

    public function save(BlogCategory $category) : void
    {
        if(!$category->save()){
            throw new \DomainException('Saving error.');
        }
    }

    public function getCategoryDescendants(BlogCategory $category) : array
    {
        return $category->getDescendants()->all();
    }

    public function deleteCategoryWithChildren(BlogCategory $category) : void
    {
        if(!$category->deleteWithChildren()){
            throw new \DomainException('Delete error.');
        }
    }

    public function delete(BlogCategory $category) : void
    {
        if(!$category->delete()){
            throw new \DomainException('Delete error.');
        }
    }

    public function remove($id) : void
    {

    }

    public function getMainMenu()
    {
        $menus =  BlogCategory::find()
            ->with(['mainDescription' => function($q)
            {
                $q->where(['language_id' => LanguageHelper::getCurrentId()]);
            },'url'])
            ->where(['depth' => 1])
            ->all();

        foreach ($menus as $key=>$menu) {
            $result = BlogCategoryAssignment::find()
                ->where(['main_id' => $menu->id])
                ->one();

            if(!$result){
                $children = $menu->children;
                if(empty($children)){
                    unset($menus[$key]);
                }
            }

        }

        return $menus;

    }

    public function getAboutMenu()
    {
        return BlogCategory::find()
            ->with(['mainDescription','url'])
            ->where(['and',['depth' => 1],['about' => 1]])
            ->all();
    }

    private function getBy($condition)
    {
        if(!$category = BlogCategory::find()
            ->with('mainDescriptions')
            ->where($condition)->one()){
            throw new NotFoundException('Category not found.');
        }

        return $category;
    }
}