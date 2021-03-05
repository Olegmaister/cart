<?php

namespace frontend\services;

use Yii;
use common\entities\Categories\Category;
use common\entities\Products\ProductInCategory;
use frontend\entities\ProductOne;
use common\entities\Categories\CategoryPath;
use frontend\repositories\ProductRepository;

class CategoriesService
{
    // Категории для сортировки продуктов в группах: Лидеры, Новигки и Рекомендуемые
    const GROUP_CATEGORY_IDS = [188, 168, 13, 62, 137009];

    public static function getFullTreeSecondLevelCategories()
    {
        $categories = ProductRepository::getСategoriesWithName(0);
        $subCategories = ProductRepository::getСategoriesWithName(1);
        $categoryIds = array_column($categories, 'category_id');
        $categoryPath = ProductRepository::getCategoryPath($categoryIds);

        foreach ($categoryPath as $path) {
            if (isset($categories[$path['parent_id']]) && isset($subCategories[$path['category_id']])) {
                $categories[$path['parent_id']]['children'][] = $subCategories[$path['category_id']];
            }
        }

        return $categories;
    }

    public function wrapper($arr)
    {
        if (isset($arr['link'])) {
            return "<li><a href=\"{$arr['link']}\" data-category_id=\"{$arr['category_id']}\">{$arr['name']}</a></li>";
        }
    }

    public static function getParentCategoriesUpTree($categoryId, $returnParentCategoryId = false)
    {
        $query = ProductRepository::getCategoryParent($categoryId);
        $parents[] = $categoryId;

        WHILE ($query) {
            $parents[] = $query['parent_id'];
            $query = ProductRepository::getCategoryParent($query['parent_id']);
        }

        if ($returnParentCategoryId) {
            return end($parents);
        }

        return ProductRepository::getСategoriesNameByIds($parents);
    }

    public static function getParentCategoriesDownTree($categoryId)
    {
        $parents = ProductRepository::getCategoriesPathByOneCategory($categoryId);
        $allCategories = $categories = array_column($parents, 'category_id');

        WHILE ($categories != null) {
            $array = ProductRepository::getCategoryPath($categories);
            $categories = array_column($array, 'category_id');
            $allCategories = array_merge($allCategories, $categories);
        }

        return $allCategories;
    }

    public static function checkSearchSortCategory($categories = null)
    {
        if($categories) {
            foreach($categories as $key => $category) {
                $parentCategory = CategoriesService::getParentCategoriesUpTree($category->category_id, true);
                $count = count($categories) - 1;

                if(in_array($parentCategory, self::GROUP_CATEGORY_IDS)) {
                    if($parentCategory == 62) {
                        return 12;
                    } elseif ($parentCategory == 137009) {
                        return 188;
                    }
                    return $parentCategory;
                } else {
                    if($count == $key) {
                        return 1;
                    }
                }
            }
        }
        return 1;
    }

    public static function getParentCategoriesForId($categoryId, $langId=2)
    {
        return CategoryPath::find()
            ->select('category.sort_main_menu, category_path.category_id, category_path.parent_id, category_path.level,
                category_description.name, url_alias.keyword, category.image')
            ->leftJoin('category_description', 'category_path.category_id=category_description.category_id')
            ->leftJoin('url_alias', 'category_path.category_id=url_alias.id')
            ->leftJoin('category', 'category.category_id=category_path.category_id')
            ->where('category_path.category_id != category_path.parent_id')
            ->andWhere(['category_path.parent_id' => $categoryId])
            ->andWhere(['category_description.language_id' => $langId])
            ->andWhere(['url_alias.controller' => 'categories', 'action' => 'view'])
            ->orderBy([
                new \yii\db\Expression('case when category.sort_main_menu = 0 then 999 else sort_main_menu end asc')
            ])
            ->asArray()
            ->all();
    }

    public static function getParentCategoryBrandsForId($categoryId, $langId=2)
    {
        $productIds = ProductInCategory::find()
            ->select('product_in_category.product_id')
            ->where(['product_in_category.category_id' => $categoryId])
            ->asArray()
            ->all();

        return ProductOne::find()
            ->select('product.manufacturer_id as brand_id, brand.image, brand_description.name, url_alias.keyword')
            ->where(['in', 'product.product_id', array_column($productIds, 'product_id')])
            ->leftJoin('brand', 'brand.brand_id=product.manufacturer_id')
            ->leftJoin('brand_description', 'brand_description.brand_id=product.manufacturer_id')
            ->leftJoin('url_alias', 'url_alias.id=product.manufacturer_id')
            ->andWhere(['brand_description.language_id' => $langId])
            ->andWhere(['url_alias.controller' => 'brands', 'action' => 'view'])
            ->groupBy('product.manufacturer_id')
            ->asArray()
            ->all();
    }

    public static function getCategoryBrandParents($catIds, $langId = 2)
    {
        if (isset($catIds[0])) {
            return Category::find()
                ->select('category.category_id, category_description.name, url_alias.keyword, category.image')
                ->leftJoin('category_description', 'category.category_id=category_description.category_id')
                ->leftJoin('url_alias', 'category.category_id=url_alias.id')
                ->where(['in', 'category.category_id', $catIds])
                ->andWhere(['category_description.language_id' => $langId])
                ->andWhere(['url_alias.controller' => 'categories', 'action' => 'view'])
                ->asArray()
                ->all();
        }

        return [];
    }
}