<?php

namespace frontend\services;

use common\entities\Brands\Brand;
use common\entities\Products\Product;
use common\entities\Products\ProductSimilar;
use common\entities\Stock\Stock;
use common\entities\Stock\StockPresent;
use common\helpers\ArrayHelper;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\models\Compare;
use frontend\models\WishList;
use frontend\repositories\ProductRepository;
use core\services\cart\DiscountService;
use frontend\services\product\ProductDiscount;
use frontend\services\product\StockWatchService;
use Yii;
use yii\web\Cookie;
use yii\web\Response;


class ProductService
{
    private $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }


    const PRODUCT_GROUP = ['hit', 'new', 'sale', 'recommend', 'shares']; // 'leader'


    public function getGroup()
    {
        return ['hit', 'new', 'sale', 'recommend'];
    }

    // Для главной Хиты, новинки, распродажа и рекомендуемые
    public static function getItemsForHome()
    {
        $items = [];
        foreach (self::PRODUCT_GROUP as $group) {
            $items[$group] = ProductRepository::getProductViaPovider($group, ["stock_status" => Product::STATUS_ACTIVE], LanguageHelper::getCurrentId(), 12);
        }

        return $items;
    }

    // Группы (лидеры, новинки, распродажа, рекомендуемое и акции ) для карточки товара
    public static function getItemsForProduct()
    {
        $group = self::PRODUCT_GROUP;
        $items = [];

        foreach ($group as $group) {
            $items[$group] = ProductRepository::getProductViaPovider($group, ["stock_status" => Product::STATUS_ACTIVE], LanguageHelper::getCurrentId(), 8);
        }

        return $items;
    }

    public static function werapperJson($array)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $array;
    }

    public static function checkExistNextPage($provider)
    {
        if (isset($provider->pagination->pageCount) && isset($provider->pagination->page)) {
            return ($provider->pagination->pageCount > $provider->pagination->page + 1) ? true : false;
        }
        return false;
    }

    /*======stock product=====*/
    public function getStockProduct($productarr)
    {


	 $product = Product::find()
            ->where(['product_id' => $productarr['product_id']])
            ->one();

	if(!isset($product->product_id)){
		return null;
	}

        $productDiscounts = $this->discountService->getProduct($product->product_id);
        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($productDiscounts as &$row) {
            if ($row->stock->counting_method == Stock::COUNTING_MONEY) {
                $row->stock->percent = round((100 * $row->stock->money) / $product->price);
            }
        }

        $brandDiscounts = $this->discountService->getBrand($product->manufacturer_id);
        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($brandDiscounts as &$row) {
            if ($row->stock->counting_method == Stock::COUNTING_MONEY) {
                $row->stock->percent = round((100 * $row->stock->money) / $product->price);
            }
        }

        $categoryDiscounts = $this->discountService->getCategory($product->product_id);
        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($categoryDiscounts as &$row) {
            if ($row->stock->counting_method == Stock::COUNTING_MONEY) {
                $row->stock->percent = round((100 * $row->stock->money) / $product->price);
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

        $items = ArrayHelper::getArrayByKey($discounts, 'stock');
        $stock = ArrayHelper::getMaxValue($items);

        $brand = Brand::getDb()->cache(function () use ($product) {
            return Brand::find()
                ->select('limitation_discount')
                ->where(['brand_id' => $product->manufacturer_id])
                ->one();
        }, 60);

        $limitationDiscount = $brand->limitation_discount;

        if (isset($stock->percent)) {
            if ($stock->percent > $limitationDiscount) {
                $stock->percent = $limitationDiscount;
            }
        }


        $productDiscount =  new ProductDiscount($product, $stock);
        return $productDiscount;
    }


    public function getStockProduct2($product)
    {
        $productDiscounts = $this->discountService->getProduct($product['product_id']);
        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($productDiscounts as &$row) {
            if ($row->stock->counting_method == Stock::COUNTING_MONEY) {
                $row->stock->percent = round((100 * $row->stock->money) / $product['price']);
            }
        }

        $brandDiscounts = $this->discountService->getBrand($product['manufacturer_id']);
        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($brandDiscounts as &$row) {
            if ($row->stock->counting_method == Stock::COUNTING_MONEY) {
                $row->stock->percent = round((100 * $row->stock->money) / $product['price']);
            }
        }

        $categoryDiscounts = $this->discountService->getCategory($product['product_id']);
        //если тип подсчета money: определяем процент для данного товара
        //(100*money)/product->price
        //и вносим изминения в акцию, присваиваем ей percent
        foreach ($categoryDiscounts as &$row) {
            if ($row->stock->counting_method == Stock::COUNTING_MONEY) {
                $row->stock->percent = round((100 * $row->stock->money) / $product['price']);
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

        $items = ArrayHelper::getArrayByKey($discounts, 'stock');
        $stock = ArrayHelper::getMaxValue($items);

        $brand = Brand::getDb()->cache(function () use ($product) {
            return Brand::find()
                ->select('limitation_discount')
                ->where(['brand_id' => $product->manufacturer_id])
                ->one();
        }, 60);

        $limitationDiscount = $brand->limitation_discount;

        if (isset($stock->percent)) {
            if ($stock->percent > $limitationDiscount) {
                $stock->percent = $limitationDiscount;
            }
        }


        return new ProductDiscount($product, $stock);
    }

    public static function productWatching($categoryId)
    {
        $catIds = ProductRepository::getPoductIdsByCategoryArray($categoryId);
        $queryWatching =  ProductHelper::getProductWithSize(array_column($catIds, 'product_id'), LanguageHelper::getCurrentId(), 20, ['viewed' => SORT_DESC]);
        return ProductHelper::rebuildMpnProductGroup($queryWatching, ['key' => 'status', 'value' => 1]);
    }

    private static function addProductViewed($productId, $limit = 30)
    {
        if (!Yii::$app->request->cookies->has('viewedProductIds')) {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'viewedProductIds',
                'value' => [$productId],
                'httpOnly' => false,
                'expire' => time() + 3600 * 24,
            ]));

            return false;
        }

        $viewed = Yii::$app->request->cookies->get('viewedProductIds');
        $valueFirst = $value = $viewed->value;

        if (!in_array($productId, $value)) {
            $value[] = $productId;
        }

        if (count($value) > $limit) {
            array_shift($value);
        }

        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'viewedProductIds',
            'value' => $value,
            'httpOnly' => false,
            'expire' => time() + 3600 * 24,
        ]));

        return $valueFirst;
    }

    private static function prepareProductViewed($productIds)
    {
        $mpn = array_column(ProductRepository::getProductMpnByProductIdsForViewed($productIds), 'product_id', 'mpn');
        $queryRelate = ProductHelper::getProductWithSize($mpn, LanguageHelper::getCurrentId());

        return ProductHelper::rebuildMpnProductGroup($queryRelate, ['key' => 'status', 'value' => 1], $mpn);
    }

    public static function getProductViewed($productId, $limit)
    {
        $productIds = self::addProductViewed($productId, $limit);
        if ($productIds) {
            return self::prepareProductViewed($productIds);
        }

        return false;
    }

    // для продукта
    public static function getProductSimilars($productId)
    {
        if ($productId) {
            $productIds = ProductSimilar::find()->select('similar_id')->where(['product_id' => $productId])->asArray()->all();
            return self::prepareProductViewed(array_column($productIds, 'similar_id'));
        }

        return false;
    }

    public static function getProductViewedForCatalog()
    {
        $viewed = Yii::$app->request->cookies->get('viewedProductIds');

        if (isset($viewed->value[0])) {
            return self::prepareProductViewed($viewed->value);
        }

        return false;
    }

    public static function getGroupedSettings($settings)
    {
        $setingsGroup = [];
        foreach ($settings as $setting) {
            $setingsGroup[$setting['group_name']][$setting['language_id']] = $setting->value;
        }

        return $setingsGroup;
    }

    public static function getTranslatedValues($settings)
    {
        $translatedSettings = [];
        foreach (self::getGroupedSettings($settings) as $key => $setting) {
            $translatedSettings[$key] = isset($setting[LanguageHelper::getCurrentId()]) ?
                $setting[LanguageHelper::getCurrentId()] : $setting[2];
        }

        return $translatedSettings;
    }

    public static function groupMpnForCatalog($products, $category = false)
    {
        $ids = [];
        $mpn = [];
        foreach ($products as $product) {
            $ids[] = $product->product_id;
            $mpn[$product->product_id] = ($category) ? $product->mpn->mpn : $product->mpn;
        }

        return [
            'ids' => $ids,
            'mpn' => $mpn,
        ];
    }

    public static function getProductWatchingForCatalog($productIds, $langId)
    {
        $queryWatching =  ProductHelper::getProductWithSize($productIds, $langId, 20, ['viewed' => SORT_DESC]);
        return ProductHelper::rebuildMpnProductGroup($queryWatching, ['key' => 'status', 'value' => 1]);
    }

    public static function prepareAttributes($attributes)
    {
        $attrs = [];
        foreach ($attributes as $attribute) {
            if (!isset($attrs[$attribute['group_id']]['group_name'])) {
                $attrs[$attribute['group_id']]['group_name'] = $attribute['gr_name'];
            }
            $attrs[$attribute['group_id']]['values'][] = $attribute['name'];
        }

        return array_map(function ($a) {
            $a['values'] = implode(', ', $a['values']);
            return $a;
        }, $attrs);
    }

    public static function translationCorrection($text)
    {
        $correctUkrText = [
            'всі Військовий одяг' => 'Весь військовий одяг',
            'всі Взуття' => 'Все взуття',
            'всі Тактичне спорядження' => 'Все тактичне спорядження',
            'всі Бівачне спорядження' => 'Все бівачне спорядження',
            'всі Історичне' => 'Все історичне',

            'все Военная одежда' => 'Вся военная одежда',
            'все Обувь' => 'Вся Обувь',
            'все Оптика и прицелы' => 'Вся оптика и прицелы',

        ];

        return isset($correctUkrText[$text]) ? $correctUkrText[$text] : $text;
    }

    public static function buildColorGroup($cloneColorQuery, $colorGroup, $colors)
    {
        $queryClone = $cloneColorQuery->select('color, color_group')->andWhere(['in', 'color_group',  $colorGroup])->asArray()->all();
        $grpupQuery = [];

        if ($queryClone) {
            $queryIndex = FilterService::groupColors($queryClone);
            $grpupQuery = array_keys($queryIndex);

            foreach ($queryIndex as $group => $color) {
                foreach ($color as $colorVal) {
                    if (in_array($colorVal, $colors)) {
                        if (($key = array_search($group, $grpupQuery)) !== false) {
                            unset($grpupQuery[$key]);
                        }
                    }
                }
            }
        }

        if(count($grpupQuery) > 0) {
            return $grpupQuery;
        }

        return false;
    }

    // Делаем выборку WishList
    public static function getWishList()
    {
        $wishList = [];

        if($userId = Yii::$app->user->id) {
            $queryWishList = WishList::find()->select('product_id')->where(['customer_id' => $userId])->asArray()->all();
            if ($queryWishList) {
                $wishList = array_column($queryWishList, 'product_id');
            }
        }

        return $wishList;
    }

    // Делаем выборку compare
    public static function getCompare()
    {
        $compare = [];

        if($userId = Yii::$app->user->id) {
            $queryCompare = Compare::find()->select('product_id')
                ->where(['customer_id' => $userId])
                ->asArray()
                ->all();

            if($queryCompare) {
                $compare = array_column($queryCompare, 'product_id');
            }
        } else {
            $compareIds = Yii::$app->request->cookies->get('compareIds');
            if (isset($compareIds->value)) {
                $compare = $compareIds->value;
            }
        }

        return $compare;
    }

    public static function getPresents()
    {
        $presents = StockPresent::find()
            ->select('product_id')
            ->distinct()
            ->asArray()
            ->all();

        return ($presents !== null) ? array_column($presents,'product_id') : [];
    }

    public static function getEmail()
    {
        return isset(Yii::$app->user->identity->email) ? Yii::$app->user->identity->email : '';
    }

    public static function getStockWatchByEmail($email = false)
    {
        if ($email) {
            // Выбираем все product_id - подписчиков по емейл и со статусом '0' (0=подписан)
            $query = StockWatchService::getAllSubscribers($email);
            return $query ? array_column($query, 'product_id'): [];
        }

        return [];
    }

    public static function buildWatchingForCatalog($get)
    {
        $langId = LanguageHelper::getCurrentId();

        //type=brand_categories& value=brand_8-category_157
        if($get['type'] == 'brand_categories') {
            $ids = explode('-', $get['value']);
            $brandId = str_replace('brand_', '', $ids[0]);
            $categoryId = str_replace('category_', '', $ids[1]);

            $mpnIds = ProductRepository::getMpnAndIdForBrandCategories($brandId, $categoryId);
        }
        elseif($get['type'] == 'brand') {
            $mpnIds = ProductRepository::getMpnAndIdForBrand($get['value']);
        }
        //  Хиты, распродажа ...
        elseif($get['type'] == 'group') {
            $mpnIds = ProductRepository::getMpnAndIdForGroup($get['value']); //$name = 'hit';
        }
        // Если тип == категория то отдавать категорию... иначе
        elseif($get['type'] == 'category') {
            $mpnIds = ProductRepository::productIndexByMpn($get['value']); // $get['category_id']
        }
        else {
            $mpnIds = [];
        }

        return ProductService::getProductWatchingForCatalog($mpnIds, $langId);
    }

    public static function checkVideo($video)
    {
        if(empty($video['id_video'])) {
           preg_match('~embed/(.*?)"~is', $video['content'], $output);
           return isset($output[1]) ? $output[1] : '';
        }

        return $video['id_video'];
    }
}