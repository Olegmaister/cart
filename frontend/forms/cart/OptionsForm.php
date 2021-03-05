<?php
namespace frontend\forms\cart;

use yii\base\Model;
use function globalFunction\functions\dd;

class OptionsForm extends Model
{

    public $name;
    public $quantity;
    public $option_value_id;

    public function __construct($option,$config = [])
    {
        $this->name = $option['name'];
        $this->quantity = $option['quantity'];
        $this->option_value_id = $option['option_value_id'];
        parent::__construct($config);
    }
}