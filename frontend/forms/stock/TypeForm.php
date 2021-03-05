<?php
namespace frontend\forms\stock;

use Yii;
use yii\base\Model;

class TypeForm extends Model
{

    public $sort;

    public function getListType()
    {
        return[
            '' => Yii::t('app', 'All stocks'),
			'product' => Yii::t('app', 'Products'),
            'brand' => Yii::t('app', 'Brands'),
            'category' => Yii::t('app', 'Categories'),
            'present' => Yii::t('app', 'Goods as a gift'),
        ];
    }
}


