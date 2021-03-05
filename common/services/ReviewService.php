<?php

namespace common\services;

use common\entities\Customer;
use common\entities\Products\ProductReview;

class ReviewService
{
    public static function changeStatus($data)
    {
        if(isset($data['review_id'])) {
            $review = ProductReview::findOne(['review_id' => $data['review_id']]);
            $review->status = $data['status'];
            if($review->save()) {
                return true;
            }
        }
        return false;
    }

    public static function addReview($data)
    {
        
        $review = new ProductReview();

        $review->text = htmlspecialchars($data['text']);
        $review->author = htmlspecialchars($data['author']);
        $review->rating = isset($data['vote']) ? $data['vote'] : 0;
        $review->status = isset($data['re']) ? ProductReview::STATUS_ACTIVE : ProductReview::STATUS_NEW;
        $review->language_id = 2;
        $review->product_id = $data['product_id'];
        $review->answer_review_id = (isset($data['answer_review_id']) && $data['answer_review_id'] != 0) ? $data['answer_review_id'] : 0 ;

        if (isset($data['email'])) {
            $customer = Customer::findOne(['email' => $data['email']]);
            if (isset($customer->customer_id)) {
                $review->customer_id = $customer->customer_id;
            }
        }

        if ($review->save()) {
            if(!isset($data['answer_review_id'])) {
                $reviewNew = ProductReview::findOne(['review_id' => $review->review_id]);
                $reviewNew->answer_review_id = $review->review_id;
                $reviewNew->update();
            }
            return true;
        }

        return json_encode($review->errors);
    }

    public static function getCountNewReviews()
    {
        return ProductReview::find()
            ->where(['status' => ProductReview::STATUS_NEW])
            ->count();
    }
}