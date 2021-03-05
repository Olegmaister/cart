<?php

use borales\extensions\phoneInput\PhoneInput;
use common\helpers\LanguageHelper;
use frontend\components\ApiCurrency;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$currency = new ApiCurrency();
?>
<div class="modal modal--quik-buy">

    <div class="modal-content">

        <span class="modal__close modal__close--quik-buy"></span>

        <div class="modal__title pb-0"><?= Yii::t('app', 'QUICK ORDER') ?></div>
        <h2 class="text-muted font-weight-normal"><?= Yii::t('app', 'Delivery to the new post office') ?>: </h2>

        <?php $form = ActiveForm::begin([
            'action' => '/' . LanguageHelper::getCurrent() . '/checkout/fast',
            'id' => 'js-checkout-form-fast',
        ]) ?>

            <div class="modal-content-inner" data-error="<?= Yii::t('app', 'Fills in required fields') ?>!">
                <div class="popup-quik-buy">
                    <div class="popup-quik-buy-row">
                        <div class="popup-quik-buy-col">
                            <div class="b-field">
                                <?= $form->field($model, 'firstName',[
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Name')]
                                ])->textInput() ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                        </div>
                        <div class="popup-quik-buy-col">
                            <div class="b-field">
                                <?= $form->field($model, 'lastName',[
                                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Surname')]
                                ])->textInput() ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                        </div>
                    </div>

                    <div class="popup-quik-buy-row">

                        <div class="popup-quik-buy-col">


                            <div class="b-field b-field-dd">
                                <span class="b-field__label">*</span>
                                <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                                    'jsOptions' => [
                                        'preferredCountries' => ['ua', 'pl', 'no'],
                                    ],
                                    'options' => ['class' => 'field-input']
                                ]);
                                ?>
                                <span class="field-required js-field-required">*</span>
                            </div>
                        </div>

                        <div class="popup-quik-buy-col">

                            <div class="b-field">

                                <div class="select-pages">

                                    <?= $form->field($model, 'city', [
                                        'inputOptions' => ['class' => 'modal-select', 'placeholder' => Yii::t('app', 'City')]
                                    ])->dropDownList($model->getCities(), ['promt' => Yii::t('app', 'Select city')])->label(false) ?>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="popup-quik-buy-row">

                        <div class="popup-quik-buy-col">

                            <div class="b-field">

                                <div class="select-pages">

                                    <?= $form->field($model, 'branch', [
                                        'inputOptions' => ['class' => 'modal-select simple-filter', 'placeholder' => Yii::t('app', 'department')]
                                    ])->dropDownList(['promt' => Yii::t('app', 'Select branch')]) ?>

                                </div>

                            </div>

                        </div>
                        <div class="popup-quik-buy-col align-items-start">
                            <div class="popup-quik-buy-col-inner">
                                <div class="popup-quik-buy-info d-block">
                                    <div class="popup-quik-buy-info-col font-weight-bold">
                                        <?= Yii::t('app', 'delivery') ?>: <span class="js-fast-delivery text-red"></span>
                                    </div>
                                    <div class="popup-quik-buy-info-col font-weight-bold js-discount-fast hidden">
                                        <?= Yii::t('app', 'discount') ?>:
                                        <span class="text-red">
                                            <?= $currency->getCurrencySign() ?>
                                        </span>
                                        <span class="text-red js-fast-discount-value"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="popup-quik-buy-col-inner">
                                <div class="popup-quik-buy-info">
                                    <div class="popup-quik-buy-info-col font-weight-bold">
                                        <?= Yii::t('app', 'sum') ?>:
                                        <span class="text-red">
                                            <?= $currency->getCurrencySign() ?>
                                        </span>
                                        <span class="js-cost-fast text-red"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?= $form->field($model, 'productId',[])->hiddenInput() ?>
                    <?= $form->field($model, 'optionId',[])->hiddenInput() ?>
                    <?= $form->field($model, 'optionName',[])->hiddenInput() ?>
                    <?= $form->field($model, 'productColorImage',[])->hiddenInput() ?>
                    <?= $form->field($model, 'paymentId',[])->hiddenInput() ?>
                    <?= $form->field($model, 'deliveryCost',[])->hiddenInput() ?>
                    <?= $form->field($model, 'productPrice',[])->hiddenInput() ?>

                    <?= $form->field($model, 'presentId')->hiddenInput() ?>
                    <?= $form->field($model, 'presentOptionId')->hiddenInput() ?>
                    <?= $form->field($model, 'presentOptionName')->hiddenInput() ?>

                    <div class="popup-quik-buy-row popup-quik-buy-buttons">
                        <div class="popup-quik-buy-col">
                            <?= Html::button('<span class="btn__inner" onclick="gtag(\'event\', \'category\', {\'event_category\': \'Оформить быструю покупку\', \'event_action\': \'Нажатие на кнопку\'});">' . Yii::t('app', 'checkout') . '</span>', ['class' => 'js-fast-order btn btn--red btn--full btn--lg-x']) ?>
                        </div>
                        <div class="popup-quik-buy-col">
                            <?= Html::button('<span class="btn__inner" onclick="gtag(\'event\', \'category\', {\'event_category\': \'Оплатить быструю покупку\', \'event_action\': \'Нажатие на кнопку\'});">' . Yii::t('app', 'order and pay') . '</span>', ['class' => 'js-fast-order wayforpay btn btn--black btn--full btn--lg-x']) ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php ActiveForm::end() ?>
        <!--CONTENT INNER-->
    </div>
</div>
