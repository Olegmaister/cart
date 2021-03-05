<?php
namespace core\services\cart;


use common\entities\Brands\Brand;
use common\entities\Customer;
use common\entities\Products\Product;
use common\entities\Products\ProductInCategory;
use common\entities\Stock\Stock;
use common\entities\Stock\StockBrand;
use common\entities\Stock\StockCategory;
use common\entities\Stock\StockCumulative;
use common\entities\Stock\StockFunded;
use common\entities\Stock\StockProduct;
use common\entities\Stock\StockPromo;
use common\helpers\ArrayHelper;
use common\helpers\DateHelper;
use common\repositories\Order\FundedCustomerRepository;
use common\repositories\Order\StockCustomerRepository;
use common\repositories\Order\StockRepository;
use common\repositories\ProductRepository;
use common\services\stock\SegmentService;
use core\services\cart\cost\Discount;

class DiscountService
{

    private $stockRepository;
    private $productRepository;
    private $stockCustomerRepository;
    private $fundedCustomerRepository;
    private $segmentService;

    public function __construct(
        StockRepository $stockRepository,
        ProductRepository $productRepository,
        StockCustomerRepository $stockCustomerRepository,
        FundedCustomerRepository $fundedCustomerRepository,
        SegmentService $segmentService

    )
    {
        $this->stockRepository = $stockRepository;
        $this->productRepository = $productRepository;
        $this->stockCustomerRepository = $stockCustomerRepository;
        $this->fundedCustomerRepository =$fundedCustomerRepository;
        $this->segmentService = $segmentService;
    }

    public function cumulative($product){
        $stocks = StockCumulative::find()
            ->joinWith('stock')
            ->where(['and',['product_id' => $product->product_id],['stock.active' => Stock::STATUS_ACTIVE]])
            ->all();

        return $this->getAnswerDiscount($stocks);

    }


    private function substitutionFixedDiscount($row, $price)
    {
        if($row->stock->counting_method == Stock::COUNTING_PERCENT){
            return $row;
        }

        $row->stock->percent = round((100 * $row->stock->money) / $price);
        return $row;

    }

    public function getInfoDiscount($product, $discountUser, $promo = null, $dataArr = null)
    {
        $customer = \Yii::$app->user->identity;

        $productDiscounts = $this->stockRepository->relevantProduct($product->product_id);

        $temporaryPercent = null;

        foreach ($productDiscounts as &$row) {

            $row = $this->substitutionFixedDiscount($row, $product->price);

            if($row->stock->counting_method == Stock::COUNTING_MONEY){
                $row->stock->percent = round((100 * $row->stock->money) / $product->price);
            }

            if($this->segmentService->checkConditionForSegment($customer)){
                $row = $this->segmentService->applyStockBySegment(
                    $row,
                    $product,
                    $customer
                );
            }

        }


        $brandDiscounts = $this->stockRepository->relevantBrand($product->manufacturer_id);


        foreach ($brandDiscounts as &$row) {
            $row = $this->substitutionFixedDiscount($row, $product->price);
            if($this->segmentService->checkConditionForSegment($customer)){
                $row = $this->segmentService->applyStockBySegment(
                    $row,
                    $product,
                    $customer
                );
            }
        }

    $categorieIds = isset($dataArr['categorieIds'][$product->product_id]) ?
    $dataArr['categorieIds'][$product->product_id] : [];

        $categoryDiscounts = $this->stockRepository->relevantCategories($categorieIds);


        foreach ($categoryDiscounts as &$row) {

            $row = $this->substitutionFixedDiscount($row, $product->price);

            if($this->segmentService->checkConditionForSegment($customer)){
                $row = $this->segmentService->applyStockBySegment(
                    $row,
                    $product,
                    $customer
                );
            }
        }

        $promoDiscount = null;

        if(isset($promo->id)){
            $promoDiscount = StockPromo::find()
                ->with('stock')
                ->where(['id' => $promo->id])
                ->one();


            if($promoDiscount->stock->counting_method == Stock::COUNTING_MONEY){
                $promoDiscount->stock->percent = round((100 * $promoDiscount->stock->money) / $product->price);
            }
        }

        $discounts = [];

        foreach ($productDiscounts as $productDiscount) {
            $discounts[] = $productDiscount;
        }

        foreach ($categoryDiscounts as $categoryDiscount) {
            $discounts[] = $categoryDiscount;
        }

        foreach ($brandDiscounts as $brandDiscount) {
            $discounts[] = $brandDiscount;
        }

        $discounts[] = $promoDiscount;


        $items = ArrayHelper::getArrayByKey($discounts, 'stock');

        $stock = ArrayHelper::getMaxValue(ArrayHelper::merge($items, $discountUser));

        if($stock)
            return $stock;

        return null;

    }

    private function getAnswerDiscount($discounts)
    {

        $items = ArrayHelper::getArrayByKey($discounts, 'stock');

        $stock = ArrayHelper::getMaxValue($items);

        if($stock)
            return $stock;

        return null;
    }

    /*=========user discount============*/
    /* @var Customer $customer**/
    public function getUserGroupDiscount($customer)
    {
        if(\Yii::$app->user->isGuest)
            return null;


        $customerDiscount[] = $this->getUserDiscount($customer);

        if(isset($customer->profile->discount) && $customer->profile->discount != 0 && !$customer->isRetail()){
            $customerDiscount[] = Stock::createSegmentDiscount($customer->profile->discount);
        }


        if($customer->isRetail()){
            $customerDiscount[] = $this->getFundedStock($customer);
        }


        $result = ArrayHelper::getMaxValue($customerDiscount);

        if($result)
            return $result;

        return null;

    }

    public function getUserDiscount(Customer $customer)
    {
        $stocks = $this->stockRepository->getStockCustomer($customer->customer_id);
        return  $this->getAnswerDiscount($stocks);
    }



    public function getGroupDiscount(Customer $customer)
    {
        return $this->stockRepository->discountGroup($customer);
    }


    public function getGroupDiscountStock(int $segmentId)
    {

        $stocks =  $this->stockRepository->getStockGroup($segmentId);

        return  $this->getAnswerDiscount($stocks);
    }

    public function getFundedStock(Customer $customer)
    {
        $customerCost = $customer->getAccumulatedSales();

        $stocks = StockFunded::find()
            ->joinWith('stock')
            ->where(
                ['and',
                ['<','cost',$customerCost],
                ['stock.active' => Stock::STATUS_ACTIVE],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()]])
            ->orderBy(['cost' => SORT_DESC])
            ->all();

        return  $this->getAnswerDiscount($stocks);




    }

    public function getMaxValue($array)
    {
        return ArrayHelper::getMaxValue($array);
    }


    /*=========new=========*/
    public function getProduct($productId)
    {
            return StockProduct::find()
                ->where(['and',
                    ['stock_product.product_id' => $productId],
                    ['stock.active' => Stock::STATUS_ACTIVE],
                    ['<','stock.date_from', DateHelper::getCurrentTime()],
                    ['>','stock.date_to', DateHelper::getCurrentTime()]
                ])
                ->joinWith(['stock','productDescription'])
                ->all();
    }

    public function getBrand($brandId)
    {

            return StockBrand::find()
                ->where(['and',
                    ['brand_id' => $brandId],
                    ['stock.active' => Stock::STATUS_ACTIVE],
                    ['<','stock.date_from', DateHelper::getCurrentTime()],
                    ['>','stock.date_to', DateHelper::getCurrentTime()]
                ])
                ->joinWith('stock')
                ->all();
    }

    public function getCategory($productId)
    {
        $productsCategory = ProductInCategory::find()->where(['product_id' => $productId])->all();

        $categorieIds = [];
        foreach ($productsCategory as $productCategoryId) {
            $categorieIds[] = $productCategoryId->category_id;
        }

            return StockCategory::find()
                ->where(['and',
                    ['in','category_id',$categorieIds],
                    ['stock.active' => Stock::STATUS_ACTIVE],
                    ['<','stock.date_from', DateHelper::getCurrentTime()],
                    ['>','stock.date_to', DateHelper::getCurrentTime()]
                ])
                ->joinWith('stock')
                ->all();
    }


    public function getCurrentDiscountByProduct(Product $product, Stock $stock)
    {
        $value = floor(($product->price / 100) * $stock->percent);
        return new Discount($stock,$product->price, $value, 1);
    }


    public function getCurrentProductPrice(Product $product)
    {
        //акции на товар[]
        $products = $this->replacementFixedDiscount(
            $this->stockRepository->getStockProductByProduct($product->product_id)
            ,$product
        );

        //акции на бренд[]
        $brands = $this->replacementFixedDiscount(
            $this->stockRepository->getStockProductByBrand($product->manufacturer_id),
            $product
        );

        //акции на категории[]
        $productsCategory = ProductInCategory::find()->where(['product_id' => $product->product_id])->all();

        $categorieIds = [];
        foreach ($productsCategory as $productCategoryId) {
            $categorieIds[] = $productCategoryId->category_id;
        }

        $categories = $this->replacementFixedDiscount(
            $this->stockRepository->getStockProductByCategory($categorieIds),
            $product
        );

        $discounts = array_merge($products,$brands,$categories);

        $items = ArrayHelper::getArrayByKey($discounts, 'stock');

        $stock = ArrayHelper::getMaxValue($items);


        $limitationDiscount = Brand::LIMITATION_DEFAULT;

        $brand = Brand::find()
            ->select('limitation_discount')
            ->where(['brand_id' => $product->manufacturer_id])->one();

        if(isset($brand)){
            $limitationDiscount = $brand->limitation_discount;
        }

        if($stock){
            if(isset($stock->percent)){
                if($stock->percent > $limitationDiscount){
                    $stock->percent = $limitationDiscount;
                }
            }
            return $stock;
        }


        return null;
    }




    private function replacementFixedDiscount($data, $product)
    {
        if(!is_array($data) || empty($data))
            return $data;

        foreach ($data as &$row) {
            if($row->stock->counting_method == Stock::COUNTING_MONEY){
                $row->stock->percent = round((100 * $row->stock->money) / $product->price);
            }
        }

        return $data;
    }


    public static function buildData($items)
    {
        $productIds = [];
        $brands = [];

        foreach ($items as $item) {
            $product = $item->getProduct();
            $productIds[] = $product->product_id;
            $brands[$product->manufacturer_id] = $product->manufacturer_id;
        }

        $brandQuery = Brand::find()->select('brand_id, limitation_discount')
            ->where(['in', 'brand_id', $brands])->asArray()->all();


        $productsCategory = ProductInCategory::find()->select('category_id, product_id')
            ->where(['in', 'product_id', $productIds])->asArray()->all();


        $categorieIds = [];
        foreach ($productsCategory as $category) {
            $categorieIds[$category['product_id']][] = $category['category_id'];
        }

        return [
            'brandIds' => array_column($brandQuery, 'limitation_discount', 'brand_id'),
            'productIds' => $productIds,
            'categorieIds' => $categorieIds
        ];
    }
}
