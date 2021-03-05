<?php

namespace frontend\services;

use common\entities\Products\Product;
use common\entities\Products\ProductInCategory;

class BrandService
{
    public static function getSliderData($brandId, $catIds, $langId, $brandName)
    {
        $categorySlider = [];

        $query = Product::find()
            ->select('product_id')->distinct()
            ->where(['manufacturer_id' => $brandId]);

        $products = ProductInCategory::find()
            ->select('category_id')->distinct()
            ->where(['in', 'product_id', $query])
            ->andWhere(['in', 'category_id', $catIds])
            ->asArray()->all();

        if ($products) {
            $categorySlider = CategoriesService::getCategoryBrandParents(array_column($products, 'category_id'), $langId);
        }

        if (isset($brandName->url->keyword)) {
            $categorySlider = array_map(function ($a) use ($brandName) {
                $a['keyword'] = $brandName->url->keyword . '/' . $a['keyword'];
                return $a;
            }, $categorySlider);
        }

        return $categorySlider;
    }
}