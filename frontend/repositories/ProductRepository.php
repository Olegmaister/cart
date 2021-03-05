<?php

namespace frontend\repositories;

use common\entities\Attributes\AttributeGroup;
use common\entities\Brands\Brand;
use common\entities\Categories\Category;
use common\entities\Categories\CategoryPath;
use common\entities\Color;
use common\entities\Products\Product;
use common\entities\Products\ProductAttribute;
use common\entities\Products\ProductImage;
use common\entities\Products\ProductInCategory;
use common\entities\Products\ProductReview;
use common\entities\Products\ProductStoreOption;
use common\entities\Products\ProductVideo;
use common\entities\Seo\Seo;
use common\entities\Seo\SeoAdditionalDescription;
use common\entities\Settings\Settings;
use common\entities\Slider\Slider;
use common\entities\Stock\StockProduct;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;
use frontend\components\ApiCurrency;
use frontend\entities\ProductOne;
use frontend\services\CategoriesService;
use frontend\services\DataProvider\GroupProviderService;
use frontend\services\ProductService;
use Yii;

class ProductRepository
{
    public static function getMpnAndIdByField($field)
    {
        return Product::find()
            ->select('product_id, mpn')
            ->where(['status' => Product::STATUS_ACTIVE, "{$field}" => 1])
            ->groupBy('mpn')
            ->asArray()
            ->all();
    }

    public static function getProductIdsByBrandId($id)
    {
        return Product::find()
            ->select('mpn, product_id')
            ->where(['status' => Product::STATUS_ACTIVE, 'manufacturer_id' => $id])
            ->groupBy('mpn')
            ->asArray()
            ->all();
    }

    public static function getProductViaPovider($field, $condition = false, $langId = 2, $limit = 8, $sort = false)
    {
        $provider = GroupProviderService::getProductProvider($field, $condition, $limit, $sort);
        $ids = array_column($provider->getModels(), 'product_id', 'mpn');
        $queryRelate = ProductHelper::getProductWithSize($ids, $langId);
        $items = ProductHelper::rebuildMpnProductGroup($queryRelate, ['key' => $field, 'value' => 1], $ids);

        return [
            'existNextPage' => ProductService::checkExistNextPage($provider),
            'relate' => $items['relate'],
            'mpn' => $items['mpn']
        ];
    }

    public static function getProductByFieldStockProduct($field, $limit)
    {
        $products = Product::find()
            ->where(['and', ['product.status' => 1], ['in', 'product_id', $field]])
            ->orderBy(['product.stock_status' => SORT_DESC])
            ->limit($limit)
            ->all();

        return [
            'products' => $products
        ];
    }

    public static function getProductByFieldStockOther($field, $limit)
    {
        $products = Product::find()
            ->where(['and', ["product.status" => 1], ['in', 'product_id', $field]])
            ->orderBy(['product.stock_status' => SORT_DESC])
            ->limit($limit)
            ->all();

        $mpn = array_column($products, 'mpn');
        $queryRelate = self::getProductByMpn($mpn);
        $relate = ProductHelper::getIndexColumn($queryRelate, 'mpn');

        return [
            'products' => $products,
            'relate' => $relate
        ];
    }

    public static function getStockProduct($id)
    {
        return StockProduct::find()
            ->with('stock')
            ->where(['product_id' => $id])
            ->one();
    }

    public static function getProductByMpn($mpn = [], $limit = false, $orderBy = false)
    {
        $products = Product::find()
            ->where(['product.status' => Product::STATUS_ACTIVE])
            ->andWhere(['in', 'product.mpn', $mpn]);

        if ($limit) {
            $products->limit($limit);
        }

        if ($orderBy) {
            $products->orderBy($orderBy);
        }

        return $products->all();
    }

    public static function getProductByMpnWishList($mpn)
    {
        return Product::find()
            ->where(['product.status' => Product::STATUS_ACTIVE])
            ->andWhere(['in', 'product.mpn', $mpn])
            ->leftJoin('wish_list wl', 'wl.product_id = product.product_id')
            ->orderBy(new \yii\db\Expression('IF(wl.product_id IS NOT NULL, 1, 0) DESC'))
            ->all();
    }

    public static function getColorsByMpn($mpn)
    {
        return Product::find()
            ->select('product_id, color')
            //->with('url')
            ->where(['status' => Product::STATUS_ACTIVE, 'mpn' => $mpn])
            ->indexBy('color')
            ->all();
    }

    public static function getProductByIds($productIds, $limit = 30, $orderBy = null, $indexBy = null, $select = null)
    {
        //dd($productIds);
        $product = Product::find()
            ->where(['in', 'product_id', $productIds])
            ->andWhere(['stock_status' => 1])
            //->with(['url', 'description'])
            //->groupBy('mpn')
            ->limit($limit);

        if ($indexBy) {
            $product->indexBy($indexBy);
        }

        if ($orderBy) {
            $product->orderBy([$orderBy => SORT_DESC]);
        }

        if ($select) {
            $product->select($select);
        }

        return $product->all();
    }

    public static function getPoductIdsByCategory($catIds, $condition = false, $productIdsOnly = false)
    {
        $productIds = ProductInCategory::find()
            ->where(['category_id' => $catIds]);

        if ($productIdsOnly) {
            $productIds->select('product_id');
        }

        return $productIds->all();
    }

    public static function getPoductIdsInCategory($catIds, $asArray = false)
    {
        $product = ProductInCategory::find()
            ->select('product_id')->distinct()
            //->with('mpn')
            ->where(['in', 'category_id', $catIds]);

        if ($asArray) {
            $product->asArray();
        }
        return $product->all();
    }

    public static function getPoductsInCategory($productId)
    {
        return ProductInCategory::find()
            ->with('description', 'url')
            ->where(['product_id' => $productId])
            ->all();
    }

    public static function getCategoriesInProductIds($ids)
    {
        return ProductInCategory::find()
            ->select('category_id')
            ->distinct()
            ->where(['in', 'product_id', $ids])
            ->all();
    }

    public static function getBrandsByProductIds($productIds)
    {
        return Product::find()
            ->select('manufacturer_id')->distinct()
            ->where(['in', 'product_id', $productIds])
            ->all();
    }

    public static function getBrandsById($ids)
    {
        return Brand::find()
            ->with('url', 'description')
            ->where(['status' => Product::STATUS_ACTIVE])
            ->andWhere(['in', 'brand_id', $ids])
            ->all();
    }

    public static function getBrads($langId = 2)
    {
        return Brand::find()
            ->select('brand.image, brand_description.name, url_alias.keyword')
            ->leftJoin('brand_description', 'brand_description.brand_id=brand.brand_id')
            ->leftJoin('url_alias', 'brand.brand_id=url_alias.id')
            ->where(['status' => Product::STATUS_ACTIVE])
            ->andWhere(['brand_description.language_id' => $langId])
            ->andWhere(['url_alias.controller' => 'brands', 'url_alias.action' => 'view'])
            ->asArray()
            ->all();
    }

    public static function getMpnByBrandId($id)
    {
        $query = Product::find()
            ->select('mpn')->distinct()
            ->where(['status' => Product::STATUS_ACTIVE, 'manufacturer_id' => $id]);

        $ids = Product::find()
            ->where(['status' => Product::STATUS_ACTIVE, 'manufacturer_id' => $id])
            ->andWhere(['in', 'mpn', $query])
            ->orderBy(['product.product_id' => SORT_ASC])
            ->all();

        return $ids;
    }

    public static function getVideo()
    {
        return ProductVideo::find()
            ->joinWith('products')
            ->orderBy(['product_id' => SORT_ASC])
            ->limit(10)
            ->all();
    }

    public static function getVideoByMainPage()
    {
        $videos = self::getVideoSort();
        $fullData = [];

        foreach($videos as $key => $video) {
            $limitTags = ($key == 0) ? 1 : 2;
            $fullData[] = [
                'keyword' => $video['keyword'],
                'name' => $video['name'],
                'tags' => ProductHelper::getVideoTagsByUrl($video['content'], $limitTags),
                'date_modified'=> Yii::$app->formatter->asDate($video['date_modified'], 'php:d.m.Y'),
                'image_name' => $video['id_video'],
                'preview_video' => 'https://img.youtube.com/vi/' .  $video['id_video'] . '/sddefault.jpg'
            ];
        }

        return $fullData;
    }

    public static function getVideoSort($limit=4)
    {
        return ProductVideo::find()
            ->select('product_video.product_id, product_video.content, product_video.id_video, product_video.name, product_video.date_modified, url_alias.keyword')
            ->leftJoin('url_alias', 'url_alias.id=product_video.product_id')
            ->where(['url_alias.controller' => 'products', 'url_alias.action' => 'view'])
            ->orderBy(['date_modified' => SORT_DESC])
            ->limit($limit)
            ->asArray()
            ->all();
    }

    public static function getProductOptionsById($id)
    {
        return ProductStoreOption::find()
            ->with('description')
            ->where(['product_id' => $id])
            ->all();
    }

    public static function getProductOptionsByIdForCart($id)
    {
        return ProductStoreOption::find()
            ->with('description')
            ->where(['product_id' => $id])
            ->groupBy('option_id')
            ->all();
    }


    public static function getProductOptionsForCart($id, $langId = 2)
    {
        return ProductStoreOption::find()
            ->select('SUM(product_store_option.quantity) as quantity_sum, product_store_option.store_id, product_store_option.option_id, product_store_option.product_id, option_description.name')
            ->leftJoin('option_description', 'option_description.option_id=product_store_option.option_id')
            ->where(['product_store_option.product_id' => $id])
            ->andWhere(['option_description.language_id' => $langId])
            ->groupBy('product_store_option.option_id')
            ->orderBy('quantity_sum DESC')
            ->asArray()
            ->all();
    }

    public static function getProductReviewsById($id)
    {
        $reviews = [];
        $query = ProductReview::find()
            ->where('answer_review_id = review_id')
            ->andWhere([
                'status' => ProductReview::STATUS_ACTIVE,
                'product_id' => $id
            ])
            ->asArray()
            ->all();

        if ($query !== null) {
            $answers = [];
            $queryRe = ProductReview::find()
                ->where('answer_review_id <> review_id')
                ->andWhere([
                    'status' => ProductReview::STATUS_ACTIVE,
                    'product_id' => $id
                ])
                ->asArray()
                ->all();

            if ($queryRe !== null) {
                foreach ($queryRe as $re) {
                    $answers[$re['answer_review_id']][] = $re;
                }
            }

            foreach ($query as $key => $review) {
                $reviews[$key] = $review;
                $reviews[$key]['re'] = isset($answers[$review['review_id']])
                    ? $answers[$review['review_id']] : [];
            }
        }

        return $reviews;
    }

    public static function getImagesByProductId($id)
    {
        return ProductImage::find()
            //->select('image')
            ->where(['product_id' => $id])
            ->asArray()
            ->all();
    }

    public static function getProductById($id)
    {
        return Product::find()
            //->with('url', 'description', 'brand', 'stockStatus', 'attrNames')
            //->with('url', 'description', 'brand')
            ->where(['product.product_id' => $id])
            ->one();
    }

    public static function prepareItemsData($provider) // Todo
    {
        $products = $provider->getModels();
        $mpn = array_column($products, 'mpn');
        $queryRelate = ProductRepository::getProductByMpn($mpn);

        return [
            'products' => $products,
            'relate' => ProductHelper::getIndexColumn($queryRelate, 'mpn')
        ];
    }

    // Categories
    public static function getCategoryPath($array)
    {
        return CategoryPath::find()
            ->where('category_id != parent_id')
            ->andWhere(['in', 'parent_id', $array])
            ->asArray()
            ->all();
    }

    public static function getCategoriesPathByOneCategory($categoryId)
    {
        return CategoryPath::find()
            ->where('category_id != parent_id')
            ->andWhere(['parent_id' => $categoryId])
            ->asArray()
            ->all();
    }

    public static function getСategoriesNameByIds($categoryIds)
    {
        $category = Category::find()
            ->where(['category.status' => Category::STATUS_ACTIVE])
            ->andWhere(['in', 'category.category_id', $categoryIds])
            ->orderBy('category_id')->all();

        return $category;
    }

    public static function getСategoriesWithName($level)
    {
        $categories = Category::find()
            ->joinWith('url')
            ->joinWith('description')
            ->joinWith('path')
            ->where(['category.status' => Category::STATUS_ACTIVE, 'category_path.level' => $level])
            ->orderBy(['category.sort_main_menu' => SORT_ASC]);

        if ($level == 0) {
            $categories = $categories->andWhere(['<>', 'category.sort_main_menu', 0]);
        }

        return $categories->indexBy('category_id')->asArray()->all();
    }

    public static function getCategoryLevelById($id)
    {
        return CategoryPath::findOne(['parent_id' => $id, 'category_id' => $id]);
    }

    public static function getProductsForCategoryPage($id)
    {
        $catIds = CategoriesService::getParentCategoriesDownTree($id);
        array_push($catIds, $id);
        $poductIdsInCategory = ProductRepository::getPoductIdsInCategory($catIds);
        $productIds = array_column($poductIdsInCategory, 'product_id');
        $items['products'] = ProductRepository::getProductByIds($productIds);
        $mpn = array_column($items['products'], 'mpn');
        $queryRelate = ProductRepository::getProductByMpn($mpn);
        $items['relate'] = ProductHelper::getIndexColumn($queryRelate, 'mpn');

        return $items;
    }

    public static function getCategoryParent($categoryId)
    {
        return CategoryPath::find()
            ->where('category_id != parent_id')
            ->andWhere(['category_id' => $categoryId])
            ->asArray()
            ->one();
    }

    public static function getProductIdsFromCategories($id)
    {
        $catIds = CategoriesService::getParentCategoriesDownTree($id);
        array_push($catIds, $id);
        return ProductRepository::getPoductIdsInCategory($catIds, true);
    }

    public static function getRelateProductsFromCategory($poductIdsInCategory)
    {
        $productIds = [];

        foreach ($poductIdsInCategory as $element) {
            if (!array_key_exists($element->mpn->mpn, $productIds)) {
                if ($element->mpn->mpn) {
                    $productIds[$element->mpn->mpn] = $element->product_id;
                }
            }
        }

        return $productIds;
    }

    public static function getRelateIdsByProduct($poducts)
    {
        $productIds = [];

        foreach ($poducts as $element) {
            if (!array_key_exists($element->mpn->mpn, $productIds)) {
                $productIds[$element->mpn->mpn] = $element->product_id;
            }
        }

        return $productIds;
    }

    public static function getAttributesByProductMpn($productMpn)
    {
        return ProductAttribute::find()
            ->select('attribute_id')->distinct()
            ->where(['in', 'product_mpn', $productMpn])
            ->all();
    }

    public static function getProductsMpnByAttributes($attributeIds, $asArray = false)
    {
        $attributes = ProductAttribute::find()
            ->select('product_mpn, attribute_id')->distinct()
            ->where(['in', 'attribute_id', $attributeIds]);

        if ($asArray) {
            $attributes->asArray();
        }

        return $attributes->all();
    }

    public static function getQueryFull($productIds)
    {
        return Product::find()
            ->where(['in', 'product_id', $productIds])
            ->andWhere(['product.status' => Product::STATUS_ACTIVE]);
    }

    /**
     * @param string $name
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public static function getProductsByName(string $name, int $limit = 12, int $offset = 0): array
    {
        $nameClear = trim(preg_replace('/[^A-zА-яёЁ\d]/u', ' ', $name));
        $skuClear = trim(preg_replace('/[^A-zА-яёЁ\.\-\d]/u', '', $name));

        $sql = '
            SELECT
                p.*
            FROM product p
            LEFT JOIN product_description pd ON pd.product_id = p.product_id AND pd.language_id = :LANG
            LEFT JOIN url_alias ua ON ua.id = p.product_id
                                          AND ua.controller = "products"
             WHERE (REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pd.name, ":", ""), "*", ""), ".", ""), ",", ""), "?", ""), "!", ""), \'"\', ""), " ", ""), "-", "") LIKE :SEARCH_NAME OR p.sku LIKE :SEARCH_SKU)
              AND p.status = 1
            GROUP BY p.mpn
            HAVING MAX(p.price) > 0
            ORDER BY 
                     IF(p.sku = :SEARCH_SKU_ORDER, 1, 0) DESC,
                     MATCH(`name`) AGAINST(:SEARCH_NAME_ORDER IN BOOLEAN MODE) DESC
            LIMIT :LIMIT
            OFFSET :OFFSET
        ';

        $products = Product::findBySql($sql, [
            'SEARCH_NAME' => "%$nameClear%",
            'SEARCH_SKU' => "%$skuClear%",
            'SEARCH_SKU_ORDER' => $skuClear,
            'SEARCH_NAME_ORDER' => $nameClear,
            'LANG' => LanguageHelper::getCurrentId(),
            'LIMIT' => $limit,
            'OFFSET' => $offset,
        ]);

        $productsCount = $products->count();
        $products = $products->all();

        $mpn = array_column($products, 'mpn');
        $queryRelate = self::getProductByMpn($mpn);
        $relate = ProductHelper::getIndexColumn($queryRelate, 'mpn');

        return [
            'products' => $products,
            'relate' => $relate,
            'count' => $productsCount,
        ];
    }

    /**
     * @param string $name
     * @param int $limit
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getProductAjaxData(string $name, int $limit = 10): array
    {
        $nameClear = trim(preg_replace('/[^A-zА-яёЁ\d]/u', '', $name));
        $skuClear = trim(preg_replace('/[^A-zА-яёЁ\.\-\d]/u', '', $name));

        $sql = '
            SELECT
                pd.name
              , ua.keyword AS url
              , p.price
              , p.price_old
              , p.image
            FROM product p
            LEFT JOIN product_description pd ON pd.product_id = p.product_id AND pd.language_id = :LANG
            LEFT JOIN url_alias ua ON ua.id = p.product_id
                                          AND ua.controller = "products"
             WHERE (REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(pd.name, ":", ""), "*", ""), ".", ""), ",", ""), "?", ""), "!", ""), \'"\', ""), " ", ""), "-", "") LIKE :SEARCH_NAME OR p.sku LIKE :SEARCH_SKU)
              AND p.status = 1
            GROUP BY p.mpn
            HAVING MAX(p.price) > 0
            LIMIT :LIMIT
        ';

        $data =  Yii::$app->db->createCommand($sql)
            ->bindValues([
                'SEARCH_NAME' => "%$nameClear%",
                'SEARCH_SKU' => "%$skuClear%",
                'LANG' => LanguageHelper::getCurrentId(),
                'LIMIT' => $limit,
            ])
            ->queryAll();

        $currency = new ApiCurrency();
        $sign = $currency->getCurrencySign();

        foreach ($data as &$item) {
            $newPath = ProductHelper::correctedImgPath($item['image']);
            $item['url'] = LanguageHelper::langUrl($item['url']);
            $item['image'] = $newPath;
            $item['sign'] = $sign;

            $item['price'] = $currency->getPrice($item['price']);

            if (!empty($item['price_old'])) {
                $item['price_old'] = $currency->getPrice($item['price_old']);
            }
        }

        return $data;
    }

    public static function getAttributesGroup($asArray = false)
    {
        $group = AttributeGroup::find()
            ->where(['status' => AttributeGroup::STATUS_ACTIVE])
            ->indexBy('group_id');

        if ($asArray) {
            $group->asArray();
        }

        return $group->all();
    }

    public static function getColorByProductId(int $colorId): string
    {
        $model = Color::findOne($colorId);

        if (!$model) {
            return '';
        }

        return '/images/colors/' . $model->image;
    }

    public static function getProductVideosById($id)
    {
        $videos = ProductVideo::find()
            ->select('name, id_video, main, content')
            ->where(['product_id' => $id])
            ->asArray()
            ->all();

        $orderVideo = [];

        if ($videos) {
            foreach ($videos as $video) {
                if ($video['main'] == 1) {
                    $orderVideo['main'] = $video;
                } else {
                    $orderVideo['other'][] = $video;
                }
            }

            if (!isset($orderVideo['main'][0])) {
                $orderVideo['main'] = $videos[0];
                unset($orderVideo['other'][0]);
            }
            return $orderVideo;
        }

        return [];
    }

    public static function getCurrencyFromDb()
    {
        return Settings::find()
            ->where(['group_name' => 'currency'])
            ->indexBy('value_name')
            ->all();
    }

    public static function getGroupedSettings()
    {
        $settings = [];
        foreach (Settings::find()->all() as $row) {
            $settings[$row->group_name][] = $row;
        }
        return $settings;
    }

    public static function getSettingsByGroup(array $value)
    {
        return Settings::findAll($value);
    }

    public static function getProductMpnByProductIds($productIds)
    {
        return Product::find()
            ->select('mpn, product_id')
            ->where(['in', 'product_id', $productIds])
            ->all();
    }

    // Выборка только для каталога
    public static function productIndexByMpn($categoryId)
    {
        $catIds = CategoriesService::getParentCategoriesDownTree($categoryId);
        array_push($catIds, $categoryId);
        $ids = array_column(ProductRepository::getPoductIdsInCategory($catIds, true), 'product_id');
        $productIds = Product::find()
            ->select('mpn, product_id')
            ->where(['status' => 1])
            ->andWhere(['in', 'product_id', $ids])
            ->indexBy('mpn')
            //->orderBy('stock_status')
            ->asArray()
            ->all();

        return array_column($productIds, 'product_id', 'mpn');
    }

    // $limit и $orderBy только для $watching
    public static function getProductGroupByMpn($mpn = [], $langId = 2, $limit = false, $orderBy = false, $selectDescription)
    {
        $select = 'product.product_id, product.sort_category, product.mpn, product.status, product.image, product.color, product.color_group, product.hit, product.date_added, product.viewed,
            product.manufacturer_id, product.model, product.best_seller, product.new, product.recommend, product.sale, product.discontinued, product.stock_status,
            product.price, product.price_old, product.shares, product_description.name, url_alias.keyword, color.image as color_image, color.name as color_name';

        if ($selectDescription) {
            $select .= ',' . 'product_description.description';
        }

        $products = ProductOne::find()
            ->select($select)
            ->leftJoin('product_description', 'product.product_id=product_description.product_id')
            ->leftJoin('url_alias', 'product.product_id=url_alias.id')
            ->leftJoin('color', 'product.color=color.id')
            ->where(['product.status' => Product::STATUS_ACTIVE])
            ->andWhere(['in', 'product.mpn', $mpn])
            ->andWhere(['product_description.language_id' => $langId])
            ->andWhere(['url_alias.controller' => 'products', 'action' => 'view'])
            ->asArray();

        if ($limit) {
            $products->limit($limit);
        }

        if ($orderBy) {
            $products->orderBy($orderBy);
        }

        return $products->all();
    }

    public static function getProductSizes($products, $langId = 2)
    {
        return ProductStoreOption::find() // product_store_option.store_id,  product_store_option.quantity,
            ->select('SUM(product_store_option.quantity) as quantity_sum,
                product_store_option.product_id, product_store_option.option_id, option_description.name')

            ->leftJoin('option_description', 'product_store_option.option_id=option_description.option_id')
            ->where(['in', 'product_id', $products])
            //->andWhere('product_store_option.quantity <> 0')
            ->andWhere(['option_description.language_id' => $langId])

            ->groupBy('product_store_option.option_id')
            ->orderBy('quantity_sum DESC')

            ->asArray()
            ->all();
    }

    public static function getMpnAndIdForGroup($field)
    {
        return array_column(self::getMpnAndIdByField($field), 'product_id', 'mpn');
    }

    public static function getMpnAndIdForBrand($id)
    {
        return array_column(self::getProductIdsByBrandId($id), 'product_id', 'mpn');
    }

    public static function getProductMpnByProductIdsForViewed($productIds, $limit = 20)
    {
        return ProductOne::find()
            ->select('product_id, mpn')
            ->where(['in', 'product_id', $productIds])
            ->groupBy('mpn')
            ->asArray()
            ->limit($limit)
            ->all();
    }

    public static function getAttributesByProductArray($productMpn, $langId)
    {
        return ProductAttribute::find()
            ->select('product_attribute.product_mpn, product_attribute.attribute_id, attribute.group_id, attribute_description.name, attribute_group_description.name as group_name')
            ->distinct()
            ->leftJoin('attribute', 'product_attribute.attribute_id=attribute.attribute_id')
            ->leftJoin('attribute_description', 'product_attribute.attribute_id=attribute_description.attribute_id')
            ->leftJoin('attribute_group_description', 'attribute_group_description.group_id=attribute.group_id')
            ->where(['in', 'product_attribute.product_mpn', $productMpn])
            ->andWhere(['attribute_description.language_id' => $langId])
            ->andWhere(['attribute_group_description.language_id' => $langId])
            ->asArray()
            ->all();
    }

    public static function getPoductIdsByCategoryArray($catIds)
    {
        return ProductInCategory::find()
            ->select('product_id')
            ->distinct()
            ->where(['category_id' => $catIds])
            ->asArray()
            ->all();
    }

    public static function getSliderMain($langId)
    {
        return Slider::find()->select('slider.link, slider.image, slider_description.name,
                slider_description.button_name, slider_description.text')
            ->leftJoin('slider_description', 'slider_description.slider_id=slider.id')
            ->where(['slider.status' => Slider::STATUS_ACTIVE])
            ->andWhere(['slider_description.language_id' => $langId])
            ->asArray()
            ->all();
    }

    public static function getSeoBlock($page, $langId)
    {
        $seoBlock = Seo::find()
            ->select('seo.id, seo.type, seo.image, seo.link, seo_description.title, seo_description.description')
            ->leftJoin('seo_description', 'seo_description.seo_id=seo.id')
            ->where(['seo.on_page' => $page])
            ->andWhere(['seo_description.language_id' => $langId])
            ->asArray()
            ->one();

        $seoBlock['additionals'] = SeoAdditionalDescription::find()
            ->select('title, text')
            ->where(['seo_id' => $seoBlock['id']])
            ->andWhere(['language_id' => $langId])
            ->asArray()
            ->all();

        return $seoBlock;
    }

    public static function getColorsForProduct($mpn)
    {
        return ProductOne::find()//product.product_id,
            ->select('product.color as color_id, url_alias.keyword, url_alias.id as prod_id,
                color.code_1c, color.name, color.image')
            ->leftJoin('url_alias', 'url_alias.id=product.product_id')
            ->leftJoin('color', 'color.id=product.color')
            ->where(['status' => 1, 'mpn' => $mpn])
            ->andWhere(['url_alias.controller' => 'products', 'url_alias.action' => 'view'])
            ->asArray()
            ->all();
    }

    public static function getPhones()
    {
        return Settings::find()
            ->where(['group_name' => 'phone_sales'])
            ->asArray()
            ->all();
    }

    public static function getSettingsByGroupArr(array $value)
    {
        return Settings::find()
            ->where($value)
            ->asArray()
            ->all();
    }

    public static function getMpnAndIdForBrandCategories($brandId, $categoryId)
    {
        $products = ProductRepository::getProductIdsFromCategories($categoryId);
        $productsByBrand = ProductOne::find()
            ->select('product_id, mpn')
            ->where(['manufacturer_id' => $brandId])
            ->asArray()
            ->all();

        $brandMpn = array_column($productsByBrand, 'mpn','product_id');

        $mpnIds = [];
        foreach ($products as $product) {
            if (isset($brandMpn[$product['product_id']])) {
                if (!array_key_exists($brandMpn[$product['product_id']], $mpnIds)) {
                    $mpnIds[$brandMpn[$product['product_id']]] = $product['product_id'];
                }
            }
        }

        return $mpnIds;
    }

    public static function getPoductsInCategoryArray($productId, $langId)
    {
        return ProductInCategory::find()
            ->select('category_description.name, url_alias.keyword,product_in_category.category_id, category_path.level')
            ->leftJoin('category_description', 'category_description.category_id=product_in_category.category_id')
            ->leftJoin('url_alias', 'product_in_category.category_id=url_alias.id')
            ->leftJoin('category_path', 'category_path.category_id=product_in_category.category_id')
            ->where('category_path.category_id=category_path.parent_id')
            ->andWhere([
                'product_in_category.product_id' => $productId,
                'category_description.language_id' => $langId,
                'url_alias.controller' => 'categories', 'action' => 'view'
            ])
            // Без новинок и распродаж
            ->andWhere(['<>', 'product_in_category.category_id', '137001'])
            ->andWhere(['<>', 'product_in_category.category_id', '137004'])
            ->orderBy('category_path.level')
            ->asArray()
            ->all();
    }

    public static function getAttrGroups($productId, $langId)
    {
        $sql = "
            SELECT ad.name, agd.name as gr_name, agd.group_id, ad.attribute_id
            FROM attribute_description ad
            LEFT JOIN product_attribute pa on pa.attribute_id = ad.attribute_id
            LEFT JOIN attribute a on a.attribute_id = ad.attribute_id
            LEFT JOIN attribute_group_description agd on agd.group_id = a.group_id
            WHERE pa.product_id=$productId
              AND ad.language_id=$langId
              AND agd.language_id=$langId
        ";

        return Yii::$app->db->createCommand($sql)->queryAll();
    }
}
