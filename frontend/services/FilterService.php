<?php

namespace frontend\services;

use common\helpers\LanguageHelper;
use Yii;
use common\entities\Products\Product;
use common\entities\Products\ProductAttribute;
use frontend\components\ApiCurrency;
use frontend\repositories\ProductRepository;

class FilterService
{
    const FILTRS = ['price_max', 'color_group', 'colors', 'brands', 'attributes'];

    public static function prepareFilterData($data)
    {
        $group = [];
        foreach ($data as $attribute) {
            if (isset($attribute['group_name']) && !isset($group[$attribute['group_id']]['group_name'])) {
                $group[$attribute['group_id']]['group_name'] = trim($attribute['group_name']);
            }

            $group[$attribute['group_id']]['attributes'][$attribute['attribute_id']] = trim($attribute['name']);
        }

        return $group;
    }

    private static function renderFilter($key, $get, $filtersData, $obj)
    {
        return $obj->renderAjax('/parts/filters/_' . $key, ['filtersData' => $filtersData, 'get' => $get]);
    }

    public static function renderFilters($get, $filtersData, $obj)
    {
        $renderData = [];
        foreach ($filtersData as $key => $value) {
            if ($key == 'minPrice' || $key == 'minPriceVal' || $key == 'maxPriceVal' || $key == 'lowPrice' || $key == 'colors') {
                continue;
            } elseif ($key == 'maxPrice') {
                if ($filtersData['minPrice'] != $filtersData['maxPrice']) {
                    $renderData['price'] = self::renderFilter('price', $get, $filtersData, $obj);
                }
            } else {
                $renderData[$key] = self::renderFilter($key, $get, $filtersData, $obj);
            }
        }

        return $renderData;
    }

    public static function checkAndBuildFilterData($filtersData, $intersect, $get)
    {
        $getKey = array_key_first($intersect);
        $filtersAll = json_decode(Yii::$app->session->get('filters'), true);

        if ($getKey == 'attributes') {
            $attrs = explode(',', $get['attributes']);

            $attrGroup = [];
            foreach ($filtersAll['attributes'] as $key => $val) {
                foreach ($val['attributes'] as $attrId => $name) {
                    if (in_array($attrId, $attrs)) {
                        $attrGroup[$key][] = $attrId;
                    }
                }
            }

            if (count($attrGroup) == 1) {
                $keyGroup = array_key_first($attrGroup);
                $filtersData['attributes'][$keyGroup] = $filtersAll['attributes'][$keyGroup];
            }
        } elseif ($getKey == 'price_max') {
            if (isset($get['price_min_val'])) {
                $filtersData['minPriceVal'] = (int)$get['price_min_val'];
            } else {
                $filtersData['minPriceVal'] = (int)$filtersAll['minPrice'];
            }
            if (isset($get['price_max_val'])) {
                $filtersData['maxPriceVal'] = (int)$get['price_max_val'];
            }

            $filtersData['minPrice'] = (int)$get['price_min'];
            $filtersData['maxPrice'] = (int)$get['price_max'];
        } else {
            $filtersData[$getKey] = $filtersAll[$getKey];
        }

        return $filtersData;
    }

    public static function getLeftFilterDataByParams($ids, $get)
    {
        if (isset($get['attributes']) && !empty($get['attributes'])) {
            $attributeIds = explode(',', $get['attributes']);

            if (AttributeService::checkAttrGroup($attributeIds)) {
                $productIds = AttributeService::getDiffData($ids, $attributeIds);
            } else {

                $productIds = array_flip(array_intersect(
                    array_flip($ids),
                    array_column(ProductRepository::getProductsMpnByAttributes($attributeIds, true), 'product_mpn')
                ));
            }

        } else {
            $productIds = $ids;
        }

        $query = Product::find()
            ->where(['in', 'product_id', $productIds])
            ->andWhere(['product.status' => 1]);

        if (isset($get['color_group']) && !empty($get['color_group'])) {
            $colorGroup = explode(',', $get['color_group']);
            $query->andFilterWhere(['in', 'product.color_group', $colorGroup]);
        }

        if (isset($get['colors']) && !empty($get['colors'])) {
            $colors = explode(',', $get['colors']);
            $query->andFilterWhere(['in', 'product.color', $colors]);
        }

        if (isset($get['brands']) && !empty($get['brands'])) {
            $brands = explode(',', $get['brands']);
            $query->andFilterWhere(['in', 'product.manufacturer_id', $brands]);
        }

        if (isset($get['price_min']) && isset($get['price_max'])) {
            $currency = new ApiCurrency();
            $query->andFilterWhere(['and',
                ['>=', 'price', (int)$currency->getCurrencyMultiply($get['price_min'])],
                ['<=', 'price', (int)$currency->getCurrencyMultiply($get['price_max'])],
            ]);
        }

        return $query;
    }

    public static function getAttributeById($attributeId)
    {
        return ProductAttribute::findOne(['attribute_id' => $attributeId]);
    }

    public static function buildGetParams($get)
    {
        $getNames = [];
        foreach ($get as $key => $val) {
            if (in_array($key, self::FILTRS)) {
                if ($key == 'attributes') {
                    $attributeIds = explode(',', $get['attributes']);
                    // Группы атрибутов по порядку
                    $positionGr = [];
                    // Отсортированные группы  с гетами аттр
                    $attrGroupWithId = [];

                    foreach ($attributeIds as $position => $id) {
                        $attr = self::getAttributeById($id);
                        if (!in_array($attr->group['group_id'], $positionGr)) {
                            $positionGr[] = $attr->group['group_id'];
                        }
                        $attrGroupWithId[$attr->group['group_id']] [] = $attr->group['attribute_id'];
                    }

                    foreach ($positionGr as $element) {
                        $getNames[] = [
                            'name' => 'attr_group_' . $element,
                            'get' => ['attributes' => implode($attrGroupWithId[$element], ',')]
                        ];
                    }
                } elseif ($key == 'price_max') {
                    $getNames[] = [
                        'name' => 'price_max',
                        'get' => [
                            'price_min' => (int)$get['price_min'],
                            'price_max' => (int)$get['price_max'],
                            'price_min_val' => (int)isset($get['price_min_val']) ? $get['price_min_val'] : $get['price_min'],
                            'maxPriceVal' => (int)$get['price_max_val']
                        ]
                    ];
                } else {
                    $getNames[] = [
                        'name' => $key,
                        'get' => [$key => $val]
                    ];
                }
            }
        }
        //dd($getNames);
        return [
            'data' => $getNames
        ];
    }

    public static function setDataFilter($name, $getParams, $filtersAll, $get)
    {
        if ($name == 'price_max') {
            $filtersData['minPrice'] = (int)$get['price_min'];
            $filtersData['maxPrice'] = (int)$get['price_max'];

        } else {
            $filtersData[$name] = $filtersAll[$name];
        }

        return $filtersData;
    }

    public static function groupColors($colors) {
        $group = [];
        foreach ($colors as $color) {
            $group[$color['color_group']][$color['color']] = $color['color'];
        }

        return $group;
    }

    public static function getProductsFilterData($query)
    {
        $langId = LanguageHelper::getCurrentId();
        $filtersData = [];
        $cloneQuery = clone $query;
        $cloneBrand = clone $query;

        $filtersData['minPrice'] = $query->min('price');
        $filtersData['maxPrice'] = $query->max('price');
        $filtersData['lowPrice'] = $query->andWhere(['>', 'price', 0])->andWhere(['=', 'stock_status', 1])->min('price');
        $filtersData['color_group'] = array_column($cloneQuery->select('color_group')->distinct()->asArray()->all(), 'color_group');
         sort($filtersData['color_group'] );
        $filtersData['colors'] = self::groupColors($cloneQuery->select('color, color_group')->asArray()->all());//->groupby('color')
        //unset($filtersData['colors'][0]);
        // Убираем color_group = 0
        //unset($filtersData['color_group'][0]);

        $filtersData['brands'] = $cloneBrand->select('manufacturer_id')->distinct()->with('brandName')->asArray()->all();

        $productMpn = array_column($cloneQuery->select('mpn')->distinct()->all(), 'mpn');

        $attributeData = ProductRepository::getAttributesByProductArray($productMpn, $langId);
        $filtersData['attributes'] = FilterService::prepareFilterData($attributeData);

        return $filtersData;
    }

    public static function getFistFilter($getNames, $get, $filtersData, $mpnIds)
    {
        foreach ($getNames as $key => $name) {

            if ($key == 0) {
                if ($name['name'] == 'price_max') {

                    $filtersData['minPrice'] = $get['price_min'];
                    $filtersData['maxPrice'] = $get['price_max'];
                    if (isset($get['price_min_val']) && isset($get['price_max_val'])) {
                        $filtersData['minPriceVal'] = $get['price_min_val'];
                        $filtersData['maxPriceVal'] = $get['price_max_val'];
                    }
                } else {
                    $first = FilterService::getLeftFilterDataByParams($mpnIds, []);
                    $filtersAll = self::getProductsFilterData($first);

                    //dd($name['name']);
                    if (substr($name['name'], 0, 11) == 'attr_group_') {
                        $n = str_replace('attr_group_', '', $name['name']);

                        $filtersData['attributes'][$n] = $filtersAll['attributes'][$n];
                    } elseif ($name['name'] == 'color_group' || $name['name'] == 'colors') {
                        //dd($name['name']);
                        $filtersData['color_group'] = $filtersAll['color_group'];
                        $filtersData['colors'] = $filtersAll['colors'];
                        //dd($filtersData['colors']);
                    } else {
                        $filtersData[$name['name']] = $filtersAll[$name['name']];
                    }
                }
            }
        }

        return $filtersData;
    }

    public static function countGetParams($key, $getNames)
    {
        $getParams = [];
        foreach ($getNames as $k => $get) {
            if ($k == $key) {
                break;
            }
            $getParams = array_merge($getParams, $getNames[$k]['get']);
        }

        return $getParams;
    }

    public static function getOtherFilters($getNames, $get, $filtersData, $mpnIds)
    {
        $isColor = false;
        foreach ($getNames as $key => $data) {
            if ($key == 0) {
                continue;
            }

            if ($data['name'] == 'price_max') {
                $filtersData['minPrice'] = $get['price_min'];
                $filtersData['maxPrice'] = $get['price_max'];
                $filtersData['minPriceVal'] = $get['price_min_val'];
                $filtersData['maxPriceVal'] = $get['price_max_val'];
            } else {
                $objData = FilterService::getLeftFilterDataByParams($mpnIds, self::countGetParams($key, $getNames));
                $filters = self::getProductsFilterData($objData);

                if (substr($data['name'], 0, 11) == 'attr_group_') {
                    $n = str_replace('attr_group_', '', $data['name']);
                    if (isset($filtersData['attributes'][$n]) && isset($filters['attributes'][$n])) {
                        $filtersData['attributes'][$n] = $filters['attributes'][$n];
                    }
                } else {
                    if($data['name'] == 'color_group') {
                        if(!$isColor && $getNames[0]['name'] != 'color_group' && $getNames[0]['name'] != 'colors') {
                            $filtersData['color_group'] = $filters['color_group'];
                            $filtersData['colors'] = $filters['colors'];
                            $isColor = true;
                        }
                    } elseif($data['name'] == 'colors') {
                        if(!$isColor && $getNames[0]['name'] != 'color_group' && $getNames[0]['name'] != 'colors') {
                            $filtersData['colors'] = $filters['colors'];
                            $filtersData['color_group'] = $filters['color_group'];
                            $isColor = true;
                        }
                    } else {
                        $filtersData[$data['name']] = $filters[$data['name']];
                    }
                }
            }
        }

        return $filtersData;
    }
}