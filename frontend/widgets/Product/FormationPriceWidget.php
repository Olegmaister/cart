<?php
namespace frontend\widgets\Product;


use frontend\components\ApiCurrency;
use frontend\services\ProductService;
use yii\base\Widget;

class FormationPriceWidget extends Widget
{
    public $product;

    private $service;
    private $currency;

    public function __construct(
        ProductService $service,
        $config = []
    )
    {
        $this->service = $service;
        $this->currency = new ApiCurrency();
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        return $this->render('price', [
            'product' => $this->product,
            'currency' => $this->currency,
            'service' => $this->service
        ]);
    }
}