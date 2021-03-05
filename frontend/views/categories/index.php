<?php
use common\helpers\LanguageHelper;
use frontend\services\ProductService;
?>
<div class="page">
    <div class="wrapper">
        <ul class="breadcrumbs">
            <li><a href="<?= LanguageHelper::langUrl('/') ?>"><?= Yii::t('app', 'home') ?></a></li>
            <li><span><?= Yii::t('app', 'catalog of goods') ?></span></li>
        </ul>
        <div class="page-content">

            <h1 class="title title--page"><?= Yii::t('app', 'catalog of goods') ?></h1>
            <div class="categories-items-wrap mb-5">

                <?php foreach ($categories as $category): ?>
                    <?php if ($category['category_id'] == 137001): ?>
                        <?php continue ?>
                    <?php endif ?>
                    <section class="categories-item">
                        <div class="categories-item-row categories-item-row--top">
                            <div class="categories-item-col categories-item-col--left">
                                <div class="el-icon-txt">
                                    <div class="el-icon-txt__media">
                                        <img loading="lazy" src="/images/slider-content/<?= $category['url']['keyword'] ?>.svg"
                                             title="<?= $category['description']['name'] ?> - Prof1group"
                                             alt="<?= $category['description']['name'] ?>">
                                    </div>
                                    <h2 data-category_id="<?= $category['category_id'] ?>"
                                          class="el-icon-txt__name"><?= $category['description']['name'] ?></h2>
                                </div>
                            </div>
                            <div class="categories-item-col categories-item-col--right mob-hide-x766 _flex">
                                <a class="btn btn--inline btn--lg-xs btn--black" href="<?= LanguageHelper::langUrl($category['url']['keyword']) ?>">
                                    <span class="btn__inner">
                                        <?= ProductService::translationCorrection(
                                                Yii::t('app', 'all') .' '. $category['description']['name']) ?>
                                    </span>
                                </a>
                            </div>
                        </div>

                        <div class="categories-item-row categories-item-row--bottom categories-item-row--grids">
                            <?php if (isset($category['children'] [0])): ?>
                                <?php foreach ($category['children'] as $children): ?>
                                    <div class="categories-grid-col">
                                        <a data-category_id="<?= $children['category_id'] ?>"
                                           href="<?= LanguageHelper::langUrl($children['url']['keyword']) ?>" class="cat-prod-card">
                                            <div class="cat-prod-card-img">
                                                <img loading="lazy" src="/images/<?= !empty($children['image']) ?
                                                    'categories/' . $children['image'] :
                                                    'no_image.png' ?>" title="<?= $children['description']['name'] ?> - Prof1group" alt="<?= $children['description']['name'] ?>">
                                            </div>
                                            <div class="cat-prod-card-info">
                                                <h3 class="cat-prod-card__name"><?= $children['description']['name'] ?></h3>
                                                <i class="cat-prod-card__arrow"></i>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>

                        <div class="categories-buttons mob-show-x766">
                            <a class="btn btn--lg-x btn--full btn--black" href="<?= LanguageHelper::langUrl($category['url']['keyword']) ?>">
                                <span class="btn__inner">
                                    <?= ProductService::translationCorrection(
                                        Yii::t('app', 'all') .' '. $category['description']['name']) ?>
                                </span>
                            </a>
                        </div>
                    </section>
                <?php endforeach ?>

            </div>
            <!--WRAP ITEMS-->
            <section class="cat-desc">
                <div class="post-prev">
                    <div class="post-prev-col post-prev-col_left">
                        <div class="post-prev-img"><img loading="lazy" src="images/post-prev/1.jpg" alt=""></div>
                    </div>
                    <div class="post-prev-col post-prev-col_right">
                        <h2 class="post-prev__title">
                            Как правильно выбрать
                            военную одежду
                        </h2>
                        <div class="post-prev__desc">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet.
                            Proin gravida dolor sit amet lacus accumsan et viverra justo commodo. Proin sodales pulvinar
                            tempor. Cum sociis natoque penatibus et magnis dis Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus
                            accumsan et viverra justo commodo. Proin sodales pulvinar tempor. Cum sociis natoque
                            penatibus et magnis dis Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean
                            euismod bibendum laoreet. Proin gravida dolor
                        </div>
                        <button class="btn-link btn-link--red">
                            <a href="#" class="btn-link__inner"><?= Yii::t('app', 'read more') ?></a>
                        </button>
                    </div>
                </div>
            </section>
        </div>
        <!--PAGE CONTENT-->
    </div>
    <!--WRAPPER-->
</div>
<!--PAGE-->
