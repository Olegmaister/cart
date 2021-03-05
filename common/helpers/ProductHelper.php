<?php

namespace common\helpers;

use common\entities\Products\Product;
use common\entities\Products\ProductStoreOption;
use common\entities\Settings\Settings;
use frontend\models\Compare;
use frontend\models\WishList;
use frontend\repositories\ProductRepository;
use Yii;
use yii\helpers\Html;
use yii\web\Response;

class ProductHelper
{
    public static function getImageColor($str)
    {
        $template = '000000000';
        $link = '/images/colors/';
        $link .= substr($template, strlen($str)) . $str . '.jpg';

        return $link;
    }

    public static function getImageColorLink($str, $relationLink)
    {
        $template = '000000000';
        $link = 'https://prof1group.ua/image/color/';
        $link .= substr($template, strlen($str)) . $str . '.jpg';

        return "<a href=\"{$relationLink}\">
                    <img loading=\"lazy\" src=\"{$link}\" style=\"width:50px; display: inline-table; margin: 10px;\">
                 </a>";
    }

    public static function resizeImage($image)
    {
        return str_replace('.jpg', '-500x500.jpg', $image);
    }

    public static function getIndexColumn($array = [], $index, $name = null, $indexByIds = null)
    {
        $items = [];
        foreach ($array as $item) {
            if ($indexByIds) {
                $items[$item->$index][$item->product_id] = ($name != null) ? $item->$name : $item;
            } else {
                $items[$item->$index][] = ($name != null) ? $item->$name : $item;
            }
        }

        return $items;
    }

    public static function getAverage($array)
    {
        if (isset($array[0]['rating'])) {
            return round(array_sum(array_column($array, 'rating')) / count($array));
        } elseif (isset($array['rating'])) {
            return $array['rating'];
        }
        return 0;
    }

    public static function getRatingStars($array)
    {
        $rating = (int)self::getAverage($array);
        $blockStars = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $rating) {
                $blockStars .= '<div class="rating__item rating__item--active"></div>';
            } else {
                $blockStars .= '<div class="rating__item"></div>';
            }
        }
        return $blockStars;
    }

    public static function getGroup($product)
    {
        $group = null;
        if ($product->new == 1) {
            $group = 'new';
        } elseif ($product->hit == 1) {
            $group = 'hit';
        } elseif ($product->recommend == 1) {
            $group = 'recommend';
        } elseif ($product->discontinued == 1) {
            $group = 'discontinued';
        }

        return $group;
    }

    public static function correctedImgPath($image)
    {
        if (empty($image)) {
            return '/images/no-image.png';
        }

        //'https://dev.p1gtac.com/images/products/';
        $host = Yii::$app->params['homeUrl'] . '/images/products/';

        return $host . str_replace('.', '-228x228.', $image);
    }

    public static function correctedImgPath_228p($image)
    {
        if (empty($image)) {
            return '/images/no-image.png';
        }

        //'https://dev.p1gtac.com/images/products/';
        $host = Yii::$app->params['homeUrl'] . '/images/products/';

        return $host . str_replace('.', '-228x228.', $image);
    }

    public static function correctedImgPath_500p($image)
    {
        if (empty($image)) {
            return '/images/no-image.png';
        }

        //'https://dev.p1gtac.com/images/products/';
        $host = Yii::$app->params['homeUrl'] . '/images/products/';

        return $host . str_replace('.', '-500x500.', $image);
    }

    public static function checkGetParams($get)
    {
        unset($get['id']);
        unset($get['brandId']);
        unset($get['categoryId']);
        if (count($get) > 0) {
            return true;
        }

        return false;
    }

    public static function isSort($get)
    {
        return isset($get['sort']) ? '' : ' active';
    }

    public static function getUrlSortClass($get, $sort = null)
    {
        if (!isset($get['sort'])) {
            return '';
        } elseif ($sort == 'price' && $get['sort'] == 'price') {
            return ' active _up';
        } elseif ($sort == 'price' && $get['sort'] == '-price') {
            return ' active _down';
        } elseif ($get['sort'] == $sort) {
            return ' active';
        }
    }

    public static function checkLinkActive($link)
    {
        return (strpos(Yii::$app->request->url, '/' . $link) !== false) ? 'active' : '';
    }

    public static function getSizesJsonArr($sizes)
    {
        if(is_array($sizes)) {
            return json_encode(array_values($sizes));
        }

        return '';
    }

    public static function getSizesJson($sizes)
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
        $array = [];
        foreach ($sizes as $value) {
            $array[] = [
                'option_id' => $value['option_id'],
                'name' => $value['name'],
                //'quantity' => $value['quantity'],
            ];
        }

        return json_encode($array);
    }

    //временный метод, не удалять
    public static function getSizesJson2($sizes)
    {
        $array = [];
        foreach ($sizes as $value) {
            $array[] = [
                'option_id' => $value['option_id'],
                'name' => $value['name']
            ];
        }
        if(is_array($sizes)) {
            return json_encode(array_values($sizes));
        }

            $return  = json_encode(array_values($array));
        return $return;
    }

    public static function mbUcfirst($string)
    {
        return mb_strtoupper(mb_substr($string, 0, 1)) . mb_strtolower(mb_substr($string, 1));
    }

    public static function checkGroupProduct($product, $returnJson = false, $flagDiscount = null)
    {
        $group = [];

        if ($product->stock_status) {
            if ($product->hit) {
                $group[] = 'hit';
            }
            if ($product->new) {
                $group[] = 'new';
            }
            if ($product->recommend) {
                $group[] = 'recommend';
            }
            if ($product->sale) {
                $group[] = 'sale';
            }
            if ($product->shares == 1 && !$product->inSale()) {
                $group[] = 'stock_shares';
            }
        } else {
            $group[] = 'not_available';
        }

        if (count($group) > 0) {
            $html = '';
            $groupArr = [];

            foreach ($group as $element) {
                $groupArr[] = [
                    'label' => $element,
                    'name' => Yii::t('app', $element)
                ];

                $html .= '<span class="product-card__label background_' . $element . '">';
                $html .= Yii::t('app', $element);
                $html .= '</span>';
            }

            if ($returnJson) {
                //return json_encode( htmlentities($html) );
                return json_encode($groupArr);
            }

            return $html;
        }

        return '';
    }

    public static function checkGroupProductArr($product, $returnJson = false, $flagDiscount = null)
    {
        $group = [];

        if ($product['stock_status']) {
            if ($product['hit']) {
                $group[] = 'hit';
            }
            if ($product['new']) {
                $group[] = 'new';
            }
            if ($product['recommend']) {
                $group[] = 'recommend';
            }
            if ($product['sale']) {
                $group[] = 'sale';
            }
            if ($product['shares'] == 1 && !$product['sale'] == 1) {
                $group[] = 'stock_shares';
            }
        } else {
            $group[] = 'not_available';
        }

        if (count($group) > 0) {
            $html = '';
            $groupArr = [];

            foreach ($group as $element) {
                $groupArr[] = [
                    'label' => $element,
                    'name' => Yii::t('app', $element)
                ];

                $html .= '<span class="product-card__label background_' . $element . '">';
                $html .= Yii::t('app', $element);
                $html .= '</span>';
            }

            if ($returnJson) {
                //return json_encode( htmlentities($html) );
                return json_encode($groupArr);
            }

            return $html;
        }

        return '';
    }

    public static function splitText($text)
    {
        $textSplit = explode("\n", $text);
        $newText = [];
        foreach ($textSplit as $split) {
            $newText[] = "<span><span>{$split}</span></span>";
        }

        return implode($newText);
    }

    public static function getClearPoductsInCategory($id)
    {
        $categories = ProductRepository::getPoductsInCategory($id);
        $clearCategories = [];
        $categoryId = [];

        foreach ($categories as $category) {
            // Новинки и Распродажа
            if (

                $category->category_id != 137004 &&
                $category->category_id != 137001 &&
                isset($category->description->category_id) &&
                !in_array($category->description->category_id, $categoryId)
            ) {
                //d($category->category_id);
                $clearCategories[] = $category;
                $categoryId[] = $category->description->category_id;
            }
        }

        return $clearCategories;
    }

    public static function wrapToList($settings, $class = false)
    {
        $settingsSplit = explode("\n", $settings);
        $wrapped = '';
        foreach ($settingsSplit as $settings) {
            $wrapped .= "<li class=\"{($class) ? $class : ''}\">
                {$settings}</li>";
        }

        return $wrapped;
    }

    public static function getProductsForViewed($productIds, $productsRaw)
    {
        $products = array_flip(array_reverse($productIds));
        foreach ($productsRaw as $product) {
            $products[$product->product_id] = $product;
        }

        return $products;
    }

    public static function getProductsForViewedIndex($productIds, $productsRaw)
    {
        $products = array_flip($productIds);
        foreach ($productsRaw as $product) {
            $products[$product->product_id] = $product->mpn;
        }

        return $products;
    }

    public static function rebuildProducts($products, $id)
    {
        $newArray[$id] = $products[$id];
        foreach ($products as $key => $product) {
            if ($key != $id) {
                $newArray[$key] = $product;
            }
        }

        return $newArray;
    }

    public static function rebuildMpnProductGroup($products, $condition = false, $mpn = false)
    {
        $newArray = [];
        if ($mpn) {
            $newMpn = array_map(function ($a) {
                return '';
            }, $mpn);
        } else {
            $newMpn = [];
        }

        foreach ($products as $product) {
            if (!isset($newMpn[$product['mpn']]) || empty($newMpn[$product['mpn']])) {
                if ($condition) {
                    if ($product[$condition['key']] == $condition['value']) {
                        $newMpn[$product['mpn']] = $product['product_id'];
                    }
                } else {
                    $newMpn[$product['mpn']] = $product['product_id'];
                }
            } else {
                if ($condition) {
                    if ($product[$condition['key']] == $condition['value'] && $product['stock_status'] == 1) {
                        //dd($condition['key']);
                        $newMpn[$product['mpn']] = $product['product_id'];
                    }
                } else {
                    $newMpn[$product['mpn']] = $product['product_id'];
                }
            }

            $newArray[$product['mpn']][$product['product_id']] = $product;
        }

        return [
            'mpn' => array_flip($newMpn),
            'relate' => $newArray
        ];
    }

    public static function getSplitImages($id)
    {
        $images = [];
        $allImages = ProductRepository::getImagesByProductId($id);
        if (!$allImages) {
            return $images;
        }

        foreach ($allImages as $image) {
            if ($image['additional'] == 1) {
                $images['additional'][] = $image['image'];
            } else {
                $images['main'][] = $image['image'];
            }
        }

        return $images;
    }

    public static function checkCanonical($context)
    {
        $get = Yii::$app->request->get();
        unset($get['id']);

        if ($context->id == 'search' && $context->action->id == 'index') {
            return '<link rel="canonical" href="'.Yii::$app->request->hostInfo.' />"';
        } elseif (count($get)) {
            $head = '<link rel="canonical" href="'.Yii::$app->request->hostInfo.'/'.Yii::$app->request->pathInfo.'" />';
            $head .= "\n" . '<link name="robots" content="noindex, follow" />';

            return $head;
        }
    }


    /*======stock========*/
    public static function stockList(): array
    {
        return [
            Product::NOT_IN_STOCK => 'нет',
            Product::IN_STOCK => 'да',
        ];
    }

    public static function stockLabel($stock): string
    {
        switch ($stock) {
            case Product::NOT_IN_STOCK:
                $class = 'label label-default';
                break;
            case Product::IN_STOCK:
                $class = 'label label-success';
                break;
        }

        return Html::tag('span', \yii\helpers\ArrayHelper::getValue(self::stockList(), $stock), [
            'class' => $class,
        ]);
    }

    public static function clearPhone($phone)
    {
        return str_replace([' ', '-', '(', ')'], ['', '', '', ''], $phone);
    }

    public static function clearQuotes($text)
    {
        return str_replace(['"', '“', '”'], '', $text);
    }

    public static function checkRelFollow($link)
    {
        if(strpos($link, 'dev.p1gtac.com') !== false || strpos($link, 'prof1group.ua') !== false) {
            return '';
        }

        return 'rel="nofollow" ';
    }

    public static function getVideoTagsByUrl($content, $limit)
    {
        $tags = [];
        preg_match('`src="(.*?)"`', $content, $url);
        if(isset($url[1]) && !empty($url[1])) {
            $video = file_get_contents($url[1]);
            preg_match_all('`"query":"(.*?)"`', $video, $tagsArr);

            if (isset($tagsArr[1][0]) && !empty($tagsArr[1][0])) {
                foreach ($tagsArr[1] as $key => $tag) {
                    if ($key == $limit) {
                        break;
                    }
                    $tags[] = [
                        'name' => $tag,
                        'link' => 'https://www.youtube.com/results?search_query=' . str_replace('#', '%23', $tag)
                    ];
                }
                return $tags;
            }
        }

        return false;
    }

    public static function getTextForErrorPage()
    {
        $settings = Settings::find()->where(['group_name' => 'text404'])->orWhere(['group_name' => 'prom_code'])->asArray()->all();
        if($settings) {
            $langId = LanguageHelper::getCurrentId();
            $text = [];
            foreach ($settings as $setting) {
                if($setting['group_name'] == 'prom_code') {
                    $text['prom_code'] = $setting['value'];
                }

                if($setting['group_name'] == 'text404' && $setting['language_id'] == $langId) {
                    $text['text404'] = $setting['value'];
                }
            }
            return $text;
        }

        return [];
    }

    // К выборке продуктов еще добавляем Размеры
    // compare и wish-list НЕ добавляем в выборку
    public static function getProductWithSize($productIds, $langId = 2, $limit = false, $orderBy = false, $queryRelate = false)
    {
        //$langId = LanguageHelper::getCurrentId();
        $queryRelate = ProductRepository::getProductGroupByMpn(array_flip($productIds), $langId, $limit, $orderBy, $queryRelate);
        $sizes = ProductRepository::getProductSizes(array_column($queryRelate, 'product_id'), $langId);

        /*
            // Добавить (compare и wish-list)
            if($userId = Yii::$app->user->id) {
                $queryCompare = Compare::find()->select('product_id')->where(['customer_id' => $userId])->asArray()->all();
                if($queryCompare) {
                    $compare = array_column($queryCompare, 'product_id');
                }

                $queryWishList = WishList::find()->select('product_id')->where(['customer_id' => $userId])->asArray()->all();
                if($queryWishList) {
                    $wishList = array_column($queryWishList, 'product_id');
                }
            } else {
                $compareIds = Yii::$app->request->cookies->get('compareIds');
                if (isset($compareIds->value)) {
                    $compare = $compareIds->value;
                }
            }
        */


        $indexSizes = [];
        foreach ($sizes as $size) {
            $indexSizes[$size['product_id']][$size['option_id']] = [
                'option_id' => $size['option_id'],
                'name' => $size['name'],
                'quantity' => $size['quantity_sum']
            ];
        }

        $products = [];
        foreach ($queryRelate as $key => $product) {
            $products[$key] = $product;
            $products[$key]['sizes'] = isset($indexSizes[$product['product_id']]) ? array_values($indexSizes[$product['product_id']]) : '';

            /*
                // Добавить (compare и wish-list)
                if (isset($compare) && in_array($product['product_id'], $compare)) {
                    $products[$key]['compare'] = true;
                }

                if (isset($wishList) && in_array($product['product_id'], $wishList)) {
                    $products[$key]['favorite'] = true;
                }
            */
        }
        //dd($products);
        return $products;
    }

    public static function getProductSizes($products, $langId = 2)
    {
        return ProductStoreOption::find()
            ->select('product_store_option.product_id, product_store_option.store_id, product_store_option.option_id, product_store_option.quantity, option_description.name')
            ->leftJoin('option_description', 'product_store_option.option_id=option_description.option_id')
            ->where(['in', 'product_id', $products])
            ->andWhere(['option_description.language_id' => $langId])
            ->asArray()
            ->all();
    }

    // Собираем все атрибуты с  [group_id] => 2 (Сезоны года)
    public static function getUrlParams($product)
    {
        if(isset($product->attrGroups[0])) {
            $params = [];
            foreach ($product->attrGroups as $attr) {
                if($attr['group_id'] == 2) {
                    $params[] = $attr['attribute_id'];
                }
            }

            if(isset($params[0])) {
                return '?attributes=' . implode(',', $params);
            }
        }

        return '';
    }

    public static function translateWord($word, $langId)
    {
        if ($word == 'единый') {
            $words = [
                1 => 'single',
                2 => 'единый',
                3 => 'єдиний'
            ];

            return isset($words[$langId]) ? $words[$langId] : $word;
        }

        return $word;
    }
}