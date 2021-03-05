<?php
/**
 * @var \yii\web\View $this
 */

use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;

$model = StaticPage::findOne(StaticPage::PAGE_WARRANTY_ID);
$data = $model->pageWarranty;
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
            <div class="p-warranty clearfix">
                <img loading="lazy" src="<?= $data->image ?>" alt="" class="float-left mr-4 mb-4">
                <h2 class="p-warrantly__title"><?= $data->title_1 ?></h2>
                <div class="p-warrantly__desc">
                    <?= $data->content_1 ?>
                </div>
                <h2 class="p-warrantly__title"><?= $data->title_2 ?></h2>
                <div class="p-warrantly__desc">
                    <?= $data->content_2 ?>
                </div>
            </div>

        </div>
        <!--CONTENT-->

    </div>
    <!--WRAPPER-->

</div>
<!--PAGE-->