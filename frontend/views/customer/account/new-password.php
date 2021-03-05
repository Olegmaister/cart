<?php

use common\helpers\LanguageHelper;
use yii\widgets\ActiveForm;

?>
<div class="page">
    <div class="wrapper">
        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'New password') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <div class="remind-pass-content b-new-pass">
                <div class="remind-pass-content-row b-new-pass__title">
                    <div class="remind-pass__title"> <?= Yii::t('app', 'Enter new password') ?></div>
                </div>
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'enctype' => 'multipart/form-data',
                    ],
                ]); ?>
                <div class="b-new-pass-inner">
                    <div class="remind-pass-content-row">
                        <div class="b-field">
                            <?= $form->field($model, 'password',[
                                'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'password')]
                            ])->passwordInput() ?>
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                    <div class="remind-pass-content-row">
                        <div class="b-field">
                            <?= $form->field($model, 'repeatPassword',[
                                'inputOptions' => ['class' => 'field-input', 'placeholder' => Yii::t('app', 'password')]
                            ])->passwordInput() ?>
                            <span class="field-required js-field-required">*</span>
                        </div>
                    </div>
                    <div class="remind-pass-content-row">
                        <button class="btn btn--red btn--lxx">
                            <span class="btn__inner"><?= Yii::t('app', 'confirm changes') ?></span>
                        </button>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>