<?php

namespace frontend\forms\customer;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\entities\Countries;
use common\entities\Customer;
use common\forms\CompositeForm;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * @property ProfileForm $profile
 */
class CustomerForm extends CompositeForm
{
    public $email;
    public $phone;
    public $avatar;

    private $_customer_id;

    public function __construct(Customer $customer, $config = [])
    {
        $this->_customer_id = $customer->customer_id;
        $this->phone = $customer->phone;
        $this->email = $customer->email;

        $this->profile = new ProfileForm($customer);

        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['email', 'phone'], 'required'],
            [['phone'], 'string'],
            [['phone'], PhoneInputValidator::class],
            [['email', 'phone'], 'unique', 'targetClass' => Customer::class, 'filter' => ['<>', 'customer_id', $this->_customer_id]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => '',
            'email' => '',
        ];
    }

    public function getCountryList()
    {
        $langName = 'name';

        if (Yii::$app->language === 'en-EN') {
            $langName = 'name_en';
        }

        if (Yii::$app->language === 'ua-UA') {
            $langName = 'name_ua';
        }

        return  ArrayHelper::map(
            Countries::find()
                ->asArray()
                ->orderBy(['sort' => SORT_DESC, 'code' => SORT_ASC])
                ->all()
            , 'code', $langName);
    }

    protected function internalForms(): array
    {
        return ['profile'];
    }
}