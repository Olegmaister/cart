<?php
namespace api\forms\stock;

use api\behaviors\LoadFormBehavior;
use backend\forms\Stocks\SegmentForm;
use common\entities\Customer\Segment;
use common\entities\Stock\Stock;
use common\forms\CompositeForm;
use common\helpers\ArrayHelper;
use yii\base\Model;

class PresentCreateForm extends CompositeForm
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

    public function checkGuids($name)
    {
        return isset($this->data[0][$name]) && !empty($this->data[0][$name]);
    }

    public function getMainProductGuid()
    {
        return $this->data[0]['guid'];
    }

    public function getPresentProductGuid()
    {
        return $this->data[0]['guid_present'];
    }

    public function rules()
    {
        return [
            [['api','type','data'],'required'],
            [['method'],'safe'],
            ['type', 'typeChecking'],
            [['descriptions'],'safe'],

        ];
    }

    public function typeChecking($attribute, $params) {
        if(!in_array($this->type,$this->getListType())){
            $this->addError($attribute, "Не допустимый тип {$this->type} допустимый: present");
        }
    }

    public function getDescription()
    {
        return $this->description[0];
    }

    private function getListType()
    {
        return [
            Stock::TYPE_PRESENT
        ];
    }

    protected function internalForms(): array
    {
        return [
            'segment'
        ];
    }
}

