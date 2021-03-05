<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \common\forms\customer\SignupForm */

use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>


<?php $form = ActiveForm::begin(
    [
        'id' => 'js-form-registration'
    ]
); ?>
<div class="login-fields pg-row">
    <div class="field pg-col-50 pg-col-sm-100">
        <?= $form->field($model, 'username', [
            'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Name')]
        ])->textInput(['autofocus' => true])->label(false); ?>
        <span class="field-required js-field-required">*</span>
    </div>

    <div class="field pg-col-50 pg-col-sm-100">
        <?= $form->field($model, 'lastName', [
            'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Surname')]
        ])->textInput(['autofocus' => true])->label(false); ?>
        <span class="field-required js-field-required">*</span>
    </div>

    <div class="field pg-col-50 pg-col-sm-100">
        <?= $form->field($model, 'phone', [
            'inputOptions' => ['placeholder' => Yii::t('app', 'Phone')]
        ])->widget(PhoneInput::class, [
            'jsOptions' => [
                'preferredCountries' => ['ua', 'pl', 'no'],
            ],
            'options' => ['class' => 'field-input']
        ])->label(false);
        ?>
        <span class="field-required js-field-required">*</span>
    </div>

    <div class="field pg-col-50 pg-col-sm-100">
        <?= $form->field($model, 'email', [
            'inputOptions' => ['class' => 'field-input', 'placeholder' => 'E-mail']
        ])->textInput(['autofocus' => true])->label(false); ?>
        <span class="field-required js-field-required">*</span>
    </div>

    <div class="field pg-col-50 pg-col-sm-100">
        <?= $form->field($model, 'password', [
            'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Password')]
        ])->passwordInput()->label(false); ?>
        <span class="field-required js-field-required">*</span>
    </div>

    <div class="field pg-col-50 pg-col-sm-100">
        <?= $form->field($model, 'repeatPassword', [
            'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'Repeat password')]
        ])->passwordInput()->label(false); ?>
        <span class="field-required js-field-required">*</span>
    </div>
    <div class="w-100 text-center">
        <div class="checkbox-1 d-inline-block">
            <input id="no-email" type="checkbox">
            <label for="no-email"><?= Yii::t('app', 'I have no e-mail') ?></label>
        </div>
    </div>
</div>
<div class="login-bottom">
    <?= Html::button('<span class="btn__inner" onclick="gtag(\'event\', \'category\', {\'event_category\': \'Регистрация на сайте\', \'event_action\': \'Нажатие на кнопку\'});">' . Yii::t('app', 'registration') . '</span>', ['class' => 'js-btn-event-registration btn btn--red btn--lxx', 'name' => 'account-button']) ?>
</div>
<?php ActiveForm::end(); ?>

<form id="js-confirm-registration">
    <div class="row mt-5">
        <div class="col-md-6 m-auto pt-5">
            <p class="text-roboto mb-1"><?= Yii::t('app', 'Enter the code that came to you via') ?> <span></span></p>
            <div class="mb-3">
                <input type="text" minlength="4" maxlength="4" name="code-confirm" class="input-1" placeholder="<?= Yii::t('app', 'Code') ?>">
            </div>
            <button type="submit" class="btn btn--red btn--lxx w-100"><span class="btn__inner"><?= Yii::t('app', 'Confirm') ?></span></button>
        </div>
    </div>
</form>
