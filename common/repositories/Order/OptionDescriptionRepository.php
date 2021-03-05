<?php
namespace common\repositories\Order;

use backend\entities\Order\OptionDescription;

class OptionDescriptionRepository
{
    public function getById($optionId)
    {
        return OptionDescription::find()
            ->where(['and',['option_id' => $optionId],['language_id' => 1]])
            ->one();
    }

    public function getByOption($optionId, $languageId)
    {
        return OptionDescription::find()
            ->where(['and',['option_id' => $optionId],['language_id' => 1]])
            ->one();
    }
}