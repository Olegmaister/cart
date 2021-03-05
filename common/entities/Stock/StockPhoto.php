<?php

namespace common\entities\Stock;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%stock_photos}}".
 *
 * @property int $id
 * @property int $stock_id
 * @property string $file
 * @property int|null $sort
 */
class StockPhoto extends \yii\db\ActiveRecord
{
    const THUMB = 'thumb';
    const ADMIN = 'admin';
    const SLIDER = 'slider';

    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        $photo->sort = rand(0, 20);
        return $photo;
    }

    public function setSort($sort): void
    {
        $this->sort = $sort;
    }


    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%stock_photos}}';
    }



    public function behaviors()
    {
        return [
            [
                'class' => '\bajadev\upload\ImageUploadBehavior',
                'attribute' => 'file',
                'thumbs' => [
                    'thumb' => ['width' => 400, 'height' => 300, 'crop' => false, 'quality' => 80],
                    'admin' => ['width' => 200, 'height' => 100, 'crop' => false, 'quality' => 80],
                    'slider' => ['width' => 1000, 'height' => 500, 'crop' => false, 'quality' => 80],
                ],
                'deleteOriginalFile' => true,
                'rotateImageByExif' => true,

                //
                'filePath' => '@staticRoot/stocks/[[attribute_stock_id]]/[[id]].[[extension]]',//сохранение
                'fileUrl' => '@static/stocks/[[attribute_stock_id]]/[[id]].[[extension]]',//сохранение
                'thumbPath' => '@staticRoot/stocks/[[attribute_stock_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/stocks/[[attribute_stock_id]]/[[profile]]_[[id]].[[extension]]',
            ],
        ];
    }

}
