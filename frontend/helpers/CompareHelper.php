<?php

namespace frontend\helpers;

use Yii;
use common\entities\Products\ProductInCategory;
use frontend\models\Compare;
use yii\web\Cookie;

class CompareHelper
{
    // Счетчик
    public function getProductCount($customerId = null)
    {
        if ($customerId) {
            $count = Compare::find()->where(['customer_id' => $customerId])->count();
            return $count != 0 ? $count : '';
        } else {
            $compareIds = Yii::$app->request->cookies->get('compareIds');
            return isset($compareIds->value) ? count($compareIds->value) : '';
        }
    }

    //Db - Удаляем все или конкретную категорию. Если не передать иди продуктов то удаляем все
    public function deleteProductsDb($customerId, $productsIds = false)
    {
        if ($productsIds) {
            Compare::deleteAll([
                'AND',
                'customer_id' => $customerId,
                ['in', 'product_id', $productsIds],
            ]);

            return ['product_ids' => $productsIds];
        } else {

            $all = array_column(Compare::findAll(['customer_id' => $customerId]), 'product_id');
            if (Compare::deleteAll(['customer_id' => $customerId])) {
                return ['product_ids' => $all];
            } else {
                return false;
            }
        }
    }

    //Cookie - Удаляем все или конкретную категорию
    public function deleteProductsCookie($productsIds = false)
    {
        $value = Yii::$app->request->cookies->get('compareIds')->value;
        if ($productsIds) {
            if (isset($value)) {
                foreach ($productsIds as $product) {
                    $key = (int)array_search($product, $value);
                    if ($key !== false) {
                        unset($value[$key]);
                    }
                }
            }
        } else {
            $productsIds = isset($value) ? array_values($value) : '';
            $value = null;
        }

        Yii::$app->response->cookies->add(new Cookie([
            'name' => 'compareIds',
            'value' => $value,
            'httpOnly' => false
        ]));

        return ['product_ids' => $productsIds];
    }

    //Db - Получаем все продукт-ид по пользователю
    public function getProductIdsFromDb($customerId)
    {
        $compare = Compare::findAll(['customer_id' => $customerId]);
        if ($compare) {
            return array_column($compare, 'product_id');
        }
        return false;
    }

    //Cookie - Получаем все продукт-ид из куков
    public function getProductIdsFromCookies()
    {
        $ids = Yii::$app->request->cookies->get('compareIds');
        if (isset($ids->value)) {
            return $ids->value;
        }
        return false;
    }

    /*
     *  Получаем собранный масив с категориями и с урл
     *  по ids продуктов
     *  возвоащает упорядоченые категории
     *  если $returnIds=true  еще вернет и все ид подуктов
     */
    public function getCompareCategories($customerId = false, $langId = 2, $returnIds = false)
    {
        if ($customerId) {
            $productIds = $this->getProductIdsFromDb($customerId);
        } else {
            $productIds = $this->getProductIdsFromCookies();
        }

        if ($productIds) {
            $productInCategory = ProductInCategory::find()
                ->select('product_in_category.product_id, category_description.name, url_alias.keyword')
                ->leftJoin('category_description', 'category_description.category_id = product_in_category.category_id')
                ->leftJoin('url_alias', 'url_alias.id = product_in_category.category_id')
                ->where(['category_description.language_id' => $langId])
                ->andWhere(['url_alias.controller' => 'categories'])
                ->andWhere(['in', 'product_in_category.product_id', $productIds])
                ->asArray()
                ->all();
        } else {
            return false;
        }

        $inCategory = [];
        foreach ($productInCategory as $product) {
            $inCategory[$product['product_id']][$product['keyword']] = [
                'name' => $product['name'],
                'keyword' => $product['keyword']
            ];
        }

        $categoryList = [];
        foreach ($inCategory as $key =>  $category) {
            $lastElement = end($category);
            $categoryList[$lastElement['keyword']]['name'] = $lastElement['name'];
            $categoryList[$lastElement['keyword']]['productIds'][] = $key;
        }

        return [
            'categories' => $categoryList,
            'ids' => $returnIds ? $productIds : null
        ];
    }

    //Db - Если есть продукт в сравнении то удаляем иначе добавляем
    public function toggleProductDb($productId)
    {
        $customerId = Yii::$app->user->id;
        $compare = Compare::findOne([
            'product_id' => $productId,
            'customer_id' => $customerId
        ]);

        if (!$compare) {
            $compare = new Compare();
            $compare->customer_id = $customerId;
            $compare->product_id = $productId;
            if ($compare->save()) {
                return true;
            }
        } else {
            $compare->delete();
            return false;
        }
    }

    //Cookie - Если есть продукт в сравнении то удаляем иначе добавляем
    public function toggleProductCookie($productId)
    {
        $cookies = Yii::$app->request->cookies;

        if (!$cookies->has('compareIds')) {
            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'compareIds',
                'value' => [$productId],
                'httpOnly' => false
            ]));

            return true;
        } else {
            $compareIds = Yii::$app->request->cookies->get('compareIds');
            $value = $compareIds->value;

            $key = array_search($productId, $value);
            if ($key !== false) {
                unset($value[$key]);
                $result = false;
            } else {
                $value[] = $productId;
                $result = true;
            }

            Yii::$app->response->cookies->add(new Cookie([
                'name' => 'compareIds',
                'value' => $value,
                'httpOnly' => false
            ]));

            return $result;
        }
    }

    //Cookie - проверяем есть ли id в куках
    public static function checkCookiesInProductId($productId)
    {
        $compareIds = Yii::$app->request->cookies->get('compareIds');

        if (isset($compareIds->value)) {
            $key = array_search($productId, $compareIds->value);
            if ($key !== false) {
                return true;
            }
        }

        return false;
    }
}
