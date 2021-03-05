<?php

use borales\extensions\phoneInput\PhoneInput;
use common\helpers\LanguageHelper;
use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/**@var $model \frontend\forms\customer\CustomerForm */
?>


<?php $form = ActiveForm::begin([
    'id' => 'js-customer-form',
    'options' => [
        'class' => 'account-item-bg'
    ],
    'enableClientValidation' => true,
]); ?>

<div class="row user-info-grid">
    <div class="col-md-4">
        <div class="b-field">
            <?= $form->field($model->profile, 'firstName', [
                'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Name')]
            ])->textInput() ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <?= $form->field($model->profile, 'lastName', [
                'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Family name')]
            ])->textInput() ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <?= $form->field($model->profile, 'fatherName', [
                'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Middle name')]
            ])->textInput() ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <div class="form-group">
                <?= $form->field($model, 'phone')->widget(PhoneInput::class, [
                    'jsOptions' => [
                        'preferredCountries' => ['ua', 'pl', 'no'],
                    ],
                    'options' => ['class' => 'field-input']
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <div class="form-group">
                <?= $form->field($model, 'email', [
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => 'E-mail']
                ])->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <?= $form->field($model->profile, 'phone')->widget(PhoneInput::class, [
                'jsOptions' => [
                    'preferredCountries' => ['ua', 'pl', 'no'],
                ],
                'options' => ['class' => 'field-input']
            ]); ?>
        </div>
    </div>
    <div class="col-12">
        <hr>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <div class="select-pages">


                <?= $form->field($model->profile, 'countryId', [
                    'inputOptions' => [
                            'class' => 'custom-select custom-select--lg'
                    ]
                ])->dropDownList($model->getCountryList())->label(false); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field js-account-city-ukraine">
            <div class="form-group">
                <?= $form->field($model->profile, 'city', [
                    'inputOptions' => ['class' => 'js-courierNp-city field-input custom-select custom-select--lg', 'placeholder' => Yii::t('app', 'City')]
                ])->dropDownList($model->profile->getCities()) ?>
            </div>
        </div>
        <div class="b-field js-account-city-others">
            <div class="form-group">
                <?= $form->field($model->profile, 'cityName', [
                    'inputOptions' => ['class' => 'js-courierNp-city field-input custom-select custom-select--lg', 'placeholder' => Yii::t('app', 'City')]
                ])->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <div class="form-group">
                <?= $form->field($model->profile, 'street', [
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Street')]
                ])->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="b-field">
            <div class="form-group">
                <?= $form->field($model->profile, 'house', [
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'House')]
                ])->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="b-field">
            <div class="form-group">
                <?= $form->field($model->profile, 'apartment', [
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Apartment')]
                ])->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="b-field">
            <div class="form-group">
                <?= $form->field($model->profile, 'porch', [
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Porch')]
                ])->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="b-field">
            <div class="form-group">
                <?= $form->field($model->profile, 'index', [
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Index')]
                ])->textInput() ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <div class="form-group">
                <?php echo $form->field($model->profile, 'dateBirth')->widget(DatePicker::class, [
                    'options' => ['placeholder' => Yii::t('app', 'Date Birth')],
                    'pluginOptions' => [
                        'format' => 'yyyy-mm-dd',
                        'autoclose' => true
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="b-field">
            <?= $form->field($model->profile, 'state', [
                'inputOptions' => ['class' => 'field-input', 'placeholder' => 'Область/Штат']
            ])->textInput() ?>
        </div>
    </div>
    <div class="col-md-4">
        <select name="ProfileForm[gender]" class="select-1">
            <option value="" disabled><?=Yii::t('app', 'Select gender')?></option>
            <option <?= $model->profile->gender === 'M' ? 'selected' : '' ?> value="M"><?= Yii::t('app', 'Male') ?></option>
            <option <?= $model->profile->gender === 'F' ? 'selected' : '' ?> value="F"><?= Yii::t('app', 'Female') ?></option>
        </select>
    </div>
</div>
<div class="row text-center align-items-center user-info-grid">
    <div class="col-md-auto order-md-last mt-4">
        <a target="_blank" href="<?= Url::to('/'.LanguageHelper::getSlugByCode(Yii::$app->language).'/account/new-password') ?>"
           class="link link--red"><?= Yii::t('app', 'Change password') ?></a>
    </div>
    <div class="col-md-auto order-md-2 mt-4 mr-auto">
        <div class="checkbox-1 d-none">
            <input id="no-email" type="checkbox">
            <label for="no-email">У меня нет e-mail</label>
        </div>
    </div>
    <div class="col-md-4 mt-4">
        <?= Html::submitButton('<span class="btn__inner">' . Yii::t('app', 'Save') . '</span>', ['class' => 'btn btn--red btn--lxx w-100']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>




