<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\forms\customer\LoginForm */

use borales\extensions\phoneInput\PhoneInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>




<?php $form = ActiveForm::begin(
        [
            'id' => 'js-form-auth'
        ]); ?>
    <div class="login-fields">
        <div class="login-fields-row">
            <div class="login-fields-row__title">
                <span>*</span> <?= Yii::t('app', 'Enter your phone number or e-mail to enter') ?> 
            </div>
        </div>

		<div class="pg-row login-form">

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
				<?= $form->field($model, 'email',[
					'inputOptions' => ['class' => 'field-input', 'placeholder' => 'E-mail']
				])->textInput()->label(false); ?>
				<span class="field-required js-field-required">*</span>
			</div>

			<div class="field pg-col-50 pg-col-sm-100">
				<?= $form->field($model, 'password',[
					'inputOptions' => ['class' => 'field-input', 'placeholder' =>  Yii::t('app', 'Password')]
				])->passwordInput()->label(false); ?>
				<span class="field-required js-field-required">*</span>
			</div>

			<div class="pg-col-50 pg-col-sm-100">
				<?= Html::button('<span class="btn__inner">' . Yii::t('app', 'to come in') . '</span>', ['class' => 'js-btn-event-auth btn btn--red btn--full btn--lg-x', 'name' => 'account-button']) ?>
			</div>

		</div>
    </div>
<?php ActiveForm::end(); ?>






