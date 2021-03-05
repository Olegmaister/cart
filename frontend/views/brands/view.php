<?php

use common\helpers\LanguageHelper;

echo $this->render('/seo', [
    'title' => $brand->description->name . ' | купить, цена, каталог товаров бренда | Prof1Group.ua',
    'description' => 'Каталог товаров' . $brand->description->meta_description . ' - Купить ' . $brand->description->meta_description . ' у официального дилера в Украине ➤ работаем с 2001 года ➤ скидки только сегодня | Prof1Group.ua',
    //'keywords' => $brand->description->meta_keyword
]);

?>
<div class="page">
    <div class="cat-head">
        <div class="wrapper">
            <nav class="breadcrumbs">
                <ul class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="<?= LanguageHelper::langUrl('/') ?>">
                            <span itemprop="name"
                                  content="<?= Yii::t('app', 'home') ?>"><?= Yii::t('app', 'home') ?></span>
                        </a>
                        <meta itemprop="position" content="1"/>
                    </li>
                    <li class="breadcrumbs__item" itemprop="itemListElement" itemscope
                        itemtype="https://schema.org/ListItem">
                        <a class="breadcrumbs__link" href="<?= LanguageHelper::langUrl('brands') ?>">
                            <span itemprop="name"><?= Yii::t('app', 'brands') ?></span>
                        </a>
                    </li>
                    <meta itemprop="position" content="2"/>
                    <li class="breadcrumbs__item">
                        <span class="breadcrumbs__link breadcrumbs__link--current"><?= $brand->description->name ?></span>
                    </li>
                </ul>
            </nav>

            <h1 class="title title--page">
                <?= $brand->description->name ?>
                <img class="flag-44" src="/images/flags/<?= $brand->country['en-EN'] ?>.png"
                     alt="<?= $brand->description->name ?>" title="Флаг <?= $brand->country['ru-RU'] ?> - Prof1group">
            </h1>

            <div class="row">

                <?php if(isset($sliderImages[0])): ?>
                    <div class="col-md-5">
                        <div class="slider-3">
                            <?php foreach($sliderImages as $slide): ?>
                                <img src="/images/brands/<?= $slide['image'] ?>" alt="image">
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
                <div class="col-md-<?= isset($sliderImages[0]) ? '7' : '12' ?>">
                    <img class="brand-image mb-3" src="/images/brands/<?= $brand->image ?>" title="<?= $brand->description->name ?>  - Prof1group"
                         alt="<?= $brand->description->name ?>">
                    <div class="brand-head__desc">
                        <div class="js-height-brands-desc">
                            <?=
                            //\yii\helpers\StringHelper::truncate(html_entity_decode($brand->description->description), 800)
                            html_entity_decode($brand->description->description)
                            ?>
                        </div>
                    </div>
                    <button class="button-dots js-brands-view-desc mt-3 ml-n1"></button>
                </div>
            </div>

            <div class="brand-head d-none">
                <div class="brand-head-col brand-head-col--left">
                    <div class="brand-head__media">
                        <img loading="lazy" src="/images/brands/<?= $brand->image ?>"
                             title="<?= $brand->description->name ?>" alt="<?= $brand->description->name ?>"
                             class="brand-head__media__img">
                    </div>
                </div>
                <div class="brand-head-col brand-head-col--right">
                    <div class="brand-head__desc">
                        <div id="js-height-brands-desc" class="brand-head__desc-inner">
                            <?= html_entity_decode($brand->description->description) ?>
                        </div>

                    </div>
                    <div class="brand-head-circles js-brands-view-desc">
                        <div class="brand-head-circles__item"></div>
                        <div class="brand-head-circles__item"></div>
                        <div class="brand-head-circles__item"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-content page-content--min">
        <div class="wrapper">

            <?php if (count($categories['items'])): ?>
                <h2 class="title title--page"><?= Yii::t('app', 'product categories') ?></h2>

                <div class="categories-items-wrap mb-5">
                    <section class="categories-item">
                        <div class="row row-10 brand-section_categories">
                            <?= $this->render('blocks/_categories', ['brandSlug' => $brand->url->keyword, 'categories' => $categories['items']]) ?>
                        </div>

                        <div class="row row-10">
                            <?php if ($categories['existNextPage']): ?>
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <button data-page="2" data-item="categories" style="margin-right: 20px;"
                                            class="brands__categories-but w-100 btn btn--lxx btn--lxx-md-sl btn--gray">
                                        <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                                    </button>
                                </div>
                            <?php endif ?>
                            <div class="col-md-6 col-lg-3 mb-4">

                                <button class="btn btn--lxx btn--lxx-md-sl btn--red w-100">
                                    <a href="<?= LanguageHelper::langUrl('brand-catalog-' . $brand->url->keyword) ?>">
                                        <span class="btn__inner"><?= Yii::t('app', 'all brand products') ?></span>
                                    </a>
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            <?php endif ?>

            <?php if (!empty($bestSeller['relate'])): ?>
                <section class="content-extra">
                    <h2 class="content-extra__title"><?= Yii::t('app', 'bestsellers') ?></h2>
                    <div class="product-card-wrap brand-section_best_seller">
                        <?= $this->render('/parts/_items-common', ['items' => $bestSeller, 'name' => 'best_seller', 'currency' => $currency, 'productService' => $productService]) ?>
                    </div>

                    <?php if ($bestSeller['existNextPage']): ?>
                        <div class="categories-buttons categories-buttons--center">
                            <button data-page="2" data-item="best_seller"
                                    style="width: calc(25% - 16px)"
                                    class="brands__items-but  btn btn--lxx btn--lxx-md-sl btn--gray">
                                <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                            </button>
                        </div>
                    <?php endif ?>
                </section>
            <?php endif ?>

            <?php if (!empty($novelty['relate'])): ?>
                <section class="content-extra" style="margin-top: 0px;">
                    <h2 class="content-extra__title"><?= Yii::t('app', 'novelty') ?></h2>
                    <div class="product-card-wrap brand-section_new">
                        <?= $this->render('/parts/_items-common', ['items' => $novelty, 'name' => 'new', 'currency' => $currency, 'productService' => $productService]) ?>
                    </div>

                    <?php if ($novelty['existNextPage']): ?>
                        <div class="categories-buttons product-card-wrap">
                            <div class="product-card-col w-100 w-lg-25">
                                <button data-page="2" data-item="new"
                                        class="brands__items-but w-100 btn btn--lxx btn--lxx-md-sl btn--gray">
                                    <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                                </button>
                            </div>
                        </div>
                    <?php endif ?>
                </section>
            <?php endif ?>

        </div>
    </div>
</div>
