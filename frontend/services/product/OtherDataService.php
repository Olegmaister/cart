<?php

namespace frontend\services\product;

use common\entities\Brands\BrandDescription;
use common\entities\Products\ProductReview;
use common\entities\Products\ProductVideo;
use frontend\repositories\ProductRepository;

class OtherDataService
{
    public static function getBrandNames($brandIds, $langId = 2)
    {
        $brands = BrandDescription::find()
            ->select('brand_id, name')
            ->where(['in', 'brand_id', array_column($brandIds, 'manufacturer_id')])
            ->andWhere(['language_id' => $langId])
            ->asArray()->all();

        if ($brands) {
            return array_column($brands, 'name', 'brand_id');
        }

        return false;
    }

    public static function getReviews($ids)
    {
        $reviews = ProductReview::find()
            ->select('rating, product_id')
            ->where(['in', 'product_id', $ids])
            //->andWhere(['language_id' => $langId])
            ->asArray()->all();

        $data = [];
        if ($reviews) {
            foreach ($reviews as $review) {
                $data[$review['product_id']][]['rating'] = $review['rating'];
            }
        }

        return $data;
    }

    public static function getVideos($ids)
    {
        $videos = ProductVideo::find()
            ->select('content, product_id')
            ->where(['in', 'product_id', $ids])
            ->asArray()->all();

        $data = [];
        if ($videos) {
            foreach ($videos as $video) {
                $data[$video['product_id']][] = $video['content'];
            }
        }

        return $data;
    }

    public static function getAttributes($mpn, $langId)
    {
        $attributes = ProductRepository::getAttributesByProductArray($mpn, $langId);

        $data = [];
        if ($attributes) {
            foreach ($attributes as $attribute) {
                $data[$attribute['product_mpn']][] = [
                    'group_name' => $attribute['group_name'],
                    'attr_name' => $attribute['name'],
                ];
            }
        }

        return $data;
    }
}