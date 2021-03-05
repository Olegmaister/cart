<?php

use yii\helpers\Url;
use frontend\widgets\CustomLinkPager;
use common\helpers\ProductHelper;
use common\helpers\LanguageHelper;

/**@var \frontend\services\ProductService $productService */


echo $this->render('/seo', [
    'title' => html_entity_decode($category->description->meta_title),
    'description' => html_entity_decode($category->description->meta_description),
    'keywords' => html_entity_decode($category->description->meta_keyword),
    'url' => 'https://prof1group.ua' . LanguageHelper::langUrl($category->url->keyword),
    'image' => Yii::$app->request->hostInfo . '/images/categories/' . $category->image,
    'width' => 258,
    'height' => 362,
]);
?>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Product",
        "url": "<?= Yii::$app->request->absoluteUrl ?>",
        "name": "<?= end($breadcrumbs)->description->name ?>",
        "offers": {
            "@type": "AggregateOffer",
            "highPrice": "<?= $filtersData['maxPrice'] ?>",
            "lowPrice": "<?= $filtersData['lowPrice'] ?>",
            "offerCount": "<?= $provider->getTotalCount() ?>",
            "priceCurrency":"<?= $currency->getCurrencyName() ?>"
        }
    }
</script>
<div class="page">
    <div class="cat-head">
        <div class="wrapper">
            <ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                        <span itemprop="name" content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                    </a>
                    <meta itemprop="position" content="1"/>
                </li>
                <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <a itemprop="item" href="<?= LanguageHelper::langUrl('catalog') ?>">
                        <span itemprop="name"><?= Yii::t('app', 'catalog') ?></span>
                    </a>
                    <meta itemprop="position" content="2"/>
                </li>
                <?php if (isset($breadcrumbs[1])): ?>
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="<?= LanguageHelper::langUrl($breadcrumbs[0]->url->keyword) ?>">
                            <span itemprop="name"><?= $breadcrumbs[0]->description->name ?></span>
                        </a>
                        <meta itemprop="position" content="3"/>
                    </li>
                    <li><span><?= end($breadcrumbs)->description->name ?></span></li>
                <?php else: ?>
                    <li><span><?= $breadcrumbs[0]->description->name ?></span></li>
                <?php endif ?>
            </ul>
            <h1 class="title title--page"
                data-category_id="<?= end($breadcrumbs)->description->category_id ?>"><?= end($breadcrumbs)->description->name ?></h1>
            <div class="cat-slider">
                <div class="cat-slider-arrows"></div>

                <?php if ($path == 'categories'): ?>
                    <?= $this->render('blocks/category-slider', ['categorySlider' => $slider]); ?>
                <?php else: ?>
                    <?= $this->render('blocks/brand-slider', ['brandSlider' => $slider]); ?>
                <?php endif ?>

            </div>
        </div>
    </div>
    <!--CAT HEAD-->
    <div class="page-content page-content--min">
        <div class="wrapper">
            <div class="page-content-columns page-content-columns-cat">

                <?= $this->render('/parts/catalog/left-sidebar', [
                    'get' => $get,
                    'filtersData' => $filtersData
                ]) ?>

                <div class="page-content-col page-content-col--right page-content-col--right-cat">
                    <div class="page-options">
                        <div class="page-options-col page-options-col--left">
                            <div class="prod-sort mob-hide-x766">
                                <div class="prod-sort-col prod-sort-col--left">
                                    <div class="prod-sort__title"><?= Yii::t('app', 'sort') ?> <?= Yii::t('app', 'by') ?>
                                        :
                                    </div>
                                </div>

                                <div class="prod-sort-col prod-sort-col--right">
                                    <ul class="prod-sort-menu">
                                        <li class="sorting_section sort_all<?= ProductHelper::isSort($get) ?>"
                                            data-sort="all">
                                            <a href=""><?= Yii::t('app', 'all') ?></a>
                                        </li>
                                        <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'price') ?>"
                                            data-sort="price">
                                            <a href="<?= Url::current(['sort' => 'price']) ?>"><?= Yii::t('app', 'price') ?>
                                                <span
                                                        class="arrow_up arrow_down"></a>
                                        </li>
                                        <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'sale') ?>"
                                            data-sort="-sale">
                                            <a href=""><?= Yii::t('app', 'sale') ?><span class=""></a>
                                        </li>
                                        <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'new') ?>"
                                            data-sort="-new">
                                            <a href=""><?= Yii::t('app', 'new products') ?><span class=""></a>
                                        </li>
                                        <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'rating') ?>"
                                            data-sort="-rating">
                                            <a href=""><?= Yii::t('app', 'rating') ?><span class=""></a>
                                        </li>
                                        <li class="sorting_section<?= ProductHelper::getUrlSortClass($get, 'viewed') ?>"
                                            data-sort="-viewed">
                                            <a href=""><?= Yii::t('app', 'popularity') ?><span class=""></a>
                                        </li>
                                        <li class="sorting_section">
                                            <a href=""><?= Yii::t('app', 'shares') ?><span class=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="prod-sort-mob mob-show-x766">
                                <img loading="lazy" src="/images/arrows-sort.svg" alt="sort"
                                     class="prod-sort-mob__img mr-2">
                                <select class="js-nice-select js-select-filter simple-select">
                                    <option value="all"><?= Yii::t('app', 'all') ?></option>
                                    <option value="price"><?= Yii::t('app', 'price') ?></option>
                                    <option value="-sale"><?= Yii::t('app', 'sale') ?></option>
                                    <option value="-new"><?= Yii::t('app', 'new products') ?></option>
                                    <option value="-rating"><?= Yii::t('app', 'rating') ?></option>
                                    <option value="-viewed"><?= Yii::t('app', 'popularity') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="page-options-col page-options-col--right">
                            <div class="views-buttons">
                                <div class="views-buttons-but views-buttons-but--view-1 views-buttons-but--active js-toggle-view"></div>
                                <div class="views-buttons-but views-buttons-but--view-2 js-toggle-view"></div>
                                <div class="views-buttons-but views-buttons-but--view-3 js-toggle-view"></div>
                            </div>
                        </div>
                    </div>
                    <div class="page-content-inner js-catalog-cards">
                        <div class="product-card-wrap product-card-wrap--card-3x js-toggle-views product-card-wrap--view-1">
                            <?= $this->render('/parts/_items-common', [
                                'items' => $items,
                                'currency' => $currency,
                                'productService' => $productService
                            ]) ?>
                        </div>

                        <div class="page-content-inner-row">

                            <div class="page-content-inner-row-col page-content-inner-row-col mob-hide-x766">
                                <?php if ($provider): ?>
                                    <div class="page-content-inner-row-col page-content-inner-row-col--left mob-hide-x766">
                                        <?= CustomLinkPager::widget([
                                            'pagination' => $provider->getPagination()
                                        ]); ?>
                                    </div>
                                <?php endif ?>
                            </div>

                            <div class="page-content-inner-row-col page-content-inner-row-col--right mob-hide-x766">
                                <!--button class="btn btn--lg btn--black">
                                    <a href="#" class="btn__inner"><?= Yii::t('app', 'show more') ?></a>
                                </button-->
                            </div
                        </div>
                    </div>
                    <!--CONTENT INNER-->
                </div>
                <!--COL RIGHT-->
            </div>

            <?php if ($seoBlock): ?>
                <?= $this->render('/parts/_seo-block', ['seoBlock' => $seoBlock]) ?>
            <?php endif ?>

        </div>
        <!--wrapper-->
    </div>
    <!--PAGE CONTENT-->

    <?php if ($viewed): ?>
        <br>
        <div class="wrapper">
            <div class="content-extra content-extra--product mt-4">
                <h2 class="content-extra__title"><?= Yii::t('app', 'you looked at the goods') ?></h2>
                <div class="carousel-1 mt-n5">
                    <?= $this->render('/parts/_items-common', ['items' => $viewed, 'currency' => $currency, 'productService' => $productService]) ?>
                </div>
            </div>
        </div>
    <?php endif ?>

    <?php if (isset($watching['mpn'])): ?>
        <div class="wrapper">
            <div class="content-extra content-extra--product content-extra--product-last">
                <h2 class="content-extra__title"><?= Yii::t('app', 'buyers are also watching') ?></h2>
                <div class="carousel-1 mt-n5">
                    <?= $this->render('/parts/_items-common', ['items' => $watching, 'currency' => $currency, 'productService' => $productService]) ?>
                </div>
            </div>
        </div>
    <?php endif ?>
</div>
<!--PAGE-->
