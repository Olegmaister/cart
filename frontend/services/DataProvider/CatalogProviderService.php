<?php

namespace frontend\services\DataProvider;

use Yii;
use frontend\components\ApiCurrency;
use frontend\services\AttributeService;
use frontend\services\ProductService;
use frontend\repositories\ProductRepository;
use common\entities\Products\Product;
use yii\data\ActiveDataProvider;

class CatalogProviderService
{
    public static function getProductProvider($ids, $sort = ['sort_stock_status' => SORT_DESC], $queryOther = false)
    {
        $get = Yii::$app->request->get();

        if (isset($get['attributes']) && !empty($get['attributes'])) {
            $attributeIds = explode(',', $get['attributes']);

            /*
             * Проверяем если атр_ид относятся к одной группе то плюсуем их
             * иначе то оставляем только совпавшие!!!
             */
            if (AttributeService::checkAttrGroup($attributeIds)) {
                // удаляем товары которые не совпали
                $productIds = AttributeService::getDiffData($ids, $attributeIds);
            } else {
                // Плюсуем товары так-как одна группа
                $productIds = array_flip(array_intersect(
                    array_flip($ids),
                    array_column(ProductRepository::getProductsMpnByAttributes($attributeIds, true), 'product_mpn')
                ));
            }
        } else {
            $productIds = $ids;
        }

        // Сортировка по 3 группам - Наличие, категории и просмотры
        // MAX(product.sort_category) as sort_cat,SUM(product.stock_status) as sort_stock_status,
        // MAX(product.viewed) as   sort_viewed,
        /*
            CASE
            WHEN MAX(product.viewed) AND stock_status = 1  THEN product.viewed
            END sort_viewed,
         */
        $query = Product::find()
            ->select(
                'CASE
                    WHEN SUM(product.stock_status) > 0 THEN 1
                    ELSE 0 END sort_stock_status,
                    MAX(product.viewed) as   sort_viewed,
                    product.*'
            )
            ->where(['in', 'product.mpn', array_flip($productIds)])
            ->andWhere(['product.status' => 1])
            ->andWhere(['>', 'product.price', 0])
            //->orderBy('SUM(product.stock_status) DESC')
            ->groupBy('product.mpn');

        // хиты, новинки, распродажа, рекомендуемые
        if($queryOther) {
            $query->andFilterWhere(['=', $queryOther, 1]);
        }


        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 21,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            'sort' => [
                'defaultOrder' => $sort
                //'defaultOrder' => ['sort_stock_status' => SORT_DESC]

                /*'attributes' => [
                    'sort_stock_status' => [
                        'asc' => ['sort_stock_status' => SORT_ASC],
                        'desc' => ['sort_stock_status' => SORT_DESC],
                    ]
                ],*/
            ],
        ]);

        // Дополнительные сортировки
        $sort = $provider->getSort();
        //$sort->defaultOrder = ['sort_stock_status' => SORT_DESC];
        $sort->attributes['sort_stock_status'] = [
            'asc' => ['sort_stock_status' => SORT_ASC],
            'desc' => ['sort_stock_status' => SORT_DESC]
        ];
        /*$sort->attributes['sort_category'] = [
            'asc' => ['sort_category' => SORT_ASC],
            'desc' => ['sort_category' => SORT_DESC]
        ];*/
        $sort->attributes['sort_viewed'] = [
            'asc' => ['sort_viewed' => SORT_ASC],
            'desc' => ['sort_viewed' => SORT_DESC]
        ];

        $provider->setSort($sort);
        //dd( $provider->getSort() );

        if (isset($get['color_group']) || isset($get['colors'])) {

            if (isset($get['color_group']) && !empty($get['color_group'])) {
                $colorGroup = explode(',', $get['color_group']);
            }

            if (isset($get['colors']) && !empty($get['colors'])) {
                $colors = explode(',', $get['colors']);
            }

            if(isset($colorGroup) && isset($colors)) {
                $grpupQuery = ProductService::buildColorGroup(clone $query, $colorGroup, $colors);

                if($grpupQuery) {
                    $query->andFilterWhere(['or',
                        ['in', 'product.color', $colors],
                        ['in', 'product.color_group', $grpupQuery]
                    ]);
                } else {
                    $query->andFilterWhere(['in', 'product.color', $colors]);
                }

            } elseif(isset($colorGroup)) {
                $query->andFilterWhere(['in', 'product.color_group', $colorGroup]);
            } elseif (isset($colors)) {
                $query->andFilterWhere(['in', 'product.color', $colors]);
            }
        }

        if (isset($get['brands']) && !empty($get['brands'])) {
            $brands = explode(',', $get['brands']);

            if (count($brands) > 1) {
                $query->andFilterWhere(['in', 'product.manufacturer_id', $brands]);
            } else {
                //$query->andFilterWhere(['=', 'product.manufacturer_id', $get['brands']]);
                $query->andFilterWhere(['in', 'product.manufacturer_id', $brands]);
            }
        }

        if (isset($get['price_min']) && isset($get['price_max'])) {
            $currency = new ApiCurrency();

            $query->andFilterWhere([ 'and',
                ['>=', 'price', (int) $currency->getCurrencyMultiply($get['price_min'])],
                ['<=', 'price', (int) $currency->getCurrencyMultiply($get['price_max'])],
            ]);
        }

        return [
            'provider' => $provider,
            'query' => $query
        ];
    }
}