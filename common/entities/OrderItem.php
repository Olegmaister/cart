<?php

namespace common\entities;

use common\entities\Products\Product;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "{{%order_items}}".
 *
 * @property int $id
 * @property int $order_id
 * @property int|null $product_id
 * @property string $product_name
 * @property string $product_code
 * @property integer $option_id
 * @property string $option_name
 * @property string $product_color_image
 * @property int $origin_price
 * @property float $discount_price
 * цена со скидкой
 * @property int $price
 * @property int $quantity
 *
 * @property Product $product
 */

class OrderItem extends ActiveRecord
{

    public $present;


    public static function create(
        $product,
        $optionId,
        $optionName,
        $productColorImage,
        $price,
        $quantity,
        $present = null
    )
    {

        $item = new static();
        $item->product_id = $product->product_id;
        $item->option_id = $optionId;
        $item->option_name = trim($optionName);
        $item->product_color_image = $productColorImage;
        $item->product_name = isset($product->description->name) ? $product->description->name : $product->model;
        $item->product_code = $product->sku;
        $item->origin_price = $price;
        $item->quantity = $quantity;
        $item->present = $present;


        return $item;
    }


    public static function createItem($product)
    {
        $item = new self();

        $item->product_id = $product['id'];
        $item->product_code = $product['code'];
        $item->product_name = $product['name'];
        $item->quantity = $product['quantity'];
        $item->price = $product['price'];
        $item->option_id = $product['optionId'];
        $item->option_name = $product['optionName'];
        $item->product_color_image = $product['productColorImage'];

        return $item;

    }

    public function assignOrderId($orderId)
    {
        $this->order_id = $orderId;
    }


    //общая сумма, одного товара может быть несколько
    //добавлено в корзину
    public function getCost(): int
    {
        return $this->price * $this->quantity;
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['product_id' => 'product_id']);
    }

    public function parentKey()
    {
        return md5($this->product_id.$this->option_id);
    }

    public static function tableName(): string
    {
        return '{{%order_items}}';
    }
}
