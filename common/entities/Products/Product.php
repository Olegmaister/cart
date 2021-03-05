<?php

namespace common\entities\Products;

use common\entities\Brands\Brand;
use common\entities\Brands\BrandDescription;
use common\entities\Categories\CategoryDescription;
use common\entities\Color;
use common\entities\Options\OptionDescription;
use common\entities\queries\ProductQuery;
use common\entities\SlugManager;
use common\entities\Stock\Stock;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use common\services\CacheService;
use frontend\models\Compare;
use frontend\models\WishList;
use frontend\services\product\StockWatchService;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Url;

/**
 * This is the model class for table "product".
 *
 * @property int $product_id
 * @property string $model
 * @property string $sku
 * @property string $mpn
 * @property string|null $image
 * @property int $manufacturer_id
 * @property float $price
 * @property float $weight
 * @property float $length
 * @property float $width
 * @property float $height
 * @property int $status
 * @property string|null $color
 * @property int|null $color_group
 * @property int $only_ua
 * @property int $viewed
 * @property string $date_added
 * @property string $date_modified
 * @property int $new
 * @property int $hit
 * @property int $sale
 * @property int $recommend
 * @property int $discontinued
 * @property int $stock_status
 * @property int $not_update_1c
 *
 * @property SlugManager $url
 * @property string $tablesize_id [varchar(255)]
 * @property string $video
 * @property int $price_old [int(11)]
 * @property int $minimum [int(11)]
 * @property int $rating [int(11)]
 * @property int $best_seller [int(1)]
 * @property string $guid [varchar(64)]
 * @property bool $shares [tinyint(3)]
 * @property int $shares_date_to [int(11)]
 * @property int $shares_id [int(11)]
 * @property string $shares_temp
 * @property int $sort_category [int(11)]
 * @property date $new_expires
 */
class Product extends ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const SALE = 1;

    const IN_STOCK = 1;
    const NOT_IN_STOCK = 0;

    public $defaultLanguageId = 2;
    public $descriptons = [];
    public $languageId;
    public $imageFile;
    public $imageTablesize;

    private $service;

    public function __construct(
        $config = [])
    {
        $this->languageId = LanguageHelper::getIdByCode(Yii::$app->language);
        parent::__construct();
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    //ActiveRecord::EVENT_BEFORE_INSERT => ['date_added'],
                    ActiveRecord::EVENT_BEFORE_INSERT => ['date_added', 'date_modified'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['date_modified'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    // Перед сохранением
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            // Проверяем наличие товара по `quantity` в таблице `product_store_option`
            $quantity = ProductStoreOption::find()->where(['product_id' => $this->product_id])->sum('quantity');
            $this->stock_status = (int)($quantity > 0) ? 1 : 0;

            // Проверяем товар по времени является ли он новым. Если срок закончился то снимаем пометку
            if ($this->new_expires && $this->new == 1) {
                if ($this->new_expires < date("Y-m-d")) {
                    $this->new = 0;
                    //$this->new_expires = '';
                }
            }

            return true;
        }
        return false;
    }


    // После сохранеия
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Удаляем кешь групп на главной и в карточке товаров на трех языках
        CacheService::clearGroupHomeAndProduct();

        // TODO перенести в очереди и повесить на крон
        // Проверяем есть ли рассылка и рассылаем
        StockWatchService::checkAndNotifyAllUsers($this->product_id);
    }

    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['guid', 'sku', 'mpn'], 'required'],
            [['manufacturer_id', 'status', 'only_ua', 'viewed', 'new', 'hit', 'recommend', 'sale', 'discontinued', 'best_seller'], 'integer'],
            [['price', 'price_old', 'weight', 'length', 'width', 'height', 'minimum', 'color_group', 'show_excerpt', 'not_update_1c'], 'number'],
            [['date_added', 'date_modified', 'stock_status', 'new_expires'], 'safe'],
            [['video'], 'string'],
            [['model', 'sku', 'mpn', 'guid'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 250],
        ];
    }

    public function attributeLabels()
    {
        return [
            'image' => 'Изображения',
            'product_id' => 'ID',
            'price' => 'Цена',
            'price_old' => 'Старая цена',
            'status' => 'Статус',
            'manufacturer_id' => 'Бренд',
            'stock_status' => 'Наличие на складе',
            'keyword' => 'Ссылка (URL)',
            'model' => 'Модель',
            'sku' => 'Артикул',
            'mpn' => 'Номер производителя (Mpn)',
            'categories' => 'Категории',
            'weight' => 'Вес',
            'length' => 'Длина',
            'width' => 'Ширина',
            'height' => 'Высота',
            'color' => 'Цвет',
            'color_group' => 'Цвет',
            'only_ua' => 'Только для украины',
            'viewed' => 'Просмотров',
            'date_added' => 'Дата добавления',
            'date_modified' => 'Дата изменения',
            'new' => 'Новый',
            'hit' => 'Лидер',
            'recommend' => 'Рекомендуем',
            'discontinued' => 'Снято с производства',
            'sale' => 'Распродажа',
            'best_seller' => 'Бестсейлер',
            'video' => 'Видео инструкция',
            'show_excerpt' => 'Выводить на сайте',
            'new_expires' => 'Окончание',
            'not_update_1c' => 'Не обновлять название при синхронизации с 1С',
        ];
    }

    public function getUrl()
    {
        return $this->hasOne(SlugManager::className(), [
            'id' => 'product_id',
        ])->where(['url_alias.controller' => 'products']);
    }

    public function getFavorite()
    {
        return $this->hasOne(WishList::class, [
            'product_id' => 'product_id',
        ])->where(['wish_list.customer_id' => Yii::$app->user->id]);
    }

    public function getBarcode()
    {
        return $this->hasOne(ProductStoreOption::class, [
            'product_id' => 'product_id',
        ]);
    }

    public function getCompare()
    {
        return $this->hasOne(Compare::class, [
            'product_id' => 'product_id',
        ])->where(['compare.customer_id' => Yii::$app->user->id]);
    }

    public function inSale()
    {
        return $this->sale == self::SALE;
    }

    public function getDescription()
    {
        return $this->hasOne(ProductDescription::className(), ['product_id' => 'product_id'])
            ->where(['product_description.language_id' => $this->languageId]);
    }

    public function getLink()
    {
        return isset($this->url->keyword) ?
            "<a href=\"/{$this->url->keyword}\">{$this->url->keyword}</a>" : '';
    }

    public function getVideos()
    {
        return $this->hasOne(ProductVideo::className(), ['product_id' => 'product_id']);
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getImage()
    {
        if ($this->image) {
            $imgUrl = ProductHelper::correctedImgPath($this->image);
        } else {
            $imgUrl = '/images/no-image.png';
        }

        return Url::to($imgUrl, true);
    }

    public function getImages()
    {
        return ProductImage::findAll(['product_id' => $this->product_id]);
    }

    public function getBrandName()
    {
        return $this->hasOne(BrandDescription::className(), ['brand_id' => 'manufacturer_id'])
            ->select('brand_id, name')
            ->where(['language_id' => $this->languageId])->asArray();
    }

    public function getBrand()
    {
        return $this->hasOne(BrandDescription::className(), ['brand_id' => 'manufacturer_id'])
            ->where(['language_id' => $this->languageId]);
    }

    public function getBrandLimitation()
    {
        return $this->hasOne(Brand::class, ['brand_id' => 'manufacturer_id'])
            ->where(['language_id' => $this->languageId]);
    }

    public function getCategoriesId()
    {
        return $this->hasMany(ProductInCategory::className(), ['product_id' => 'product_id']);
    }

    public function getCategoryId()
    {
        return $this->hasOne(ProductInCategory::className(), ['product_id' => 'product_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(ProductInCategory::class, ['category_id' => 'product_id']);
    }

    public function getCategories()
    {
        return $this->hasMany(CategoryDescription::className(), ['category_id' => 'category_id'])->via('categoriesId')
            ->where(['category_description.language_id' => $this->languageId]);
    }

    /*public function getOptions()
    {
        return $this->hasMany(ProductStoreOption::class, ['product_id' => 'product_id']);
        //->where(['language_id' => $this->languageId]);
    }*/

    public function getSizes()
    {
        return $this->hasMany(OptionDescription::className(), ['option_id' => 'option_id'])
            ->viaTable('product_store_option', ['product_id' => 'product_id'])
            ->where(['option_description.language_id' => $this->languageId]);
    }

    public function getColorName()
    {
        return $this->hasOne(Color::class, ['id' => 'color'])->asArray();
    }

    /*public function getAttrs()
    {
        return $this->hasMany(ProductAttribute::className(), ['product_id' => 'product_id']);
    }

    public function getAttrNames()
    {
        return $this->hasMany(AttributeDescription::className(), ['attribute_id' => 'attribute_id'])
            ->via('attrs')
            ->where(['language_id' => $this->languageId]);
    }*/

    public function getAttrp()
    {
        return $this->hasMany(ProductAttribute::className(), ['product_id' => 'product_id']);
    }

    public function getAttrGroups()
    {
        $sql = "
            SELECT ad.name, agd.name as gr_name, agd.group_id, ad.attribute_id
            FROM attribute_description ad
            LEFT JOIN product_attribute pa on pa.attribute_id = ad.attribute_id
            LEFT JOIN attribute a on a.attribute_id = ad.attribute_id
            LEFT JOIN attribute_group_description agd on agd.group_id = a.group_id
            WHERE pa.product_id=$this->product_id
              AND ad.language_id=$this->languageId
              AND agd.language_id=$this->languageId
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public function getReviews()
    {
        return $this->hasMany(ProductReview::className(), ['product_id' => 'product_id']);
        //->where(['language_id' => $this->languageId]);
    }

    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

    /**
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public function getStoreList(): array
    {
        $sql = "
            SELECT
                MAX(p.product_id),
                CONCAT(s.name, ' ', s.address) AS 'store',
                MAX(s.store_id) AS 'store_id',
                MAX(s.city) AS 'store_city'
            FROM
                 product p
            LEFT JOIN product_store_option pso ON p.product_id = pso.product_id
            LEFT JOIN store_description s ON s.store_id = pso.store_id
            WHERE pso.quantity > 0
                AND p.product_id = :ID
                AND s.language_id = :LangId
                AND s.store_id != 0
            GROUP BY pso.store_id, pso.product_id
        ";

        return Yii::$app->db->createCommand($sql)
            ->bindValue('ID', $this->product_id)
            ->bindValue('LangId', $this->languageId)
            ->queryAll();
    }

    /**
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public function getUniqStoreList(): array
    {
        $sql = "
            SELECT
                s.city AS 'store_city'
            FROM
                 product p
            LEFT JOIN product_store_option pso ON p.product_id = pso.product_id
            LEFT JOIN store_description s ON s.store_id = pso.store_id
            WHERE pso.quantity > 0
            AND p.product_id = :ID
            AND s.language_id = :LangId
            GROUP BY s.city
        ";

        return Yii::$app->db->createCommand($sql)
            ->bindValue('ID', $this->product_id)
            ->bindValue('LangId', $this->languageId)
            ->queryAll();
    }

    /**
     * @param int $storeId
     * @return array|\yii\db\DataReader
     * @throws \yii\db\Exception
     */
    public function getStoreProductSizesList(int $storeId): array
    {
        $sql = "
            SELECT
                MAX(pso.option_id) AS 'option_id',
                MAX(od.name) AS 'option_name',
                MAX(pso.quantity) AS 'option_quantity'
            FROM
                 product p
            LEFT JOIN product_store_option pso ON p.product_id = pso.product_id
            LEFT JOIN store s ON s.store_id = pso.store_id
            LEFT JOIN option_description od ON od.option_id = pso.option_id
            WHERE p.product_id = :ID
            AND od.language_id = :LANG
            AND pso.store_id = :STORE
            GROUP BY pso.store_id, pso.product_id, od.name
            ORDER BY option_quantity DESC, option_name
        ";

        return Yii::$app->db->createCommand($sql)
            ->bindValue('ID', $this->product_id)
            ->bindValue('STORE', $storeId)
            ->bindValue('LANG', $this->languageId)
            ->queryAll();
    }

    public function isCheckStock()
    {
        return $this->shares == 0;
    }

    public function unAssignProductStock()
    {
        $this->shares_id = null;
        $this->shares = null;
        $this->shares_date_to = null;
        $this->shares_temp = null;
    }

    public function assignStock(Stock $stock)
    {

        $this->shares_id = Stock::find()->max('id') + 1;
        $this->shares = 1;
        $this->shares_date_to = $stock->date_to;
        $this->shares_temp = date('d-m-Y h:i:s', $stock->date_to);
    }

    public function assignCurrentStock(Stock $stock, $dateTo)
    {

        $this->shares_id = $stock->id;
        $this->shares = 1;
        $this->shares_date_to = $dateTo;
        $this->shares_temp = date('d-m-Y h:i:s', $dateTo);
    }
}
