<?php

namespace frontend\services\DataProvider;

use common\entities\Products\ProductReview;
use yii\data\ActiveDataProvider;

class ReviewsProviderService
{
    public static function getData()
    {
        $query = ProductReview::find()
            ->where('product_review.review_id = product_review.answer_review_id')
            ->andWhere([
                'status' => ProductReview::STATUS_ACTIVE,
                'language_id' => 2
            ]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
                'pageSizeParam' => false,
                'forcePageParam' => false
            ],
            'sort' => [
                'defaultOrder' => [
                    'date_modified' => SORT_DESC
                ],
            ],
        ]);

        return $provider;
    }
}