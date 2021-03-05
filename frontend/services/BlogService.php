<?php

namespace frontend\services;

use Yii;
use yii\helpers\ArrayHelper;
use common\entities\Blog\BlogCategoryAssignment;
use common\entities\Blog\BlogCategory;
use common\entities\Blog\BlogTagAssignment;
use common\helpers\DateHelper;

class BlogService
{
    public static function buildImageUrl($item)
    {
        return Yii::$app->params['homeUrl'] . '/frontend/web/images/blogs/' . $item['id'] . '/slider_' .
            $item['main_photo_id'] . substr($item['file'], -4);
    }

    public static function getTagsByIds($ids, $langId)
    {
        $tagDescriptionsQuery = BlogTagAssignment::find()
            ->select('blog_tag_assignment.*, blog_tag.slug, blog_tag_description.name')
            ->leftJoin('blog_tag', 'blog_tag_assignment.tag_id=blog_tag.id')
            ->leftJoin('blog_tag_description', 'blog_tag_description.tag_id=blog_tag.id')
            ->where(['in', 'blog_tag_assignment.blog_id', $ids])
            ->andWhere(['blog_tag_description.language_id' => $langId])
            ->asArray()
            ->all();

        $tagDescriptions = [];
        foreach ($tagDescriptionsQuery as $tag) {
            $tagDescriptions[$tag['blog_id']][] = $tag;
        }

        return $tagDescriptions;
    }

    public static function getQueryByCondition($condition, $langId)
    {
        // все  ['>','depth',1];
        // по категориям   ['in', 'id', $ids];

        return BlogCategory::find()
            ->select('blog_category.*, url_alias.keyword,
                        blog_photos.file,blog_category_children_description.name')
            ->leftJoin('blog_photos', 'blog_photos.id=blog_category.main_photo_id')
            ->leftJoin('url_alias', 'url_alias.id=blog_category.id')
            ->leftJoin('blog_category_children_description', 'blog_category_children_description.category_id=blog_category.id')
            ->where($condition)
            ->andWhere([
                'url_alias.controller' => 'blogs',
                'blog_category_children_description.language_id' => $langId,
            ])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->asArray()
            ->all();
    }

    public static function buildMainData($condition, $langId, $menus = false, $categoryName = false)
    {
        $blogsMenuQuery = self::getQueryByCondition($condition, $langId);
        $ids = array_column($blogsMenuQuery, 'id');
        $tagDescriptions = self::getTagsByIds($ids, $langId);

        $blogsMenu = [];
        foreach ($blogsMenuQuery as $key => $blog) {
            $blogsMenu[$key] = [
                'image_url' => self::buildImageUrl($blog),
                'id' => $blog['id'],
                'slug' => $blog['slug'],
                'like' => $blog['like'],
                'keyword' => $blog['keyword'],
                'name' => $blog['name'],
                'date_formate' => DateHelper::getFormatDate($blog['created_at'])
            ];

            if (isset($tagDescriptions[$blog['id']][0])) {
                $blogsMenu[$key]['tags'] = $tagDescriptions[$blog['id']];
            }

            if ($menus !== false) {
                foreach ($menus as $menu) {
                    if (in_array($blog['id'], $menu['ids'])) {
                        $blogsMenu[$key]['category_name'] = trim($menu['name']);
                    }
                }
            } elseif ($categoryName !== false) {
                $blogsMenu[$key]['category_name'] = $categoryName;
            } else {
                $blogsMenu[$key]['category_name'] = '';
            }
        }

        return $blogsMenu;
    }

    public static function getQueryMenu($langId)
    {
        $queryMenu = BlogCategory::find()
            ->select('blog_category.*, blog_category_main_description.name')
            ->leftJoin('blog_category_main_description', 'blog_category_main_description.category_id=blog_category.id')
            ->where(['depth' => 1])
            ->andWhere([
                'blog_category_main_description.language_id' => $langId
            ])
            ->asArray()
            ->all();

        foreach ($queryMenu as $key => $menu) {
            $result = BlogCategoryAssignment::find()
                ->where(['main_id' => $menu['id']])
                ->asArray()
                ->one();

            if (!$result) {
                if (empty($children)) {
                    unset($queryMenu[$key]);
                }
            }
        }

        return $queryMenu;
    }

    public static function getMenu($langId)
    {
        $menus = [];
        foreach (self::getQueryMenu($langId) as $key => $menu) {
            $ids = [];
            foreach ($result = array_merge(
                self::getAllIdsCategoriesArr($menu),
                self::getIdsByCategoriesAndAssignmentsArr($menu['id'])
            ) as $item) {
                $ids[$item] = $item;
            }

            $menus[$key] = $menu;
            $menus[$key]['ids'] = $ids;
            $ids = null;
        }

        return $menus;
    }

    public static function getAllIdsCategoriesArr($blog)
    {
        //получение id блогов по данной категории
        $blogIds = BlogCategory::find()
            ->select('id')
            ->where(['and', ['>', 'depth', 1], ['>=', 'lft', $blog['lft']], ['<=', 'rgt', $blog['rgt']]])
            ->asArray()->all();

        return ArrayHelper::getColumn($blogIds, 'id');
    }

    public static function getIdsByCategoriesAndAssignmentsArr($id)
    {
        //получение главной категории
        $category = BlogCategory::find()->where(['id' => $id])->one();

        //получение id блогов по данной категории
        $blogIds = BlogCategory::find()
            ->select('id')
            ->where(['and', ['>', 'lft', $category->lft], ['<', 'rgt', $category->rgt]])
            ->asArray()->all();

        // получение из таблицы category_assignment id блогов ,
        // которые нужно показать в данной категории
        $blogsIds1 = BlogCategoryAssignment::find()
            ->select('blog_id as id')
            ->where(['main_id' => $category->id])
            ->asArray()
            ->all();

        return ArrayHelper::getColumn(ArrayHelper::merge($blogIds, $blogsIds1), 'id');
    }

    public static function getAllData($langId)
    {
        $data['menus'] = self::getMenu($langId);
        $data['mainData'] = BlogService::buildMainData(['>', 'blog_category.depth', 1], $langId, $data['menus']);

        foreach ($data['menus'] as $category) {
            $data['categoryData'][$category['id']] = BlogService::buildMainData(
                ['in', 'blog_category.id', $category['ids']], $langId, false, $category['name']);
        }

        return $data;
    }
}