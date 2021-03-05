<?php
namespace frontend\forms\blog;

use borales\extensions\phoneInput\PhoneInputValidator;
use common\entities\Customer;
use yii\base\Model;

class ReviewForm extends Model
{
    public $name;
    public $reviewId;
    public $email;
    public $text;
    public $rating;

    public function __construct(Customer $customer = null,$config = [])
    {
        if($customer){
            $this->name = $customer->profile->first_name;
            $this->email = $customer->email;
        }
        parent::__construct($config);
    }


    public function rules()
    {

        return [
            [['reviewId','rating'], 'safe'],
            [['name','email','text'], 'required'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'name' => '',
            'email' => '',
            'rating' => '',
            'text' => '',
            'reviewId' => ''

        ];
    }
}