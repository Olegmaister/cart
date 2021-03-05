<?php
namespace common\services\stock;

use common\entities\Brands\Brand;
use common\entities\Stock\Stock;
use common\helpers\ArrayHelper;
use common\repositories\CustomerRepository;
use common\repositories\OrderRepository;
use common\repositories\ProductRepository;
use common\services\customer\CustomerService;
use core\services\cart\cost\Discount;
use core\services\cart\DiscountService;

class DiscountsStockService
{
    private $customerService;
    private $repository;
    private $productRepository;
    private $customerRepository;
    private $discountService;


    private $limitationDiscountBrand = 0;

    public function __construct( CustomerService $customerService,
                                 OrderRepository $repository,
                                 ProductRepository $productRepository,
                                 CustomerRepository $customerRepository,
                                 DiscountService $discountService)
    {
        $this->customerService = $customerService;
        $this->repository = $repository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->discountService = $discountService;
    }

    public function getProductDiscount($product,$customer)
    {

        //поиск пользователя
        $customer = $this->customerService->getProfile();
        $product = $this->productRepository->getId($product->product_id);

        //если товар в распродаже , возвращаем null
        if($product->inSale())
        return null;

        //получаем ограничение по бренду
        $brand = Brand::find()
        ->where(['brand_id' => $product->manufacturer_id])
        ->one();


        if(isset($brand->limitation_discount) && !empty($brand->limitation_discount)){
        $this->limitationDiscountBrand = $brand->limitation_discount;
        }

        //если пользователь auth получить возможную скидку для него
        $discountCustomer = [];
        if(isset($customer)){
        /*получение скидки пользователя*/
        // - скидка группы в которой состоит пользователь
        // - скидка конкретно для пользователя
        // - накопительная система
        $discountCustomer[] = $this->discountService->getUserGroupDiscount($customer);

        }
        //получение возможной скидки по товару
        $data[] = $this->discountService->getInfoDiscount($product, $discountCustomer, null);
        $discount = $this->discountService->getMaxValue(ArrayHelper::merge($discountCustomer, $data));

        if(!$discount)return null;

        if(isset($discount->percent)){
            if($discount->percent > $this->limitationDiscountBrand){
                $discount->percent = $this->limitationDiscountBrand;
            }
        }


        if($discount->counting_method == Stock::COUNTING_MONEY){
            $value = $discount->money * 1;
        }else{
            $value = floor(($product->price / 100) * $discount->percent) * 1;
        }

        return new Discount($discount,$product->getPrice(), $value);
    }
}