<?php
/**
 * @var \yii\web\View $this
 * @var \backend\modules\page\models\DeliveryPage $item
 */

use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;
use common\helpers\ProductHelper;

$model = StaticPage::findOne(StaticPage::PAGE_DELIVERY_ID);

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

            <h1 class="title title--page"><?= $model->pageSeoData->seo_title ?></h1>

            <div class="p-delivery">

                <div class="p-delivery-inner">
                    <?php foreach ($model->pageDelivery as $item): ?>
                    <div class="p-delivery-item">

                        <div class="p-delivery-item-head">
                            <div class="p-delivery-item-head__num"><?= $item->icon_text ?></div>
                            <div class="p-delivery-item-head__icon">
                                <img loading="lazy" src="<?= $item->icon_link ?>" alt="<?= $item->title ?>">
                            </div>
                        </div>
                        <!--HEAD-->

                        <div class="p-delivery-item-inner">

                            <h2 class="p-delivery-item__title"><?= $item->title ?></h2>

                            <div class="p-delivery-item__desc">
                                <?= $item->content ?>
                            </div>

                        </div>
                        <!--INNER-->

                        <?php if ($item->btn_link): ?>
                            <div class="p-delivery-item-but">
                                <a <?= ProductHelper::checkRelFollow($item->btn_link) ?>target="_blank" href="<?= $item->btn_link ?>" class="btn btn--trans btn--inline btn--lxs-h">
                                    <span class="btn__inner"><?= $item->btn_text ?></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>

                </div>
                <!--INNER-->

                <div class="p-delivery-info">

                    <i class="p-delivery-info__icon">
                        <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill="#EF1B1B" d="M11 7h2v7h-2zM11 16h2v2h-2z"/><circle cx="12" cy="12" r="11" stroke="#EF1B1B" stroke-width="2"/></svg>
                    </i>

                    <h3 class="p-delivery-info__title"><?= $model->pageTextBlock->title ?></h3>

                    <div class="p-delivery-info__desc">
                        <?= $model->pageTextBlock->text ?>
                    </div>

                </div>
                <!--INFO-->

            </div>
            <!--P-DELIVERY-->

        </div>
        <!--CONTENT-->

    </div>
    <!--WRAPPER-->

</div>
<!--PAGE-->