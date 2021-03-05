<?php
namespace api\behaviors;

use api\forms\stock\CreateForm;
use yii\base\Behavior;

class LoadFormBehavior extends Behavior
{
    public function loadForm($request)
    {
        $owner = $this->owner;
        $class = lcfirst(get_class($this->owner));

        foreach ($request as $key=>$item) {
            if(property_exists($class, $key)){
                $owner->{$key} = $item;
            }
        }

    }
}