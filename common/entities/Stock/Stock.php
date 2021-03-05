<?php

namespace common\entities\Stock;

use backend\forms\Stocks\StockCreateForm;
use common\entities\queries\StockQuery;
use common\entities\UrlAlias;
use common\helpers\DateHelper;
use common\helpers\LanguageHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%stock}}".
 *
 * @property int $id
 * @property string $type
 * @property string $guid
 * @property integer $counting_method
 * @property double $money
 * @property int $percent
 * @property integer $slider
 * @property int $date_from
 * @property int $date_to
 * @property int $active
 *
 * @property StockCustomer[] $customers
 * @property StockPresent $presents
 * @property UrlAlias $slug
 * @property StockDescription[] $descriptions
 * @property StockBrand [] $brands
 * @property StockPhoto[] $photos
 * @property StockCategory [] $categories
 * @property StockProduct [] $products
 * @property StockGroup [] $groups
 * @property StockFunded [] $fundeds
 * @property StockCost [] $costs
 * @property StockPromo [] $promos
 */
class Stock extends ActiveRecord
{

    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;
    const SLIDER_SHOW = 1;
    const STATUS_DRAFT = 0;
    const NOT_STOCK = 0;

    const COUNTING_MONEY = 2;
    const COUNTING_PERCENT = 1;

    const TYPE_CUSTOMER = 'customer';
    const TYPE_GROUP = 'group';
    const TYPE_PRODUCT = 'product';
    const TYPE_CATEGORY = 'category';
    const TYPE_BRAND = 'brand';
    const TYPE_PRESENT = 'present';
    const TYPE_FUNDED = 'funded';
    const TYPE_PROMO = 'promo';

    public $date;


    const EVENT_TEST = 'test';

    public static function tableName()
    {
        return '{{%stock}}';
    }

    public static function create($type,$countingMethod,$money, $percent,$dateFrom, $dateTo, $active, $slider)
    {

        $object = new self();
        $object->type = $type;
        $object->counting_method = $countingMethod;
        $object->money = $money;
        $object->percent = $percent;
        $object->date_from = DateHelper::getTimestampByDate($dateFrom);
        $object->date_to = DateHelper::getTimestampByDateTo($dateTo);
        $object->active = $active;
        $object->slider = $slider;

        return $object;
    }

    //TODO временно отдельно для api
    public static function apiCreate($api, $type, $method, $dateFrom, $dateTo)
    {
        $object = new self();
        $object->guid = $api;
        $object->type = $type;
        $object->counting_method = $method;
        $object->date_from = $dateFrom;
        $object->date_to = $dateTo;

        return $object;
    }

    //TODO временно отдельно для api
    public function apiEdit($method, $percent, $money, $dateFrom, $dateTo)
    {
        $this->counting_method = $method;
        $this->percent = $percent;
        $this->money = $money;
        $this->date_from = $dateFrom;
        $this->date_to = $dateTo;
    }

    public function edit($type,$countingMethod,$money, $percent,$dateFrom, $dateTo, $active, $slider)
    {
        $this->type = $type;
        $this->counting_method = $countingMethod;
        $this->money = $money;
        $this->percent = $percent;
        $this->date_from = DateHelper::getTimestampByDate($dateFrom);
        $this->date_to = DateHelper::getTimestampByDateTo($dateTo);
        $this->active = $active;
        $this->slider = $slider;
    }

    public function setDescription(array $descriptions)
    {

        $data = [];

        foreach ($descriptions as $description) {
            $data[] = $description;
        }

        $this->descriptions = $data;

    }

    public function isActive()
    {
        return $this->active;
    }

    public function activate()
    {
        $this->active = self::STATUS_ACTIVE;
    }

    public function deactivate()
    {
        $this->active = self::STATUS_NOT_ACTIVE;
    }

    public function setPercent($percent)
    {
        $this->percent = $percent;
    }

    public function setMoney($money)
    {
        $this->money = $money;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function setSlider($slider)
    {
        $this->slider = $slider;
    }

    public function getId()
    {
        return $this->id;
    }

    public static function createSegmentDiscount($percent)
    {
        $object = new self();
        $object->percent = $percent;
        $object->counting_method = self::COUNTING_PERCENT;

        return $object;
    }


    public function updateActive()
    {
        $result = $this::find()
            ->andWhere(['and',
                ['id' => $this->id],
                ['<','stock.date_from', DateHelper::getCurrentTime()],
                ['>','stock.date_to', DateHelper::getCurrentTime()],
                ['stock.active' => Stock::STATUS_ACTIVE]
                ]
            )
            ->one();

        if($result){
            $this->active = 1;
        }else{
            $this->active = 0;
        }

        $this->save();
    }

    public function attributeLabels()
    {
        return [
            'percent' => 'Скидка %',
            'type' => 'Тип',
            'active' => 'Активна',
            'date' => 'Период действия',
            'counting_method' => 'Метод подсчета',
            'name' => 'Название'
        ];
    }
    /*type stock*/
    public function ifTypeProduct()
    {
        return $this->type == self::TYPE_PRODUCT;
    }
    public function ifTypeBrand()
    {
        return $this->type == self::TYPE_BRAND;
    }
    public function ifTypeCategory()
    {
        return $this->type == self::TYPE_CATEGORY;
    }
    public function ifTypePresent()
    {
        return $this->type == self::TYPE_PRESENT;
    }

    //customers
    public function assingCustomer(array $customers,$segments)
    {

        $data = [];

        foreach ($customers as $customer) {
            $data[] = StockCustomer::create($customer,$segments);
        }

        $this->customers = $data;

    }
    //customers

    //presents
    public function assingPresent(int $productId, array $productPresents)
    {

        $data = $this->presents;

        foreach ($productPresents as $productPresent) {
            $data[] = StockPresent::create($productId, $productPresent);
        }

        $this->presents = $data;



    }
    //presents

    //brands
    public function assingBrand(array $brands,$segments)
    {
        $data = [];
        foreach ($brands as $brand) {
            $data[] = StockBrand::create($brand,$segments);
        }

        $this->brands = $data;
    }
    //brands

    //categories
    public function assignCategory(array $categories,$segments)
    {
        $data = [];
        foreach ($categories as $category) {
            $data[] = StockCategory::create($category,$segments);
        }

        $this->categories = $data;
    }
    //categories

    //products
    public function assingProduct(array $products,$segments)
    {
        $data = [];
        foreach ($products as $product) {
            $data[] = StockProduct::create($product,$segments);
        }

        $this->products = $data;
    }
    //products

    //groups
    public function assingGroup(array $groups)
    {
        $data = [];
        foreach ($groups as $group) {
            $data[] = StockGroup::create($group);
        }

        $this->groups = $data;
    }
    //groups

    //fundeds
    public function assingFunded(StockCreateForm $form)
    {
            $data[] = StockFunded::create($form);

        $this->fundeds = $data;
    }



    //fundeds

    //amount
    public function assingCost(int $cost)
    {
        $data = StockCost::create($cost);
        $this->costs = $data;

    }
    //amount

    //promo
    public function assignPromo(array $promoStock)
    {
        $promos = $this->promos;

        foreach ($promoStock as $promo) {
            $promos[] = StockPromo::create($promo);

        }

        $this->promos = $promos;

    }
    //promo


    /*photos*/
    public function addPhoto(UploadedFile $file): void
    {
        $photos = $this->photos;
        $photos[] = StockPhoto::create($file);

        $this->photos = $photos;

    }


    public function checkStart()
    {

    }

    public function existsPhotos()
    {
        return  isset($this->photos) && !empty($this->photos);
    }

    public function existsPhoto($name)
    {
        if(!isset($this->photo))return false;
        $infoFile = $this->photo->getThumbFileUrl('file', 'slider');
        $info = new \SplFileInfo($infoFile);
        $path = \Yii::getAlias("@staticRoot/stocks/{$this->id}/{$name}_{$this->photo->id}.{$info->getExtension()}");

        return file_exists($path);
    }


    public function getTypeName()
    {
        return $this->typeDescription();
    }



    private function typeDescription()
    {
        $types = [
            'customer' => 'Пользователи',
            'product' => 'Товары',
            'brand' => 'Бренды',
            'category' => 'Категории',
            'funded' => 'Накопительная',
            'group' => 'Сегмент',
            'promo' => 'Промокод',
            'present' => 'Товар в подарок'
        ];

        return isset($types[$this->type]) ? $types[$this->type] : 'не известно';
    }

    public function checkProduct($productId)
    {
        return $productId == 2740;
    }

    /*descriptions*/
    public function editChildDescription($description)
    {
        $descriptions = $this->descriptions;
        /**@var  $item*/
        foreach ($descriptions as &$item) {
            /**@var StockDescription $item*/
            if ($item->isForCategoryDescription($description->id)) {
                $item = $description;
            }
        }

        $this->descriptions = $descriptions;
    }

    public function getValueDiscount()
    {
        if($this->counting_method == self::COUNTING_PERCENT)
            return $this->getPercent();

        if($this->counting_method == self::COUNTING_MONEY)
            return $this->getMoney();
    }

    public function getSign()
    {
        if($this->counting_method == self::COUNTING_PERCENT)
            return $this->getSignPercent();

        if($this->counting_method == self::COUNTING_MONEY)
            return $this->getSignMoney();
    }

    public function getSignPercent()
    {
        return ' %';
    }

    public function getSignMoney()
    {
        return ' грн.';
    }



    public function getPercent()
    {
        return $this->percent;
    }

    public function getMoney()
    {
        return $this->money;
    }


    public function behaviors()
    {
        return[
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => [
                    'descriptions',
                    'customers',
                    'brands',
                    'categories',
                    'products',
                    'groups',
                    'fundeds',
                    'funded',
                    'costs',
                    'promos',
                    'photos',
                    'slug',
                    'presents'
                ],

            ],
        ];
    }


    public function getLinkTableName(string $type)
    {
        $array = $this->tes();
        return $array[$type];
    }

    public function tes()
    {
        return [
            'product' => StockProduct::class,
            'category' => StockCategory::class,
            'customer' => StockCustomer::class,
            'brand' => StockBrand::class,
            'group' => StockGroup::class,
            'promo' => StockPromo::class,
            'funded' => StockFunded::class,
            'present' => StockPresent::class
        ];
    }

    /*====getters===*/

    /*===relations====*/
    public function getCustomers()
    {
        return $this->hasMany(StockCustomer::class, ['stock_id' => 'id']);
    }

    public function getPresents()
    {
        return $this->hasMany(StockPresent::class, ['stock_id' => 'id']);
    }

    public function getDescriptions()
    {
        return $this->hasMany(StockDescription::class, ['stock_id' => 'id']);
    }

    public function getDescription()
    {
        return $this->hasOne(StockDescription::class, ['stock_id' => 'id'])
            ->where(['language_id' => LanguageHelper::getCurrentId()]);
    }

    public function getSlug()
    {
        return $this->hasOne(UrlAlias::class, ['id' => 'id'])->where(['url_alias.controller' => 'stocks']);
    }


    public function getBrands()
    {
        return $this->hasMany(StockBrand::class, ['stock_id' => 'id']);
    }

    public function getCategories()
    {
        return $this->hasMany(StockCategory::class, ['stock_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(StockProduct::class, ['stock_id' => 'id']);
    }

    public function getGroups()
    {
        return $this->hasMany(StockGroup::class, ['stock_id' => 'id']);
    }

    public function getFundeds()
    {
        return $this->hasMany(StockFunded::class, ['stock_id' => 'id']);
    }

    public function getFunded()
    {
        return $this->hasOne(StockFunded::class, ['stock_id' => 'id']);
    }

    public function getCosts()
    {
        return $this->hasMany(StockCost::class, ['stock_id' => 'id']);
    }

    public function getPromos()
    {
        return $this->hasMany(StockPromo::class, ['stock_id' => 'id']);
    }

    public function getPhotos()
    {
        return $this->hasMany(StockPhoto::class, ['stock_id' => 'id']);
    }

    public function getPhoto()
    {
        return $this->hasOne(StockPhoto::class, ['stock_id' => 'id']);
    }


    public static function find(): StockQuery
    {
        return new StockQuery(static::class);
    }



}
