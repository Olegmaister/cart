<?php

namespace frontend\entities;

/**
 * This is the model class for table "product".
 *
 * @property int $product_id
 * @property string $model
 * @property string $sku
 * @property string $mpn
 * @property int $stock_status
 * @property string|null $image
 * @property int|null $manufacturer_id
 * @property string|null $tablesize_id
 * @property string|null $video
 * @property int|null $price
 * @property int|null $price_old
 * @property float|null $weight
 * @property float|null $length
 * @property float|null $width
 * @property float|null $height
 * @property int $minimum
 * @property int $status
 * @property string|null $color
 * @property int|null $color_group
 * @property int|null $only_ua
 * @property int $viewed
 * @property string $date_added
 * @property string $date_modified
 * @property int|null $hit
 * @property int|null $new
 * @property int|null $recommend
 * @property int|null $discontinued
 * @property int|null $sale
 * @property int $rating
 * @property int $best_seller
 * @property string $guid
 * @property int|null $shares
 * @property int|null $shares_date_to
 * @property int|null $shares_id
 * @property string|null $shares_temp
 * @property int|null $sort_category
 * @property int $show_excerpt
 */
class ProductOne extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'sku', 'mpn', 'date_added', 'date_modified', 'guid'], 'required'],
            [['stock_status', 'manufacturer_id', 'price', 'price_old', 'minimum', 'status', 'color_group', 'only_ua', 'viewed', 'hit', 'new', 'recommend', 'discontinued', 'sale', 'rating', 'best_seller', 'shares', 'shares_date_to', 'shares_id', 'sort_category', 'show_excerpt'], 'integer'],
            [['video', 'shares_temp'], 'string'],
            [['weight', 'length', 'width', 'height'], 'number'],
            [['date_added', 'date_modified'], 'safe'],
            [['model', 'sku', 'mpn', 'guid'], 'string', 'max' => 64],
            [['image', 'tablesize_id'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 250],
            [['guid'], 'unique'],
        ];
    }
}
