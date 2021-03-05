<?php


namespace frontend\services;


use common\entities\Attributes\Attribute;
use frontend\repositories\ProductRepository;

class AttributeService
{
    public static function checkAttrGroup($attributeIds)
    {
        $group = Attribute::find()->select('group_id')->distinct()->where(['in', 'attribute_id', $attributeIds])->asArray()->all();
        return (count(array_column($group, 'group_id')) > 1) ? true : false;
    }

    public static function getDiffData($ids, $attributeIds)
    {
        $productIds = [];
        $attrGroup = [];
        foreach (ProductRepository::getProductsMpnByAttributes($attributeIds) as $attr) {
            $attrGroup[$attr->group['group_id']][] = $attr->product_mpn;
        }

        foreach (array_unique(call_user_func_array("array_intersect", $attrGroup)) as $val) {
            if(isset($ids[$val])) {
                $productIds[$val] = $ids[$val];
            }
        }

        return $productIds;
    }
}