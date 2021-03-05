<?php
/**
 * @var \yii\web\View $this
 * @var \backend\modules\page\models\ContactsPage $item
 */

use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;

$model = StaticPage::findOne(StaticPage::PAGE_CONTACTS_ID);

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= $model->pageSeoData->seo_title ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">

            <div class="p-contacts-head">
                <h1 class="title title--page"><?= $model->pageSeoData->seo_title ?></h1>
                <a href="<?= LanguageHelper::langUrl('our-stores') ?>" class="btn btn--red btn--lxx">
                    <span class="btn__inner"><?= Yii::t('app', 'Store addresses') ?></span>
                </a>
            </div>


            <div class="p-contacts">

                <?php foreach ($model->pageContacts as $item): ?>
                    <div class="p-contacts-item">

                        <div class="p-contacts-item-head">
                            <?= $item->title ?>
                        </div>

                        <div class="p-contacts-item-inner">
                            <?php if ($item->phones): ?>
                                <div class="p-contacts-item-col">
                                    <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'Phones') ?></h3>
                                    <?php foreach (explode("\n", $item->phones) as $phone): ?>
                                        <a href="tel:><?= $phone ?>"><?= $phone ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($item->timetable): ?>
                            <div class="p-contacts-item-col">
                                <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'Working hours') ?></h3>
                                <?php foreach (explode("\n", $item->timetable) as $timetable): ?>
                                    <p><?= $timetable ?></p>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <?php if ($item->emails): ?>
                            <div class="p-contacts-item-col">
                                <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'mail') ?></h3>
                                <?php foreach (explode("\n", $item->emails) as $email): ?>
                                    <a href="mailto:<?= $email ?>"><?= $email ?></a>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <?php if ($item->address): ?>
                            <div class="p-contacts-item-col">
                                <h3 class="p-contacts-item-col__title"><?= Yii::t('app', 'Address') ?></h3>
                                <div class="p-contacts-item-col__adress">
                                    <?= $item->address ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <!--INNER-->
                    </div>
                <?php endforeach; ?>
            </div>
            <!--P-CONTACTS-->
        </div>
        <!--CONTENT-->
    </div>
</div>
<!--PAGE-->
