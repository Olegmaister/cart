<?php

namespace common\entities;

use Yii;
use core\services\cart\CartItem as Cart;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%cart_items}}".
 *
 * @property int $cart_id
 * @property int|null $api_id
 * @property int $customer_id
 * @property string|null $session_id
 * @property int|null $product_id
 * @property int|null $recurring_id
 * @property string|null $option
 * @property string|null $option_name
 * @property string|null $product_color_image
 * @property int|null $quantity
 * @property string|null $date_added
 */
class CartItem extends ActiveRecord
{

    public function edit($quantity)
    {
        $this->quantity += $quantity;
    }

    public static function create(Cart $item, $customerId) : self
    {

        $object = new self();
        $object->customer_id = $customerId;
        $object->product_id = $item->getProductId();
        $object->quantity = $item->getQuantity();
        $object->option = $item->getOption();
        $object->option_name = trim($item->getOptionName());
        $object->product_color_image = $item->getProductColorImage();

        return $object;
    }


    public function getPresents(): ActiveQuery
    {
        return $this->hasMany(CartItemPresent::class, ['cart_item_id' => 'cart_id']);
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%cart_items}}';
    }

}
