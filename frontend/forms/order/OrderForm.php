<?php

namespace frontend\forms\order;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\entities\Customer;
use common\entities\Stock\StockPromo;
use common\forms\CompositeForm;
use yii\helpers\ArrayHelper;

/**
 * @property DeliveryForm $delivery
 * @property RecipientForm $recipient
 * @property CourierNpForm $courierNp
 * @property OfficeNpForm $officeNp
 * @property StoreReservationForm $storeReservation
 * @property ForeignersUpForm $foreignersUp
 *
 * @property PaymentForm $paymentForm;
 */
class OrderForm extends CompositeForm
{
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $comment;
    public $noCallMe;

    public $cost;

    public $promoToken;
    public $checkboxRecipient;

    //регистрационные данные
    public $registration;
    public $password;
    public $repeatPassword;

    private $_registration;


    /**@var Customer $customer*/
    public function __construct(int $weight,$customer = null, array $config = [])
    {
        if(isset($customer->profile)){
            $this->firstName = $customer->profile->first_name;
            $this->lastName = $customer->profile->last_name;
            $this->email = $customer->email;
            $this->phone = $customer->phone;

        }
        //recipient
        $this->recipient = new RecipientForm();

        //delivery
        $this->delivery = new DeliveryForm($weight,$customer);
        $this->courierNp = new CourierNpForm($customer);
        $this->officeNp = new OfficeNpForm($customer);
        $this->storeReservation = new StoreReservationForm();
        $this->foreignersUp = new ForeignersUpForm($customer);

        //payment
        $this->paymentForm = new PaymentForm();

        parent::__construct($config);
    }


    public function rules()
    {


        $this->_registration = isset(\Yii::$app->request->post('OrderForm')['registration'])
        ? \Yii::$app->request->post('OrderForm')['registration']
        : 0;

        return array_filter([
            [['registration','cost', 'noCallMe'], 'safe'],
            $this->_registration == 1 ?[['password','repeatPassword'], 'required'] : false,
            $this->_registration == 1 ? ['email', 'unique', 'targetClass' => '\common\entities\Customer', 'message' => 'This email already.'] : false,
            $this->_registration == 1 ? ['phone', 'unique', 'targetClass' => '\common\entities\Customer', 'message' => 'This phone already.'] : false,
            $this->_registration == 1 ? ['repeatPassword', 'compare', 'compareAttribute' => 'password'] : false,
            $this->_registration == 1 ?  ['password', 'string', 'min' => 6] : false,
            [['firstName', 'lastName','phone'], 'required'],
            [['email'], 'safe'],
            [['comment'], 'safe'],
            [['promoToken'], 'safe'],
            [['phone'], 'string'],
            [['phone'], PhoneInputValidator::class],
        ]);
    }



    public function attributeLabels()
    {
        return [
            'firstName' => '',
            'lastName' => '',
            'phone' => '',
            'email' => '',
            'promoToken' => '',
            'checkboxRecipient' => '',
            'password' => '',
            'repeatPassword' => '',
            'cost' => '',
            'comment' => ''

        ];
    }

    public function afterValidate()
    {
        parent::afterValidate(); // TODO: Change the autogenerated stub
    }


    public function getCountry()
    {
        return [
            'UA' => 'Украина',
            'PL' => 'Польша',
        ];
    }

    public function ifCustomerRegisters()
    {
        return $this->registration == 1;
    }


    public function getPromoCode()
    {

        $customer = \Yii::$app->user->identity;

        $model = StockPromo::find()
            ->joinWith('promo')
            ->where(['and',
                ['customer_id' => $customer->customer_id],
                ['>','promo.count',0]
            ])
            ->asArray()
            ->all();

        return ArrayHelper::map($model,'id',function(array $item){
            $currentItem = $item['promo'][0];
            return $currentItem['promo_token'];
        });
    }


    protected function internalForms(): array
    {
        return [
            'delivery',
            'recipient',
            'courierNp',
            'officeNp',
            'foreignersUp',
            'paymentForm',
            'storeReservation'
        ];
    }


    public function getErrorForms()
    {
        $errors = [];
        foreach ($this->getForms() as $formName) {
            if(!empty($this->{$formName}->errors))
            $errors[$formName] = $this->{$formName}->errors;
        }


        if(!empty($this->errors)){
            $errors[$this->formName()] = $this->errors;
        }


        return $errors;
    }

    public function beforeValidate()
    {
        if(!$this->cost)
            $this->cost = 0;
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    private function getForms(): array
    {
        return [
            'delivery',
            'recipient',
            'courierNp',
            'officeNp',
            'foreignersUp',
            'paymentForm',
            'storeReservation'
        ];
    }
}
