<?php
namespace common\services\stock;

use common\entities\Products\Product;
use common\entities\Stock\Stock;
use common\entities\Stock\StockBrand;
use common\entities\Stock\StockProduct;
use common\repositories\Order\StockRepository;
use common\repositories\ProductRepository;
use yii\helpers\ArrayHelper;

class SharesService
{
    private $repository;
    private $stockRepository;

    public function __construct(
        ProductRepository $repository,
        StockRepository $stockRepository
    )
    {
        $this->repository = $repository;
        $this->stockRepository = $stockRepository;
    }

    /*новая акция
     * ставим отметку для товара , что он учавствует в акции
     * param array $products - массив id товаров
     * param object $stock - акция
     **/
    public function setStock(array $products, Stock $stock)
    {
        if($this->notActiveStock($stock->date_from, $stock->active))
            return false;

        $currentTime = date('d-m-Y h:i:s', $stock->date_to);

        //получение списка товаров, вынести в репу
        $productsArray = $this->repository->getByIds($products);


        foreach ($productsArray as &$product) {
            $product = $this->forEachRow($product,$stock);
        }

        foreach ($productsArray as $item) {
            Product::updateAll([
                'shares' => $item['shares'],
                'shares_date_to' => $item['shares_date_to'],
                'shares_temp' => $currentTime
            ],
                ['product_id' => $item['product_id']
                ]);
        }
    }

    private function notActiveStock($dateFrom, $active)
    {
        if($dateFrom > time() || $active == Stock::STATUS_NOT_ACTIVE)
            return true;

        return false;
    }

    private function forEachRow($product,$stock)
    {
        //если товар не участвует в акции
        if($product['shares'] == 0){
            $product = $this->doesNotExistStock($product, $stock);
            //если товар участвует в акции
        }else{
            if($stock->date_to > $product['shares_date_to']){
                $product = $this->changeDate($product, $stock);
            }
        }

        return $product;
    }

    private function doesNotExistStock($product, $stock)
    {
        $product['shares'] = 1;
        $product['shares_date_to'] = $stock->date_to;
        return $product;
    }

    private function changeDate($product, $stock)
    {
        $product['shares_date_to'] = $stock->date_to;
        return $product;
    }

    public function editStock(Stock $stock, $data)
    {
        $this->updateStock($stock, $data);
    }



    //работа с товарами связанными с
    //акцией которую удаляем
    public function removeStock(Stock $stock, $productIds)
    {
        foreach ($productIds as $productId) {

            //список акций в которых участвует товар
            $listShares = [];

            /**@var Product $product*///получение товара
            //который может участвовать в других акциях
            $product = $this->repository->getByIdInfoStock($productId);

            //получение максимальной даты завершения акции,
            //по данному товару исключая данную акцию
            $maxDate = $this->getMaxEndDate($product, $stock->id);

            //если товара не участвует больше в акциях
            if(!$maxDate){
                $product->unAssignProductStock();
            }
            //если дата вернулась значит товар участвует
            //в других акциях
            //обновить информацию для данного товара
            else{
                $product->assignCurrentStock($stock, $maxDate);
            }

            $product->save(false);

        }

    }
    //работа с товарами связанными с
    //акцией которую удаляем
    public function updateStock(Stock $stock, $productIds)
    {
        foreach ($productIds as $productId) {

            //список акций в кторых участвует товар
            $listShares = [];

            /**@var Product $product*///получение товара
            //который может участвовать в других акциях
            $product = $this->repository->getByIdInfoStock($productId);


            //получение максимальной даты завершения акции,
            //по данному товару исключая данную акцию
            $maxDate = $this->getMaxEndDateEdit($product, $stock->id);

            //если товара не участвует больше в акциях
            if(!$maxDate){
                $product->unAssignProductStock();
            }
            //если дата вернулась значит товар участвует
            //в других акциях
            //обновить информацию для данного товара
            else{
                $product->assignCurrentStock($stock, $maxDate);
            }

            $product->save(false);

        }

    }

    private function getMaxEndDate(Product $product, int $stockId)
    {

        $stocks = [];

        //прверка данного товара в акциях по типу[product brand category]
        $stocks[] = $this->stockRepository->getStockProductByProductId($product->product_id, $stockId);
        $stocks[] = $this->stockRepository->getStockBrandByProductId($product->manufacturer_id, $stockId);

        //работа с категориями
        //1 получить списка категорий к которым привязан товар
        $result = $this->repository->getCategoryByProductId($product);
        $categories = [];

        foreach ($result as $item) {
            $categories[] = $item->category_id;
        }

        //2 список акций по данным категориям
        $stocks[] = $this->stockRepository->getStockCategoryByCategoryIds($categories, $stockId);


        $value = [];

        //получение поля date_to
        foreach ($stocks as $stock){
            foreach ($stock as $item) {
                $value[] = ArrayHelper::getValue($item, 'stock.date_to');
            }
        }

        //если значения нет return false
        if(!$value)
            return false;

        //получаем маскимальную дату
        //завершения акции для товара
        //возвращае значение
        return max($value);
    }

    private function getMaxEndDateEdit(Product $product, int $stockId)
    {

        $stocks = [];

        //прверка данного товара в акциях по типу[product brand category]
        $stocks[] = $this->stockRepository->getStockProductByProductIdEdit($product->product_id, $stockId);
        $stocks[] = $this->stockRepository->getStockBrandByProductIdEdit($product->manufacturer_id, $stockId);

        //работа с категориями
        //1 получить списка категорий к которым привязан товар
        $result = $this->repository->getCategoryByProductId($product);
        $categories = [];

        foreach ($result as $item) {
            $categories[] = $item->category_id;
        }

        //2 список акций по данным категориям
        $stocks[] = $this->stockRepository->getStockCategoryByCategoryIdsEdit($categories, $stockId);


        //получение поля date_to
        foreach ($stocks as $stock){
            foreach ($stock as $item) {
                $value[] = ArrayHelper::getValue($item, 'stock.date_to');
            }
        }

        //если значения нет return false
        if(!isset($value) || empty($value))
            return false;

        //получаем маскимальную дату
        //завершения акции для товара
        //возвращае значение
        return max($value);
    }

    public function getIdProductByStockProduct(Stock $stock, $newArray)
    {

        //вынести в репозиторий
        $oldData = StockProduct::find()
            ->select('product_id')
            ->where(['stock_id' => $stock->id])
            ->all();

        //сипсок старых данных
        $oldIds = [];
        foreach ($oldData as $item) {
            $oldIds[] = $item->product_id;
        }

        //получение списка на удаление
        $deleteElement = [];
        foreach ($oldIds as $val){
            if(!in_array($val, $newArray)){
                $deleteElement[] = $val;
            }
        }


        return $deleteElement;

    }

    public function getIdProductByStockBrand(Stock $stock , $newArray)
    {
        //получить все бренды по данной акции(старый список)
        $oldData = ArrayHelper::map(StockBrand::find()
            ->select('brand_id')
            ->where(['stock_id' => $stock->id])
            ->asArray()
            ->all(),'brand_id','brand_id');


        //получение списка на удаление
        $deleteElement = [];
        foreach ($oldData as $val){
            if(!in_array($val, $newArray)){
                $deleteElement[] = $val;
            }
        }

        //получить все товары по данным брендам
        $products = ArrayHelper::map(
            $this->repository->getProductByBrand($deleteElement),
            'product_id',
            'product_id');

        return $products;

    }

    public function getIdProductByStockCategory(Stock $stock , $newArray)
    {
        //получить всех категорий по данной акции(старый список)
        $oldData = ArrayHelper::map(
            $this->stockRepository->getCategoryIds($stock),
            'category_id',
            'category_id');

        //получение списка на удаление
        $deleteElement = $this->getDifference($oldData, $newArray);

        //получить все товары по данным брендам
        $products = ArrayHelper::map(
            $this->repository->getProductByCategory($deleteElement),
            'product_id',
            'product_id');

        return $products;
    }


    /*=========вынести в отдельный сервис==========*/
    private function getDifference($oldData, $newData)
    {
        $elements = [];
        foreach ($oldData as $value){
            if(!in_array($value, $newData)){
                $elements[] = $value;
            }
        }

        return $elements;

    }




}
