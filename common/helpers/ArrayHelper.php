<?php
namespace common\helpers;

class ArrayHelper
{
	
	public static function getArrayByKey($array, $key)
   	 {
        $items = [];
        foreach ($array as $item) {
            if(isset($item->{$key}))
                $items[] = $item->{$key};
            else
                break;
        }
        return $items;
    }
	public static function getByKey($array, $key)
   	 {
        $items = [];
        foreach ($array as $item) {
            if(isset($item[$key]))
                $items[] = $item[$key];
            else
                break;
        }
        return $items;
    }



    public static function getMaxValue($array)
    {

        $k = false;
        $resultKey = null;

        foreach($array as $key=>$item){
            if(!$k){
                $k=$item['percent'];
                $resultKey = $key;
            }
            if(isset($item['percent']) && $k<$item['percent']){
                $k=$item['percent'];
                $resultKey = $key;
            }
        }



        if(!isset($array[$resultKey])){
            return null;
        }

        return $array[$resultKey];

    }

    public static function getMaxIndex($items)
    {
        $keys = array_keys($items);
        return max($keys);
    }

    public static function getLastItem(array $items)
    {
        return array_pop($items);
    }

    public static function merge($array1, $array2)
    {
        return \yii\helpers\ArrayHelper::merge($array1, $array2);
    }


    public static function getFieldFromArray($array, $nameField)
    {
        $result = [];

        foreach ($array as $item) {
            $result[] = $item[$nameField];
        }

        return $result;
    }

    public static function removeEmptyItems(array $data)
    {
        return array_filter($data, function($element) {
            return !empty($element);
        });
    }

    //public static function
}
