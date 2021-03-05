<?php
/**
 * @var \yii\web\View $this
 */

use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;

$model = StaticPage::findOne(StaticPage::PAGE_WHOLESALE_ID);
$data = $model->pageWholesale;
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'For wholesalers') ?></span>
                </li>
            </ul>
        </nav>

    </div>
    <!--WRAPPER-->

    <div class="page-content">

        <div class="js-page-paddings">

            <h1 class="title title--page"><?= $model->pageSeoData->seo_title ?></h1>

        </div>
        <!--WRAPPER-->

        <div class="p-opt">

            <div class="js-page-paddings">

                <div class="p-opt-conditions">

                    <section class="post-prev p-opt-post">

                        <div class="post-prev-col post-prev-col_left">
                            <div class="post-prev-img"><img loading="lazy" src="<?= $data->image ?>" alt=""></div>
                        </div>
                        <div class="post-prev-col post-prev-col_right">
                            <h2 class="post-prev__title"><?= $data->title ?></h2>
                            <div class="post-prev__desc" style="display: table;">
                                <?= $data->content ?>
                            </div>

                            <?php /*if ($data->btn_link): ?>
                                <button class="btn-link btn-link--red">
                                    <a href="<?= $data->btn_link ?>" class="btn-link__inner"><?= $data->btn_text ?></a>
                                </button>
                            <?php endif; */ ?>
                        </div>

                    </section>

                </div>
                <!--CONDITIONS-->

            </div>
            <!--WRAPPER-->
            <div class="p-opt-query">

                <div class="js-page-paddings">

                    <h2 class="title title--white"><?= Yii::t('app', 'INQUIRY FOR WHOLESALE PRICE') ?></h2>

                    <div class="p-opt-query-form">

                        <form class="popup-call auxiliary_form"
                              data-success="<?= Yii::t('app', 'Message sent. Thank you for your message!') ?>"
                              data-error="<?= Yii::t('app', 'Fills in the required fields!') ?>"
                              method="post">
                            <div class="p-opt-query-form-fields">

                                <div class="p-opt-query-form-col p-opt-query-form-col--left">

                                    <div class="p-opt-query-form-row">

                                        <div class="p-opt-query-form-row-col">
                                            <div class="b-field b-field--white">
                                                <span class="b-field__label">*</span>
                                                <input type="text" name="user_name" value="<?= isset($model->profile->firstName) ? $model->profile->firstName : '' ?>" placeholder="<?= Yii::t('app', 'Name') ?>" class="input-field">
                                            </div>
                                        </div>

                                        <div class="p-opt-query-form-row-col">
                                            <div class="b-field b-field--white">
                                                <span class="b-field__label">*</span>
                                                <input type="tel"  name="user_phone"
                                                       pattern="[+][0-9]{12}"
                                                       title="+380xxxxxxxxx"
                                                       value="<?= isset($model->profile->phone) ? $model->profile->phone : '' ?>" placeholder="<?= Yii::t('app', 'Phone') ?>" class="input-field">
                                            </div>
                                        </div>

                                    </div>
                                    <!--ROW-->

                                    <div class="p-opt-query-form-row">

                                        <div class="p-opt-query-form-row-col">
                                            <div class="b-field b-field--white">
                                                <span class="b-field__label">*</span>
                                                <input type="text" placeholder="<?= Yii::t('app', 'Company name') ?>" class="input-field">
                                            </div>
                                        </div>

                                        <div class="p-opt-query-form-row-col">
                                            <div class="b-field b-field--white">
                                                <span class="b-field__label">*</span>
                                                <input type="email" name="user_email" value="<?= isset($model->email) ? $model->email : '' ?>" placeholder="E-mail" class="input-field">
                                            </div>
                                        </div>

                                    </div>
                                    <!--ROW-->

                                </div>
                                <!--COLUMN-->

                                <div class="p-opt-query-form-col p-opt-query-form-col--right">
                                    <div class="b-field b-field--white">
                                        <textarea name="message" placeholder="<?= Yii::t('app', 'Ask a question') ?>"></textarea>
                                    </div>
                                </div>
                                <!--COLUMN-->

                            </div>
                            <!--FIELDS-->

							<input type="hidden" name="type" value="wholesale price">

                            <div class="p-opt-query-form-but">
                                <button class="btn btn--red btn--full btn--lg-x">
                                    <span class="btn__inner"><?= Yii::t('app', 'send') ?></span>
                                </button>
                            </div>
                        </form>

                    </div>
                    <!--FORM-->
                </div>
                <!--WRAPPER-->

            </div>
            <!--QUERY-->

            <div class="js-page-paddings">

                <div class="p-opt-contacts">

                    <h2 class="title"><?= Yii::t('app', 'Wholesale department contacts') ?></h2>

                    <div class="p-opt-contacts-inner">

                        <div class="p-opt-contacts-col p-opt-contacts-col--left">

                            <div class="p-contacts-item-inner">

                                <div class="p-contacts-item-col">

                                    <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'Phones') ?></h3>

                                    <?php foreach (explode("\n", $data->phones) as $phone): ?>
                                        <a href="tel:><?= $phone ?>"><?= $phone ?></a>
                                    <?php endforeach; ?>

                                </div>

                                <div class="p-contacts-item-col">

                                    <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'Working hours') ?></h3>

                                    <?php foreach (explode("\n", $data->timetable) as $timetable): ?>
                                        <p><?= $timetable ?></p>
                                    <?php endforeach; ?>

                                </div>

                                <div class="p-contacts-item-col">

                                    <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'post office') ?></h3>

                                    <?php foreach (explode("\n", $data->emails) as $email): ?>
                                        <a href="mailto:<?= $email ?>"><?= $email ?></a>
                                    <?php endforeach; ?>

                                </div>

                                <div class="p-contacts-item-col">
                                    <?php if (!empty($data->address)): ?>
                                        <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'Address') ?></h3>

                                        <div class="p-contacts-item-col__adress">
                                            <?= $data->address ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                        <!--COLUMN-->

                        <div class="p-opt-contacts-col p-opt-contacts-col--right d-none">

                            <div class="p-opt-contacts-map">

                                <div class="p-opt-contacts-map-but">
                                    <button class="btn btn--red btn--lxx js-open-modal-map">
                                        <span class="btn__inner"><?= Yii::t('app', 'ADDRESS ON MAP') ?></span>
                                    </button>
                                </div>

                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d42451.4440403639!2d25.92989954311523!3d48.31794246548609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sua!4v1591635423564!5m2!1sru!2sua"
                                        width="100%" height="206" frameborder="0" style="border:0;" allowfullscreen=""
                                        aria-hidden="false" tabindex="0"></iframe>
                            </div>

                        </div>
                        <!--COLUMN-->

                    </div>
                    <!--INNER-->

                </div>
                <!--CONTACTS-->

                <div class="p-opt-seo">

                    <h2 class="title"><?= $data->info_title ?></h2>

                    <div class="p-opt-seo__desc">
                        <?= $data->info_text ?>
                    </div>

                </div>

            </div>
            <!--WRAPPER-->

        </div>
        <!--P-OPT-->

    </div>
    <!--CONTENT-->

    <div class="modal modal--map">
        <div class="modal-content">
            <span class="modal__close modal__close--map"></span>
            <div class="modal__title"><?= Yii::t('app', 'ADDRESS') ?></div>
            <div class="modal-content-inner">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d42451.4440403639!2d25.92989954311523!3d48.31794246548609!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2sua!4v1591635423564!5m2!1sru!2sua"
                        width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>

</div>
<!--PAGE-->