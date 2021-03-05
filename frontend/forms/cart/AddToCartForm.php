<?php
namespace frontend\forms\cart;

use yii\base\Model;


class AddToCartForm extends Model
{   public $productId;
    public $modification;
    public $quantity;
    public $options = [];

    public $specifications;
    private $product;

    public function __construct($product,$config = [])
    {

        $this->product = $product;
        $this->productId = $product->product_id;
        $this->quantity = 1;
        parent::__construct($config);
    }

    public function rules()
    {
        return array_filter([
            ['quantity', 'required'],
            [
                'quantity', 'integer', 'message' => 'Должно быть числом', 'max' => $this->product->quantity, 'tooBig' => 'Доступно на складе {max}',
            ],
        ]);
    }

    public function attributeLabels()
    {
        return [
            'quantity' => 'количество',
            'productId' => ''
        ];
    }

}