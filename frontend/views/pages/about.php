<?php
/**
 * @var \yii\web\View $this
 * @var \backend\modules\page\models\ContactsPage $item
 * @var common\entities\Blog\BlogCategory[] $blogsMenu
 * @var frontend\entities\Blog\Blogs[] $providers
 */

use backend\modules\page\models\AboutBottomBlockPage;
use backend\modules\page\models\AboutCompanyPage;
use backend\modules\page\models\AboutImagesPage;
use backend\modules\page\models\AboutTopBlockPage;
use backend\modules\page\models\StaticPage;
use common\helpers\LanguageHelper;

$model = StaticPage::findOne(StaticPage::PAGE_ABOUT_ID);
$topBlock = AboutTopBlockPage::findOne(['language_id' => LanguageHelper::getIdByCode(Yii::$app->language)]);
$bottomBlock = AboutBottomBlockPage::findOne(['language_id' => LanguageHelper::getIdByCode(Yii::$app->language)]);
$aboutCompanyBlock = AboutCompanyPage::findOne(['language_id' => LanguageHelper::getIdByCode(Yii::$app->language)]);
$topSlider = AboutImagesPage::findAll(['type' => AboutImagesPage::SLIDER_TOP_TYPE]);

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'about') ?></span>
                </li>
            </ul>
        </nav>
    </div>

    <div class="page-content">
        <div class="js-page-paddings">
            <h1 class="title title--page"><?= Yii::t('app', 'ALL ABOUT THE COMPANY') ?></h1>
        </div>

        <div class="p-about">
            <div class="js-page-paddings">
                <div class="p-about-shops">
                    <div class="w-100">
                        <div class="p-about-slider">
                            <div class="journal-one-slider-col journal-one-slider-col--left">
                                <div class="journal-one-slider-images">
                                    <div class="slider-arrows">
                                        <div class="slider-arrow slider-arrow__prev"></div>
                                        <div class="slider-arrow slider-arrow__next"></div>
                                    </div>
                                    <div class="js-slider-journal">
                                        <?php foreach ($topSlider as $slide): ?>
                                            <div class="slider-main__item slider-main__item--journal">
                                                <figure class="slider-main__img-wrap">
                                                    <img loading="lazy" src="<?= $slide->link ?>"
                                                         class="slider-main__img">
                                                </figure>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="journal-one-slider-col journal-one-slider-col--right">
                                <div class="journal-one-slider-thumbs js-slider-journal-thumbs">
                                    <?php foreach ($topSlider as $slide): ?>
                                        <div class="journal-one-slider-thumbs-item">
                                            <img loading="lazy" src="<?= $slide->link ?>"
                                                 class="journal-one-slider-thumbs__img">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-about-factory">
                    <h2 class="title title--page"><?= $topBlock->title ?></h2>
                    <div class="p-about__desc">
                        <?= $topBlock->text ?>
                    </div>
                </div>
            </div>

            <div class="p-about-privilege">
                <div class="js-page-paddings">
                    <h2 class="title mb-5"><?= Yii::t('app', 'COMPANY ADVANTAGES') ?></h2>
                    <div class="row">
                        <?php foreach ($model->pageAboutBenefits as $item): ?>
                            <div class="col-md-6 mb-3">
                                <div class="row align-items-center">
                                    <div class="col-auto"><img width="100" height="100" src="<?= $item->image ?>"></div>
                                    <div class="col">
                                        <div class="p-about-privilege-item__name"><?= $item->title ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="js-page-paddings">
                <div class="p-about-info d-block">
                    <h3 class="title title--page"><?= $bottomBlock->title ?></h3>
                    <div class="p-about-info-item__desc">
                        <?= $bottomBlock->text ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
