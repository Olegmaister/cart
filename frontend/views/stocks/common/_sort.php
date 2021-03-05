<?php

use yii\widgets\ActiveForm;

/**@var \frontend\forms\stock\TypeForm $modelType */
?>

<div class="row align-items-center sort-buttons">
    <div class="col-md-auto">
        <div class="row align-items-center">
            <div class="col-auto"><?= Yii::t('app', 'sort') ?> <?= Yii::t('app', 'by') ?>:</div>
            <div data-sort="asc" class="js-stock-sort sort-date col-auto">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.6665 3.33331V12.3333" stroke="#1D2023" stroke-width="2"/>
                    <path d="M1.33325 9.2998L4.63308 12.5996L7.93291 9.2998" stroke="#1D2023" stroke-width="2"/>
                    <path d="M11.2664 12.5997L11.2664 3.59967" stroke="#1D2023" stroke-width="2"/>
                    <path d="M14.5996 6.63312L11.2998 3.33329L7.99995 6.63312" stroke="#1D2023" stroke-width="2"/>
                </svg>
                <?= Yii::t('app', 'date') ?>
            </div>
            <div data-sort="discount-size" class="js-discount-size-sort sort-date col-auto">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.6665 3.33331V12.3333" stroke="#1D2023" stroke-width="2"/>
                    <path d="M1.33325 9.2998L4.63308 12.5996L7.93291 9.2998" stroke="#1D2023" stroke-width="2"/>
                    <path d="M11.2664 12.5997L11.2664 3.59967" stroke="#1D2023" stroke-width="2"/>
                    <path d="M14.5996 6.63312L11.2998 3.33329L7.99995 6.63312" stroke="#1D2023" stroke-width="2"/>
                </svg>
                <?= Yii::t('app', 'Amount of discount') ?>
            </div>
        </div>
    </div>
    <div class="col-md mt-3 mt-md-0">
        <div class="row align-items-center">
            <div class="col-md-auto my-2"><?= Yii::t('app', 'type of stock') ?>:</div>
            <div class="col-md col-lg-5 col-xl-4">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                    ],
                ]); ?>

                <?= $form->field($modelType, 'sort', [
                    'inputOptions' => ['class' => 'n-select wide sort-dropdown js-nice-select', 'placeholder' => 'Сорт']
                ])->dropDownList($modelType->getListType())->label(false) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
