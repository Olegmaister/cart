<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $mail_id
 * @property int $language_id
 * @property string $subject
 * @property Mail $mail
 * @property string $title
 * @property string $additional_text
 */
class MailLanguage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mail_language';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Тема письма',
            'title' => 'Заголовок',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject',], 'required'],
            [['subject', 'title', 'additional_text'], 'string'],
            [['id', 'mail_id', 'language_id',], 'integer'],
        ];
    }

    public function getMail()
    {
        return $this->hasOne(Mail::class, ['id' => 'mail_id']);
    }
}
