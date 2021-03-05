<?php
/**
 * @var \yii\web\View $this
 * @var \backend\modules\page\models\ContactsPage $item
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\LanguageHelper;

$this->registerJsFile('/js/subscription.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

echo $this->render('/seo', [
    'title' => Yii::t('app', 'Newsletter subscription'),
    'description' => Yii::t('app', 'Newsletter subscription'),
    //'keywords' => '',
]);

?>

<div class="page">

    <div class="js-page-paddings">

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'Newsletter subscription') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">
            <div class="p-contacts-head">
                <h1 class="title title--page"><?= isset($mailText->subject) ? $mailText->subject : '' ?></h1>
            </div>

            <div class="post-prev__desc">

                <div class="newsletter_block" style="margin-top: 15px;">
                     <p>
                        <?= isset($mailText->title) ? $mailText->title : '' ?>
                     </p>

                    <br>

                    <?php $form = ActiveForm::begin([
                        'action' => '/pages/subscription',
                        'method' => 'post',
                        'options' => ['class' => 'newsletter_subscription'],
                    ]) ?>

                    <div class="col-md-3 mb-3" style="padding-left: 0;">
                        <div class="b-field">
                            <?= $form->field($model, 'email', ['options' => ['tag' => false]])
                                ->textInput(['class' => 'input-field', 'placeholder' => Yii::t('app', 'E-mail')])->label(false) ?>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3" style="padding-left: 0;">
                        <div class="subscribe-form-but">
                            <?= Html::submitButton('<span class="btn__inner">' . Yii::t('app', 'submit') . '</span>', ['class' => 'btn btn--red btn--lxx submit_letter']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end() ?>
                </div>

                <div class="thenks_block hide" style="margin-top: 15px;">
                    <p>
                        <?= isset($mailText->additional_text) ? $mailText->additional_text : '' ?>
                    </p>

                    <br>
                    <div class="col-md-3 mb-3" style="padding-left: 0;">
                        <div class="subscribe-form-but">
                            <?= Html::submitButton('<span class="btn__inner">' . Yii::t('app', 'close') . '</span>', ['class' => 'btn btn--red btn--lxx submit_thanks']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
