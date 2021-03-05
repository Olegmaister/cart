<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\forms\customer\LoginForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin(
    [
        'id' => 'js-form-auth',
    ]); ?>
<div class="page">
    <div class="wrapper">
        <div class="page-content">
            <div class="remind-pass__title text-center my-5"> <?= Yii::t('app', 'Enter new password') ?></div>
            <div class="row justify-content-center">
                <div class="col-md-5 col-lg-3">
                    <div class="b-field mb-3">
                        <?= $form->field($model, 'password', [
                            'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'password')],
                        ])->passwordInput()->label(false) ?>
                        <span class="field-required js-field-required">*</span>
                    </div>
                    <?= Html::submitButton('<span class="btn__inner">' . Yii::t('app', 'Confirm') .  '</span>', ['class' => 'js-btn-event-auth btn btn--red btn--full btn--lg-x', 'name' => 'account-button']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
