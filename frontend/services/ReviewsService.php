<?php

namespace frontend\services;


use common\entities\Order;
use common\entities\Products\Product;
use common\entities\Products\ProductDescription;
use common\entities\Status;
use common\helpers\LanguageHelper;
use frontend\repositories\ProductRepository;

class ReviewsService
{
    public static function getProductOrders($userId)
    {
        return Order::findAll([
            'current_status' => Status::COMPLETED,
            'customer_id' => $userId
        ]);
    }

    public static function getProductIdsForReviews($userId)
    {
        $orders = ReviewsService::getProductOrders($userId);
        $productIds = [];

        if(isset($orders[0])) {
            foreach($orders as $order) {
                foreach ($order->items as $product) {
                    $productIds[$product->product_id] = $product->product_id;
                }
            }
        }

        return $productIds;
    }

    public static function getReviewsWithRe($productIds)
    {
        $reviews = [];
        if(count($productIds) > 0) {
            foreach ($productIds as $id) {
                $reviews[] = ProductRepository::getProductReviewsById($id);
            }
        }

        return $reviews;
    }

    public static function getProductReviews($productIds, $langId = 2) {
        return Product::find()
            ->select('product.*, product_description.name')
            ->leftJoin('product_description', 'product_description.product_id=product.product_id')
            ->where(['in', 'product.product_id', $productIds])
            ->andWhere(['product_description.language_id' => $langId])
            ->indexBy('product_id')
            ->asArray()
            ->all();
    }

    /*public static function getReviewsProductNames($productIds, $langId = 2)
    {
         $productDescription = ProductDescription::find()
            ->select('product_id, name')
            ->where(['in', 'product_id', $productIds])
            ->andWhere(['language_id' => $langId])
            ->asArray()
            ->all();

         return array_column($productDescription, 'name', 'product_id');
    }*/
}