<?php

namespace frontend\services\DataProvider;

use Yii;
use common\entities\Products\Product;
use yii\data\ActiveDataProvider;

class GroupProviderService
{
    public static function getProductProvider($field, $condition = false, $limit = 8, $sort = false)
    {
        if(!$sort) {
            if ($field == 'new') {
                $sort = [
                    //'stock_status' => SORT_DESC,
                    'date_added' => SORT_DESC
                ];
            } else {
                $sort = [
                    //'stock_status' => SORT_DESC,
                    'sort_category' => SORT_DESC,
                    'viewed' => SORT_DESC
                ];
            }
        }

//dd($sort);
        if (Yii::$app->request->get('page') && !Yii::$app->request->isAjax) {
            Yii::$app->request->setQueryParams(['page' => 1]);
            // $provider->pagination = false;
        }

        $mpn = Product::find()
            ->select('mpn, product_id')
            ->where([
                "status" => Product::STATUS_ACTIVE,
                //"stock_status" => Product::STATUS_ACTIVE,
                "{$field}" => 1
            ])->groupBy('mpn');

        if ($condition) {
            $mpn->andWhere($condition);
        }

        $provider = new ActiveDataProvider([
            'query' => $mpn,
            //->andWhere(['>', 'product.price', 0]);
            'pagination' => [
                'pageSize' => $limit,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            'sort' => [
                'defaultOrder' => $sort
            ],
        ]);

        return $provider;
    }
}