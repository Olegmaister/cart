<?php
namespace frontend\controllers\stock;


use core\helpers\AjaxHelper;
use frontend\components\ApiCurrency;
use frontend\services\product\PriceService;
use yii\web\Controller;

class PriceController extends Controller
{

    private $service;
    private $apiCurrency;


    public function __construct(
        $id,
        $module,
        PriceService $service,
        ApiCurrency $apiCurrency,
        $config = [])
    {
        $this->service = $service;
        $this->apiCurrency = $apiCurrency;
        parent::__construct($id, $module, $config);
    }

    public function actionCurrentPrice()
    {
        $productId = (int)AjaxHelper::getParamPost('id');

        $prices = $this->service->getCurrentDiscountPrice($productId);


        $price = $this->apiCurrency->getPrice($prices['price']);
        $oldPrice = $this->apiCurrency->getPrice($prices['price_old']);

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $answer = [
            'price' => $price,
            'oldPrice' => $oldPrice
        ];
        return $answer;
    }
}