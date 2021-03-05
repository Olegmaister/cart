<?php
/**
 * @var \yii\web\View $this
 */

use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;

$model = StaticPage::findOne(StaticPage::PAGE_DISCOUNT_ID);

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'discount') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">

            <h1 class="title title--page"><?= $model->pageTextBlock->title ?></h1>

            <div class="p-discount">
                <div class="p-discount__desc">
                    <?= $model->pageTextBlock->text ?>
                </div>

                <div class="p-discount-items">
                    <?php foreach ($model->pageDiscount as $item): ?>
                        <div class="p-discount-item">
                            <div class="p-discount-item__procent"><?= $item->discount_text ?></div>
                            <div class="p-discount-item-info">
                                <h2 class="p-discount-item__title"><?= $item->title ?></h2>
                                <div class="p-discount-item__desc">
                                    <?= $item->content ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!--ITEMS-->
            </div>
            <!--P-DISCOUNT-->
        </div>
        <!--CONTENT-->
    </div>
    <!--WRAPPER-->

</div>
<!--PAGE-->
