<?php

namespace common\entities\Stock;

use backend\forms\Stocks\StockCreateForm;
use common\entities\queries\StockDescriptionQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%stock_description}}".
 *
 * @property int $id
 * @property int|null $stock_id
 * @property int $language_id
 * @property string|null $name
 * @property string|null $heading
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $language_name
 * @property string|null $meta_description
 * @property string|null $meta_keyword
 *
 * @property Stock $stock
 */
class StockDescription extends ActiveRecord
{

    const LANGUAGE_RU = 2;
    const LANGUAGE_RU_NAME = 'ru';
    const LANGUAGE_EN_NAME = 'en';
    const LANGUAGE_UA_NAME = 'ua';
    const LANGUAGE_EN = 1;
    const LANGUAGE_UA = 3;

    public static function create($form) : array
    {

        $object = [];

        $objectRu = new self();
        $objectRu->language_id = self::LANGUAGE_RU;
        $objectRu->language_name = self::LANGUAGE_RU_NAME;
        $objectRu->name = $form->ru->name;
        $objectRu->description = $form->ru->description;
        $objectRu->heading = $form->ru->heading;
        $objectRu->meta_title = $form->ru->metaTitle;
        $objectRu->meta_description = $form->ru->metaDescription;
        $objectRu->meta_keyword = $form->ru->metaKeyword;


        $objectEn = new self();
        $objectEn->language_id = self::LANGUAGE_EN;
        $objectEn->language_name = self::LANGUAGE_EN_NAME;
        $objectEn->name = $form->en->name;
        $objectEn->description = $form->en->description;
        $objectEn->heading = $form->en->heading;
        $objectEn->meta_title = $form->en->metaTitle;
        $objectEn->meta_description = $form->en->metaDescription;
        $objectEn->meta_keyword = $form->en->metaKeyword;

        $objectUa = new self();
        $objectUa->language_id = self::LANGUAGE_UA;
        $objectUa->language_name = self::LANGUAGE_UA_NAME;
        $objectUa->name = $form->ua->name;
        $objectUa->description = $form->ua->description;
        $objectUa->heading = $form->ua->heading;
        $objectUa->meta_title = $form->ua->metaTitle;
        $objectUa->meta_description = $form->ua->metaDescription;
        $objectUa->meta_keyword = $form->ua->metaKeyword;


        $object = [$objectRu,$objectEn,$objectUa];



        return $object;
    }

    //TODO временное
    public static function apiCreate($name, $heading, $description)
    {
        $object = [];

        $objectRu = new self();
        $objectRu->language_id = self::LANGUAGE_RU;
        $objectRu->language_name = self::LANGUAGE_RU_NAME;
        $objectRu->name = $name;
        $objectRu->description = $description;
        $objectRu->heading = $heading;
        $objectRu->meta_title = $name;
        $objectRu->meta_description = $name;
        $objectRu->meta_keyword = $name;

        $object = [$objectRu];

        return $object;
    }

    public function edit($form)
    {
        $this->name = $form->name;
        $this->description = $form->description;
        $this->heading = $form->heading;
        $this->meta_title = $form->metaTitle;
        $this->meta_description = $form->metaDescription;
        $this->meta_keyword = $form->metaKeyword;
    }

    public function apiEdit($name, $description, $heading)
    {
        $this->name = $name;
        $this->description = $description;
        $this->heading = $heading;
        $this->meta_title = $name;
        $this->meta_description = $name;
        $this->meta_keyword = $name;
    }


    public function isForCategoryDescription($id)
    {
        return $this->id === $id;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_description}}';
    }


    /**
     * Gets query for [[Stock]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(Stock::class, ['id' => 'stock_id']);
    }


    public static function find() : StockDescriptionQuery
    {
        return new StockDescriptionQuery(static::class);
    }

}
