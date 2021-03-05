<?php
namespace api\forms\stock;

use api\behaviors\LoadFormBehavior;
use backend\forms\Stocks\SegmentForm;
use common\entities\Customer\Segment;
use common\entities\Stock\Stock;
use common\forms\CompositeForm;
use yii\base\Model;

class EditForm extends CompositeForm
{

    public $api;
    public $type;
    public $method;
    public $percent;
    public $money;
    public $active;
    public $slider;
    public $date_from;
    public $date_to;
    public $data;
    public $description;

    public function __construct($config = [])
    {
        $this->segment = array_map(function (Segment $segment) {
            return new SegmentForm($segment);
        }, Segment::find()->where(['opt' => Segment::STATUS_OPT])->all());
        parent::__construct($config);
        parent::__construct($config);
    }


    public function behaviors()
    {
        return [
            LoadFormBehavior::class
        ];
    }

    public function rules()
    {
        return [
            [['api','type','method','data'],'required'],
            ['type', 'typeChecking'],
            [['descriptions'],'safe'],

        ];
    }

    public function typeChecking($attribute, $params) {
        if(!in_array($this->type,$this->getListType())){
            $this->addError($attribute, "Не допустимый тип {$this->type} допустимые: brand, category, product");
        }
    }

    public function getDescription()
    {
        return $this->description[0];
    }

    private function getListType()
    {
        return [
            Stock::TYPE_BRAND,
            Stock::TYPE_CATEGORY,
            Stock::TYPE_PRODUCT
        ];
    }

    protected function internalForms(): array
    {
        return [
            'segment'
        ];
    }
}
