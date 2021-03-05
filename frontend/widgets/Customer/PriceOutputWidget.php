<?php
namespace frontend\widgets\Customer;

use frontend\services\product\OrderItemOutputPrice;
use frontend\services\product\PriceService;
use yii\base\Widget;

class PriceOutputWidget extends Widget
{

    public $item;

    private $service;

    public function __construct(
        PriceService $service,
        $config = []
    )
    {
        $this->service = $service;
        parent::__construct($config);
    }

    public function init()
    {
        parent::init();
    }

    public function run(): string
    {
        /**@var OrderItemOutputPrice $orderItem*/
        $orderItem = $this->service->getOutput($this->item);
        return $this->render('price', [
            'orderItem' => $orderItem
        ]);
    }
}