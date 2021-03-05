<?php
namespace frontend\forms\cart;

use yii\base\Model;
use function globalFunction\functions\dd;

class SpecificationForm extends Model
{
    
    public $opt;

    public function __construct($specifications,$config = [])
    {

        foreach ($specifications as $specification) {
            $this->opt[] = new OptionsForm($specification);

        }

        parent::__construct($config);
    }
}