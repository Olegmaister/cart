<?php

use common\helpers\LanguageHelper;

echo $this->render('/seo', [
    'title' => Yii::t('app','Find Your Favorite Brand'),
    //'description' => 'Каталог товаров' . $brand->description->meta_description . ' - Купить ' . $brand->description->meta_description . ' у официального дилера в Украине ➤ работаем с 2001 года ➤ скидки только сегодня | Prof1Group.ua',
    //'keywords' => $brand->description->meta_keyword
]);
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
                    <span class="breadcrumbs__link breadcrumbs__link--current"><?= Yii::t('app', 'brands') ?></span>
                </li>
            </ul>
        </nav>
        <div class="page-content">
            <h1 class="title title--page"><?= Yii::t('app', 'brands') ?></h1>
            <section class="brands-body">
                <div class="pg-row brands-top">
                    <div class="pg-col-25 pg-col-md-33 pg-col-md-s-50 pg-col-sm-100 brands-top-row brands-top-row--search">
                        <div class="search-pages search-pages--lg" id="brand-search">
                            <input type="text" placeholder="<?= Yii::t('app', 'Search by name') ?>"
                                   class="search-pages__field" name="search">
                            <button class="search-pages__but">
                                <svg width="26" height="27" viewBox="0 0 26 27" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11.3137" cy="12" r="7" transform="rotate(-45 11.3137 12)"
                                            stroke="#1D2023" stroke-width="2"/>
                                    <path d="M19.799 20.4853L16.2634 16.9498" stroke="#1D2023" stroke-width="2"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="pg-col-25 pg-col-md-33 pg-col-md-s-50 pg-col-sm-100 brands-top-row brands-top-row--select">
                        <div class="select-pages">
                            <select class="custom-select custom-select--lg brand-country_selected" data-nice-select>
                                <option selected disabled><?= Yii::t('app', 'Search by country') ?></option>
                                <option value=""><?= Yii::t('app', 'all') ?></option>
                                <?php foreach ($countries as $id => $country): ?>
                                    <option value="<?= $id ?>"><?= $country ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="pg-col-25 pg-col-md-33 pg-col-md-s-50 pg-col-sm-100"></div>
                    <div class="pg-col-25 pg-col-md-33 pg-col-md-s-50 pg-col-sm-100"></div>
                </div>
                <div class="brands-content">
                    <div class="pg-row brand-content_section">
                        <?= $this->render('blocks/_brands', ['brands' => $brands]) ?>
                    </div>
                    <div class="brands-content-but" data-page="2">
                        <button class="btn btn--gray btn--lxx btn_brand_view-more">
                            <span class="btn__inner"><?= Yii::t('app', 'show more') ?></span>
                        </button>
                    </div>

                    <?php if (isset($seoBlock) && !empty($seoBlock)) : ?>
                        <?= $this->render('/parts/_seo-block', ['seoBlock' => $seoBlock]) ?>
                    <?php endif ?>

                </div>

            </section>
        </div>
        <!--PAGE CONTENT-->
    </div>
    <!--WRAPPER-->
</div>