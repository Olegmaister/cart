<?php

namespace common\models;

use common\helpers\LanguageHelper;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $description
 * @property string $mail_from
 * @property string $name_from
 *
 * @property MailLanguage $mailLanguage
 */
class Mail extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mail_from', 'name_from',], 'required'],
            [['description', 'mail_from', 'name_from',], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Доступные параметры',
            'mail_from' => 'Почта отправителя',
            'name_from' => 'Имя отправителя',
        ];
    }

    public function getMailLanguage()
    {
        return $this->hasOne(MailLanguage::class, ['mail_id' => 'id'])
            ->where(['language_id' => LanguageHelper::RU_ID]);
    }

    public function getLanguageData(int $languageId)
    {
        return MailLanguage::findOne([
            'mail_id' => $this->id,
            'language_id' => $languageId,
        ]);
    }

    public function search()
    {
        return new ActiveDataProvider([
            'query' => self::find(),
        ]);
    }
}
