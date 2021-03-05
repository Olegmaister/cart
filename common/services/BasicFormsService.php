<?php


namespace common\services;


use common\entities\Forms;

class BasicFormsService
{
    public static function getCountNewForms()
    {
        return Forms::find()
            ->where(['status' => Forms::STATUS_NEW])
            ->count();
    }

    public static function getRusType($type)
    {
        $types = [
            'call_back' => 'Обратный звонок',
            'personal account question' => 'Вопрос (личный кабинет)',
            'quality improvement department' => 'Отдел улучшения качества',
            'wholesale price' => 'Запрос на оптовый прайс'
        ];

        if(isset($types[$type])) {
            return $types[$type];
        }

        return $type;
    }
}