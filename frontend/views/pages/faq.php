<?php
/**
 * @var \yii\web\View $this
 */

use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;

$model = StaticPage::findOne(StaticPage::PAGE_FAQ_ID);

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'faq') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">

            <h1 class="title title--page"><?= $model->pageSeoData->seo_title ?></h1>

            <div class="p-faq">
                <section class="desc-accord">
                    <?php foreach ($model->pageFaq as $item): ?>
                        <article class="desc-accord-item">
                            <header class="desc-accord-head js-toggle-slide">
                                <div class="desc-accord-head__title"><?= $item->title ?></div>
                                <span class="material-icons b_arrow b_arrow_black">arrow_drop_down</span>
                            </header>
                            <article class="desc-accord-cont js-toggle-cont">
                                <?= $item->content ?>
                            </article>
                        </article>
                    <?php endforeach; ?>
                </section>
            </div>
        </div>
    </div>
</div>
