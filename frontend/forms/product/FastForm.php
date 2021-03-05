<?php

namespace frontend\forms\product;

use common\entities\City;
use common\entities\Customer;
use frontend\forms\order\interfaces\DeliveryInterface;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class FastForm extends Model implements DeliveryInterface
{
    public $firstName;
    public $lastName;
    public $phone;
    public $city;
    public $branch;
    public $deliveryCost;

    public $productId;
    public $optionId;
    public $optionName;
    public $productColorImage;
    public $productPrice;

    public $paymentId;

    public $presentId;
    public $presentOptionId;
    public $presentOptionName;


    public function __construct(Customer $customer = null,$config = [])
    {
        if(isset($customer)){

            $this->firstName = $customer->profile->first_name;
            $this->lastName = $customer->profile->last_name;
            $this->phone = $customer->phone;

        }

        $this->paymentId = 4;



        parent::__construct($config);
    }

    public function rules()
    {

        return [
            [[
                'firstName',
                'lastName',
                'phone',
                'city',
                'branch',
                'productId',
                'optionId',
                'optionName',
                'productColorImage',
                'paymentId',
                'deliveryCost',
                'productPrice',

                'presentId',
                'presentOptionId',
                'presentOptionName'



            ], 'safe'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'firstName' => '',
            'lastName' => '',
            'phone' => '',
            'city' => '',
            'branch' => '',
            'productId' => '',
            'optionId' => '',
            'optionName' => '',
            'productColorImage' => '',
            'paymentId' => '',
            'deliveryCost' => '',
            'productPrice' => ''
        ];
    }

    public function getCities()
    {
        $languageName = 'name';

        if (Yii::$app->language === 'en-EN' || Yii::$app->language === 'en-US') {
            $languageName = 'name_en';
        }

        if (Yii::$app->language === 'ua-UA') {
            $languageName = 'name_ua';
        }

        return ArrayHelper::map(City::find()
            ->asArray()
            ->orderBy(['name' => SORT_ASC])
            ->where(['status' => 1,])
            ->andWhere(['<>', $languageName, ''])
            ->all(), 'id', function (array $city) use ($languageName) {

            return $city[$languageName];
        });
    }

    public function existsPresent()
    {
        if(isset($this->presentId,$this->presentOptionId) && !empty($this->presentId) && !empty($this->presentOptionId))
            return true;

        return false;
    }



}

