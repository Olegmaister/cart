<?php

use backend\modules\page\models\StaticPage;
use common\entities\Stores\Store;
use common\entities\Stores\StoreDescription;
use common\helpers\LanguageHelper;

/**
 * @var Store $store
 */

$storeCityList = StoreDescription::getStoreCityList();
$storeList = Store::find()->where(['<>', 'store_id',  0])->all();
$model = StaticPage::findOne(StaticPage::PAGE_STORES_ID);

echo $this->render('/seo', [
    'title' => $model->pageSeoData->seo_title,
    'description' => $model->pageSeoData->seo_description,
    'keywords' => $model->pageSeoData->seo_keyword,
]);

/*echo $this->render('/seo', [
    'title' => Yii::t('app', 'shops'),
    'description' => Yii::t('app', 'shops'),
    'keywords' => Yii::t('app', 'shops'),
]);*/
?>
<div class="page">

    <div class="wrapper">

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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'shops') ?></span>
                </li>
            </ul>
        </nav>

        <div class="page-content">
            <h1 class="title title--page"><?= Yii::t('app', 'shops') ?></h1>

            <div class="p-shops">

                <div class="p-shops-info">

                    <div class="info-block info-block--trans">
                        <?= $model->pageStores->content ?>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-4 mb-4">

                        <div class="p-shops-select">
                            <div class="select-pages select-pages--big select-pages--trans select-pages--black select-pages--lg-h">
                                <select class="custom-select custom-select--lg js-city-select" data-nice-select>
                                    <option selected value="all"><?= Yii::t('app', 'all cities') ?></option>
                                    <?php foreach ($storeCityList as $key => $store): ?>
                                        <option value="<?= $store['city'] ?>" <?=  $key = 0 ? 'selected disabled' : ''?>>
                                            <?= $store['city'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="p-shops-accordion">

                            <section class="desc-accord desc-accord--bord desc-accord--ls">
                                <?php /*$links = [
                                    '3d-tour-prof1group-forest-gamp',
                                    '3d-tour-prof1group-polygon',
                                    '3d-tour-prof1group-rekrut',
                                    '3d-tour-prof1group',
                                ] */ ?>
                                <?php foreach ($storeList as $key => $store): ?>
                                    <article class="desc-accord-item"
                                             title="<?= $store->description->city ?>"
                                             data-id="<?= $store->store_id ?>"
                                             data-name="<?= $store->description->name ?>"
                                             data-address="<?= $store->description->address ?>"
                                             data-lng="<?= $store->geo_longitude ?>"
                                             data-lat="<?= $store->geo_latitude ?>">
                                    <header class="desc-accord-head js-toggle-slide">
                                        <div class="desc-accord-head__title">
                                            <span style="color: red"><?= $store->description->name ?></span>
                                            <?= $store->description->city ?>
                                            <?= $store->description->address ?>
                                        </div>
                                        <span class="material-icons b_arrow b_arrow_black">arrow_drop_down</span>
                                    </header>

                                    <article class="desc-accord-cont js-toggle-cont">

                                        <div class="p-shops-adress">

                                            <div class="p-shops-adress-wrap">

                                                <div class="p-shops-adress-col p-shops-adress-col--left">

                                                    <div class="p-shops-accordion-row">

                                                        <div class="p-shops-accordion-media">
                                                            <div class="p-shops-accordion-media__img">
                                                                <img loading="lazy" src="/images/store/<?= $store->store_photo ?>" alt="">
                                                            </div>
                                                            <?php if (isset($store->url->keyword)): ?>
                                                            <div class="p-shops-accordion-media-but">
                                                                <a href="<?= $store->url->keyword ?>" target="_blank" class="p-shops-but-3d">
                                                                    <img loading="lazy" src="/images/3d-but-icon.svg" class="p-shops-but-3d__icon"/>
                                                                    <div class="p-shops-but-3d__txt">3D <?= Yii::t('app', 'tour') ?></div>
                                                                </a>
                                                            </div>
                                                            <?php endif ?>
                                                        </div>

                                                    </div>

                                                    <?php if ($store->video_link): ?>
                                                        <div class="p-shops-accordion-row">
                                                            <button tabindex="0"
                                                                    data-video-src="<?= $store->video_link ?>"
                                                                    class="btn btn--trans btn--full btn--lss js-video-modal-open"
                                                            >
                                                                <span class="btn__inner"><?= Yii::t('app', 'Shop video') ?></span>
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>

                                                    <div class="p-shops-accordion-row">
                                                        <button class="btn btn--trans btn--full btn--lss js-copy-location">
                                                            <span class="btn__inner"><?= Yii::t('app', 'Copy geolocation') ?></span>
                                                        </button>
                                                    </div>

                                                </div>

                                                <div class="p-shops-adress-col p-shops-adress-col--right">
                                                    <div class="p-shops-accordion-row">
                                                        <div class="p-shops-adress__title">Контакты</div>
                                                        <div class="p-shops-adress-inner">
                                                            <?php foreach (explode("\n", $store->telephone) as $item): ?>
                                                                <a href="tel:><?= $item ?>"><?= $item ?></a>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="p-shops-accordion-row">
                                                        <div class="p-shops-adress__title"><?= Yii::t('app', 'Working hours') ?>:</div>
                                                        <div class="p-shops-adress-inner">
                                                            <?php foreach (explode("\n", $store->description->open) as $item): ?>
                                                                <p><?= $item ?></p>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="p-shops-accordion-row">
                                                        <div class="p-shops-adress__title"><?= Yii::t('app', 'Geolocation') ?></div>
                                                        <div class="p-shops-adress-inner p-shop-location">
                                                            <input value="<?= Yii::t('app', 'Latitude') ?>: <?= $store->geo_latitude ?> <?= Yii::t('app', 'Longitude') ?>: <?= $store->geo_longitude ?>">
                                                            <?= Yii::t('app', 'Latitude') ?>: <?= $store->geo_latitude ?><br/>
                                                            <?= Yii::t('app', 'Longitude') ?>: <?= $store->geo_longitude ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--COLUMN-->
                                            </div>
                                            <!--WRAP-->
                                        </div>
                                        <!--ADRESS-->
                                    </article>
                                </article>
                                <?php endforeach; ?>
                            </section>

                        </div>
                        <!--ACCORDION-->

                    </div>
                    <!--COLUMN-->

                    <div class="col-lg-8">
                        <div id="p-shops-map" class="p-shops-map"></div>
                    </div>
                    <!--COLUMN-->

                </div>
                <!--SHOPS CONTENT-->

                <?php if(isset($seoBlock) && !empty($seoBlock)) : ?>
                    <?= $this->render('/parts/_seo-block', ['seoBlock' => $seoBlock]) ?>
                <?php endif ?>
            </div>
            <!--SHOPS-->

        </div>
        <!--page-content-->

    </div>
    <!--WRAPPER-->

</div>
<!--PAGE-->

<!-- PopUp for video -->
<section class="video-modal">
    <section class="video-modal-window">
        <svg class="video-modal-close js-modal-video-close" width="18" height="18" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg">
            <path d="M15.75 0L18 2.24999L2.25006 17.9999L6.58121e-05 15.7499L15.75 0Z"></path>
            <path d="M0 2.24999L2.24999 2.46558e-06L17.9999 15.7499L15.7499 17.9999L0 2.24999Z"></path>
        </svg>
        <div class="video-modal-youtube js-modal-video-youtube" frameborder="0" allow="autoplay;" allowfullscreen=""></div>
    </section>
</section>
<!-- END PopUp for video -->