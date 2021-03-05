<?php
namespace frontend\controllers;

use core\helpers\AjaxHelper;
use Yii;
use common\repositories\readModels\ProductReadRepository;
use frontend\components\ApiCurrency;
use core\services\cart\Cart;
use core\services\cart\CartService;
use yii\web\Controller;


class CartController extends Controller
{

    private $products;
    private $service;
    private $cart;

    public function __construct(
        $id,
        $module,
        CartService $service,
        Cart $cart,
        ProductReadRepository $products,
        $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cart = $cart;
        $this->products = $products;
        $this->service = $service;
    }

    public function actionCost()
    {
        $this->service->cost();
    }

    /** add product
     * @return mixed
     */
    public function actionAdd()
    {
        //dto
        $id = AjaxHelper::getParamPostInt('productId');
        $quantity = AjaxHelper::getParamPostInt('quantity');
        $option = AjaxHelper::getParamPost('option');
        $optionName = AjaxHelper::getParamPost('optionName');
        $productColorImage = AjaxHelper::getParamPost('productColorImage');

        if (!$product = $this->products->find($id)) {
            throw new \DomainException('The requested page does not exist.');
        }
            try {
                $this->service->add(
                    $product->product_id,
                    $quantity,
                    $option,
                    $optionName,
                    $productColorImage
                );

                $newCart = $this->renderViewCart();
                $newCartHeader = $this->renderViewCartHeader();

				Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
				$items = [
				    'success' => true,
                    'view' => $newCart,
                    'viewHeader' => $newCartHeader
                ];
				return $items;

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
    }

    public function actionQuantity()
    {
        $productId = AjaxHelper::getParamPostInt('productId');
        $optionId = AjaxHelper::getParamPostInt('optionId');
        $quantity = AjaxHelper::getParamPostInt('quantity');

        try {
            $this->service->set($productId, $optionId, $quantity);
            //получение скидки (сумма скидки)
            $discountMoney = $this->cart->getCost()->getDiscount();
            //получение скидки (%)
            $discountPercent = $this->cart->getCost()->getDiscountPercent($discountMoney);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return [
                'success' => true,
                'total' => (new ApiCurrency())->getPrice($this->cart->getCost()->getTotal()),
                'empty' => $this->cart->isEmpty(),
                'quantity' => $this->cart->getQuantity(),
                'discountMoney' => (new ApiCurrency())->getPrice($discountMoney),
                'discountPercent' => $discountPercent
            ];

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

    }


    public function actionRemove()
    {
        $productId = AjaxHelper::getParamPostInt('productId');
        $optionId = AjaxHelper::getParamPostInt('optionId');

        try {
            $this->service->remove($productId, $optionId);


            $discountMoney = $this->cart->getCost()->getDiscount();

            $discountPercent = $this->cart->getCost()->getDiscountPercent($discountMoney);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $currency = new ApiCurrency();

            return [
                'success' => true,
                'total' => $currency->getPrice($this->cart->getCost()->getTotal()),
                'empty' => $this->cart->isEmpty(),
                'quantity' => $this->cart->getQuantity(),
                'discountMoney' => $discountMoney,
                'discountPercent' => $discountPercent
            ];

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

    private function renderViewCart()
    {
        return $this->renderAjax('js/element_cart',[
            'cart' => $this->cart
        ]);
    }

    private function renderViewCartHeader()
    {
        return $this->renderAjax('js/element_cart_header',[
            'cart' => $this->cart
        ]);
    }




}
