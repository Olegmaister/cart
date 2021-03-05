<?php

namespace frontend\services\DataProvider;

use common\entities\Categories\CategoryPath;
use Yii;
use common\entities\Categories\Category;
use common\entities\Products\ProductInCategory;
use yii\data\ActiveDataProvider;
use common\entities\Brands\Brand;

class BrandProviderService
{
    public static function getBrands($count = 8)
    {
        $get = Yii::$app->request->get();

        $query = Brand::find()
            ->joinWith(['description'])
            //->with(['description'])
            ->where(['status' => 1]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $count,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            /*'sort' => [
                'defaultOrder' => [
                    'brand_id' => SORT_DESC
                ],
            ],*/
        ]);

        $provider->setSort([
            'attributes' => [
                'description' => [
                    'desc' => ['brand_description.name' => SORT_DESC],
                    'asc' => ['brand_description.name' => SORT_ASC],
                ],
            ],
            'defaultOrder' => [ 'description' => SORT_ASC ],
        ]);

        if(isset($get['search']) && !empty($get['search'])) {
            $query->andFilterWhere(['LIKE', 'brand_description.name', $get['search']]);
        }

        if(isset($get['country_id'])) {
            $query->andFilterWhere(['=', 'brand.country_id', $get['country_id']]);
        }

        return $provider;
    }

    public static function getBrandCategories($ids, $level = 0)
    {
        $idsInCat = ProductInCategory::find()
            ->select('category_id')
            ->distinct()
            ->where(['in', 'product_id', $ids])
            ->andWhere(['<>', 'category_id', 137004]); // Без новинок

        $categoryPath = CategoryPath::find()
            ->select('category_id')
            ->where('category_id=parent_id')
            ->andWhere(['in', 'category_id', $idsInCat])
            ->andWhere(['level' => $level])
            ->asArray()
            ->all();

        $categories = Category::find()
            ->where(['category.status' => 1])
            ->andWhere(['in', 'category.category_id', array_column($categoryPath, 'category_id')]);

        $provider = new ActiveDataProvider([
            'query' => $categories,
            'pagination' => [
                'pageSize' => 8,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
        ]);

        return $provider;
    }
}