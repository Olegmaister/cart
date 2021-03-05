<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="remind-pass">
    <i class="remind-pass__close modal__close--login">
        <svg width="18" height="18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path class="_path" d="M15.75 0L18 2.25 2.25 18 0 15.75 15.75 0z"/>
            <path class="_path" d="M0 2.25L2.25 0 18 15.75 15.75 18 0 2.25z"/></svg>
    </i>
    <div class="remind-pass-content">
        <div class="remind-pass-content-row">
            <div class="remind-pass__title"><?= Yii::t('app', 'Enter E-mail') ?></div>
        </div>
        <?php $form = ActiveForm::begin(
            [
                'id' => 'js-form-recovery'
            ]); ?>
        <div class="remind-pass-content-row">
            <div class="b-field">
                <?= $form->field($model, 'email',[
                    'inputOptions' => ['class' => 'field-input', 'placeholder' => 'E-mail']
                ])->textInput() ?>
                <span class="field-required js-field-required">*</span>
            </div>
        </div>
        <div class="remind-pass-content-row">

            <?= Html::button('<span class="btn__inner" onclick="gtag(\'event\', \'category\', {\'event_category\': \'Открыть угловой баннер\', \'event_action\': \'Нажатие на кнопку\'});">' . Yii::t('app', 'send') . '</span>', ['class' => 'js-submit-recovery btn btn--red btn--lxx', 'name' => 'account-button']) ?>

        </div>

        <?php ActiveForm::end(); ?>
        <div class="remind-pass-content-row">
            <div class="js-link-transformed link link--red"><?= Yii::t('app', 'back') ?></div>
        </div>
    </div>
</div>
