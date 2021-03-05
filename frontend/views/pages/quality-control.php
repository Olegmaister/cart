<?php
/**
 * @var \yii\web\View $this
 * @var \backend\modules\page\models\DeliveryPage $item
 */

use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;

$model = StaticPage::findOne(StaticPage::PAGE_QUALITY_CONTROL_ID);
$data = $model->pageQualityControl;

echo $this->render('/seo', [
    'title' => $model->pageSeoData->seo_title,
    'description' => $model->pageSeoData->seo_description,
    'keywords' => $model->pageSeoData->seo_keyword,
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'Quality improvement department') ?></span>
                </li>
            </ul>
        </nav>
    </div>
    <div class="page-content">
        <div class="js-page-paddings">
            <h1 class="title title--page"><?= $data->title ?></h1>
        </div>
        <div class="p-controll">
            <div class="js-page-paddings">
                <p>
                    <?= $data->content_top ?>
                </p>
            </div>
            <div class="p-controll-remarks">
                <div class="js-page-paddings">
                    <div class="p-controll-remarks-colums">
                        <div class="p-controll-remarks-col p-controll-remarks-col--left">
                            <h2 class="p-controll-remarks__title">
                                <?= Yii::t('app', 'WRITE YOUR COMMENTS!') ?>
                            </h2>
                        </div>

                        <div class="p-controll-remarks-col p-controll-remarks-col--right">
                            <form action=""
                                  data-success="<?= Yii::t('app', 'Message sent. Thank you for your message!') ?>"
                                  data-error="<?= Yii::t('app', 'Fills in the required fields!') ?>"
                                  class="popup-call auxiliary_form">
                                <div class="p-controll-remarks-form">
                                    <div class="p-controll-remarks-form-col p-controll-remarks-form-col--left">
                                        <div class="p-controll-remarks-form-row">
                                            <div class="b-field b-field--white">
                                                <span class="b-field__label">*</span>
                                                <input type="text" name="user_name"
                                                       placeholder="<?= Yii::t('app', 'Name') ?>" class="input-field">
                                            </div>
                                        </div>
                                        <div class="p-controll-remarks-form-row">
                                            <div class="b-field b-field--white">
                                                <span class="b-field__label">*</span>
                                                <input type="tel"
                                                       pattern="[+][0-9]{12}"
                                                       title="+380xxxxxxxxx"
                                                       name="user_phone" placeholder="Телефон" class="input-field">
                                            </div>
                                        </div>

                                        <div class="p-controll-remarks-form-row">
                                            <div class="b-field b-field--white">
                                                <input type="text" name="user_email" placeholder="E-mail"
                                                       class="input-field"
                                                       value="<?= isset($model->email) ? $model->email : '' ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="type" value="quality improvement department">

                                    <div class="p-controll-remarks-form-col p-controll-remarks-form-col--right">
                                        <div class="b-field b-field--white">
                                            <textarea name="message"
                                                      placeholder="<?= Yii::t('app', 'Ask a question') ?>"></textarea>
                                        </div>
                                    </div>
                                    <div class="p-controll-remarks__but">

                                        <button class="btn btn--red btn--full btn--lg-xs">
                                            <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="js-page-paddings">
                <p>
                    <?= $data->content_bottom ?>
                </p>
            </div>
        </div>
    </div>
</div>
