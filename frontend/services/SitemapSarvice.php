<?php

namespace frontend\services;

use common\entities\Brands\Brand;
use common\entities\Categories\Category;
use common\helpers\ProductHelper;
use Yii;
use backend\entities\Order\Product;
use common\entities\Categories\CategoryPath;
use common\entities\UrlAlias;
use yii\web\Response;

class SitemapSarvice
{
    public static function showXml($xmlData)
    {
        Yii::$app->response->format = Response::FORMAT_XML;
        Yii::$app->response->isSent = true;
        header('Content-type: text/xml');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . $xmlData;
    }

    public static function getHomeSection($url)
    {
        return '<url><loc>' . $url . '</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>';
    }

    public static function formatLastmod($lastmod)
    {
        return date('c', strtotime($lastmod));
    }

    public static function getLastmodAndPriority($alias)
    {
        if ($alias['controller'] == 'products' && $alias['action'] == 'view') {
            $product = Product::find()->select('date_modified')->where(['product_id' => $alias['id']])->asArray()->one();

            $data = '<lastmod>' . self::formatLastmod($product['date_modified']) . '</lastmod>';
            $data .= '<priority>0.7</priority>';

            return $data;

        } elseif ($alias['controller'] == 'categories' && $alias['action'] == 'view') {
            $level = CategoryPath::find()->select('level')->where(['category_id' => $alias['id'], 'parent_id' => $alias['id']])->asArray()->one();
            $category = Category::find()->select('date_modified')->where(['category_id' => $alias['id']])->asArray()->one();

            if ($level) {
                $data = '<lastmod>' . self::formatLastmod($category['date_modified']) . '</lastmod>';

                if ($level['level'] == 0) {
                    $data .= '<priority>0.9</priority>';
                    return $data;
                } else {
                    $data .= '<priority>0.8</priority>';
                    return $data;
                }
            }
        } elseif ($alias['controller'] == 'brands' && $alias['action'] == 'view') {
            $brand = Brand::find()->select('date_modified')->where(['brand_id' => $alias['id']])->asArray()->one();
            $data = '<lastmod>' . self::formatLastmod($brand['date_modified']) . '</lastmod>';
            $data .= '<priority>0.9</priority>';
            return $data;
        } else {
            return '<priority>0.7</priority>';
        }
    }

    public static function getOterDataForSitemap($url)
    {
        $data = '';
        $alias = UrlAlias::find()->asArray()->all();

        foreach ($alias as $value) {
            $data .= '<url>';
            $data .= '<loc>';
            $data .= $url . '/' . trim($value['keyword']);
            $data .= '</loc>';
            $data .= '<changefreq>weekly</changefreq>';
            $data .= self::getLastmodAndPriority($value);
            $data .= '</url>';
        }

        return $data;
    }

    public static function getImagesFromProducts($url)
    {
        $data = '';
        $alias = UrlAlias::find()
            ->select('keyword, id')
            ->where(['controller' => 'products', 'action' => 'view'])
            ->all();

        foreach ($alias as $value) {
            $data .= '<url>';
            $data .= '<loc>';
            $data .= $url . '/' . trim($value['keyword']);
            $data .= '</loc>';

            $data .= '<image:image><image:loc>' . ProductHelper::correctedImgPath_500p($value->sitemapProduct['image']) . '</image:loc></image:image>';

            if (isset($value->sitemapProductImages[0])) {
                foreach ($value->sitemapProductImages as $image) {
                    $data .= '<image:image><image:loc>' . ProductHelper::correctedImgPath_500p($image['image']) . '</image:loc></image:image>';
                }
            }
            $data .= '</url>';
        }

        return $data;
    }
}