<?php
namespace common\services\stock;

use backend\forms\Stocks\StockCreateForm;
use backend\forms\Stocks\StockEditForm;
use backend\forms\Stocks\StockFundedEditForm;
use backend\forms\Stocks\StockPromoEditForm;
use common\entities\Customer;
use common\entities\Products\Product;
use common\entities\Stock\NotificationStock;
use common\entities\Stock\Stock;
use common\entities\Stock\StockBrand;
use common\entities\Stock\StockCategory;
use common\entities\Stock\StockCustomer;
use common\entities\Stock\StockDescription;
use common\entities\Stock\StockFunded;
use common\entities\Stock\StockGroup;
use common\entities\Stock\StockPhoto;
use common\entities\Stock\StockProduct;
use common\entities\Stock\StockPromo;
use common\entities\UrlAlias;
use common\helpers\ArrayHelper;
use common\helpers\StringHelper;
use common\repositories\Order\StockRepository;
use common\repositories\ProductInCategoryRepository;
use common\repositories\ProductRepository;
use common\services\TransactionManager;
use yii\helpers\FileHelper;

class StockService
{
    public $transactionManager;
    private $repository;
    private $productRepository;
    private $categoryRepository;
    private $stockProductService;
    private $notificationService;
    private $sharesService;
    private $promoService;


    public function __construct(
        TransactionManager $transactionManager,
        StockRepository $repository,
        ProductRepository $productRepository,
        ProductInCategoryRepository $categoryRepository,
        StockProductService $stockProductService,
        SharesService  $sharesService,
        PromoService  $promoService,
        NotificationService  $notificationService
)
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->transactionManager = $transactionManager;
        $this->stockProductService = $stockProductService;
        $this->sharesService = $sharesService;
        $this->promoService = $promoService;
        $this->notificationService = $notificationService;

    }


    /*
     * создание новой акции
     * @param $form
     * */
    public function create(StockCreateForm $form)
    {
        //создание новой акции
        $stock = Stock::create(
            $form->type,
            $form->countingMethod,
            $form->money,
            $form->percent,
            $form->date_from,
            $form->date_to,
            1,
            $form->slider
        );

        //привязываем изображения
        if(isset($form->photos->files)){
            foreach ($form->photos->files as $file) {
                $stock->addPhoto($file);
            }
        }

        $this->transactionManager->wrap(function () use ($stock, $form) {

            $productStock = [];

            //если тип акции customer
            if($form->type == 'customer'){
                $segments = [];
                foreach ($form->segment as $segment) {
                    $segments[$segment->guid] = ['name' => $segment->name,'value' => $segment->value];
                }
                $segments = \GuzzleHttp\json_encode($segments);

                $customers = $form->customer;
                //привязывем пользователей
                $stock->assingCustomer($customers,$segments);
            }


            //если тип акции brand
            if($form->type == 'brand'){
                $brands = $form->brand;
                $result = $this->productRepository->getProductByBrand($brands);
                foreach ($result as $item) {
                    $productStock[] = $item->product_id;
                }


                $segments = [];
                foreach ($form->segment as $segment) {
                    $segments[$segment->guid] = ['name' => $segment->name,'value' => $segment->value];
                }
                $segments = \GuzzleHttp\json_encode($segments);


                //привязывем бренды
                $stock->assingBrand($brands,$segments);
            }

            //если тип акции product
            if($form->type == 'product'){
                $products = $form->product;
                $productStock = $products;
                //привязываем товары

                $segments = [];
                foreach ($form->segment as $segment) {
                    $segments[$segment->guid] = ['name' => $segment->name,'value' => $segment->value];
                }
                $segments = \GuzzleHttp\json_encode($segments);

                $stock->assingProduct($products,$segments);
            }


            //если тип акции category
            if($form->type == 'category'){
                $categories = $form->category;
                $result = $this->productRepository->getProductByCategory($categories);
                foreach ($result as $item) {
                    $productStock[] = $item->product_id;
                }

                $segments = [];
                foreach ($form->segment as $segment) {
                    $segments[$segment->guid] = ['name' => $segment->name,'value' => $segment->value];
                }
                $segments = \GuzzleHttp\json_encode($segments);

                //привязываем категории
                $stock->assignCategory($categories, $segments);

            }

            //если тип акции group
            if($form->type == 'group'){
                $groups = $form->group;
                //привязываем группы
                $stock->assingGroup($groups);
            }

            //если тип акции funded(накопительная система)
            if($form->type == 'funded'){
                $stock->assingFunded($form);
            }

            /*работа с товарами на которые распостраняется акция
            *$productStock - список товаров
            *$stock - акция
            */
            if($stock->type == 'product' || $stock->type == 'brand' || $stock->type == 'category'){
                $this->sharesService->setStock($productStock, $stock);
            }


            if($form->type == 'promo'){
                $stock->assignPromo($form->promo->promoStock);
            }

            //создание описания для акции
            $descriptions = StockDescription::create($form);

            //привязываем описание к акции
            $stock->setDescription($descriptions);


            //сохраняем
            $stock->save();
            $query = "stock_id={$stock->id}";
            $keyword = StringHelper::getSlug($form->keyword);
            $controllers = 'stocks';
            $action = 'one';
            $id = $stock->id;
            $slug = UrlAlias::create($query, $keyword,$controllers, $action, $id);
            $slug->save();

            if($stock->type == 'product' || $stock->type == 'brand' || $stock->type == 'category'){
                $this->notificationService->notificationBayer(new NotificationStock(
                    $productStock,
                    $stock
                ));
            }


        });

        return $stock;
    }



    public function getProductIdsByType(Stock $stock)
    {

        //получение списка id товаров из stock_product
        if($stock->type == 'product'){
            $result = $this->repository->getIdProductByStock($stock);
        }
        //получение списка id брендов из stock_brand
        //получение списка id товаров
        //которые относятся к данным брендам
        if($stock->type == 'brand'){
            $brands = $this->repository->getBrandIds($stock);
            $res = [];
            foreach ($brands as $item) {
                $res[] = $item->brand_id;
            }
            $result = $this->productRepository->getProductByBrand($res);
        }
        //получение списка id брендов из stock_category
        //получение списка id товаров
        //которые относятся к данным брендам
        if($stock->type == 'category'){
            $categories = $this->repository->getCategoryIds($stock);
            $res = [];
            foreach ($categories as $category) {
                $res[] = $category->category_id;
            }
            $result = $this->productRepository->getProductByCategory($res);
        }

        //получение массива id товаров
        $productIds = ArrayHelper::getFieldFromArray($result,'product_id');

       return $productIds;

    }




    public function edit(StockEditForm $form, int $stockId)
    {
        //находим акцию
        /**@var Stock $stock*/
        $stock = $this->repository->getById($stockId);

        //редактирование основной информации
        $stock->edit(
            $form->type,
            $form->countingMethod,
            $form->money,
            $form->percent,
            $form->date_from,
            $form->date_to,
            1,
            $form->slider
        );

        foreach ($form->photos->files as $file) {
            $path = \Yii::getAlias('@staticRoot/stocks/'.$stock->id);  // выведет: /path/to/frontend/img/
            FileHelper::removeDirectory($path);
            $stock->addPhoto($file);
            StockPhoto::deleteAll(['stock_id' => $stock->id]);
        }

        //редактирование описание
        foreach ($stock->descriptions as $description) {
            $formName = $description->language_name;
            /**@var StockDescription $description*/
            $description->edit($form->$formName);
            $stock->editChildDescription($description);

        }

        $this->transactionManager->wrap(function () use ($stock, $form) {

            $ids = explode('|',$form->stockType);


            $new_array = array_filter($ids, function($element) {
                return !empty($element);
            });


            //элементы для удаления
            $deleteElement = [];

            if($stock->type == 'product'){
                $deleteElement = $this->stockProductService->getIdProductByStockProduct($stock, $new_array);
            }elseif ($stock->type == 'brand'){
                $deleteElement = $this->stockProductService->getIdProductByStockBrand($stock, $new_array);
            }elseif ($stock->type == 'category'){
                $deleteElement = $this->stockProductService->getIdProductByStockCategory($stock, $new_array);
            }


            $productIds = array_diff($this->getProductIdsByType($stock),$deleteElement);


            if($stock->type == 'product' || $stock->type == 'brand' || $stock->type == 'category'){
                //редактирование товаров которые учавстуют в акции
                $this->stockProductService->editStock($stock, $productIds);

                //удаление товаров из акции
                $this->stockProductService->removeStock($stock, $deleteElement);

            }


            //TODO вынести в отдельный метод получение основного класса для работы
            //TODO по типу акции ['brand' => StockBrand ....]
            switch ($stock->type){
                case 'brand' : StockBrand::deleteAll(['stock_id' => $stock->id]);
                    $segments = [];
                    foreach ($form->segment as $segment) {
                        $segments[$segment->guid] = ['name' => $segment->name,'value' => $segment->value];
                    }
                    $segments = \GuzzleHttp\json_encode($segments);
                $stock->assingBrand($new_array,$segments);break;

                case 'product' :StockProduct::deleteAll(['stock_id' => $stock->id]);
                    $segments = [];
                    foreach ($form->segment as $segment) {
                        $segments[$segment->guid] = ['name' => $segment->name,'value' => $segment->value];
                    }
                    $segments = \GuzzleHttp\json_encode($segments);
                    $stock->assingProduct($new_array,$segments);break;

                case 'group' : StockGroup::deleteAll(['stock_id' => $stock->id]);
                $stock->assingGroup($new_array);break;

                case 'category' : StockCategory::deleteAll(['stock_id' => $stock->id]);
                    $segments = [];
                    foreach ($form->segment as $segment) {
                        $segments[$segment->guid] = ['name' => $segment->name,'value' => $segment->value];
                    }
                    $segments = \GuzzleHttp\json_encode($segments);
                $stock->assignCategory($new_array,$segments);break;

                case 'customer' : StockCustomer::deleteAll(['stock_id' => $stock->id]);
                $stock->assingCustomer($new_array);break;
            }

            //сохранение stock

            $this->repository->save($stock);


        });

        return $stock;
    }

    public function remove($id)
    {
        //получаю акцию
        /**@var Stock $stock*/
        $stock = $this->repository->getById($id);

        $productIds = [];
        $result = [];

        /*получение списка id товаров по акции которую удаляю*/

        //получение списка id товаров из stock_product
        if($stock->type == 'product'){
            $result = $this->repository->getIdProductByStock($stock);
        }
        //получение списка id брендов из stock_brand
        //получение списка id товаров
        //которые относятся к данным брендам
        if($stock->type == 'brand'){
            $brands = $this->repository->getBrandIds($stock);
            $res = [];
            foreach ($brands as $item) {
                $res[] = $item->brand_id;
            }
            $result = $this->productRepository->getProductByBrand($res);
        }
        //получение списка id брендов из stock_category
        //получение списка id товаров
        //которые относятся к данным брендам
        if($stock->type == 'category'){
            $categories = $this->repository->getCategoryIds($stock);
            $res = [];
            foreach ($categories as $category) {
                $res[] = $category->category_id;
            }
            $result = $this->productRepository->getProductByCategory($res);
        }

        //получение массива id товаров
        $productIds = ArrayHelper::getFieldFromArray($result,'product_id');


        //основная работа с товарами которые учавствуют в акции
        if($stock->type == 'product' || $stock->type == 'brand' || $stock->type == 'category'){
            $this->stockProductService->removeStock($stock, $productIds);
        }

        //получаю название класса
        $className = $stock->getLinkTableName($stock->type);

        //удаление всего что связанно с данной акцией
        $className::deleteAll(['stock_id' => $stock->id]);

        //удаление всех данных из url_alias
        $this->removeUrlAlias($stock);

        //удаление основной информации по акции
        Stock::deleteAll(['id' => $stock->id]);

    }



    public function test($brands)
    {
            $result = $this->productRepository->getProductByBrand($brands);
            foreach ($result as $item) {
                $productStock[] = $item->product_id;
            }

            return $result;

    }

    public function editPromo(StockPromoEditForm $form, int $stockId)
    {

        $stock = $this->repository->getById($stockId);

        //редактирование основной информации
        $stock->edit(
            $form->type,
            $form->countingMethod,
            isset($form->money) ? $form->money : null,
            $form->percent,
            $form->date_from,
            $form->date_to,
            1,
            $form->slider
        );

        foreach ($stock->descriptions as $description) {
            $formName = $description->language_name;
            /**@var StockDescription $description*/
            $description->edit($form->$formName);
            $stock->editChildDescription($description);

        }



        $this->transactionManager->wrap(function () use ($stock, $form) {
            //удалить все что связанно с данной акцией
            StockPromo::deleteAll(['stock_id' => $stock->id]);

            //привязать новое
            $stock->assignPromo($form->promoStock);

            //сохранить
            $this->repository->save($stock);
        });



    }


    public function editFunded(StockFundedEditForm $form, int $stockId)
    {

        //находим stock
        /**@var Stock $stock*/
        $stock = $this->repository->getById($stockId);
        //вносим изминения в описание

        $stock->edit(
            $form->type,
            $form->countingMethod,
            isset($form->money) ? $form->money : null,
            $form->percent,
            $form->date_from,
            $form->date_to,
            1,
            $form->slider
        );


        foreach ($stock->descriptions as $description) {
            $formName = $description->language_name;
            /**@var StockDescription $description*/
            $description->edit($form->$formName);
            $stock->editChildDescription($description);

        }

        $this->transactionManager->wrap(function () use ($stock, $form) {
            /**@var StockFunded $funded*/
            $funded = StockFunded::find()->where(['stock_id' => $stock->id])->one();
            $funded->edit($form->cost);

            $funded->save();
            $this->repository->save($stock);

        });

        return $stock;

    }

    private function getClass()
    {

    }


    public function getProductIds(Stock $stock)
    {
        //получаем все id товаров  из StockProduct
        if($stock->ifTypeProduct()){
               $ids = $this->repository->getProductIds($stock);
                return $this->product($ids);
        }
        if($stock->ifTypeBrand()){
               $ids = $this->repository->getBrandIds($stock);
               return $this->brand($ids);
        }
        if($stock->ifTypeCategory()){
               $ids = $this->repository->getCategoryIds($stock);
               return $this->category($ids);
        }
        if($stock->ifTypePresent()){
               $ids = $this->repository->getPresentIds($stock);
               return $this->productUnique($ids);
        }
    }


    public function count($prodId)
    {
        return Product::find()->where(['and',['in','product_id', $prodId ],['product.status' => 1]])->count();
    }


    public function getSlug($data)
    {
        return  StringHelper::getSlug($data);

    }

    //получение id товаров
    private function product($ids)
    {
        $array = [];

        foreach ($ids as $id) {
            $array[] = $id->product_id;
        }

        return $array;
    }

    private function productUnique($ids)
    {
        $array = [];

        foreach ($ids as $id) {
            $array[$id->product_id] = $id->product_id;
        }

        return $array;
    }

    private function brand($ids)
    {
        $idsBrand = [];
        foreach ( $ids as $item) {
            $idsBrand[] = $item->brand_id;
        }

        $result = $this->productRepository->getProductByBrand($idsBrand);

        $array = [];
        foreach ($result as $id) {
            $array[] = $id->product_id;
        }

        return $array;

    }


    private function category($ids)
    {
        $categoryIds = [];

        foreach ($ids as $id) {
            $categoryIds[] = $id->category_id;
        }

        $result = $this->categoryRepository->getProductByCategory($categoryIds);

        $resArray = [];

        foreach ($result as $item) {
            $resArray[] = $item->product_id;
        }


        return $resArray;

    }

    public function getOptDiscount(Customer $customer)
    {

        return $customer->profile->discount;


        //id сегмента из табл. stock_group
        //получить максимальную скидку
//        $discounts = $this->repository->getOptDiscount($customer->segment->id);
//        return $this->getAnswerDiscount($discounts);
    }

    private function getAnswerDiscount($discounts)
    {

        $items = ArrayHelper::getArrayByKey($discounts, 'stock');


        $stock = ArrayHelper::getMaxValue($items);

        if($stock)
            return $stock;

        return null;
    }

    public function sortType($stocks, $type)
    {
        if(!$type)
            return $stocks;


        $typeArray = [];


        foreach ($stocks as $i => $stock) {
            if($stock->type === $type){
                $typeArray[] = $stock;
                unset($stocks[$i]);

            }

        }

        return array_merge($typeArray, $stocks);

    }

    public function getInfoStock(array $productIds, Stock $stock, $limit)
    {
        if($stock->ifTypeProduct() || $stock->ifTypePresent()){
            //получение информации по товаром
            $model = \frontend\repositories\ProductRepository::getProductByFieldStockProduct($productIds,$limit);
        }elseif($stock->ifTypeBrand() || $stock->ifTypeCategory()){
            //$this->view = '_other_stocks';
            $model = \frontend\repositories\ProductRepository::getProductByFieldStockOther($productIds,$limit);
        }


        return $model;
    }


    /*==========================*/
    public function getNewLimit($currentLimit, $defaultLimit)
    {
        return $currentLimit + $defaultLimit;
    }

    public function active(int $id) : Stock
    {
        $stock = $this->repository->getById($id);
        $stock->activate();
        $this->repository->save($stock);

        $productIds = $this->getProductIdsByType($stock);

        $this->stockProductService->stockActive($productIds, $stock);






        return $stock;
    }

    public function deactivate(int $id) : Stock
    {

        $stock = $this->repository->getById($id);
        $stock->deactivate();

        $productIds = $this->getProductIdsByType($stock);

        //основная работа с товарами которые учавствуют в акции
        if($stock->type == 'product' || $stock->type == 'brand' || $stock->type == 'category'){
            $this->stockProductService->removeStock($stock, $productIds);
        }

        $this->repository->save($stock);

        return $stock;
    }


    private function removeUrlAlias(Stock  $stock)
    {
        UrlAlias::deleteAll(['and',
            ['controller' => 'stocks'],
            ['id' => $stock->id]
        ]);
    }


}
