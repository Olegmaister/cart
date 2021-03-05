<?php
/**
 * @var \backend\modules\page\models\DynamicPage $data
 */
use common\helpers\LanguageHelper;

echo $this->render('/seo', [
    'title' => $data->pageData->seo_title,
    'description' => $data->pageData->seo_description,
    'keywords' => $data->pageData->seo_keyword
]);
?>
<div class="page">
    <div class="wrapper">

        <nav class="breadcrumbs">
            <ul class="breadcrumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                    itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= \common\helpers\LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= $data->pageData->title ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">
            <h1 class="title-h2 title--black title--page"><?= $data->pageData->title ?></h1>

            <div class="page-content__text">
                <?= $data->pageData->content ?>
            </div>

        </div>
    </div>
</div>
